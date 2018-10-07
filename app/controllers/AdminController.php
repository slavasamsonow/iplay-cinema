<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Project;

class AdminController extends Controller{

    protected $modelProject;

    public function __construct($route){
        parent::__construct($route);
        $this->view->layout = 'lk';
        if(!$this->model->role == 'admin'){
            $this->view->errorCode('403');
        }

        $this->modelProject = $this->loadModel('project');;
    }

    public function confirmTasksAction(){
        if(!empty($_POST)){
            $data = $this->model->saveStatusTask($_POST);
            $this->view->data($data);
        }
        $tasks = $this->model->getNoverifyTasks();
        $vars = [
            'tasks' => $tasks,
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

    public function addprojectAction(){
        if(!empty($_POST)){
            if($this->modelProject->createProject($_POST)){
                $this->view->location('projects');
            }
        }
        $vars = [
            'userList' => $this->model->userlist(),
        ];
        $this->view->render($vars);
    }

    public function editprojectAction(){
        if(!empty($_POST)){
            $id = $_POST['projectid'];
            unset($_POST['projectid']);
            if($this->modelProject->updateProject($id, $_POST)){
                $this->view->location('projects');
            }
        }
        if(!$this->model->checkExists('id', $this->route['projectid'], 'projects')){
            $this->view->errorCode(404);
        }
        $vars = [
            'userList' => $this->model->userlist(),
            'project' => $this->modelProject->project($this->route['projectid']),
        ];
        $this->view->render($vars);
    }

    public function courseslistAction(){
        $vars = [
            'seo' => [
                'title' => 'Список курсов',
            ],
            'courses' => $this->model->coursesList(),
        ];
        $this->view->render($vars);
    }

    public function addcourseAction(){
        if(!empty($_POST)){
            if($courseid = $this->model->createCourse($_POST)){
                $this->view->location('admin/courses');
            }
        }
        $vars = [
            'coursesTypes' => $this->model->coursesTypeList(),
        ];
        $this->view->render($vars);
    }

    public function editcourseAction(){
        if(!empty($_POST)){
            $id = $_POST['courseid'];
            unset($_POST['courseid']);
            if($this->model->updateCourse($id, $_POST)){
                $this->view->location('admin/courses');
            }
        }
        if(!$this->model->checkExists('id', $this->route['courseid'], 'courses')){
            $this->view->errorCode(404);
        }
        $vars = [
            'coursesTypes' => $this->model->coursesTypeList(),
            'course' => $this->model->courseinfo($this->route['courseid']),
        ];
        $this->view->render($vars);
    }
}