<?php


namespace App\Di;


use Exception;
use ReflectionException;

/**
 * Class Container
 * @package App\Di
 */
class Container
{
    /**
     * @var Injector
     */
    private $injector;

    /**
     * @var array
     */
    private $container = [];

    /**
     * @var array
     */
    private $callbacks = [];

    /**
     * @var array
     */
    private $interfaces_dictionary;

    /**
     * Container constructor.
     */
    public function __construct(array $interfaces_dictionary = [])
    {
        $this->injector = new Injector($this);
        $this->container[self::class] = $this;
        $this->interfaces_dictionary = $interfaces_dictionary;
    }

    /**
     * @param string $class_name
     * @return mixed|void
     * @throws Exception
     */
    public function get(string $class_name)
    {
        if (!class_exists($class_name)) {

            if (interface_exists($class_name)) {
                $interface_mapping = $this->getInterfaceMapping($class_name);
                return $this->get($interface_mapping);
            }

            throw new Exception("Class not exists!");
        }

        return $this->getClass($class_name);
    }

    /**
     * @param string $class_name
     * @param callable|null $callback
     */
    public function add(string $class_name, callable $callback = null)
    {
        if (is_callable($callback)) {
            $this->callbacks[$class_name] = $callback;
        }

        $this->container[$class_name] = false;
    }

    /**
     * @return Injector
     */
    public function getInjector()
    {
        return $this->injector;
    }

    /**
     * @param string $key
     * @return string|null
     */
    private function getInterfaceMapping(string $key): ?string
    {
        return $this->interfaces_dictionary[$key] ?? null;
    }

    /**
     * @param string $class_name
     * @return object
     * @throws ReflectionException
     */
    private function getClass(string $class_name): object
    {
        $is_singleton = $this->isSingleton($class_name);

        if ($is_singleton) {
            $instance = $this->getSingleton($class_name);
        } else {
            $instance = $this->getInjector()->createClass($class_name);
        }

        return $instance;
    }

    /**
     * @param string $class_name
     * @return object
     * @throws ReflectionException
     */
    private function getSingleton(string $class_name): object
    {
        $instance = $this->container[$class_name];

        if ($instance == false) {
            $instance = $this->createSingleton($class_name);
        }

        return $instance;
    }

    /**
     * @param string $class_name
     * @return object
     * @throws ReflectionException
     */
    private function createSingleton(string $class_name): object
    {
        $is_callback_exist = $this->isCallbackExist($class_name);

        if ($is_callback_exist) {
            $callback = $this->getCallback($class_name);
            $instance = $callback();
        } else {
            $instance = $this->getInjector()->createClass($class_name);
        }

        $this->container[$class_name] = $instance;

        return $instance;
    }

    /**
     * @param string $class_name
     * @return callable
     */
    private function getCallback(string $class_name): callable
    {
        return $this->callbacks[$class_name];
    }

    /**
     * @param string $class_name
     * @return bool
     */
    private function isSingleton(string $class_name): bool
    {
        return isset($this->container[$class_name]);
    }

    /**
     * @param string $class_name
     * @return bool
     */
    private function isCallbackExist(string $class_name): bool
    {
        return isset($this->callbacks[$class_name]) && is_callable($this->callbacks[$class_name]);
    }
}