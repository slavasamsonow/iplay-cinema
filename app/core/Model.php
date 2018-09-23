<?php

namespace app\core;

use app\lib\Db;
use app\lib\Amo;
use app\lib\YandexMoney;
use app\lib\SxGeo;
use app\lib\phpmailer\PHPMailer;
use app\lib\phpmailer\Exception;
use app\lib\phpmailer\SMTP;

abstract class Model{

    public $db;
    public $amo;
    public $auth;
    public $geo;
    public $geoCity;

    public function __construct(){
        $this->db = new Db;
        $this->amo = new Amo;
        $this->yandexMoney = new YandexMoney;
        $this->auth = $this->checkAuth();
        $this->geo = $this->SxGeoCity();
    }

    public function phpmailer($toEmail, $toName = '', $subject, $body){
        if(empty($toEmail)){
            return false;
        }
        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';

        //Server settings
        //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
        //$mail->isSMTP();                                      // Set mailer to use SMTP
        //$mail->Host = 'smtp.yandex.ru';  // Specify main and backup SMTP servers
        //$mail->SMTPAuth = true;                               // Enable SMTP authentication
        //$mail->Username = 'iplay.videolab@yandex.ru';                 // SMTP username
        //$mail->Password = 'Videolab1';                           // SMTP password
        //$mail->SMTPSecure = 'SSL';                            // Enable TLS encryption, `ssl` also accepted
        //$mail->Port = 465;                                    // TCP port to connect to

        //Данные
        $mail->setFrom('admin@iplay-cinema.ru', 'Киношкола iPlay');
        //$mail->addReplyTo('admin@iplay-cinema.ru', 'Киношкола iPlay');
        if(isset($toName)){
            $mail->addAddress($toEmail, $toName);
        }else{
            $mail->addAddress($toEmail);
        }

        //файлы
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // вставка файла ('путь','название(не обязательно)')

        //Контент
        $mail->Subject = $subject;
        $mail->msgHTML($body);
        //$mail->AltBody = 'Сообщение от киношколы iPlay. Рекомендуется просмотр с содержимым';

        if (!$mail->send()) {
            //echo "Mailer Error: " . $mail->ErrorInfo;
            return false;
        } else {
            return true;
        }
    }

    protected function checkAuth(){
        if(isset($_SESSION['user']['email']) && isset($_SESSION['user']['password'])){
            $params = [
                'email' => $_SESSION['user']['email'],
            ];
            $password = $this->db->column('SELECT `password` FROM `users` WHERE `email` = :email', $params);
            if($password = $_SESSION['user']['password']){
                return 'auth';
            }else{
                unset($_SESSION['user']);
                setcookie('i','',time());
                setcookie('p','',time());
                return 'guest';
            }
        }elseif(isset($_COOKIE['i']) && isset($_COOKIE['p'])){
            $params = [
                'id' => $_COOKIE['i'],
            ];
            $data = $this->db->row('SELECT * FROM `users` WHERE `id` = :id', $params)[0];
            if($data['password'] == $_COOKIE['p']){
                $_SESSION['user'] = $data;
                return 'auth';
            }else{
                setcookie('i','',time());
                setcookie('p','',time());
                return 'guest';
            }
        }else{
            return 'guest';
        }
    }

    public function validate($input, $data){
        $rules = [
            'email' => [
                'pattern' => '#^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$#',
                'message' => 'E-mail адрес указан неверно'
            ],
            'username' => [
                'pattern' => '#^([a-z0-9_-]{3,20})$#',
                'message' => 'Логин указан неверно. <br> Логин может состоять из латинских букв, цифр, знаков - и _, длина логина от 3 до 20 символов'
            ],
            'password' => [
                'pattern' => '#(?=.*\d)(?=.*[A-Za-zА-Яа-я])#',
                'message' => 'Пароль должен содержать минимум букву и цифру'
            ],
            'phone' => [
                'pattern' => '#^((\+7) \(\d{3}\) [\d\-]{7,10})$#',
                'message' => 'Телефон введен неверно'
            ]
        ];
        foreach ($input as $val) {
            if(!isset($data[$val]) || !preg_match($rules[$val]['pattern'], $data[$val])){
                $this->error = $rules[$val]['message'];
                return false;
            }
        }
        if(isset($input['password'])){
            if(iconv_strlen($data['password']) < 10){
                $this->error = 'Длина пароля должна быть больше 10 символов';
                return false;
            }
        }
        return true;
    }

    public function checkExists($name, $val, $table='users'){
        $params = [
            $name => $val,
        ];
        return $this->db->column('SELECT `id` FROM '.$table.' WHERE '.$name.' = :'.$name, $params);
    }

    public function createToken($len = 30){
        return substr(str_shuffle(str_repeat('1234567890qwertyuiopasdfghjklzxcvbnm', 20)),0,$len);
    }

    protected function SxGeoCity(){
        if(isset($_SESSION['geo'])){
            return $_SESSION['geo'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
            if($ip == '127.0.0.1'){
                $ip = '46.147.163.208';
            }

            $SxGeo = new SxGeo('app/lib/SxGeoCity.dat');
            return $_SESSION['geo'] = $SxGeo->getCityFull($ip);
        }
    }

}