<?php

namespace Konsulting\Exposer;

trait Exposer
{
    protected static $classExposerPrefix = '_expose_';

    /**
     * Proxy method call to parent to allow testing of protected methods.
     *
     * @param string $method
     * @param array  $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (strpos($method, static::$classExposerPrefix) === 0) {
            $parentMethod = substr($method, strlen(static::$classExposerPrefix));

            return parent::{$parentMethod}(...$args);
        }

        return parent::__call($method, $args);
    }

    /**
     * Proxy method call to parent to allow testing of static protected methods.
     *
     * @param string $method
     * @param array  $args
     * @return mixed
     */
    public static function __callStatic($method, $args)
    {
        if (strpos($method, static::$classExposerPrefix) === 0) {
            $parentMethod = substr($method, strlen(static::$classExposerPrefix));

            return parent::{$parentMethod}(...$args);
        }

        return parent::__callStatic($method, $args);
    }

    /**
     * Expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        if (strpos($property, static::$classExposerPrefix) === 0) {
            return $this->{substr($property, strlen(static::$classExposerPrefix))};
        }

        return parent::__get($property);
    }
}
