<?php

namespace core\lib\db;


use core\lib\Config;
use PDO;

class Db
{
    private $db;
    private $config;
    /**
     * Db constructor.
     */
    public function __construct()
    {
        $this->config = Config::instace();
        $this->db = new PDO('mysql:host=' . $this->config->db['host'] . ';dbname=' . $this->config->db['dbname'] . '', $this->config->db['user'], $this->config->db['password']);
    }

    /**
     * @param $sql
     * @param array $params
     * @return \PDOStatement
     */
    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        if (!empty($params)) {
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    /**
     * @param $sql
     * @param array $params
     * @return array
     */
    public function findAll($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @param $sql
     * @param array $params
     * @return array
     */
    public function findOne($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param $sql
     * @param array $params
     * @return string
     */
    public function column($sql, $params = [])
    {
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }

    /**
     * @param $sql
     * @param array $params
     * @return mixed
     */
    public function insert($sql, $params = []) {
        $this->query($sql, $params);
        return $this->db->lastInsertId();
    }

    /**
     * @param $sql
     * @param array $params
     * @return \PDOStatement
     */
    public function update($sql, $params = []) {
        return $this->query($sql, $params);
    }

    /**
     * @param $sql
     * @param array $params
     * @return \PDOStatement
     */
    public function delete($sql, $params = []) {
        return $this->query($sql, $params);
    }
}