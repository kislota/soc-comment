<?php

namespace core;

use core\lib\Config;
use ReflectionMethod;

/**
 * Class App
 * @package core
 */
class App
{
    public
        $app,
        $config;
    private
        $param,
        $controller,
        $model,
        $action,
        $classname;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->config = Config::instace();
        $this->param = $this->getUri();
        $this->controller = $this->getController();
        $this->model = $this->getModel();
        $this->action = $this->getAction();
        $this->run();
    }

    /**
     *  Load app
     */
    public function run()
    {
        $param = [
            'controller' => $this->classname,
            'model' => $this->model
        ];
        $this->app = new $this->controller($param);
        $this->getActionParam();
    }

    private function getUri()
    {
        $uri = trim(rtrim(preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']), '/'), '/');
        return explode('/', $uri);
    }

    /**
     * get controller or to default controller $this->config->app['default_controller'] -> app_config.php
     * @return string
     */
    private function getController()
    {
        $classname = array_shift($this->param);
        $this->classname = ucfirst($classname);
        $this->controller = 'app\controller\\' . $this->classname . 'Controller';
        if (class_exists($this->controller)) {
            return $this->controller;
        } elseif (!$this->classname) {
            $this->controller = 'app\controller\\' . $this->config->app['default_controller'] . 'Controller';
            if (class_exists($this->controller)) {
                if ($this->classname != $this->config->app['default_controller']) {
                    array_unshift($this->param, $classname);
                    $this->classname = $this->config->app['default_controller'];
                }
                return $this->controller;
            }
        }
        return View::errorCode(404);
    }

    /**
     * get model default to name controller
     * @return bool|string
     */
    private function getModel()
    {
        $this->model = 'app\model\\' . $this->classname;
        if (class_exists($this->model))
            return $this->model;
        return false;
    }

    /**
     * get action or to default actionIndex
     * @return string
     */
    private function getAction()
    {
        $this->action = array_shift($this->param);
        $action = 'action' . ucfirst($this->action);
        if (method_exists($this->controller, $action))
            return $action;
        array_unshift($this->param, $this->action);
        $this->action = 'actionIndex';
        if (method_exists($this->controller, $this->action))
            return $this->action;
        return View::errorCode(404);
    }

    /**
     *  get Request param to action
     */
    private function getActionParam()
    {
        $param = [];
        $reflection = new ReflectionMethod($this->controller, $this->action);
        $rParams = $reflection->getParameters();
        foreach ($rParams AS $key => $arg) {
            $new = '';
            $new .= $arg->getType();
            if ($new != '') {
                $path = __DIR__ . '/../' . str_replace('\\', '/', $new . '.php');
                if (file_exists($path)) {
                    require_once $path;
                    $param['param' . $key] = new $new();
                }
            } elseif ($_REQUEST[$arg->name])
                $param[$arg->name] = $_REQUEST[$arg->name];
            else
                $param[$arg->name] = null;
        }
        call_user_func_array([$this->app, $this->action], $param);
    }
}