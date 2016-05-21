<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 19/05/16
 * Time: 23:30
 */

namespace Pintsize\DI;


class ClassWithOneDependency
{
    /**
     * @var ClassWithOneDependency
     */
    private $dependency;

    /**
     * ClassWithOneDependency constructor.
     * @param ClassWithNoDependencies $dependency
     */
    public function __construct(ClassWithNoDependencies $dependency)
    {
        $this->dependency = $dependency;
    }
}