<?php

namespace app\controllers;

use app\core\Controller;

class AdminController extends Controller{
    public function confirmTasksAction(){
        if($this->model->role == 'admin'){
           $this->view->render();
        }else{
            $this->view->errorCode('403');
        }
    }
}