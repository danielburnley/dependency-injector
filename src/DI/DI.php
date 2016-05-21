<?php

namespace Pintsize\DI;

use phpDocumentor\Reflection\DocBlock\Tag\ParamTag;
use Pintsize\DI\Exceptions\ConcreteImplementationNotFoundException;
use Pintsize\DI\Exceptions\ClassDoesNotImplementInterfaceException;

/**
 * Created by PhpStorm.
 * User: dan
 * Date: 19/05/16
 * Time: 23:02
 */
class DI
{

    private $mappings = [];

    public function addMappings(array $mappings)
    {
        $this->mappings += $mappings;
    }

    /**
     * @param $class
     * @return object
     * @throws ConcreteImplementationNotFoundException
     */
    public function getInstanceOf($class)
    {
        $reflectionClass = new \ReflectionClass($class);
        if ($reflectionClass->isInterface()) {
            $reflectionClass = $this->getConcreteImplementation($class);
        }
        $dependencies = [];
        if ($this->classHasDependencies($reflectionClass)) {
            $dependencies = $this->getDependencies($reflectionClass, $dependencies);
        }
        return $reflectionClass->newInstanceArgs($dependencies);
    }

    /**
     * @param \ReflectionClass $reflectionClass
     * @return bool
     */
    private function classHasDependencies(\ReflectionClass $reflectionClass)
    {
        return $reflectionClass->getConstructor() && !empty($reflectionClass->getConstructor()->getParameters());
    }

    /**
     * @param $reflectionClass
     * @param $dependencies
     * @return array
     * @throws ConcreteImplementationNotFoundException
     */
    private function getDependencies(\ReflectionClass $reflectionClass, array $dependencies)
    {
        foreach ($reflectionClass->getConstructor()->getParameters() as $parameter) {
            $dependencyName = $parameter->getClass()->getName();
            $dependencies[] = self::getInstanceOf($dependencyName);
        }
        return $dependencies;
    }

    /**
     * @param $class
     * @return \ReflectionClass
     * @throws ClassDoesNotImplementInterfaceException
     * @throws ConcreteImplementationNotFoundException
     */
    private function getConcreteImplementation($class)
    {
        if (!array_key_exists($class, $this->mappings)) {
            throw new ConcreteImplementationNotFoundException("{$class} does not have mapping!");
        }
        $reflectionClass = new \ReflectionClass($this->mappings[$class]);
        if (!$reflectionClass->implementsInterface($class)) {
            throw new ClassDoesNotImplementInterfaceException("{$reflectionClass->getName()} does not implement {$class}!");
        }
        return $reflectionClass;
    }

}