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
            'videos' => $this->model->getItemVideos($this->route['projectid']),
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

    public function addVideoAction(){
        if(!empty($_POST)){
            $data = $_POST;

            if(!$project = $this->model->getItem($data['project'])){
                $this->view->message(404);
            }

            if(!$this->model->checkAccess($project)){
                $this->view->errorCode(403);
            }

            if(isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != ''){
                if($file = $this->model->saveFile($_FILES['image'], 'public/img/projects/videos/', 'image')){
                    $data['image'] = $file;
                }
            }

            if($this->model->addVideo($data)){
                $this->view->location('project/'.$data['project']);
            }else{
                $this->view->message('Ошибка', "");
            }
        }

        if(!$project = $this->model->getItem($this->route['projectid'])){
            $this->view->errorCode(404);
        }

        if(!$this->model->checkAccess($project)){
            $this->view->errorCode(403);
        }

        $vars = [
            'seo' => [
                'title' => 'Добавление видео',
            ],
            'project' => $project,
        ];
        $this->view->render($vars);

    }

    public function editVideoAction(){
        if(!empty($_POST)){
            $data = $_POST;

            $id = $data['id'];
            unset($data['id']);

            if(!$project = $this->model->getItem($data['project'])){
                $this->view->message(404);
            }

            if(!$video = $this->model->getItemVideo($id)){
                $this->view->errorCode(404);
            }

            if(!$this->model->checkAccess($project)){
                $this->view->errorCode(403);
            }

            if(isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != ''){
                if($file = $this->model->saveFile($_FILES['image'], 'public/img/projects/videos/', 'image')){
                    $data['image'] = $file;
                    if(!empty($data['oldimage'])){
                        $oldImagePath = $_SERVER['DOCUMENT_ROOT'].'/public/img/projects/videos/'.$data['oldimage'];
                        if(file_exists($oldImagePath)){
                            unlink($oldImagePath);
                        }
                    }
                }
            }
            unset($data['oldimage']);

            if($this->model->editVideo($id,$data)){
                $this->view->location('project/'.$data['project']);
            }else{
                $this->view->message('Ошибка', "");
            }
        }

        if(!$project = $this->model->getItem($this->route['projectid'])){
            $this->view->errorCode(404);
        }

        if(!$video = $this->model->getItemVideo($this->route['videoid'])){
            $this->view->errorCode(404);
        }

        if(!$this->model->checkAccess($project)){
            $this->view->errorCode(403);
        }

        $vars = [
            'seo' => [
                'title' => 'Редактирование видео',
            ],
            'video' => $video,
        ];
        $this->view->render($vars);

    }
}