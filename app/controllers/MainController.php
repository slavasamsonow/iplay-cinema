<?php

namespace app\controllers;

use app\core\Controller;

class MainController extends Controller{

    public function indexAction(){
        $this->view->layout = 'empty';
        $vars = [];
        $this->view->render($vars);
    }
}