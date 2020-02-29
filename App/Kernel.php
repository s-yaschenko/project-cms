<?php


namespace App;


use App\Di\Container;
use App\Http\Response;
use App\Middleware\IMiddleware;
use App\Router\Route;
use App\Router\Router;
use Exception;

/**
 * Class Kernel
 * @package App
 */
final class Kernel
{

    /**
     * @var Container
     */
    private $container;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var Config
     */
    private $config;

    /**
     * Kernel constructor.
     * @param Container $container
     * @param Router $router
     * @param Config $config
     */
    public function __construct(Container $container, Router $router, Config $config)
    {
        $this->container = $container;
        $this->router = $router;
        $this->config = $config;
    }

    /**
     * @throws Exception
     */
    public function run()
    {
        $route = $this->getRouter()->dispatch();
        $this->runMiddlewares($route);
        $response = $this->dispatch($route);

        $response->send();
    }

    /**
     * @param Route $route
     * @return Response
     * @throws Exception
     */
    private function dispatch(Route $route): Response
    {
        return $this->getContainer()
            ->getInjector()
            ->callMethod(
                $route->getController(),
                $route->getMethod()
            );
    }

    /**
     * @param Route $route
     * @throws Exception
     */
    private function runMiddlewares(Route $route)
    {
        $middlewares = $this->getConfig()->get('middlewares');

        foreach ($middlewares as $middleware_class) {
            $this->runMiddleware($route, $middleware_class);
        }
    }

    /**
     * @param Route $route
     * @param string $middleware_class
     * @throws Exception
     */
    private function runMiddleware(Route $route, string $middleware_class)
    {
        $is_middleware_exist = class_exists($middleware_class);
        if (!$is_middleware_exist) {
            return;
        }

        $implements = class_implements($middleware_class);
        $is_middleware = in_array(IMiddleware::class, $implements);

        if (!$is_middleware) {
            return;
        }

        /**
         * @var IMiddleware $middleware
         */
        $middleware = $this->getContainer()->get($middleware_class);
        $middleware->run($route);
    }

    /**
     * @return Container
     */
    private function getContainer()
    {
        return $this->container;
    }

    /**
     * @return Router
     */
    private function getRouter()
    {
        return $this->router;
    }

    /**
     * @return Config
     */
    private function getConfig(): Config
    {
        return $this->config;
    }
}