<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Account;

class MainController extends Controller{
    public $modelAccount;

    public function indexAction(){
        if(!empty($_POST)){
            if($_POST['form'] == 'register'){
                if(!$this->model->validate(['email', 'phone'], $_POST)){
                    $this->view->message('Ошибка', $this->model->error);
                }
                if($this->model->checkExists('email', $_POST['email'])){
                    $this->view->message('Войдите в личный кабинет', '<p>Вы уже записались. Войдите в личный кабинет: </p> <a href="/login" class="btn btn-default">Войти</a>');
                }
                $this->modelAccount = $this->loadModel('account');
                $user = $this->modelAccount->register($_POST);

                if(!$this->model->registerForm($_POST, $user)){
                    $this->view->message('Ошибка', 'Заявка не отправлена');
                }

                $this->view->message('Вы зарегестрировались', 'На вашу почту отправлено письмо. Дальнейшие указания вы найдете в нем.');
            }
            if($_POST['form'] == 'question'){
                $this->model->questionForm($_POST);
                $this->view->message('Ваша заявка отправлена', 'В скором времени мы свяжемся с вами');
            }
        }
        $this->view->layout = 'intro';
        $vars = [
            'events' => $this->model->events(),
        ];
        $this->view->render($vars);
    }

    public function lendingAction(){
        if(!empty($_POST)){
            if($_POST['form'] == 'registercourse'){
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
                if(isset($_POST['email'])){
                    $_SESSION['guest']['email'] = $_POST['email'];
                }
                if(isset($_POST['fio'])){
                    $_SESSION['guest']['fio'] = $_POST['fio'];
                }
                if(isset($_POST['phone'])){
                    $_SESSION['guest']['phone'] = $_POST['phone'];
                }
                if(isset($_POST['city'])){
                    $_SESSION['guest']['city'] = $_POST['city'];
                }
                //$this->view->location('pay/'.$_POST['courseid']);
                $messageBody = "В скором времени мы свяжемся с вами. <br> А пока вы можете оплатить участие по ссылке: <a href='pay/".$_POST['courseid']."' class='btn'>Оплатить</a>";
                $this->view->message('Ваша заявка отправлена', $messageBody);
            }
            if($_POST['form'] == 'registercooperation'){
                if(!$this->model->validate(['email', 'phone'], $_POST)){
                    $this->view->message('Ошибка', $this->model->error);
                }

                $this->model->registerCooperation($_POST);
                $this->view->message('Ваша заявка отправлена', 'В скором времени мы свяжемся с вами');
            }
        }
        if($this->route['pagename'] != 'intensiv'){
            $this->view->errorCode('404');
        }
        $this->view->layout = 'lending';
        $vars = [
            'seo' => [
                'title' => 'Интенсив-шоу №2',
            ]
        ];
        $this->view->render($vars);
    }
}