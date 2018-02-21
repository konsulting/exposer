<?php

namespace Konsulting\Exposer;

use ReflectionClass;

class Exposer
{
    protected static $subjectClass;

    /**
     * @var object
     */
    protected $subject;

    /**
     * @var ReflectionClass
     */
    protected $reflection;

    public function __construct($subject)
    {
        $this->subject = $subject;
        $this->reflection = new ReflectionClass($subject);
    }

    /**
     * @param object $subject
     * @return static
     */
    public static function make($subject)
    {
        return new static($subject);
    }

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
     * Call a method on the subject class.
     *
     * @param string $method
     * @param array  $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return $this->reflection->hasMethod($method)
            ? static::invokeMethod($this->reflection, $this->subject, $method, $args)
            : call_user_func_array([$this->subject, $method], $args);
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
        $reflection = new ReflectionClass(static::$subjectClass);

        return $reflection->hasMethod($method)
            ? static::invokeStaticMethod($reflection, $method, $args)
            : call_user_func_array([static::$subjectClass, $method], $args);
    }

    /**
     * Invoke a method on the subject class, regardless of its visibility.
     *
     * @param ReflectionClass $reflection
     * @param object|null     $subject
     * @param string          $method
     * @param array           $args
     * @return mixed
     */
    protected static function invokeMethod(ReflectionClass $reflection, $subject, $method, $args)
    {
        $reflectionMethod = $reflection->getMethod($method);
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod->invokeArgs($subject, $args);
    }

    /**
     * @param ReflectionClass $reflection
     * @param string          $method
     * @param array           $args
     * @return mixed
     */
    protected static function invokeStaticMethod(ReflectionClass $reflection, $method, $args)
    {
        return static::invokeMethod($reflection, null, $method, $args);
    }

    public function __get($property)
    {
        return $this->reflection->hasProperty($property)
            ? $this->getProperty($property)
            : $this->subject->{$property};
    }

    /**
     * Get a property on the subject.
     *
     * @param string $property
     * @return mixed
     */
    protected function getProperty($property)
    {
        $reflectionProperty = $this->reflection->getProperty($property);
        $reflectionProperty->setAccessible(true);

        return $reflectionProperty->getValue($this->subject);
    }
}
