<?php

namespace app\core;

use app\lib\Db;
use app\lib\Amo;
use app\lib\YandexMoney;
use app\lib\SxGeo;
use app\lib\phpmailer\PHPMailer;
use app\lib\phpmailer\Exception;
use app\lib\phpmailer\SMTP;

use Imagick;

abstract class Model{

    public $db;
    public $amo;
    public $auth;
    public $role;
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
        if(isset($_SESSION['user']['id']) && isset($_SESSION['user']['password'])){
            $params = [
                'id' => $_SESSION['user']['id'],
            ];
            $password = $_SESSION['user']['password'];
        }
        elseif(isset($_COOKIE['i']) && isset($_COOKIE['p'])){
            $params = [
                'id' => $_COOKIE['i'],
            ];
            $password = $_COOKIE['p'];
        }
        else{
            return 'guest';
        }

        $data = $this->db->row('SELECT * FROM `users` WHERE `id` = :id', $params);

        if(empty($data[0])){
            if(isset($_SESSION['user'])) unset($_SESSION['user']);
            setcookie('i','',time());
            setcookie('p','',time());
            return 'guest';
        }
        $data = $data[0];

        if($data['password'] != $password){
            if(isset($_SESSION['user'])) unset($_SESSION['user']);
            setcookie('i','',time());
            setcookie('p','',time());
            return 'guest';
        }

        $_SESSION['user'] = $data;
        $this->role = $_SESSION['user']['role'];
        return 'auth';

    }

    public function validate($input, $data){
        $rules = [
            'email' => [
                'pattern' => '#^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$#',
                'message' => 'E-mail адрес указан неверно'
            ],
            'username' => [
                'pattern' => '#^[a-zA-Z0-9][a-zA-Z0-9_]{1,20}[a-zA-Z0-9]$#',
                'message' => 'Логин указан неверно. <br> Логин может состоять из латинских букв, цифр, знака _, длина логина от 3 до 20 символов. Логин не должен начинаться и кончаться знаком подчеркивания'
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

            if($val == 'password'){
                if(iconv_strlen($data['password']) < 10){
                    $this->error = 'Длина пароля должна быть больше 10 символов';
                    return false;
                }
            }

            if($val == 'username'){
                if(preg_match('#^id[0-9]+$#', $data['username'])){
                    $this->error = 'Недопустимый логин';
                    return false;
                }
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

    public function pagination($countElem, $params = []){
        $onPage = (isset($params['onpage']))?$params['onpage']:10;

        $currentPage = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

        $countPage = ceil($countElem / $onPage);

        if($currentPage > $countPage){
            $currentPage = $countPage;
        }else if($currentPage < 1){
            $currentPage = 1;
        }

        $startElem = ($currentPage - 1) * $onPage;

        if($countPage != 1){
            $strPagination = '';
            $url = explode('?', $_SERVER['REQUEST_URI']);
        }else{
            $strPagination = '';
        }

        $url = explode('?', $_SERVER['REQUEST_URI']);
        if(isset($url['1'])){
            $params = explode('&', $url['1']);
            foreach($params as $key => $param){
                $paramval = explode('=',$param);
                if($paramval[0] == 'page'){
                    unset($params[$key]);
                }
            }
        }

        //Дописать ссылки на страницы



        $params['page'] = 'page='. 3;
        $fullurl = $url[0].'?'.implode('&', $params);

        $out = [
            'start' => $startElem,
            'limit' => $onPage,
            'pagination' => $strPagination,
        ];
        return $out;
    }

    public function saveFile($file, $path, $fileType = ''){
        $newFilename = $_SESSION['user']['id'].'-'.$this->createToken(15);
        $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/'.$path;

        $types = [
            [
                'type' => 'image',
                'mime' => 'image/jpeg',
                'suf' => '.jpeg'
            ],
            [
                'type' => 'image',
                'mime' => 'image/png',
                'suf' => '.png'
            ]
        ];

        foreach($types as $type){
            if($type['type'] == $fileType && $type['mime'] == $file['type']){
                $fileMime = $type['mime'];
                $newFilename .= $type['suf'];
            }
        }

        if(!isset($fileMime)){
            $this->error = 'Неправильный формат файла';
            return false;
        }

        $uploadFile = $uploadDir . $newFilename;
        if($fileType = 'image'){
            $uploadFileThumb = $uploadDir.'thumb/'.$newFilename;
            $sizeImage = getimagesize($file['tmp_name']);
            $image = new Imagick($file['tmp_name']);
            if($sizeImage[0] > 2000){
                $image->thumbnailImage(2000, 0);
            }else if($sizeImage[1] > 2000){
                $image->thumbnailImage(0, 2000);
            }
            $image->setImageCompressionQuality(80);
            $image->writeImage($uploadFile);
            $image->cropThumbnailImage(100, 100);
            $image->writeImage($uploadFileThumb);
        }
        else{
            if (!move_uploaded_file($file['tmp_name'], $uploadFile)) {
                $this->error = 'Не удалось осуществить сохранение файла';
                return false;
            }
        }

        return $newFilename;
    }

    public function textformatting($data){
        foreach($data as $key => $val){
            $datanew = trim($val);
            $dataout[$key]  = htmlspecialchars($datanew);
        }
        return $dataout;
    }

    public function toUnixtime($datetime){
        $datetimeAr = explode(' ',$datetime);
        $date = $datetimeAr[0];
        $time = $datetimeAr[1];

        $dateAr = explode('.',$date);
        $d = $dateAr[0];
        $m = $dateAr[1];
        $y = $dateAr[2];

        $timeAr = explode(':',$time);
        $h = $timeAr[0];
        $i = $timeAr[1];
        $s = $timeAr[2];

        return mktime($h, $i, $s, $m, $d, $y);
    }
}