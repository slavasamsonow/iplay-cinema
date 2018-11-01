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

    protected function query($data, $list){
        $re = '/[\d]+$/';
        preg_match_all($re, $this->apiKey, $matches, PREG_SET_ORDER, 0);
        $link_num = (isset($matches[0][0])) ? $matches[0][0] : '';

        $url = 'https://us'.$link_num.'.api.mailchimp.com/3.0/lists/'.$list.'/members';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERPWD, 'user:'.$this->apiKey);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if($httpCode == 200){
            return true;
        }else{
            return false;
        }
    }

    protected function processData($data){
        foreach($data as $type => $dataItem){
            switch($type){
                case 'email';
                    $newData['email_address'] = $dataItem;
                    break;
                case 'fName':
                    $newData['merge_fields']['FNAME'] = $dataItem;
                    break;
                case 'lName':
                    $newData['merge_fields']['LNAME'] = $dataItem;
                    break;
                case 'phone':
                    $newData['merge_fields']['PHONE'] = $dataItem;
                    break;
            }

            $newData['status'] = 'subscribed';
        }
        return $newData;
    }

    public function subscribe_student($data){
        $list = $this->lists['students'];

        $dataSend = $this->processData($data);

        if($this->query($dataSend, $list)){
            return true;
        }else{
            return false;
        }
    }
}