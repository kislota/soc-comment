<?php

namespace core\lib;


use core\lib\core\Singleton;

class Config
{
    public $app,
        $db,
        $soc;

    static private $instance;

    private function __construct()
    {
        $this->app = require __DIR__ . '/../config/app_config.php';
        $file_db_conf = __DIR__ . '/../../db.php';
        if(file_exists($file_db_conf)){
            $this->db = require __DIR__ . '/../../db.php';
        }else{
            $this->db = require __DIR__ . '/../config/db.php';
        }
        $this->soc = require __DIR__ . '/../config/soc_config.php';
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    public static function instace()
    {
        if(empty(static::$instance)){
            static::$instance = new Static();
        }
        return static::$instance;
    }
}