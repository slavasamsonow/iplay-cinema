<?php

namespace app\controllers;

use app\core\Controller;

class CourseController extends Controller{

    public function __construct($route){
        parent::__construct($route);
        $this->view->layout = 'lk';
    }

    public function courseAction(){
        if($this->model->auth == 'guest'){
            $this->view->layout = 'default';
        }
        if(!$course = $this->model->courseInfo($this->route['courseid'])){
            $this->view->redirect('account');
        }

        $arraynewtext = [
            'description' => $course['description'],
        ];
        $newtext = $this->model->descriptionText($arraynewtext);
        foreach($newtext as $key=>$newtextstr){
            $course[$key] = $newtextstr;
        };

        $vars = [
            'seo' => [
                'title' => $course['name'],
            ],
            'course' => $course,
            'teachers' => $this->model->courseTeachers($course['id']),
            'curators' => $this->model->courseCurators($course['id']),
            'program' => $this->model->courseProgram($course['id']),
        ];
        if($course['caption'] != ''){
            $vars['seo']['description'] = $course['caption'];
        }

        $this->view->render($vars);
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