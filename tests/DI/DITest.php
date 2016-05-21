<?php

namespace Pintsize\DI;

use Pintsize\DI\Exceptions\ClassDoesNotImplementInterfaceException;
use Pintsize\DI\Exceptions\ConcreteImplementationNotFoundException;

class DITest extends \PHPUnit_Framework_TestCase
{
    /** @var DI */
    private $DI;

    protected function setUp()
    {
        parent::setUp();
        $this->DI = new DI;
    }

    /**
     * @test
     */
    public function givenClassWithNoDependencies_whenGettingInstanceOfClass_thenReturnCorrectInstance()
    {
        $object = $this->DI->getInstanceOf(ClassWithNoDependencies::class);
        $this->assertInstanceOf(ClassWithNoDependencies::class, $object);
    }

    /**
     * @test
     */
    public function givenClassWithOneDependency_whenGettingInstanceOfClass_thenReturnCorrectInstance()
    {
        $object = $this->DI->getInstanceOf(ClassWithOneDependency::class);
        $this->assertInstanceOf(ClassWithOneDependency::class, $object);
    }

    /**
     * @test
     */
    public function givenClassWithTwoDependencies_whenGettingInstanceOfClass_thenReturnCorrectInstance()
    {
        $object = $this->DI->getInstanceOf(ClassWithTwoDependencies::class);
        $this->assertInstanceOf(ClassWithTwoDependencies::class, $object);
    }

    /**
     * @test
     */
    public function givenInterfaceWithNoMapping_whenGettingImplementation_thenThrowException()
    {
        $this->expectException(ConcreteImplementationNotFoundException::class);
        $this->DI->getInstanceOf(TestInterface::class);
    }

    /**
     * @test
     */
    public function givenInterfaceWithMapping_whenGettingImplementation_returnConcreteImplementation()
    {
        $mapping = [ TestInterface::class => TestImplementation::class ];
        $this->DI->addMappings($mapping);
        $object = $this->DI->getInstanceOf(TestInterface::class);
        $this->assertInstanceOf(TestImplementation::class, $object);
    }

    /**
     * @test
     */
    public function givenInterfaceWithMappingThatDoesNotImplementInterface_whenAddingMapping_thenThrowException()
    {
        $this->expectException(ClassDoesNotImplementInterfaceException::class);
        $mapping = [ TestInterface::class => ClassWithNoDependencies::class ];
        $this->DI->addMappings($mapping);
        $this->DI->getInstanceOf(TestInterface::class);
    }

}
