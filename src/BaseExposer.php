<?php

namespace Konsulting\Exposer;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

class BaseExposer
{
    /**
     * Check if the given method exists on the subject.
     *
     * @param object|string $subject The instance or class name.
     * @param string        $method  The method name.
     * @return bool
     */
    public static function hasMethod($subject, $method)
    {
        return (new ReflectionClass($subject))->hasMethod($method);
    }

    /**
     * Check if the given property exists on the subject.
     *
     * @param object|string $subject  The instance or class name.
     * @param string        $property The property name.
     * @return bool
     */
    public static function hasProperty($subject, $property)
    {
        return (new ReflectionClass($subject))->hasProperty($property);
    }

    /**
     * Invoke a method on the subject class.
     *
     * @param object $subject The subject instance.
     * @param string $method  The name of the method.
     * @param array  $args    The arguments to pass to the method.
     * @return mixed
     */
    public static function invokeMethod($subject, $method, $args)
    {
        return static::getReflectionMethod($subject, $method)
            ->invokeArgs($subject, $args);
    }

    /**
     * Invoke a static method on the subject class.
     *
     * @param string $subject The subject class name.
     * @param string $method  The name of the method.
     * @param array  $args    The arguments to pass to the method.
     * @return mixed
     */
    public static function invokeStaticMethod($subject, $method, $args)
    {
        return static::getReflectionMethod($subject, $method)
            ->invokeArgs(null, $args);
    }

    /**
     * Get a reflection object for the given method.
     *
     * @param object|string $subject The instance or class name.
     * @param string        $method  The name of the method.
     * @return ReflectionMethod
     */
    protected static function getReflectionMethod($subject, $method)
    {
        $reflectionMethod = new ReflectionMethod($subject, $method);
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod;
    }

    /**
     * Get a property or static property on the subject class.
     *
     * @param object|string $subject  The instance or class name.
     * @param string        $property The name of the property.
     * @return mixed
     */
    public static function getProperty($subject, $property)
    {
        $reflectionProperty = new ReflectionProperty($subject, $property);
        $reflectionProperty->setAccessible(true);

        return $reflectionProperty->getValue($subject);
    }
}