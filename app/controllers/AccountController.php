<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Account;

class AccountController extends Controller{

    /* @var $model Account */
    public $model;

    /**
     * Главная страница
     */
    public function indexAction(){
        if($this->model->auth == 'auth'){
            $this->view->redirect('study');
        }
        else{
            $this->view->redirect('login');
        }
    }

    /**
     * Страница регистрации
     * @throws \app\lib\phpmailer\Exception
     */
    public function registerAction(){
        if(!empty($_POST)){
            if(!$this->model->validate(['email', 'password'], $_POST)){
                $this->view->message('Ошибка', $this->model->error);
            }
            else if($this->model->checkExists('email', $_POST['email'])){
                $this->view->message('Ошибка', 'Пользователь с таким E-mail уже существует');
            }
            $this->model->register($_POST);
            if($_POST['request_url']){
                $this->view->location('login?request_url='.$_POST['request_url']);
            }
            else{
                $this->view->location('login');
            }
            $this->view->message('OK', 'регистрируем!');
        }
        if($this->model->auth == 'guest'){
            $this->view->render('Регистрация');
        }
        else{
            $this->view->redirect('account');
        }
    }

    /**
     * Страница подтверждения email
     * @throws \app\lib\phpmailer\Exception
     */
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
            }
            else{
                $this->view->errorCode(404);
            }
        }
        else{
            $this->view->errorCode(404);
        }

    }

    /**
     * Страница входа
     */
    public function loginAction(){
        if(!empty($_POST)){
            if(!$this->model->checkUser($_POST['username'], $_POST['password'])){
                $this->view->message('Ошибка', 'Логин или пароль указаны неверно');
            }
            if(isset($_POST['remember'])){
                $remember = $_POST['remember'];
            }
            else{
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
        }
        else{
            $this->view->redirect('account');
        }
    }

    /**
     * Страница выхода
     */
    public function logoutAction(){
        setcookie('i', '', time(), '/');
        setcookie('p', '', time(), '/');
        unset($_SESSION['user']);

        if(isset($_SERVER['HTTP_REFERER'])){
            if(strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME'])){
                $urlInnerPos = strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'].'/');
                $urlInner = substr($_SERVER['HTTP_REFERER'], $urlInnerPos + iconv_strlen($_SERVER['HTTP_HOST']) + 1);
                $this->view->redirect($urlInner);
            }
        }
        $this->view->redirect('login');
    }

    /**
     * Страница редактирования пароля
     */
    public function editpasswordAction(){
        if(!empty($_POST)){
            if(!$this->model->validate(['password'], $_POST)){
                $this->view->message('Ошибка', $this->model->error);
            }
            else if($_POST['password'] != $_POST['password_confim']){
                $this->view->message('Ошибка', 'Пароли не совпадают');
            }
            else if(!password_verify($_POST['oldpassword'], $_SESSION['user']['password'])){
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
        }
        else{
            $this->view->redirect('account');
        }
    }

    /**
     * Страница редактирования информации
     * @throws \ImagickException
     */
    public function editinfoAction(){
        if(!empty($_POST)){
            if($_POST['username'] != ''){
                $_POST['username'] = mb_strtolower($_POST['username']);
                if(!$this->model->validate(['username'], $_POST)){
                    $this->view->message('Ошибка', $this->model->error);
                }
                if($_POST['username'] != $_SESSION['user']['username']){
                    if($this->model->checkExists('username', $_POST['username'])){
                        $this->view->message('Ошибка', 'Пользователь с таким логином уже существует');
                    }
                }
            }


            foreach($_POST as $key => $postD){
                $data[$key] = htmlentities($postD);
            }
            if(isset($data['public'])){
                if($data['public'] == 'public'){
                    $data['public'] = 1;
                }
                else{
                    $data['public'] = 0;
                }
            }
            else{
                $data['public'] = 0;
            }

            if(isset($_FILES['photo']['tmp_name']) && $_FILES['photo']['tmp_name'] != ''){
                if($file = $this->model->saveFile($_FILES['photo'], 'public/img/users/', 'image')){
                    $data['photo'] = $file;
                    if(!empty($data['oldphoto'])){
                        $oldPhotoPath = $_SERVER['DOCUMENT_ROOT'].'/public/img/users/'.$data['oldphoto'];
                        $oldPhotoThumbPath = $_SERVER['DOCUMENT_ROOT'].'/public/img/users/thumb/'.$data['oldphoto'];
                        if(file_exists($oldPhotoPath)){
                            unlink($oldPhotoPath);
                        }
                        if(file_exists($oldPhotoThumbPath)){
                            unlink($oldPhotoThumbPath);
                        }
                    }
                }
            }
            unset($data['oldphoto']);

            $this->model->saveUserData($_SESSION['user']['id'], $data);
            $this->view->location('account');
        }
        if($this->model->auth == 'auth'){
            $vars = [
                'seo' => [
                    'title' => 'Редактирование информации'
                ]
            ];
            $this->view->render($vars);
        }
        else{
            $this->view->redirect('account');
        }
    }

    /**
     * Список пользователей
     */
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
        }
        else{
            $this->view->redirect('account');
        }
    }

    /**
     * Страница пользователя
     */
    public function userAction(){
        if(!$userPage = $this->model->userInfo($this->route['username'])){
            $this->view->errorCode('404');
        }

        $vars = [
            'seo' => [
                'title' => $userPage['fname'].' '.$userPage['lname'],
            ],
            'userPage' => $userPage,
            'userProjects' => $this->model->userProjects($userPage['id']),
        ];
        $this->view->render($vars);
    }

}