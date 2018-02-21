<?php

namespace Konsulting\Exposer;

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

    public static function invokeMethod($method, $args)
    {
        return BaseExposer::hasMethod(static::$subjectClass, $method)
            ? BaseExposer::invokeStaticMethod(static::$subjectClass, $method, $args)
            : call_user_func_array([static::$subjectClass, $method], $args);
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
        return static::invokeMethod($method, $args);
    }

    public static function getProperty($property)
    {
        return BaseExposer::hasProperty(static::$subjectClass, $property)
            ? BaseExposer::getProperty(static::$subjectClass, $property)
            : call_user_func_array([static::$subjectClass, $method], $args);
    }
}
