<?php

namespace app\models;

use app\core\Model;

class Pay extends Model{
    public function courseInfo($id){
        $params = [
            'id' => $id,
        ];
        $course = $this->db->row('SELECT courses.id, courses.name, courses.timestart, courses.active, courses.payment, courses.description, courses_type.price, courses_type.name AS `type` FROM courses JOIN courses_type ON courses.type=courses_type.id WHERE courses.id=:id AND courses.type IS NOT NULL', $params);
        if(!empty($course)){
            return $course[0];
        }else{
            return false;
        }
    }

    public function checkPayment($courseId){
        $params = [
            'user' => $_SESSION['user']['id'],
            'course' => $courseId,
        ];
        return $this->db->row('SELECT `status` FROM `payments` WHERE `user` = :user AND `course` = :course ORDER BY `id` DESC', $params);
    }

    public function createPayment($data, $dataPayer = []){
        $params = [
            'course' => $data['id'],
        ];
        if(!empty($dataPayer)){
            $params['email'] = $dataPayer['email'];
            $payment = $this->db->row('SELECT `id`, `createdon`, `amoid` FROM `payments` WHERE `email` = :email AND `course` = :course', $params);
        }else if(isset($_SESSION['user']['id'])){
            $params['user'] = $_SESSION['user']['id'];
            $payment = $this->db->row('SELECT `id`, `createdon`, `amoid` FROM `payments` WHERE `user` = :user AND `course` = :course', $params);
        }

        if($payment && (int) $payment[0]['createdon'] + 3600*24 >= time()){
            $idempotence = $payment[0]['createdon'];
            $id = $payment[0]['id'];
            $amoid = $payment[0]['amoid'];
        }
        else{
            $varsAmo = [
                'sale' => $data['price'],
                'nameCourse' => $data['name'],
            ];
            if(!empty($dataPayer)){
                if($AmoContact = $this->amo->searchContact($dataPayer['email'])){
                    $varsAmo['contact_id'] = $AmoContact;
                }else{
                    $varsAmoNew = [
                        'email' => $dataPayer['email'],
                    ];

                    if(isset($dataPayer['fio'])){
                        $varsAmoNew['name'] = $dataPayer['fio'];
                    }else{
                        $varsAmoNew['name'] = $dataPayer['email'];
                    }

                    if(isset($dataPayer['city'])){
                        $varsAmoNew['city'] = $dataPayer['city'];
                    }

                    if(isset($dataPayer['phone'])){
                        $varsAmoNew['phone'] = $dataPayer['phone'];
                    }

                    $varsAmo['contact_id'] = $this->amo->newContact($varsAmoNew);
                }
            }else if(isset($_SESSION['user']['amoid'])){
                $varsAmo['contact_id'] = $_SESSION['user']['amoid'];
            }
            $amoid = $this->amo->newLead($varsAmo);

            $params = [
                'amoid' => $amoid,
                'createdon' => time(),
                'course' => $data['id'],
                'amount' => $data['price'],
                'status' => 'start',
            ];
            if(!empty($dataPayer)){
                $params['email'] = $dataPayer['email'];
                $params['description'] = 'Оплата без регистрации email: '.$dataPayer['email'].' за '.$data['name'];
            }else if(isset($_SESSION['user']['id'])){
                $params['user'] = $_SESSION['user']['id'];
                $params['description'] = 'Пользователь '.$_SESSION['user']['fname'].' '.$_SESSION['user']['lname'].' за '.$data['name'];
            }
            $paramNV = $this->db->paramNandV($params);

            $this->db->query('INSERT INTO `payments` ('.$paramNV['N'].') VALUES ('.$paramNV['V'].')', $params);
            $idempotence = $params['createdon'];
            $id = $this->db->lastInsertId();
        }

        $paymentData = [
            'idempotence' => $idempotence,
            'amount' => $data['price'],
            'name' => $data['name'],
            'type' => $data['type'],
        ];
        if(!empty($dataPayer)){
            $paymentData['email'] = $dataPayer['email'];
        }else if(isset($_SESSION['user']['email'])){
            $paymentData['email'] = $_SESSION['user']['email'];
        }

        $yandexPaymentData = $this->yandexMoney->createPayment($paymentData);

        if(isset($yandexPaymentData['type']) && $yandexPaymentData['type'] == 'error'){
            return false;
        }
        $params = [
            'id' => $id,
            'yandexid' => $yandexPaymentData['id'],
        ];
        $this->db->query('UPDATE `payments` SET `yandexid` = :yandexid WHERE `id` = :id', $params);
        return [
            'amoid' => $amoid,
            'paymentid' => $id,
            'yandexConfirmation' => $yandexPaymentData['confirmation']['confirmation_url'],
        ];
    }

    public function uploadPayment($data){
        $params = [
            'id' => $data['paymentid'],
            'status' => 'pending',
        ];
        $this->db->query('UPDATE `payments` SET `status` = :status WHERE `id` = :id', $params);

        $this->amo->updateStatusLead($data['amoid'], 21604234);
    }

    public function checkPaymentSuccess($yandexPaymentId){
        $yandexPaymentData = $this->yandexMoney->getPaymentInfo($yandexPaymentId);
        if($yandexPaymentData['status'] == 'succeeded'){
            return true;
        }else{
            return false;
        }
    }

    public function paymentSuccess($yandexPaymentId){
        $params = [
            'yandexid' => $yandexPaymentId,
        ];
        $payment = $this->db->row('SELECT * FROM `payments` WHERE `yandexid` = :yandexid',$params)[0];

        $params = [
            'id' => $payment['id'],
            'status' => 'succeeded',
        ];
        $this->db->query('UPDATE `payments` SET `status` = :status WHERE `id` = :id', $params);

        $params = [
            'user' => $payment['user'],
            'course' => $payment['course'],
        ];
        $paramNV = $this->db->paramNandV($params);

        $this->db->query('INSERT INTO `payments` ('.$paramNandV['N'].') VALUES ('.$paramNandV['V'].')', $params);

        $this->amo->updateStatusLead($payment['amoid'], 142);
    }
}