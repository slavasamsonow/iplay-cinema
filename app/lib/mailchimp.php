<?php

namespace app\lib;

class MailChimp{

    protected $apiKey;
    protected $lists;

    public function __construct(){
        $config = require 'app/config/mailchimp.php';
        $this->apiKey = $config['apiKey'];
        $this->lists = $config['lists'];
    }

    protected function query($data){
        $re = '/[\d]+$/';
        preg_match_all($re, $this->apiKey, $matches, PREG_SET_ORDER, 0);
        $link_num = (isset($matches[0][0])) ? $matches[0][0] : '';

        $url = 'https://us'.$link_num.'.api.mailchimp.com/3.0/lists/'.$data['list'].'/members';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_USERPWD, 'user:'.$this->apiKey);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        $dataSend = [
            'email_address' => $data['email'],
            'merge_fields' => ['FNAME' => $data['name']],
            'status' => 'subscribed',
        ];
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dataSend));
        $result = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if($httpCode == 200){
            return true;
        }else{
            return false;
        }
    }

    public function subscribe_student($data){
        $name = $data['name'];
        $email = $data['email'];
        $list = $this->lists['students'];
        $dataSend = [
            'name' => $name,
            'email' => $email,
            'list' => $list
        ];
        if($this->query($dataSend)){
            return true;
        }else{
            return false;
        }
    }
}