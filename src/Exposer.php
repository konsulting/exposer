<?php

namespace Konsulting\Exposer;

use ReflectionClass;

class Exposer
{
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
