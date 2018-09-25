<?php

namespace app\models;

use app\core\Model;

class Pay extends Model{
    public function courseInfo($id){
        $params = [
            'id' => $id,
        ];
        $course = $this->db->row('SELECT courses.id, courses.name, courses.timestart, courses.active, courses_type.price, courses_type.name AS `type` FROM courses JOIN courses_type ON courses.type=courses_type.id WHERE courses.id=:id AND courses.type IS NOT NULL', $params);
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

    public function createPayment($data){
        $params = [
            'user' => $_SESSION['user']['id'],
            'course' => $data['id'],
        ];
        $payment = $this->db->row('SELECT `id`, `createdon`, `amoid` FROM `payments` WHERE `user` = :user AND `course` = :course', $params);
        if($payment && (int) $payment[0]['createdon'] + 3600*24 >= time()){
            $idempotence = $payment[0]['createdon'];
            $id = $payment[0]['id'];
            $amoid = $payment[0]['amoid'];
        }
        else{
            $varsAmo = [
                'sale' => $data['price'],
                'nameCourse' => $data['name'],
                // Еще номер amoid!
            ];
            $amoid = $this->amo->newLead($varsAmo);

            $params = [
                'amoid' => $amoid,
                'createdon' => time(),
                'user' => $_SESSION['user']['id'],
                'course' => $data['id'],
                'amount' => $data['price'],
                'status' => 'start',
                'description' => 'Пользователь '.$_SESSION['user']['fname'].' '.$_SESSION['user']['lname'].' за '.$data['name'],
            ];

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

        $this->db->query('INSERT INTO `payments` ('.$paramNV['N'].') VALUES ('.$paramNV['V'].')', $params);

        $this->amo->updateStatusLead($payment['amoid'], 142);
    }
}