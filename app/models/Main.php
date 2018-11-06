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

    public function events(){
        $params = [
            'timestart' => time(),
        ];
        return $this->db->row('SELECT * FROM courses c WHERE c.type = 1 AND c.timestart > :timestart AND c.active = 1 AND c.private = 0 ORDER BY c.timestart ASC', $params);
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
