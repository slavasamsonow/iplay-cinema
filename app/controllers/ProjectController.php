<?php

namespace app\controllers;

use app\core\Controller;

class ProjectController extends Controller{
    public function __construct($route){
        parent::__construct($route);
        $this->view->layout = 'lk';
    }

    public function projectAction(){
        if($this->model->auth == 'auth'){
            if(!$project = $this->model->project($this->route['project'])){
                $this->view->errorCode(404);
            }
            $vars = [
                'seo' => [
                    'title' => $project['name'],
                ],
                'project' => $project,
            ];
            $this->view->render($vars);
        }else{
            $this->view->errorCode(403);
        }
    }

    public function projectslistAction(){
        if($this->model->auth == 'auth'){
            $projects = $this->model->projectsList();
            $vars = [
                'seo' => [
                    'title' => 'Список проектов',
                ],
                'projects' => $projects,
            ];
            $this->view->render($vars);
        }else{
            $this->view->errorCode(403);
        }

    }
}