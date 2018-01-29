<?php

namespace app\controller;

use core\Controller;
use core\lib\Request;

class UserController extends Controller
{
    /**
     * redirect to login page
     */
    public function actionIndex()
    {
        redirect('/user/login');
    }

    /**
     * Login page
     */
    public function actionLogin(Request $request)
    {
        if (!$this->model->auth($request)) {
            $this->view->render('login');
        }else{
            redirect('/');
        }

    }

    /**
     * Logout page
     */
    public function actionLogout()
    {
        // Удаляем информацию о пользователе из сессии
        $this->model->logout();
        // Перенаправляем пользователя на главную страницу
        redirect('/comment/index');
    }
}