<?php

namespace app\models;

use app\core\Model;

class Main extends Model{
    public function registerForm($data, $user){
        $email = 'slavasamsonow@yandex.ru';
        $name = 'Админ';
        $subject = 'Заявка с сайта';


        $body = "<h1>Заявка с сайта</h1> ";
        $body .= "<p>";
        $body .= "ФИО: ".$data['fio']." <br>";
        $body .= "email: ".$data['email']." <br>";
        $body .= "Телефон: ".$data['phone'];
        $body .= "</p>";

        if($this->phpmailer($email, $name, $subject, $body) != true){
            $this->error = 'Ошибка отправки сообщения';
            return false;
        }

        $varsAmo = [
            'name' => 'Регистрация на мероприятие',
            'contact_id' => $user['amoid'],
        ];
        $amoid = $this->amo->newLead($varsAmo);

        return true;
    }
}