<?php

namespace core;
use app\model\User;
use core\lib\Config;


/**
 * Class View
 * @package core
 */
class View
{
    private $path;
    private $layout;


    /**
     * View constructor.
     */
    public function __construct($layout, $controller)
    {
        $this->layout = $layout;
        $this->path = __DIR__ . '/../app/view/' . lcfirst($controller).'/';
        $this->config = Config::instace();
    }

    /**
     * View template
     * @param $view
     * @param array $vars
     */
    public function render($view, $vars = [])
    {
        $pathView = $this->pathView($view);
        if (file_exists($pathView)) {
            extract($vars);
            $userInfo = $this->getUserInfo();
            $socials = $this->getUrlProvider();
            ob_start();
            require_once $pathView;
            $content = ob_get_clean();
            require_once __DIR__ . '/view/' . $this->layout . '.php';

        }
    }

    /**
     * Error page
     * @param $code
     */
    public static function errorCode($code)
    {
        http_response_code($code);
        $path = __DIR__ . '/view/errors/' . $code . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
        exit;
    }

    /**
     *
     * @param $view
     * @return string
     */
    private function pathView($view)
    {
        $arrview = explode('.', $view);
        $view = implode("/", $arrview);
        return $this->path . $view . '.php';
    }

    /**
     *  User Info
     */
    public function getUserInfo()
    {
        $user = new User;
        return $user->getUser($_SESSION['soc_id']);
    }

    private function getUrlProvider()
    {
        foreach ($this->config->soc as $social => $param) {
            $soc = 'core\social\\' . ucfirst($social);
            $this->{$social} = new $soc($param);
            $uri[$social] = $this->{$social}->getAuthUrl();
        }
        return $uri;
    }
}