<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Account;

class CourseController extends Controller{

    public function __construct($route){
        parent::__construct($route);
    }

    public function coursesAction(){
        $paramsCourses = [];
        if(isset($_GET['type'])){
            $paramsCourses['coursesType'] = $_GET['type'];
        }

        $vars = [
            'seo' => [
                'Список курсов и мероприятий',
            ],
            'coursesList' => $this->model->coursesList($paramsCourses),
        ];

        $this->view->render($vars);
    }

    public function courseAction(){
        if(!empty($_POST)){
            if($_POST['form'] == 'registergrant'){
                if(isset($_SESSION['user'])){
                    $this->model->grantApplicationUser($_POST);
                }else{
                    if(!$this->model->validate(['email', 'phone'], $_POST)){
                        $this->view->message('Ошибка', $this->model->error);
                    }

                    if(isset($_POST['register'])){
                        $this->modelAccount = $this->loadModel('account');
                        if(!$this->model->checkExists('email', $_POST['email'], 'users')){
                           $user = $this->modelAccount->register($_POST);
                        }
                    }

                    $this->model->grantApplicationGuest($_POST);
                }
                $this->view->message('Ваша заявка отправлена', 'В скором времени мы свяжемся с вами');
            }
            if($_POST['form'] == 'registercourse'){
                if(isset($_SESSION['user'])){
                    $this->model->registerCourseUser($_POST);
                    $this->view->location('pay/'.$_POST['courseid']);
                }else{
                    if(!$this->model->validate(['email', 'phone'], $_POST)){
                        $this->view->message('Ошибка', $this->model->error);
                    }

                    if(isset($_POST['register'])){
                        $this->modelAccount = $this->loadModel('account');
                        if(!$this->model->checkExists('email', $_POST['email'], 'users')){
                           $user = $this->modelAccount->register($_POST);
                        }
                    }

                    $this->model->registerСourseGuest($_POST);
                    $this->view->location('pay/'.$_POST['courseid'].'?email='.$_POST['email'].'&fio='.$_POST['fio'].'&phone='.$_POST['phone'].'&city='.$_POST['city']);
                }
                $this->view->message('Ваша заявка отправлена', 'В скором времени мы свяжемся с вами');
            }
            if($_POST['form'] == 'question'){
                $this->model->questionForm($_POST);
                $this->view->message('Ваша заявка отправлена', 'В скором времени мы свяжемся с вами');
            }
        }
        if(!$course = $this->model->courseInfo($this->route['courseid'])){
            $this->view->redirect('account');
        }

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
            $vars = [
                'course' => $course,
                'tasks' => $this->model->getTasksCourse($course['id']),
                'users' => $this->model->getUsersCourse($course['id']),
                'projects' => $this->model->getProjectsCourse($course['id']),
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