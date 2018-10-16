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
            if(!$project = $this->model->project($this->route['projectid'])){
                $this->view->errorCode(404);
            }

            $arraynewtext = [
                'description' => $project['description'],
            ];
            $newtext = $this->model->descriptionText($arraynewtext);
            foreach($newtext as $key=>$newtextstr){
                $project[$key] = $newtextstr;
            };

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
            $vars = [
                'seo' => [
                    'title' => 'Список проектов',
                ],
                'projects' => $this->model->projectsList(),
            ];
            $this->view->render($vars);
        }else{
            $this->view->errorCode(403);
        }

    }
}