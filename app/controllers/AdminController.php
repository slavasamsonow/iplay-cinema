<?php

namespace app\controllers;

use app\core\Controller;

class AdminController extends Controller{
    public function confirmTasksAction(){
        if(!empty($_POST)){
            $data = $this->model->saveStatusTask($_POST);
            echo json_encode(['data' => $data]);
            exit();
        }
        if($this->model->role == 'admin'){
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