<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Pay;

class PayController extends Controller{

    /* @var $model Pay */
    public $model;

    public function payAction(){
        if(!empty($_POST)){
            switch($_POST['action']){
                case 'promocode':
                    if(!isset($_POST['promocode']) || !isset($_POST['course'])){
                        $data = ['error' => 'Нет входных данных'];
                        $this->view->data($data);
                    }
                    if(!$sale = $this->model->checkPromocode($_POST['course'], $_POST['promocode'])){
                        $data = ['error' => 'Недействительный промокод'];
                        $this->view->data($data);
                    }
                    $data = ['sale' => $sale];
                    $this->view->data($data);
                    break;
                case 'pay':
                    unset($_POST['action']);
                    unset($_POST['price']);
                    $course = $this->model->courseInfo($_POST['course']);
                    unset($_POST['course']);

                    $price = $course['price'];
                    if(isset($_POST['promocode'])){
                        $price = $this->model->pricePromocode($course, $_POST['promocode']);
                    }
                    unset($_POST['promocode']);


                    $paymentData = $this->model->createPayment($course, $price, $_POST);
                    if(isset($paymentData['error'])){
                        $this->view->message('Ошибка', $paymentData['error']);
                    }
                    if(isset($paymentData['yandexConfirmation'])){
                        $this->view->locationOut($paymentData['yandexConfirmation']);
                    }
                    if($paymentData == 'freePayment'){
                        $this->view->message('Ваша заявка принята', 'В скором времени мы с вами свяжемся');
                    }
                    break;
                default:
                    $this->view->message('Ошибка', 'Не определено действие');
                    break;
            }
        }

        if(!$course = $this->model->courseInfo($this->route['courseid'])){
            $this->view->redirect('courses');
        }
        if(!$course['timestart'] > time() || $course['payment'] == 0){
            $this->view->redirect('courses');
        }

        $course['newPrice'] = $course['price'];
        if(isset($_GET['promocode']) && $_GET['promocode'] != ''){
            $course['newPrice'] = $this->model->pricePromocode($course, $_GET['promocode']);
        }

        if($this->model->auth == 'auth'){
            if($this->model->checkUserCourse($course['id'])){
                $this->view->redirect('study/'.$course['id']);
            }
            $this->model->openPayPage($course['id']);
        }

        $vars = [
            'seo' => [
                'title' => 'Оплата '.$course['name']
            ],
            'course' => $course
        ];

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