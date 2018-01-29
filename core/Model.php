<?php

namespace core;

use core\lib\Config;
use core\lib\db\Db;
use core\lib\Request;


/**
 * Class Model
 * @package core
 */
abstract class Model
{
    public $db;
    public $provider;
    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->db = new Db();
        $this->config = Config::instace();
        foreach ($this->config->soc as $social => $param) {
            $this->provider = $social;
            $soc = 'core\social\\' . ucfirst($social);
            $this->{$social} = new $soc($param);
        }
    }

    /**
     *  get session user id
     */
    public function id()
    {
        if (isset($_SESSION['soc_id']))
            return $_SESSION['soc_id'];
        return false;
    }

    /**
     * Save social id to session
     * @param $id
     * @return bool
     */
    public function setId($id)
    {
        if (isset($id))
            return $_SESSION['soc_id'] = $id;
        return false;
    }

    /**
     * Logout user
     */
    public function logout()
    {
        unset($_SESSION['soc_id']);
    }

    /**
     *  Login user
     */
    public function login()
    {
        $request = Request::getInstace();
        return $this->{$request->provider}->authSocial($request);
    }
}