<?php

namespace app\controllers;

use app\core\Controller;

class CourseController extends Controller{

    public function __construct($route){
        parent::__construct($route);
        $this->view->layout = 'lk';
    }

    public function studyAction(){
        if($this->model->auth == 'auth'){
            if(!$course = $this->model->checkCourse($this->route['courseid'])){
                $this->view->redirect('account');
            }
            $tasks = $this->model->getTasksCourse($course['id']);
            $vars = [
                'course' => $course,
                'tasks' => $tasks,
            ];
            $this->view->render($vars);
        }else{
            $this->view->redirect('login');
        }
    }

    public function checkTaskAction(){
        if(!empty($_POST)){
            $task = (int) $_POST['task'];
            $data = $this->model->changeTask($task);
            $this->view->data($data);
        }else{
            $this->model->errorCode(404);
        }
    }
}