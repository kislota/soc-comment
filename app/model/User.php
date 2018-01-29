<?php

namespace app\model;


use core\lib\Request;
use core\Model;

/**
 * Class User
 * @package app\model
 */
class User extends Model
{
    /**
     *  auth user
     */
    public function auth(Request $request)
    {
        if ($this->id())
            return $this->id();
        //Create new user and auth
        if (isset($request->code) && !$this->id())
            return $this->getId();
    }


    /**
     * @return bool
     */
    public function getId()
    {
        //auth social net
        $user = $this->login();
        $userId = $this->getUser($user->id);
        //create new user
        if ($userId)
            return $this->setId($user->id);
        $userId = $this->db->insert('INSERT INTO users (soc_id, name, email, avatar) VALUE (:soc_id, :name, :email, :avatar)',
            [
                'soc_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar
            ]
        );
        //set user id to session
        if($userId)
            return $this->setId($user->id);
        return false;
    }

    /**
     *  get user info to database
     */
    public function getUser($id)
    {
        return $this->db->findOne('SELECT * FROM users WHERE soc_id = :soc_id', ['soc_id' => $id]);
    }
}