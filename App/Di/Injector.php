<?php


namespace App\Di;

use App\Http\Response;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

class Injector
{

    /**
     * @var Container
     */
    private $container;

    /**
     * Injector constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    /**
     * @param string $class_name
     * @return object
     * @throws ReflectionException
     */
    public function createClass(string $class_name): object
    {
        $reflection_class = $this->getReflectionClass($class_name);
        $reflection_constrictor = $reflection_class->getConstructor();

        $arguments = [];
        if ($reflection_constrictor instanceof ReflectionMethod) {
            $arguments = $this->getArgumentsArray($reflection_constrictor);
        }
        
        return $reflection_class->newInstanceArgs($arguments);
    }

    /**
     * @param Object $object
     * @param string $method
     * @return Response
     *
     * @throws ReflectionException
     */
    public function callMethod(Object $object, string $method): Response
    {
        $reflection_class = $this->getReflectionClass($object);

        if (!$reflection_class->hasMethod($method)) {
            throw new Exception('Method not exist!');
        }

        $reflection_method = $reflection_class->getMethod($method);
        $arguments = $this->getArgumentsArray($reflection_method);

        return call_user_func_array([$object, $method], $arguments);
    }

    /**
     * @param ReflectionMethod $method
     * @return array
     * @throws Exception
     */
    private function getArgumentsArray(ReflectionMethod $method): array
    {
        $arguments = [];
        foreach ($method->getParameters() as $parameter) {
            $reflection_class = $parameter->getClass();
            $class_name = $reflection_class->getName();

            $arguments[] = $this->getContainer()->get($class_name);
        }

        return $arguments;
    }


    /**
     * @param string|object $class_name
     * @return ReflectionClass
     * @throws ReflectionException
     */
    private function getReflectionClass($class_name): ReflectionClass
    {
        return new ReflectionClass($class_name);
    }

    /**
     * @return Container
     */
    private function getContainer()
    {
        return $this->container;
    }
}