<?php

namespace app\lib;

class YandexMoney{
    protected $shopid;
    protected $secret;
    protected $path = 'https://payment.yandex.net/api/v3/';

    protected function query($link, $idempotence = '', $data=[]){
        $link = $this->path.$link;

        $curl=curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERPWD,$this->shopid.':'.$this->secret);
        curl_setopt($curl,CURLOPT_URL,$link);
        if(count($data) > 0){
            curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
            curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($data));
            curl_setopt($curl,CURLOPT_HTTPHEADER,array('Idempotence-Key: '.$idempotence,'Content-Type: application/json'));
        }
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookieYandex.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookieYandex.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
        $out=curl_exec($curl);
        $code=curl_getinfo($curl,CURLINFO_HTTP_CODE);
        curl_close($curl);

        $code=(int)$code;
        $errors=array(
            301=>'Moved permanently',
            400=>'Bad request',
            401=>'Unauthorized',
            403=>'Forbidden',
            404=>'Not found',
            500=>'Internal server error',
            502=>'Bad gateway',
            503=>'Service unavailable'
        );
        try{
            #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
            if($code!=200 && $code!=204){
                //echo print_r(($errors[$code]) ? $errors[$code] : 'Undescribed error ',$code);
            }
        }
        catch(Exception $E){
            //die('Ошибка: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
        }
        $Response=json_decode($out,true);
        return $Response;
    }

    public function __construct(){
        $config = require 'app/config/yandexmoney.php';
        $this->shopid = $config['shopid'];
        $this->secret = $config['secret'];
    }

    public function createPayment($data){
        $link = 'payments';
        $idempotence = $data['idempotence'];
        $description = 'Билет на '.$data['name'];
        $payment = [
            'amount' => [
                'value' => $data['amount'],
                'currency' => 'RUB',
            ],
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => 'https://iplay-cinema.ru',
            ],
            'receipt' => [
                'email' => $_SESSION['user']['email'],
                'items' => [
                    [
                        'description' => $description,
                        'quantity' => '1.00',
                        'amount' => [
                            'value' => $data['amount'],
                            'currency' => 'RUB',
                        ],
                        'vat_code' => '1',
                    ],
                ],
            ],
            'description' => $description,
            'capture' => true,
        ];
        $response = $this->query($link, $idempotence, $payment);
        return $response;

        //Дописать для правильных чеков!
    }

    public function getPaymentInfo($paymentid){
        $link = 'payments/'.$paymentid;
        $response = $this->query($link);
        return $response;
        //
    }

    public function capturePayment(){
        //
    }

    public function calcelPayment(){
        //
    }

    public function createRefund(){
        //
    }

    public function getRefundInfo(){
        //
    }
}