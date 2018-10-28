<?php

namespace app\models;

use app\core\Model;

class Pay extends Model{
    public function courseInfo($id){
        $params = [
            'id' => $id,
        ];
        $course = $this->db->row('SELECT c.*, ct.eng AS `type` FROM courses c JOIN courses_type ct ON c.type = ct.id WHERE c.id=:id', $params);
        if(empty($course)){
            return false;
        }
        return $course[0];
    }

    public function checkUserCourse($courseid){
        $params = [
            'user' => $_SESSION['user']['id'],
            'course' => $courseid,
        ];
        return $this->db->column('SELECT uc.id FROM user_courses uc WHERE uc.user = :user AND uc.course = :course', $params);
    }

    public function openPayPage($courseid){
        //Отправляются данные в АМО
    }

    public function checkPayment($courseId){
        $params = [
            'user' => $_SESSION['user']['id'],
            'course' => $courseId,
        ];
        return $this->db->row('SELECT `status` FROM `payments` WHERE `user` = :user AND `course` = :course ORDER BY `id` DESC', $params);
    }

    public function checkPromocode($courseid, $promocode){
        $params = [
            'course' => $courseid,
            'code' => $promocode,
            'all' => 'all'
        ];
        $sale = $this->db->row('SELECT pp.* FROM payments_promocode pp WHERE pp.course IN (:all, :course) AND pp.code = :code', $params);
        if(empty($sale)){
            return false;
        }else{
            return $sale[0]['sale'];
        }
    }

    public function pricePromocode($course, $promocode){
        if(!$sale = $this->checkPromocode($course['id'], $promocode)){
            return $course['price'];
        }

        if(strpos($sale, '%') !== false){
            $saleSum = $course['price'] / 100 * $sale;
            $newPrice = floor($course['price'] - $saleSum);
        }else{
            $newPrice -= $sale;
        }

        return $newPrice;
    }

    public function createPayment($course, $price, $dataPayer){
        $userid = 0;
        $useremail = 0;
        if(isset($_SESSION['user']['id'])){
            $userid = $_SESSION['user']['id'];
            $user = $_SESSION['user'];
        }else if(isset($dataPayer['email'])){
            if($userid = $this->checkExists('email', $dataPayer['email'])){
                $params = [
                    'id' => $userid,
                ];
                $user = $this->db->row('SELECT u.* FROM users u WHERE u.id = :id', $params)[0];
            }
            if(!$userid){
                $useremail = $dataPayer['email'];
                $userid = 0;
            }
        }else{
            return [
                'error' => 'Нет данных о пользователе'
            ];
        }

        if(isset($user)){
            $params = [
                'user' => $user['id'],
                'course' => $course['id'],
            ];
            $user_course = $this->db->row('SELECT uc.* FROM user_courses uc WHERE uc.user = :user AND uc.course = :course', $params);
            if(!empty($user_course)){
                return [
                    'error' => 'У данного пользователя уже есть этот курс',
                ];
            }
        }

        $params = [
            'course' => $course['id'],
            'amount' => $price,
            'email' => $useremail,
            'user' => $userid
        ];

        $payment = $this->db->row('SELECT p.* FROM payments p WHERE (p.email = :email OR p.user = :user) AND p.course = :course AND p.amount = :amount ORDER BY p.createdon DESC', $params);

        if($payment && (int) $payment[0]['createdon'] + 3600*24 >= time()){
            $idempotence = $payment[0]['createdon'];
            $id = $payment[0]['id'];
            $amoid = $payment[0]['amoid'];
        }
        else{
            $varsAmo = [
                'name' => 'Покупка на сайте',
                'sale' => $price,
                'nameCourse' => $course['name'],
                'status_id' => 21604234,
            ];
            if($price == 0){
                $varsAmo['name'] = 'Бесплатно';
                $varsAmo['status_id'] = 22355580;
            }

            if(isset($user['amoid'])){
                $varsAmo['contact_id'] = $user['amoid'];
            }else if(!empty($dataPayer)){
                if($AmoContact = $this->amo->searchContact($useremail)){
                    $varsAmo['contact_id'] = $AmoContact['id'];
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
            }
            $amoid = $this->amo->newLead($varsAmo);
            if($price == 0){
                if($userid != 0){
                    $params = [
                        'user' => $userid,
                        'course' => $course['id'],
                    ];
                    $paramNV = $this->db->paramNandV($params);
                    $this->db->query('INSERT INTO user_courses ('.$paramNV['N'].') VALUES ('.$paramNV['V'].')', $params);
                }
                return 'freePayment';
            }

            $params = [
                'amoid' => $amoid,
                'createdon' => time(),
                'course' => $course['id'],
                'amount' => $price,
                'status' => 'pending',
            ];
            if(isset($user)){
                $params['user'] = $user['id'];
                $params['description'] = 'Пользователь '.$user['fname'].' '.$user['lname'].' за '.$course['name'];
            }else{
                $params['email'] = $dataPayer['email'];
                $params['description'] = 'Оплата без регистрации email: '.$dataPayer['email'].' за '.$course['name'];
            }
            $paramNV = $this->db->paramNandV($params);

            $this->db->query('INSERT INTO `payments` ('.$paramNV['N'].') VALUES ('.$paramNV['V'].')', $params);
            $idempotence = $params['createdon'];
            $id = $this->db->lastInsertId();
        }

        $paymentData = [
            'idempotence' => $idempotence,
            'amount' => $price,
            'name' => $course['name'],
        ];
        if(isset($user)){
            $paymentData['email'] = $user['email'];
        }else{
            $paymentData['email'] = $dataPayer['email'];
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
            'yandexConfirmation' => $yandexPaymentData['confirmation']['confirmation_url'],
        ];
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

        if($payment['user'] != '0'){
            $params = [
                'user' => $payment['user'],
                'course' => $payment['course'],
            ];
            $paramNandV = $this->db->paramNandV($params);

            $this->db->query('INSERT INTO `user_courses` ('.$paramNandV['N'].') VALUES ('.$paramNandV['V'].')', $params);
        }

        $this->amo->updateStatusLead($payment['amoid'], 142);
    }
}