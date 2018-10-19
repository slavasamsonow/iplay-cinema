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
        $this->view->layout='intro';
        $vars = [
            'events' => $this->model->events(),
        ];
        $this->view->render($vars);
    }
}