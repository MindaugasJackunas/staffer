<?php

declare(strict_types = 1);

namespace Staffer\Infrastructure\Container;

use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

/**
 * Container implementation with dependency injection support.
 */
class Container implements ContainerInterface
{
    /**
     * @var array
     */
    protected $instances = [];

    /**
     * {@inheritdoc}
     */
    public function set(string $abstract, $concrete = null)
    {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        $this->instances[$abstract] = $concrete;
    }

    /**
     * {@inheritdoc}
     *
     * @throws ReflectionException
     */
    public function get(string $abstract)
    {
        if (!isset($this->instances[$abstract])) {
            $this->set($abstract);
        }

        if (is_object($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        return $this->resolve($this->instances[$abstract]);
    }

    /**
     * Resolves dependencies from class.
     *
     * @param $concrete
     *
     * @return mixed|object
     *
     * @throws Exception
     * @throws ReflectionException
     */
    private function resolve($concrete)
    {
        $reflector = new ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            throw new Exception("Class '{$concrete}' is not instantiable.");
        }

        if (is_null($reflector->getConstructor())) {
            return $reflector->newInstance();
        }

        $parameters = $reflector->getConstructor()->getParameters();

        $dependencies = $this->getDependencies($parameters);

        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * @param ReflectionParameter[] $parameters
     *
     * @return array
     *
     * @throws Exception
     */
    private function getDependencies(array $parameters) : array
    {
        return array_map(
            function ($parameter) {
                /** @var ReflectionParameter $parameter */
                return $this->get($parameter->getClass()->name);
            },
            $parameters
        );
    }
}
