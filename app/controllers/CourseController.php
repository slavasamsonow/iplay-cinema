<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Account;
use app\models\Course;

class CourseController extends Controller{

    /* @var $model Course */
    public $model;
    /* @var $modelAccount Account*/
    public $modelAccount;

    public function __construct($route){
        parent::__construct($route);
        $this->modelAccount = $this->loadModel('account');
    }

    public function indexAction(){
        if($this->model->auth == 'auth'){
            $vars = [
                'seo' => [
                    'title' => 'Обучение',
                ],
                'courses' => $this->model->getStudyCoursesList(),
            ];

            $this->view->render($vars);
        }
        else{
            $this->view->redirect('login');
        }
    }

    public function coursesAction(){
        $paramsCourses = [];
        if(isset($_GET['type'])){
            $paramsCourses['coursesType'] = $_GET['type'];
        }

        $vars = [
            'seo' => [
                'title' => 'Список курсов и мероприятий',
            ],
            'coursesList' => $this->model->getActive($paramsCourses),
        ];

        $this->view->render($vars);
    }

    public function courseAction(){
        if(!empty($_POST)){
            if($_POST['form'] == 'registergrant'){
                if(isset($_SESSION['user'])){
                    $this->model->grantApplicationUser($_POST);
                }
                else{
                    if(!$this->model->validate(['email', 'phone'], $_POST)){
                        $this->view->message('Ошибка', $this->model->error);
                    }

                    if(isset($_POST['register'])){
                        if(!$this->model->checkExists('email', $_POST['email'], 'users')){
                            $this->modelAccount->register($_POST);
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
                }
                else{
                    if(!$this->model->validate(['email', 'phone'], $_POST)){
                        $this->view->message('Ошибка', $this->model->error);
                    }

                    if(isset($_POST['register'])){
                        if(!$this->model->checkExists('email', $_POST['email'], 'users')){
                            $this->modelAccount->register($_POST);
                        }
                    }

                    $this->model->registerСourseGuest($_POST);
                    $messageBody = "В скором времени мы свяжемся с вами. <br> А пока вы можете оплатить участие по ссылке: <a href='/pay/".$_POST['courseid']."' class='btn'>Оплатить</a>";
                    $this->view->message('Ваша заявка отправлена', $messageBody);
                }
                $this->view->message('Ваша заявка отправлена', 'В скором времени мы свяжемся с вами');
            }
            if($_POST['form'] == 'question'){
                $this->model->questionForm($_POST);
                $this->view->message('Ваша заявка отправлена', 'В скором времени мы свяжемся с вами');
            }
        }
        if(!$course = $this->model->getItem($this->route['courseid'])){
            $this->view->redirect('account');
        }
        if($course['active'] == 0){
            $this->view->redirect('account');
        }

        $vars = [
            'seo' => [
                'title' => $course['name'],
            ],
            'course' => $course,
            'teachers' => $this->model->getTeachers($course['id']),
            'curators' => $this->model->getCurators($course['id']),
            'program' => $this->model->getProgram($course['id']),
            'projects' => $this->model->getProjectsCourse($course['id']),
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
                'users' => $this->model->getCourseStudents($course['id']),
                'projects' => $this->model->getProjectsCourse($course['id']),
            ];
            $this->view->render($vars);
        }
        else{
            $this->view->redirect('login');
        }
    }

    public function checkTaskAction(){
        if(!empty($_POST)){
            $task = (int)$_POST['task'];
            $data = $this->model->changeTask($task);
            $this->view->data($data);
        }
        else{
            $this->view->errorCode(404);
        }
    }

    public function liveAction(){
        if($this->model->auth == 'auth'){
            if(!$course = $this->model->checkCourse($this->route['courseid'])){
                $this->view->redirect('account');
            }
            $vars = [
                'course' => $course
            ];
            $this->view->layout='live';
            $this->view->render($vars);
        }
        else{
            $this->view->redirect('login');
        }
    }
}