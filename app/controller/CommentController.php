<?php

namespace app\controller;

use core\Controller;
use core\lib\Request;

class CommentController extends Controller
{
    /**
     * Comments page
     */
    public function actionIndex()
    {
        $comments = $this->model->getComments();
        $this->view->render('index', compact('comments'));
    }

    /**
     * Load comments
     */
    public function actionLoad(Request $request)
    {
        echo $this->model->getComments($request);
    }

    /**
     * Create page
     */
    public function actionCreate(Request $request)
    {
        if ($this->model->id()) {
            if (($request->message != '') && ($request->comment_id != '')) {
                $this->model->editComment($request);
            } elseif ($request->message != '') {
                $this->model->saveComment($request);
            }
            redirect('/');
        } else {
            redirect('/user/login');
        }
    }
}