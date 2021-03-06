<?php

namespace app\core;

use app\lib\Db;
use app\lib\Amo;
use app\lib\YandexMoney;
use app\lib\SxGeo;
use app\lib\phpmailer\PHPMailer;
use app\lib\phpmailer\Exception;
use app\lib\phpmailer\SMTP;
use app\lib\MailChimp;

use Imagick;

abstract class Model{

    public $db;
    public $amo;
    public $mailChimp;
    public $auth;
    public $role;
    public $geo;
    public $geoCity;
    public $error;

    public function __construct(){
        $this->db = new Db;
        $this->amo = new Amo;
        $this->mailChimp = new mailChimp();
        $this->yandexMoney = new YandexMoney;
        $this->auth = $this->checkAuth();
        $this->geo = $this->SxGeoCity();
    }

    /**
     * @param $toEmail
     * @param string $toName
     * @param $subject
     * @param $content
     *
     * @return bool
     * @throws Exception
     */
    public function phpmailer($toEmail, $toName = '', $subject, $content){
        if(empty($toEmail)){
            return false;
        }
        $config = require 'app/config/mail.php';

        $mail = new PHPMailer();
        $mail->CharSet = 'UTF-8';

        //Server settings
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = 0;

        $mail->Host = $config['host'];
        $mail->Username = $config['username'];
        $mail->Password = $config['password'];

        $mail->setFrom($config['username'], $config['name']);

        if(isset($toName)){
            $mail->addAddress($toEmail, $toName);
        }
        else{
            $mail->addAddress($toEmail);
        }

        //файлы
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // вставка файла ('путь','название(не обязательно)')

        //Контент
        $mail->Subject = $subject;
        ob_start();
        require 'app/views/layouts/mail.php';
        $body = ob_get_clean();

        $mail->msgHTML($body);
        //$mail->AltBody = 'Сообщение от киношколы iPlay. Рекомендуется просмотр с содержимым';

        if(!$mail->send()){
            //echo "Mailer Error: " . $mail->ErrorInfo;
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * @return string
     */
    protected function checkAuth(){
        if(isset($_SESSION['user']['id']) && isset($_SESSION['user']['password'])){
            $params = [
                'id' => $_SESSION['user']['id'],
            ];
            $password = $_SESSION['user']['password'];
        }
        else if(isset($_COOKIE['i']) && isset($_COOKIE['p'])){
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
            if(isset($_SESSION['user']))
                unset($_SESSION['user']);
            setcookie('i', '', time());
            setcookie('p', '', time());
            return 'guest';
        }
        $data = $data[0];

        if($data['password'] != $password){
            if(isset($_SESSION['user']))
                unset($_SESSION['user']);
            setcookie('i', '', time());
            setcookie('p', '', time());
            return 'guest';
        }

        $_SESSION['user'] = $data;
        $this->role = $_SESSION['user']['role'];
        return 'auth';

    }

    /**
     * @param $input
     * @param $data
     *
     * @return bool
     */
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
        foreach($input as $val){
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

    /**
     * @param $name
     * @param $val
     * @param string $table
     *
     * @return mixed
     */
    public function checkExists($name, $val, $table = 'users'){
        $params = [
            $name => $val,
        ];
        return $this->db->column('SELECT `id` FROM '.$table.' WHERE '.$name.' = :'.$name, $params);
    }

    /**
     * @param int $len
     *
     * @return bool|string
     */
    public function createToken($len = 30){
        return substr(str_shuffle(str_repeat('1234567890qwertyuiopasdfghjklzxcvbnm', 20)), 0, $len);
    }

    /**
     * @return array|bool
     */
    protected function SxGeoCity(){
        if(isset($_SESSION['geo'])){
            return $_SESSION['geo'];
        }
        else{
            $ip = $_SERVER['REMOTE_ADDR'];
            if($ip == '127.0.0.1'){
                $ip = '46.147.163.208';
            }

            $SxGeo = new SxGeo('app/lib/SxGeoCity.dat');
            return $_SESSION['geo'] = $SxGeo->getCityFull($ip);
        }
    }

    // todo Функция генерации пагинации
    public function pagination($countElem, $params = []){
        $onPage = (isset($params['onpage'])) ? $params['onpage'] : 10;

        $currentPage = (isset($_GET['page'])) ? intval($_GET['page']) : 1;

        $countPage = ceil($countElem / $onPage);

        if($currentPage > $countPage){
            $currentPage = $countPage;
        }
        else if($currentPage < 1){
            $currentPage = 1;
        }

        $startElem = ($currentPage - 1) * $onPage;

        if($countPage != 1){
            $strPagination = '';
            $url = explode('?', $_SERVER['REQUEST_URI']);
        }
        else{
            $strPagination = '';
        }

        $url = explode('?', $_SERVER['REQUEST_URI']);
        if(isset($url['1'])){
            $params = explode('&', $url['1']);
            foreach($params as $key => $param){
                $paramval = explode('=', $param);
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

    /**
     * @param $file
     * @param $path
     * @param $fileType
     * @param array $thumb
     *
     * @return bool|string
     * @throws \ImagickException
     */
    public function saveFile($file, $path, $fileType, $thumb = []){
        $newFilename = time().$this->createToken(15);
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

        // todo Создание превьюшек
        $uploadFile = $uploadDir.$newFilename;
        if($path == 'public/img/users/'){
            $uploadFileThumb = $uploadDir.'thumb/'.$newFilename;
            $image = new Imagick($file['tmp_name']);
            $image->setImageCompressionQuality(80);
            $image->cropThumbnailImage(100, 100);
            $image->writeImage($uploadFileThumb);
        }
        if($path = 'public/img/projects/videos'){
            $uploadFileThumb = $uploadDir.$newFilename;
            $image = new Imagick($file['tmp_name']);
            $image->setImageCompressionQuality(80);
            $image->cropThumbnailImage(293, 165);
            $image->writeImage($uploadFileThumb);
        }
        if($path != 'public/img/projects/videos'){
            if(!move_uploaded_file($file['tmp_name'], $uploadFile)){
                $this->error = 'Не удалось осуществить сохранение файла';
                return false;
            }
        }

        return $newFilename;
    }

    /**
     * @param $datetime
     *
     * @return false|int
     */
    public function toUnixTime($datetime){
        $datetimeAr = explode(' ', $datetime);
        $date = $datetimeAr[0];
        $time = $datetimeAr[1];

        $dateAr = explode('.', $date);
        $d = $dateAr[0];
        $m = $dateAr[1];
        $y = $dateAr[2];

        $timeAr = explode(':', $time);
        $h = $timeAr[0];
        $i = $timeAr[1];
        $s = $timeAr[2];

        return mktime($h, $i, $s, $m, $d, $y);
    }

    /**
     * @param $strings
     *
     * @return mixed
     */
    public function processTextIn($strings){
        foreach($strings as $key => $string){
            $newstring = trim($string);
            $newstring = strip_tags($newstring);
            $newstring = htmlspecialchars($newstring);
            if(in_array($key, ['description', 'caption', 'content', 'about'])){
                $newstring = '<p>'.$newstring.'</p>';
                $newstring = preg_replace("/(\r\n){3,}/", "\r\n\r\n", $newstring);
                $newstring = preg_replace('/\r\n/', '</p><p>', $newstring);
                $newstring = preg_replace(array('/\[b\]/', '/\[\/b\]/'), array("<b>", "</b>"), $newstring);
            }
            else{
                $newstring = preg_replace(array("/\r\n/"), '<br>', $newstring);
            }
            $newstrings[$key] = $newstring;
        }
        return $newstrings;
    }

    /**
     * @param $strings
     *
     * @return mixed
     */
    public function processTextOut($strings){
        foreach($strings as $key => $string){
            $newstring = $string;
            $newstring = preg_replace(array('/\<b\>/', '/\<\/b\>/'), array('[b]', '[/b]'), $newstring);
            $newstring = preg_replace(array('/\<br\>/', '/\<\/p\>\<p\>/'), "\r\n", $newstring);
            $newstring = preg_replace(array('/\<p\>/', '/\<\/p\>/'), "", $newstring);
            $newstrings[$key] = $newstring;
        }
        return $newstrings;
    }

    /**
     * @param $data
     */
    public function questionForm($data){
        $varsAmo = [
            'name' => 'Вопрос',
        ];
        if(isset($data['page'])){
            $varsAmo['page'] = $data['page'];
        }

        if(isset($_SESSION['user'])){
            $varsAmo['contact_id'] = $_SESSION['user']['amoid'];
        }
        else if(isset($data['email'])){
            if($amoContact = $this->amo->searchContact($data['email'])){
                $varsAmo['contact_id'] = $amoContact['id'];
            }
            else{
                $notes[] = 'Email: '.$data['email'];
                $notes[] = 'ФИО: '.$data['fio'];
            }
        }

        $notes[] = 'Вопрос: '.$data['question'];

        $lead = $this->amo->newLead($varsAmo);
        $this->amo->addNotesLead($lead, $notes);
    }
}