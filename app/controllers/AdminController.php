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
            $data = $_POST;

            if(isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != ''){
                if($file = $this->model->saveFile($_FILES['image'], 'public/img/projects/', 'image')){
                    $data['image'] = $file;
                }
            }

            if($id = $this->modelProject->createProject($data)){
                $this->view->location('admin/projects');
            }
        }
        $vars = [
            'usersList' => $this->model->userslist(),
            'coursesList' => $this->model->courseslist(),
        ];
        $this->view->render($vars);
    }

    public function editprojectAction(){
        if(!empty($_POST)){
            $id = $_POST['projectid'];
            unset($_POST['projectid']);

            $data = $_POST;

            if(isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != ''){
                if($file = $this->model->saveFile($_FILES['image'], 'public/img/projects/', 'image')){
                    $data['image'] = $file;
                    if(!empty($data['oldimage'])){
                        $oldPhotoPath = $_SERVER['DOCUMENT_ROOT'].'/public/img/projects/'.$data['oldimage'];
                        $oldPhotoThumbPath = $_SERVER['DOCUMENT_ROOT'].'/public/img/projects/thumb/'.$data['oldimage'];
                        if(file_exists($oldPhotoPath)){
                            unlink($oldPhotoPath);
                        }
                        if(file_exists($oldPhotoThumbPath)){
                            unlink($oldPhotoThumbPath);
                        }
                    }
                }
            }
            unset($data['oldimage']);

            if($this->modelProject->updateProject($id, $data)){
                $this->view->location('admin/projects');
            }
        }
        if(!$this->model->checkExists('id', $this->route['projectid'], 'projects')){
            $this->view->errorCode(404);
        }
        $vars = [
            'userList' => $this->model->userslist(),
            'coursesList' => $this->model->courseslist(),
            'project' => $this->modelProject->projectEditInfo($this->route['projectid']),
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
            $data = $_POST;
            if($courseid = $this->model->createCourse($data)){
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

            $data = $_POST;

            // $this->view->message("+", json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ));

            if($this->model->updateCourse($id, $data)){
                $this->view->location('admin/courses');
            }
        }
        if(!$this->model->checkExists('id', $this->route['courseid'], 'courses')){
            $this->view->errorCode(404);
        }
        $vars = [
            'coursesTypes' => $this->model->coursesTypeList(),
            'course' => $this->model->courseEditInfo($this->route['courseid']),
        ];
        $this->view->render($vars);
    }

    public function usercoursesAction(){
        if(!empty($_POST)){
            if(isset($_POST['action'])){
                $data = [];
                switch($_POST['action']){
                    case 'delete':
                        $data = $this->model->deleteUserCourse($_POST);
                        break;
                    case 'add':
                        $data = $this->model->addUserCourse($_POST);
                        break;
                }
                $this->view->data($data);
            }else{
                exit();
            }
        }
        $vars = [
            'seo' => [
                'title' => 'Список студентов по курсам',
            ],
            'userCoursesList' => $this->model->userCoursesList(),
            'usersList' => $this->model->userslist(),
            'coursesList' => $this->model->coursesList()
        ];
        // debug($vars);
        $this->view->render($vars);
    }
}