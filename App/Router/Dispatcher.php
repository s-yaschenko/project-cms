<?php


namespace App\Router;


use App\Config;
use App\Di\Container;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Class Dispatcher
 * @package App\Router
 */
class Dispatcher
{

    /**
     * @var array
     */
    private $routes = [];

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Container
     */
    private $container;

    /**
     * Dispatcher constructor.
     * @param Container $container
     * @param Config $config
     * @throws ReflectionException
     */
    public function __construct(Container $container, Config $config)
    {
        $this->container = $container;
        $this->config = $config;

        $this->routes = $this->getRoutes();
    }

    /**
     * @param string $url
     * @return Route|null
     * @throws Exception
     */
    public function getRoute(string $url)
    {
        $route = $this->getRouteData($url);

        if (is_null($route)) {
            return null;
        }

        $controller = $this->getContainer()->get($route[0]);
        $method = $route[1];
        $params = $route[2] ?? [];

        try {
            $route = new Route($controller, $method, $params);
        } catch (Exception $e) {
            return null;
        }

        return $route;
    }

    /**
     * @param string $url
     * @return array|null
     */
    private function getRouteData(string $url)
    {
        $route = $this->routes[$url] ?? null;

        if (!is_null($route)) {
            return $route;
        }

        foreach ($this->routes as $key => $route_data) {
            $route_params = [];

            $url_chunks = explode('/', $url);
            $route_key_chunks = explode('/', $key);

            if (count($url_chunks) != count($route_key_chunks)) {
                continue;
            }

            for ($i = 0; $i < count($url_chunks); $i++) {
                $url_chunk = $url_chunks[$i];
                $route_key_chunk = $route_key_chunks[$i];

                $match = $this->assertUrlAndRouteChunk($url_chunk, $route_key_chunk);

                if (!$match) {
                    continue 2;
                }

                $param = $this->getRouteParam($url_chunk, $route_key_chunk);
                $route_params = array_replace($route_params, $param);
            }

            $route = $route_data;
            $route[] = $route_params;
        }

        return $route;
    }

    /**
     * @param string $url_chunk
     * @param string $route_chunk
     * @return array
     */
    private function getRouteParam(string $url_chunk, string $route_chunk): array
    {
        if (preg_match('/^{.+}$/im', $route_chunk) == false) {
            return [];
        }

        $route_chunk = preg_replace('/[{}]/im', '', $route_chunk);

        return [
            $route_chunk => $url_chunk
        ];
    }

    /**
     * @param string $url_chunk
     * @param string $route_chunk
     * @return bool
     */
    private function assertUrlAndRouteChunk(string $url_chunk, string $route_chunk): bool
    {
        if (preg_match('/^{.+}$/im', $route_chunk) == false) {
            return $url_chunk == $route_chunk;
        }

        return true;
    }

    /**
     * @param array $controllers
     * @return array
     *
     * @throws ReflectionException
     */
    private function getRoutesFromControllers(array $controllers): array
    {
        $params = [];

        foreach ($controllers as $controller) {
            $methods = $this->getReflectionMethods($controller, ReflectionMethod::IS_PUBLIC);
            $temp_array = $this->getRoutesFromMethods($controller, $methods);

            $params = array_merge($params, $temp_array);
        }

        return $params;
    }

    /**
     * @param string $controller
     * @param ReflectionMethod $method
     * @param array $annotation_routes
     *
     * @return array
     */
    private function getRoutesFromAnnotations(string $controller, ReflectionMethod $method, array $annotation_routes)
    {
        $routes = [];

        foreach ($annotation_routes as $annotation_route) {
            $annotate_params = $this->getAnnotateParameters($annotation_route);
            $params = $this->getRouteParameters($annotate_params);

            $routes[$params['url']] = [
                $controller,
                $method->getName()
            ];
        }

        return $routes;
    }

    /**
     * @param string $annotation_route
     * @return array
     */
    private function getAnnotateParameters(string $annotation_route): array
    {
        $annotate_params = str_replace('@Route(', '', $annotation_route);
        $annotate_params = str_replace(')', '', $annotate_params);

        $annotate_params = explode(',', $annotate_params);
        $annotate_params = array_map(function ($item) {
            return trim($item);
        }, $annotate_params);

        return $annotate_params;
    }


    /**
     * @param array $annotate_params
     * @return array
     */
    private function getRouteParameters(array $annotate_params)
    {
        $params = [];

        foreach ($annotate_params as $param_str) {
            $param_data = explode('=', $param_str);
            $key = $param_data[0];
            $value = $param_data[1];

            $value = str_replace("\"", "", $value);

            $params[$key] = $value;
        }

        return $params;
    }

    /**
     * @param string $controller
     * @param ReflectionMethod[] $methods
     * @return array
     */
    private function getRoutesFromMethods(string $controller, $methods): array
    {
        $params = [];

        foreach ($methods as $method) {
            $annotation_routes = $this->findAnnotateRouteFromDocCommentMethod($method);

            if (empty($annotation_routes)) {
                continue;
            }

            $temp_array = $this->getRoutesFromAnnotations($controller, $method, $annotation_routes);

            $params = array_merge($params, $temp_array);
        }

        return $params;
    }

    /**
     * @param ReflectionMethod $method
     * @return array
     */
    private function findAnnotateRouteFromDocCommentMethod(ReflectionMethod $method): array
    {
        $doc_comment = $method->getDocComment();

        $matches = [];
        preg_match_all('/@Route\(.+\)/im', $doc_comment, $matches);

        return $matches[0];
    }


    /**
     * @return array
     * @throws ReflectionException
     */
    private function getRoutes(): array
    {
        $controllers = $this->getControllers();
        $routes = [];

        if (is_null($controllers)) {
            return $routes;
        }

        return $this->getRoutesFromControllers($controllers);
    }

    /**
     * @return array|null
     */
    private function getControllers()
    {
        $controllers = $this->getConfig()->get('controllers');
        return is_array($controllers) && isset($controllers[0]) ? $controllers : null;
    }

    /**
     * @param string $class_name
     * @return ReflectionClass
     *
     * @throws ReflectionException
     */
    private function getReflectionClass(string $class_name): ReflectionClass
    {
        return new ReflectionClass($class_name);
    }

    /**
     * @param string $class_name
     * @param int|null $filter
     *
     * @return ReflectionMethod[]
     *
     * @throws ReflectionException
     */
    private function getReflectionMethods(string $class_name, int $filter = null)
    {
        $reflection_class = $this->getReflectionClass($class_name);
        return $reflection_class->getMethods($filter);
    }

    /**
     * @return Config
     */
    private function getConfig(): Config
    {
        return $this->config;
    }


    /**
     * @return Container
     */
    private function getContainer(): Container
    {
        return $this->container;
    }

}