<?php

namespace app\controllers;

use app\core\Controller;

class PayController extends Controller{

    public function payAction(){
        if(!empty($_POST)){
            if($this->model->auth == 'auth'){
                $this->model->uploadPayment($_POST);
                $this->view->locationOut($_POST['yandexConfirmation']);
            }else{
                $course = $this->model->courseInfo($this->route['courseid']);
                $paymentData = $this->model->createPayment($course, $_POST);
                $this->model->uploadPayment($paymentData);
                $this->view->locationOut($paymentData['yandexConfirmation']);
            }

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