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
            if($_POST['request_url']){
                $this->view->location($_POST['request_url']);
            }
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
            $activeCourses = $this->model->activeCoursesList();
            $vars = [
                'seo' => [
                    'title' => 'Личный кабинет',
                ],
                'activeCourses' => $activeCourses,
            ];

            $this->view->render($vars);
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
            $this->model->saveUserData($_SESSION['user']['id'], $data);
            $this->view->location('account');
        }
        if($this->model->auth == 'auth'){
            $vars = [
                'seo' => [
                    'title' => 'Сменить пароль'
                ]
            ];
            $this->view->render($vars);
        }else{
            $this->view->redirect('account');
        }
    }

    public function editinfoAction(){
        if(!empty($_POST)){
            if(!$this->model->validate(['username'], $_POST)){
                $this->view->message('Ошибка', $this->model->error);
            }
            if($_POST['username'] != $_SESSION['user']['username']){
                if($this->model->checkExists('username', $_POST['username'])){
                    $this->view->message('Ошибка', 'Пользователь с таким логином уже существует');
                }
            }

            foreach($_POST as $key => $postD){
                $data[$key] = htmlentities($postD);
            }
            if(isset($data['public'])){
                if($data['public'] == 'public'){
                    $data['public'] = 1;
                }else{
                    $data['public'] = 0;
                }
            }else{
                $data['public'] = 0;
            }

            $this->model->saveUserData($_SESSION['user']['id'], $data);
            $this->view->message('Данные сохранены', '');
        }
        if($this->model->auth == 'auth'){
            $vars = [
                'seo' => [
                    'title' => 'Редактирование информации'
                ]
            ];
            $this->view->render($vars);
        }else{
            $this->view->redirect('account');
        }
    }

    public function usersAction(){
        if($this->model->auth == 'auth'){
            $users = $this->model->usersList($_GET);
            $vars = [
                'seo' => [
                    'title' => 'Пользователи',
                ],
                'users' => $users
            ];
            $this->view->render($vars);
        }else{
            $this->view->redirect('account');
        }
    }

    public function userAction(){
        if(!$userPage = $this->model->userInfo($this->route['username'])){
            $this->view->errorCode('404');
        }
        $vars = [
            'seo' => [
                'title' => $userPage['fname'].' '.$userPage['lname'],
            ],
            'userPage' => $userPage,
        ];
        $this->view->render($vars);
    }

}