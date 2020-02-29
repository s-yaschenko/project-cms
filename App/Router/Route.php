<?php


namespace App\Router;


use App\Controller\AbstractController;
use Exception;
use ReflectionClass;
use ReflectionException;

class Route
{
    /**
     * @var AbstractController
     */
    private $controller;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $params;

    /**
     * Route constructor.
     * @param AbstractController $controller
     * @param string $method
     * @param array $params
     * @throws ReflectionException
     */
    public function __construct(AbstractController $controller, string $method, array $params = [])
    {
        $this->isMethodExist($controller, $method);

        $this->controller = $controller;
        $this->method = $method;
        $this->params = $params;

        $controller->setRoute($this);
    }

    /**
     * @return AbstractController
     */
    public function getController(): AbstractController
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string $key
     * @return string|false
     */
    public function getParam(string $key): string
    {
        if (!isset($this->params[$key])) {
            return false;
        }

        return (string) $this->params[$key];
    }

    /**
     * @param AbstractController $controller
     * @param string $method
     * @return bool
     * @throws ReflectionException
     */
    private function isMethodExist(AbstractController $controller, string $method)
    {
        $reflection_class = new ReflectionClass($controller);
        if (!$reflection_class->hasMethod($method)) {
            throw new Exception('Method not exist');
        }

        return true;
    }
}