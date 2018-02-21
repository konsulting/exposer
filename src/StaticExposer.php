<?php

namespace Konsulting\Exposer;

use ReflectionClass;

class StaticExposer
{
    /**
     * @var string
     */
    protected static $subjectClass;

    /**
     * Set the class name to use in a static context.
     *
     * @param string $class
     */
    public static function setClass($class)
    {
        static::$subjectClass = $class;
    }

    /**
     * Call a static method on the subject class.
     *
     * @param string $method
     * @param array  $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        return (new ReflectionClass(static::$subjectClass))->hasMethod($method)
            ? static::invokeStaticMethod($method, $args)
            : call_user_func_array([static::$subjectClass, $method], $args);
    }


    /**
     * @param string $method
     * @param array  $args
     * @return mixed
     */
    protected static function invokeStaticMethod($method, $args)
    {
        $reflectionMethod = new \ReflectionMethod(static::$subjectClass, $method);
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod->invokeArgs(null, $args);
    }
}
