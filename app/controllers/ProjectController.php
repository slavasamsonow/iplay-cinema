<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Project;

class ProjectController extends Controller{

    /* @var $model Project */
    public $model;

    public function __construct($route){
        parent::__construct($route);
    }

    public function projectAction(){
        if(!$project = $this->model->getItem($this->route['projectid'])){
            $this->view->errorCode(404);
        }

        $vars = [
            'seo' => [
                'title' => $project['name'],
            ],
            'project' => $project,
        ];
        $this->view->render($vars);
    }

    public function projectslistAction(){
        $vars = [
            'seo' => [
                'title' => 'Список проектов',
            ],
            'projects' => $this->model->getActiveProjects(),
        ];
        $this->view->render($vars);
    }
}