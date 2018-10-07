<?php

namespace app\controllers;

use app\core\Controller;

class AdminController extends Controller{

    public function __construct($route){
        parent::__construct($route);
        $this->view->layout = 'lk';
        if(!$this->model->role == 'admin'){
            $this->view->errorCode('403');
        }
    }

    public function confirmTasksAction(){
        if(!empty($_POST)){
            $data = $this->model->saveStatusTask($_POST);
            $this->view->data($data);
        }
        $tasks = $this->model->getNoverifyTasks();
        $vars = [
            'tasks' => $tasks,
        ];
        $this->view->render($vars);
    }

    public function addprojectAction(){
        $vars = [
        ];
        $this->view->render($vars);
    }
}