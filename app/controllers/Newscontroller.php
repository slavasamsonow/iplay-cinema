<?php

namespace app\controllers;

use app\core\Controller;

class NewsController extends Controller{

    public function __construct($route){
        parent::__construct($route);
        if($this->model->auth == 'auth'){
            $this->view->layout = 'lk';
        }
    }

    public function newslistAction(){
        $vars = [
            'newslist' => $this->model->newsList(),
        ];
        $this->view->render($vars);
    }
    public function newsinfoAction(){
        if(!$news = $this->model->newsInfo($this->route['newsid'])){
            $this->view->errorCode(404);
        }
        $vars = [
            'news' => $news,
        ];
        $this->view->render($vars);
    }
}