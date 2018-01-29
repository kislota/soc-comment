<?php

namespace core\lib\core;


/**
 * Trait Singleton
 * @package core\lib\core
 */
trait Singleton
{
    static private $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    /**
     * @return mixed
     */
    public static function getInstace()
    {
        if (empty(static::$instance)) {
            static::$instance = new Static();
        }
        return static::$instance;
    }
}