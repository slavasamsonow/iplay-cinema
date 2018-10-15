<?php

namespace app\controllers;

use app\core\Controller;

class CourseController extends Controller{

    public function __construct($route){
        parent::__construct($route);
        $this->view->layout = 'lk';
    }

    public function courseAction(){
        if(!empty($_POST)){
            if($_POST['form'] == 'grant'){
                if(isset($_SESSION['user'])){
                    $this->model->grantApplicationUser($_POST);
                }else{
                    if(!$this->model->validate(['email', 'phone'], $_POST)){
                        $this->view->message('Ошибка', $this->model->error);
                    }

                    if(isset($_POST['register'])){
                        $user = $this->modelAccount->register($_POST);
                    }

                    $this->model->grantApplicationGuest($_POST);
                }
                $this->view->message('Ваша заявка отправлена', 'В скором времени мы свяжемся с вами');
            }
            if($_POST['form'] == 'question'){
                $this->model->questionForm($_POST);
                $this->view->message('Ваша заявка отправлена', 'В скором времени мы свяжемся с вами');
            }
        }
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
            'projects' => $this->model->courseProjects($course['id']),
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