<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 20/05/16
 * Time: 00:40
 */

namespace Pintsize\DI;


class ClassWithTwoDependencies
{
    /**
     * @var ClassWithNoDependencies
     */
    private $classWithNoDependencies;
    /**
     * @var ClassWithOneDependency
     */
    private $classWithOneDependency;


    /**
     * ClassWithTwoDependencies constructor.
     * @param ClassWithNoDependencies $classWithNoDependencies
     * @param ClassWithOneDependency $classWithOneDependency
     */
    public function __construct(ClassWithNoDependencies $classWithNoDependencies, ClassWithOneDependency $classWithOneDependency)
    {
        $this->classWithNoDependencies = $classWithNoDependencies;
        $this->classWithOneDependency = $classWithOneDependency;
    }
}