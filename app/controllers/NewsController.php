<?php

namespace app\controllers;

use app\core\Controller;
use app\models\News;

class NewsController extends Controller{

    /* @var $model News */
    public $model;

    public function __construct($route){
        parent::__construct($route);
    }

    public function newslistAction(){
        $vars = [
            'seo' => [
                'title' => 'Новости',
            ],
            'newslist' => $this->model->newsList(),
        ];
        $this->view->render($vars);
    }

    public function newsinfoAction(){
        if(!$news = $this->model->newsInfo($this->route['newsid'])){
            $this->view->errorCode(404);
        }
        $vars = [
            'seo' => [
                'title' => $news['title'],
            ],
            'news' => $news,
        ];
        $this->view->render($vars);
    }
}