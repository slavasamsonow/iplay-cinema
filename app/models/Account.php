<?php

namespace app\models;

use app\core\Model;

class Account extends Model{

    public function login($username, $remember = ''){
        if(preg_match('#@#', $username)){
            $params = [
                'email' => $username,
            ];
            $data = $this->db->row('SELECT * FROM `users` WHERE `email` = :email', $params)[0];
        }else{
            $params = [
                'username' => $username,
            ];
            $data = $this->db->row('SELECT * FROM `users` WHERE `username` = :username', $params)[0];
        }
        $_SESSION['user'] = $data;
        if($remember == 'remember'){
            setcookie('i', $data['id'], time()+3600*24*30, '/');
            setcookie('p', $data['password'], time()+3600*24*30, '/');
        }else{
            setcookie('i','',time(),'/');
            setcookie('p','',time(),'/');
        }
        return true;
    }

    public function register($data){
        $token = $this->createtoken(20);
        $params = [
            'email' => $data['email'],
            'createdon' => time(),
            'token' => $token,
        ];

        if(isset($data['username'])){
            $params['username'] = $data['username'];
            $login = $data['username'];
        }else{
            $login = $data['email'];
        }

        if(isset($data['phone'])){
            $params['phone'] = $data['phone'];
        }

        if(isset($data['fio'])){
            $fio = explode(' ', $data['fio']);
            $params['fname'] = $fio[0];
            if(isset($fio[1])){
                $params['lname'] = $fio[1];
            }
        }

        if(isset($data['fname'])){
            $params['fname'] = $data['fname'];
        }
        if(isset($data['lname'])){
            $params['lname'] = $data['lname'];
        }

        if(isset($data['city'])){
            $params['city'] = $data['city'];
        }

        if(isset($data['password'])){
            $password = $data['password'];
        }else{
            $password = $this->createtoken(10);
        }
        $params['password'] = password_hash($password, PASSWORD_BCRYPT);

        if($amo = $this->amo->searchContact($data['email'])){
            $params['amoid'] = $amo['id'];
        }else{
            if(isset($data['fio'])){
                $varsAmo['name'] = $data['fio'];
            }else if(isset($data['fname'])){
                $varsAmo['name'] = $data['fname'];
                if(isset($data['lname'])){
                    $varsAmo['name'] .= $data['lname'];
                }
            }else{
                $varsAmo['name'] = $data['email'];
            }

            $varsAmo['email'] = $data['email'];
            if(isset($data['phone'])){
                $varsAmo['phone'] = $data['phone'];
            }
            if(isset($data['city'])){
                $varsAmo['city'] = $data['city'];
            }
            $params['amoid'] = $this->amo->newContact($varsAmo);
        }

        $paramNV = $this->db->paramNandV($params);


        $this->db->query('INSERT INTO `users` ('.$paramNV['N'].') VALUES ('.$paramNV['V'].')', $params);
        $id = $this->db->lastInsertId();
        $params['id'] = $id;

        $this->createUserCourse(2, $id);

        $email = $data['email'];
        $name = $email;
        $subject = 'Подтвердите свой email';
        $body = '<h1>Подтвердите свой email для входа в портал</h1>';
        $body .= '
        <p>Вы зарегестрировались на портале киношколы iPlay. Для продолжения работы нужно подтвердить email по ссылке ниже</p>
        <p><a href="'.$_SERVER['SERVER_NAME'].'/confirmation?id='.$id.'&token='.$token.'">Активировать аккаунт</a></p>
        <p>
        Ваши данные для входа: <br>
            <b>Логин:</b> <br> '.$login.' <br>
            <b>Пароль:</b> <br> '.$password.' <br>
            <small>Вы можете сменить пароль в личном кабинете на сайте</small>
        </p>
        ';

        if($this->phpmailer($email, $name, $subject, $body) != true){
            $this->error = 'Ошибка отправки';
            return false;
        }

        return $params;
    }

    public function confirmation($id, $token){
        $params = [
            'id' => $id,
            'token' => $token,
        ];
        $data = $this->db->row('SELECT * FROM `users` WHERE `id` = :id AND `token` = :token', $params);

        if(empty($data)){
            return false;
        }

        $user = $data[0];

        $params = [
            'active' => 1,
        ];

        $paramNV = $this->db->paramNV($params);

        $params['id'] = $id;
        $params['token'] = $token;

        $this->db->query('UPDATE `users` SET `token` = NULL, '.$paramNV.' WHERE `id` = :id AND `token` = :token', $params);

        if(isset($_SESSION['id'])){
            $_SESSION['user']['active'] = 1;
            $_SESSION['user']['token'] = '';
        }

        $email = $user['email'];
        $name = $email;
        $subject = 'Добро пожаловать в киношколу!';
        $body = '<h1>Киношкола iPlay открывает свои двери</h1>';
        $body .= '
        <p>Ваш email подтвержден.</p>
        ';
        if($this->phpmailer($email, $name, $subject, $body) != true){
            $this->error = 'Ошибка отправки';
            return false;
        }
        return true;
    }

    // Проверка правильности логина и пароля
    public function checkUser($username, $password){
        if(preg_match('#@#', $username)){
            $params = [
                'email' => $username,
            ];
            $hash = $this->db->column('SELECT `password` FROM `users` WHERE `email` = :email', $params);
        }else{
            $params = [
                'username' => $username,
            ];
            $hash = $this->db->column('SELECT `password` FROM `users` WHERE `username` = :username', $params);
        }
        if(!$hash or !password_verify($password, $hash)){
            return false;
        }
        return true;
    }

    // Смена данных
    public function saveUserData($id, $data){
        foreach($data as $key=>$val){
            $params[$key] = $val;
            if($key == 'password'){
                $_SESSION['user']['password'] = $val;
                if(isset($_COOKIE['p'])){
                    setcookie('p',$data[$key], time()+3600+24+30, '/');
                }
            }
        }

        $paramNV = $this->db->paramNV($params);

        $params['id'] = $id;

        $this->db->query('UPDATE `users` SET '.$paramNV.' WHERE `id` = :id', $params);
    }

    // Список курсов
    public function activeCoursesList(){
        $params = [
            'userid' => $_SESSION['user']['id'],
        ];
        return $this->db->row('SELECT c.id, c.timestart, c.type, c.name, c.description, uc.percent FROM courses c JOIN user_courses uc ON c.id = uc.course WHERE uc.user = :userid', $params);
    }

    public function createUserCourse($course, $user){
        $params = [
            'course' => $course,
            'user' => $user,
        ];
        $course = $this->db->column('SELECT id FROM `user_courses` WHERE `course` = :course AND `user` = :user',$params);

        if(!empty($course)){
            $this->error = 'У этого пользователя уже есть такой курс';
            return false;
        }

        $this->db->query('INSERT INTO `user_courses` (`course`, `user`) VALUES (:course, :user)', $params);
        return true;
    }

    public function usersList($param = []){
        $countElem = $this->db->column('SELECT COUNT(*) FROM `users`');
        //$pagination = $this->pagination($countElem);

        /*$params = [
            'start' => (int) $pagination['start'],
            'limit' => (int) $pagination['limit']
        ];*/

        if(isset($_SESSION['user']['id'])){
            $params['userId'] = $_SESSION['user']['id'];
            $noId = 'AND `id` != :userId';
        }

        //$usersList = $this->db->row('SELECT `id`, `username`, `fname`, `lname`, `photo` FROM `users` WHERE `active` = 1 '.$noId.' LIMIT :start,:limit', $params);
        $usersList = $this->db->row('SELECT `id`, `username`, `fname`, `lname`, `photo` FROM `users` WHERE `active` = 1 '.$noId, $params);
        foreach($usersList as $key => $user){
            if($user['username'] == ''){
                $usersList[$key]['username'] = 'id'.$user['id'];
            }
        }
        return $usersList;
    }

    public function userInfo($username){
        if(preg_match('/^id[0-9]+$/', $username)){
            $params = [
                'id' => substr($username, 2),
            ];
            $usl = 'WHERE id = :id';
        }else{
            $params = [
                'username' => $username,
            ];
            $usl = 'WHERE username = :username';
        }
        $userData = $this->db->row('SELECT `id`, `fname`, `lname`, `about`, `video`, `photo` FROM `users` '.$usl, $params);
        if(empty($userData)){
            return false;
        }
        return $userData[0];
    }

    public function userProjects($userid){
        $params = [
            'userid' => $userid
        ];
        return $this->db->row('SELECT p.id, p.name FROM projects p JOIN users u ON p.creator = u.id WHERE p.active = 1 AND u.id = :userid', $params);
    }
}