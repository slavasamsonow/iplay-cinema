<?php

namespace app\controllers;

use app\core\Controller;

class AccountController extends Controller{

    public function registerAction(){
        if(!empty($_POST)){
            if(!$this->model->validate(['username','email','password'], $_POST)){
                $this->view->message('Ошибка', $this->model->error);
            }
            elseif($this->model->checkExists('username', $_POST['username'])){
                $this->view->message('Ошибка', 'Пользователь с таким логином уже существует');
            }
            elseif($this->model->checkExists('email', $_POST['email'])){
                $this->view->message('Ошибка', 'Пользователь с таким E-mail уже существует');
            }
            $this->model->register($_POST);
            $this->view->message('OK', 'регистрируем!');
        }
        if($this->model->auth == 'guest'){
            $this->view->redirect('account');
            //$this->view->render('Регистрация');
        }else{
            $this->view->redirect('account');
        }
    }

    public function confirmationAction(){
        if(!empty($_GET)){
            if(isset($_GET['id']) && isset($_GET['token'])){
                $id = $_GET['id'];
                $token = $_GET['token'];
                if(!$this->model->confirmation($id, $token)){
                    $this->view->errorCode(404);
                }
                $this->view->render();
                $this->view->redirect('account');
            }else{
                $this->view->errorCode(404);
            }
        }
        else{
            $this->view->errorCode(404);
        }

    }

    public function loginAction(){
        if(!empty($_POST)){
            if(!$this->model->checkUser($_POST['username'], $_POST['password'])){
                $this->view->message('Ошибка', 'Логин или пароль указаны неверно');
            }
            if(isset($_POST['remember'])){
                $remember = $_POST['remember'];
            }else{
                $remember = '';
            }
            $this->model->login($_POST['username'], $remember);
            $this->view->location('account');
        }
        if($this->model->auth == 'guest'){
            $vars = [
                'seo' => [
                    'title' => 'Вход в личный кабинет',
                ]
            ];
            $this->view->render($vars);
        }else{
            $this->view->redirect('account');
        }
    }

    public function indexAction(){
        if($this->model->auth == 'auth'){
            //$activeCourses = $this->model->activeCoursesList();
            /*$vars = [
                'activeCourses' => $activeCourses,
            ];*/
            $this->view->render();
        }else{
            $this->view->redirect('login');
        }
    }

    public function logoutAction(){
        setcookie('i','',time(),'/');
        setcookie('p','',time(),'/');
        unset($_SESSION['user']);
        $this->view->redirect('login');
    }

    public function editpasswordAction(){
        if(!empty($_POST)){
            if(!$this->model->validate(['password'], $_POST)){
                $this->view->message('Ошибка', $this->model->error);
            }
            elseif($_POST['password'] != $_POST['password_confim']){
                $this->view->message('Ошибка', 'Пароли не совпадают');
            }
            elseif(!password_verify($_POST['oldpassword'], $_SESSION['user']['password'])){
                $this->view->message('Ошибка', 'Старый пароль указан неверно');
            }
            $data = [
                'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            ];
            $this->model->saveUserData($_SESSION['user']['id'], ['password'], $data);
            $this->view->location('account');
        }
        if($this->model->auth == 'auth'){
            $this->view->render('Сменить пароль');
        }else{
            $this->view->redirect('login');
        }
    }

}