<?php

namespace Konsulting\Exposer\Tests\Stubs;

class ClassUnderTest
{
    protected $property = 'I am protected';

    protected function protectedMethod($arg1, $arg2)
    {
        return $arg1 . $arg2;
    }

    protected static function protectedStaticMethod($arg1, $arg2)
    {
        return $arg1 . $arg2;
    }

    public function __call($method, $args)
    {
        var_dump($args);
        return 'You called: ' . $args[0];
    }

    public static function __callStatic($method, $args)
    {
        return 'You called static: ' . $args[0];
    }

    public function __get($property)
    {
        return 'You tried to get: ' . $property;
    }
}
