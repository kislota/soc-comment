<?php

namespace core;


use core\lib\Config;

/**
 * @property object model
 * @property object view
 */
abstract class Controller
{
    public $config;
    public $model;
    public $view;
    public $layout = 'default';

    /**
     * Controller constructor.
     */
    public function __construct($param)
    {
        $this->config = Config::instace();
        $this->model = $this->loadModel($param['model']);
        $this->view = new View($this->layout, $param['controller']);
    }

    /**
     * @param $model
     * @return object
     */
    private function loadModel($model)
    {
        if (class_exists($model)) {
            return new $model();
        }
    }
}