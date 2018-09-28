<?php

namespace app\controllers;

use app\core\Controller;

class AdminController extends Controller{
    public function confirmTasksAction(){
        if($this->model->role == 'admin'){
            if(!empty($_POST)){
                $data = $this->model->saveStatusTask($_POST);
                $this->view->data($data);
            }
            $tasks = $this->model->getNoverifyTasks();
            $vars = [
                'tasks' => $tasks,
            ];
            $this->view->render($vars);
        }else{
            $this->view->errorCode('403');
        }
    }
}