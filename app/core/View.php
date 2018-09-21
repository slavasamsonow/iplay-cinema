<?php
namespace app\core;

class View{
    public $path;
    public $route;
    public $layout = 'default';

    public function __construct($route){
        $this->route = $route;
        $this->path = $route['controller'].'/'.$route['action'];
    }

    public function render($vars=[]){
        extract($vars);

        if(!isset($seo['title'])){
            $seo['title'] = 'Киношкола iPlay';
        }else{
            $seo['title'] .= ' | Киношкола iPlay';
        }

        if(!isset($seo['description'])){
            $seo['description'] = 'Киношкола iPlay - место, которое мотивирует и обучает создавать кино, и экспериментировать с его формами.';
        }

        if(isset($_SESSION['user'])){
            $user = $_SESSION['user'];
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

    public function redirect($url) {
		header('location: /'.$url);
		exit;
	}

    public static function errorCode($code){
        if($code == 403 || $code == 404){
            http_response_code($code);
        }
        $title = 'Ошибка '.$code;
        ob_start();
        require 'app/views/errors/'.$code.'.php';
        $content = ob_get_clean();
        require 'app/views/layouts/default.php';
        exit();
    }

    public function message($modalheader, $modalbody) {
		exit(json_encode(['modal' => 'modalmessage','modalheader' => $modalheader, 'modalbody' => $modalbody]));
	}

	public function location($url) {
		exit(json_encode(['url' => $url]));
    }

    public function locationOut($url) {
		exit(json_encode(['urlo' => $url]));
	}
}