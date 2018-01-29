<?php

namespace core\lib;
use core\lib\core\Singleton;

/**
 * Class Request
 * @package core
 */
class Request
{
    use Singleton;
    private $request;
    /**
     * Request constructor.
     * @param $param
     */
    public function __construct()
    {
        $this->getRequest();
    }
    /**
     *
     */
    private function getRequest()
    {
        if (!empty($_REQUEST)) {
            $this->request = $_REQUEST;
            $this->getFeatch();
        }
    }
    /**
     * @return request obj
     */
    private function getFeatch()
    {
        foreach ($_REQUEST as $key => $value) {
            $this->$key = $value;
        }
    }
}
