<?php

namespace app\models;

use app\core\Model;

class Main extends Model{
    public function registerForm($data, $user){
        $email = 'slavasamsonow@yandex.ru';
        $name = 'Админ';
        $subject = 'Заявка с сайта';


        ob_start();
        ?>
        <h1 style="font-family: Arial, sans-serif;font-size: 18px;">Заявка с сайта</h1>
        <p style="line-height: 1.5em;">
            ФИО: <?=$data['fio']?> <br>
            email: <?=$data['email']?> <br>
            Телефон: <?=$data['phone']?> <br>
        </p>
        <?
        $body = ob_get_clean();

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

    public function events(){
        $params = [
            'timestart' => time(),
        ];
        return $this->db->row('SELECT * FROM courses c WHERE c.type = 1 AND c.timestart > :timestart AND c.active = 1 AND c.private = 0 ORDER BY c.timestart ASC', $params);
    }

    public function resultTestToEmail($test, $result, $data){
        $email = $data['email'];
        $name = $email;
        $subject = "Результаты теста ".$test['name'];

        ob_start();
        ?>
        <h1 style="font-family: Arial, sans-serif;font-size: 18px;">Результаты теста "<?=$test['name']?>"</h1>
        <p style="line-height: 1.5em;"> <?=$result?> </p>
        <p style="text-align: center; font-weight: bold; font-family: Arial, sans-serif;">Узнать подробнее</p>
        <p style="text-align: center;">
            <a href='https://iplay-cinema.ru/lending/intensiv?utm_medium=email&utm_source=email_site&utm_campaign=lead_magnet_profession&utm_content=other'
               style='display: inline-block; padding: 12px 20px; margin-right: 20px; border-radius: 20px; background-color: #d43; color: #fff; font-family: Arial, sans-serif; font-weight: bold;text-decoration: none;'>Интенсив-шоу</a>
            <a href='https://iplay-cinema.ru/course/16?utm_medium=email&utm_source=email_site&utm_campaign=lead_magnet_profession&utm_content=other'
               style='display: inline-block; padding: 12px 20px; border-radius: 20px; background-color: #d43; color: #fff; font-family: Arial, sans-serif; font-weight: bold;text-decoration: none;'>Базовый
                курс</a>
        </p>
        <?
        $body = ob_get_clean();


        if($this->phpmailer($email, $name, $subject, $body) != true){
            $this->error = 'Ошибка отправки сообщения';
            return false;
        }
        return true;
    }

    public function registerCourseUser($data){
        $varsAmo = [
            'name' => 'Заявка на курс',
            'nameCourse' => $data['course'],
            'sale' => 0,
            'contact_id' => $_SESSION['user']['amoid'],
        ];
        $this->amo->newLead($varsAmo);
        return true;
    }

    public function registerСourseGuest($data){
        $varsAmo = [
            'name' => 'Заявка на курс',
            'nameCourse' => $data['course'],
            'sale' => 0,
        ];
        if($amoContact = $this->amo->searchContact($data['email'])){
            $varsAmo['contact_id'] = $amoContact['id'];
            $notes = [
                'Email: '.$data['email'],
                'Телефон: '.$data['phone'],
                'Город: '.$data['city'],
            ];
            $this->amo->addNotesContact($amoContact['id'], $notes);
        }else{
            $varsAmoNew = [
                'email' => $data['email'],
            ];

            if(isset($data['fio'])){
                $varsAmoNew['name'] = $data['fio'];
            }else{
                $varsAmoNew['name'] = $data['email'];
            }

            if(isset($dataPayer['city'])){
                $varsAmoNew['city'] = $data['city'];
            }

            if(isset($dataPayer['phone'])){
                $varsAmoNew['phone'] = $data['phone'];
            }

            $varsAmo['contact_id'] = $this->amo->newContact($varsAmoNew);
        }
        $amoid = $this->amo->newLead($varsAmo);

        return true;
    }

    public function registerCooperation($data){
        $varsAmo = [
            'name' => 'Заявка сотрудничество',
            'sale' => 0,
        ];
        if($amoContact = $this->amo->searchContact($data['email'])){
            $varsAmo['contact_id'] = $amoContact['id'];
            $notes = [
                'Email: '.$data['email'],
                'Телефон: '.$data['phone'],
                'Город: '.$data['city'],
                'Сообщение: '.$data['content']
            ];
            $this->amo->addNotesContact($amoContact['id'], $notes);
        }else{
            $varsAmoNew = [
                'email' => $data['email'],
            ];

            if(isset($data['fio'])){
                $varsAmoNew['name'] = $data['fio'];
            }else{
                $varsAmoNew['name'] = $data['email'];
            }

            if(isset($dataPayer['city'])){
                $varsAmoNew['city'] = $data['city'];
            }

            if(isset($dataPayer['phone'])){
                $varsAmoNew['phone'] = $data['phone'];
            }

            $varsAmo['contact_id'] = $this->amo->newContact($varsAmoNew);
            $notes = [
                'Сообщение: '.$data['content']
            ];
            $this->amo->addNotesContact($varsAmo['contact_id'], $notes);
        }
        $amoid = $this->amo->newLead($varsAmo);
        return true;
    }
}
