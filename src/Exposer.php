<?php

namespace Konsulting\Exposer;

class Exposer
{
    /**
     * @var object
     */
    protected $subject;

    /**
     * Exposer constructor.
     *
     * @param object|string $subject
     */
    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Construct a new instance for the subject.
     *
     * @param object|string $subject
     * @return static
     */
    public static function make($subject)
    {
        return new static($subject);
    }

    /**
     * Call a method on the subject.
     *
     * @param string $method
     * @param array  $args
     * @return mixed
     */
    public function invokeMethod($method, $args)
    {
        return BaseExposer::hasMethod($this->subject, $method)
            ? BaseExposer::invokeMethod($this->subject, $method, $args)
            : call_user_func_array([$this->subject, $method], $args);
    }

    /**
     * Call a method on the subject.
     *
     * @param string $method
     * @param array  $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return $this->invokeMethod($method, $args);
    }

    /**
     * Get a property on the subject.
     *
     * @param string $property
     * @return mixed
     */
    public function getProperty($property)
    {
        return BaseExposer::hasProperty($this->subject, $property)
            ? BaseExposer::getProperty($this->subject, $property)
            : $this->subject->{$property};
    }

    /**
     * Get a property on the subject.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->getProperty($property);
    }
}
