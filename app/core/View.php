<?php

namespace app\core;

class View{
    public $path;
    public $route;
    public $layout = 'default';
    public $geo;

    public function __construct($route){
        $this->route = $route;
        $this->path = $route['controller'].'/'.$route['action'];
    }

    public function render($vars = []){
        if(is_array($vars)){
            extract($vars);
        }

        //$geo['city'] = ($this->geo['region']['name_ru'] == 'Удмуртия')?'Ижевск':'Москва';
        $geo['city'] = $this->geo['city']['name_ru'];

        if(!isset($seo['title'])){
            //$seo['title'] = 'Киношкола iPlay '.$geo['city'];
            $seo['title'] = 'Продюсерский центр ИГРА';

        }else{
            // $seo['title'] .= ' | Киношкола iPlay '.$geo['city'];
            $seo['title'] .= ' | Продюсерский центр ИГРА';
        }

        $seo['description'] = (isset($seo['description'])) ? $seo['description'] : 'Продюсерский центр ИГРА - место, которое мотивирует, обучает создавать кино и экспериментировать с его формами.';

        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            $user['username'] = (($user['username']) != '') ? $user['username'] : 'id'.$user['id'];
        }

        if(file_exists('app/views/'.$this->path.'.php')){
            ob_start();
            require 'app/views/'.$this->path.'.php';
            $content = ob_get_clean();
            require 'app/views/layouts/'.$this->layout.'.php';
        }else{
            $this->errorCode('204');
        }
    }

    public function redirect($url){
        header('location: /'.$url);
        exit;
    }

    public static function errorCode($code){
        if($code == 403 || $code == 404){
            http_response_code($code);
        }
        $seo = [
            'title' => 'Ошибка '.$code.' | Киношкола iPlay',
            'description' => 'Киношкола iPlay - место, которое мотивирует и обучает создавать кино, и экспериментировать с его формами.',
        ];
        ob_start();
        require 'app/views/errors/'.$code.'.php';
        $content = ob_get_clean();
        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
            $user['username'] = (isset($user['username'])) ? $user['username'] : 'id'.$user['id'];
        }
        require 'app/views/layouts/default.php';

        exit();
    }

    public function message($modalheader, $modalbody){
        exit(json_encode(['modal' => 'modalmessage', 'modalheader' => $modalheader, 'modalbody' => $modalbody]));
    }

    public function location($url){
        exit(json_encode(['url' => $url]));
    }

    public function locationOut($url){
        exit(json_encode(['urlo' => $url]));
    }

    public function data($data){
        exit(json_encode(['data' => $data]));
    }
}