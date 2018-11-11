<?php

namespace app\controllers;

use app\core\Controller;

class ProjectController extends Controller{
    public function __construct($route){
        parent::__construct($route);
    }

    public function projectAction(){
        if(!$project = $this->model->projectInfo($this->route['projectid'])){
            $this->view->errorCode(404);
        }

        $arraynewtext = [
            'description' => $project['description'],
        ];
        $newtext = $this->model->descriptionText($arraynewtext);
        foreach($newtext as $key => $newtextstr){
            $project[$key] = $newtextstr;
        };

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
            'projects' => $this->model->projectsList(),
        ];
        $this->view->render($vars);
    }
}