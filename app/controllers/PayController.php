<?php

namespace app\controllers;

use app\core\Controller;

class PayController extends Controller{

    public function payAction(){
        if(!empty($_POST)){
            if($this->model->auth == 'auth'){
                $paymentData = $_POST;
            }else{
                $course = $this->model->courseInfo($this->route['courseid']);

                if(isset($_POST['promocode'])){
                    $promocode = $_POST['promocode'];
                    if($promocode == 'friendschool' && $course['id'] == 1){
                        $course['price'] = 299;
                    }
                    if($promocode == 'onlyforcinema' && $course['id'] == 1){
                        $course['price'] = 0;
                    }
                }

                if($course['price'] == 0){
                    $varsAmo = [
                        'sale' => $course['price'],
                        'nameCourse' => $course['name'].' Оплачено',
                    ];
                    if($AmoContact = $this->model->amo->searchContact($_POST['email'])){
                        $varsAmo['contact_id'] = $AmoContact;
                    }else{
                        $varsAmoNew = [
                            'email' => $_POST['email'],
                        ];

                        if(isset($_POST['fio'])){
                            $varsAmoNew['name'] = $_POST['fio'];
                        }else{
                            $varsAmoNew['name'] = $_POST['email'];
                        }

                        if(isset($_POST['city'])){
                            $varsAmoNew['city'] = $_POST['city'];
                        }

                        if(isset($_POST['phone'])){
                            $varsAmoNew['phone'] = $_POST['phone'];
                        }

                        $varsAmo['contact_id'] = $this->model->amo->newContact($varsAmoNew);
                    }
                    $amoid = $this->model->amo->newLead($varsAmo);
                    $this->model->amo->updateStatusLead($amoid, 142);

                    $this->view->message('Заявка отправлена', 'Ожидайте, скоро мы с вами свяжемся');
                }

                $paymentData = $this->model->createPayment($course, $_POST);
            }
            $this->model->uploadPayment($paymentData);
            $this->view->locationOut($paymentData['yandexConfirmation']);
        }

        if(!$id = $this->model->checkExists('id', $this->route['courseid'], 'courses')){
            $this->view->redirect('account');
        }
        if(!$course = $this->model->courseInfo($id)){
            $this->view->redirect('account');
        }
        if(!$course['timestart'] > time() || $course['payment'] == 0){
            $this->view->redirect('account');
        }
        $vars = [
            'seo' => [
                'title' => 'Оплата '.$course['name']
            ],
            'course' => $course
        ];

        if($this->model->auth == 'auth'){
            if($payment = $this->model->checkPayment($this->route['courseid'])){
                if($payment[0]['status'] == 'succeeded'){
                    $this->view->redirect('account');
                    exit();
                }
            }
            $vars['pay'] = $paymentData = $this->model->createPayment($course);
        }

        $this->view->layout = 'pay';
        $this->view->render($vars);
    }

    public function yandexkassaAction(){
        $source = file_get_contents('php://input');
        $json = json_decode($source, true);

        if($json['event'] == 'payment.succeeded'){
            $idConfim = $json['object']['id'];
            if($this->model->checkPaymentSuccess($idConfim)){
                $this->model->paymentSuccess($idConfim);
            }
        }
    }

}