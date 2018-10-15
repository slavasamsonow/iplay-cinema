<?php

namespace app\lib;

class Amo{

    protected $amo;
    protected $path;
    protected $userlogin;
    protected $userhash;

    public function __construct(){
        $config = require 'app/config/amo.php';
        $this->path = $config['path'];
        $this->userlogin = $config['login'];
        $this->userhash = $config['hash'];
    }

    protected function query($link, $data=[]){
        $link = $this->path.$link;

        $curl=curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
        curl_setopt($curl,CURLOPT_URL,$link);
        if(count($data) > 0){
            curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
            curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($data));
            curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        }
        curl_setopt($curl,CURLOPT_HEADER,false);
        curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookieAmo.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookieAmo.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
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

    public function start(){
        $user=array(
            'USER_LOGIN' => $this->userlogin,
            'USER_HASH' => $this->userhash,
        );
        $link = 'private/api/auth.php?type=json';
        $Response = $this->query($link, $user);
        if($Response['response']['auth'] == true) return true;
        return false;
    }

    public function newLead($data){
        if($this->start() == true){
            $leads['add'][0] = [
                  'created_at'=>time(),
                  'status_id' => '11316085',
                  'tags' => 'Сайт',
            ];

            if(isset($data['name'])){
                $leads['add'][0]['name'] = $data['name'];
            }else{
                $leads['add'][0]['name'] = 'Заявка с сайта';
            }

            if(isset($data['sale'])){
                $leads['add'][0]['sale'] = $data['sale'];
            }

            if(isset($data['contact_id'])){
                $leads['add'][0]['contacts_id'] = $data['contact_id'];
            }

            if(isset($data['nameCourse'])){
                $leads['add'][0]['custom_fields'][] = [
                    'id' => "450871",
                        'values' => [
                            [
                                'value' => $data['nameCourse']
                            ]
                        ]
                ];
            }


            $link = 'api/v2/leads';
            $Response = $this->query($link, $leads);
            if(isset($Response['_embedded']['items']['0']['id'])){
                return $Response['_embedded']['items']['0']['id'];
            }else{
                return false;
            }
        }else{
            //echo 'Не авторизован';
            // Писать на email об ошибке
        };
    }

    public function updateStatusLead($id, $status){
        if($this->start() == true){
            $leads['update'][0] = [
                'id' => $id,
                'updated_at' => time(),
                'status_id' => $status,
            ];


            $link = 'api/v2/leads';
            $Response = $this->query($link, $leads);
            if(isset($Response['_embedded']['items']['0']['id'])){
                return true;
            }else{
                return false;
            }
        }else{
            //echo 'Не авторизован';
            // Писать на email об ошибке
        };
    }

    public function newContact($vars){
        if($this->start() == true){
            $contacts['add'][0] = [
                'name'=>$vars['name'],
                'created_at'=>time(),
                'tags' => 'Сайт',
                'custom_fields' => [
                    [
                      'id' => "148121",
                      'values' => [
                            [
                                'value' => $vars['email'],
                                'enum' => "WORK"
                            ],
                        ],
                    ],
                    // Зарегестрирован на сайте
                    // [
                    //     'id' => '450873',
                    //     'values' => [
                    //         [
                    //             'value' => 1
                    //         ]
                    //     ]
                    // ]
                ],
            ];

            if(isset($vars['phone'])){
                $contacts['add'][0]['custom_fields'][] = [
                    'id' => "148119",
                    'values' => [
                        [
                            'value' => $vars['phone'],
                            'enum' => "WORK"
                        ],
                    ],
                ];
            }

            if(isset($vars['city'])){
                $contacts['add'][0]['custom_fields'][] = [
                    'id' => "451461",
                    'values' => [
                        [
                            'value' => $vars['city']
                        ],
                    ],
                ];
            }

            $link = 'api/v2/contacts';
            $Response = $this->query($link, $contacts);
            if(isset($Response['_embedded']['items']['0']['id'])){
                return $Response['_embedded']['items']['0']['id'];
            }else{
                return false;
            }
        }
    }

    public function searchContact($data){
        if($this->start() == true){
            $link = 'api/v2/contacts/?query='.$data;
            $Response = $this->query($link);
            if(isset($Response['_embedded']['items']['0'])){
                return $Response['_embedded']['items']['0'];
            }else{
                return false;
            }
        }else{
            //echo 'Не авторизован';
            // Писать на email об ошибке
        };
    }

    public function addNotesContact($amoid,$data){
        if($this->start() == true){
            foreach($data as $dataItem){
                $notes['add'][] = [
                    'element_id' => $amoid,
                    'element_type' => '1',
                    'text' => $dataItem,
                    'note_type' => '4',
                ];
            }


            $link = 'api/v2/notes';
            $Response = $this->query($link, $notes);
            if(isset($Response['_embedded']['items']['0']['id'])){
                return true;
            }else{
                return false;
            }
        }
    }
}