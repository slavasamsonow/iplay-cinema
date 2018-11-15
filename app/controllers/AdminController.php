<?php

namespace app\controllers;

use app\core\Controller;
use app\models\Account;
use app\models\Admin;
use app\models\Course;
use app\models\News;
use app\models\Project;

class AdminController extends Controller{

    /* @var $model Admin */
    public $model;
    /* @var $modelProject Project */
    public $modelProject;
    /* @var $modelAccount Account */
    public $modelAccount;
    /* @var $modelCourse Course */
    public $modelCourse;
    /* @var $modelNews News*/
    public $modelNews;

    public function __construct($route){
        parent::__construct($route);
        if(!$this->model->role == 'admin'){
            $this->view->errorCode('403');
        }

        $this->modelProject = $this->loadModel('project');
        $this->modelAccount = $this->loadModel('account');
        $this->modelCourse = $this->loadModel('course');
        $this->modelNews = $this->loadModel('news');
    }

    public function indexAction(){
        $vars = [
            'seo' => [
                'title' => 'Админ-панель'
            ]
        ];
        $this->view->render($vars);
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
            'projects' => $this->modelProject->getProjects(),
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
            'usersList' => $this->modelAccount->getUsers(),
            'coursesList' => $this->modelCourse->getAll(),
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
            'userList' => $this->modelAccount->getUsers(),
            'coursesList' => $this->modelCourse->getAll(),
            'project' => $this->modelProject->getItemEdit($this->route['projectid']),
        ];
        $this->view->render($vars);
    }

    public function courseslistAction(){
        $vars = [
            'seo' => [
                'title' => 'Список курсов',
            ],
            'courses' => $this->modelCourse->getAll(),
        ];
        $this->view->render($vars);
    }

    public function addcourseAction(){
        if(!empty($_POST)){
            $data = $_POST;
            if($courseid = $this->modelCourse->create($data)){
                $this->view->location('admin/courses');
            }
        }
        $vars = [
            'coursesTypes' => $this->modelCourse->getCoursesTypes(),
        ];
        $this->view->render($vars);
    }

    public function editcourseAction(){
        if(!empty($_POST)){
            $id = $_POST['courseid'];
            unset($_POST['courseid']);

            // Проверка на существование

            $data = $_POST;

            if(isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != ''){
                if($file = $this->model->saveFile($_FILES['image'], 'public/img/courses/', 'image')){
                    $data['image'] = $file;
                }
            }
            // todo удаление старых фото

            // $this->view->message("+", json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ));

            if($this->modelCourse->update($id, $data)){
                $this->view->location('admin/courses');
            }
        }
        if(!$course = $this->modelCourse->getItemActive($this->route['courseid'])){
            $this->view->errorCode(404);
        }
        $vars = [
            'coursesTypes' => $this->modelCourse->getCoursesTypes(),
            'course' => $course,
        ];
        $this->view->render($vars);
    }

    public function taskslistAction(){
        if(!empty($_POST)){
            // if($_POST['action'] == 'delete'){
            //     $this->model->deleteTask($_POST['id']);
            //     $this->view->location('admin/taskslist/'.$_POST['course']);
            // }
        }
        if(!$course = $this->modelCourse->getItem($this->route['courseid'])){
            $this->view->errorCode(404);
        }
        $vars = [
            'seo' => [
                'title' => 'Редактирование заданий курса'
            ],
            'course' => $course,
            'courseTasks' => $this->model->courseTasks($this->route['courseid']),
        ];
        $this->view->render($vars);
    }

    public function edittaskAction(){
        if(!empty($_POST)){
            $id = $_POST['taskid'];
            unset($_POST['taskid']);

            // Проверка на существование

            $data = $_POST;

            // $this->view->message("+", json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ));

            if($this->model->updateTask($id, $data)){
                $this->view->location('admin/taskslist/'.$data['course']);
            }
        }
        if(!$task = $this->model->taskEditInfo($this->route['taskid'])){
            $this->view->errorCode(404);
        }
        $vars = [
            'task' => $task,
        ];
        $this->view->render($vars);
    }

    public function addtaskAction(){
        if(!empty($_POST)){
            $data = $_POST;

            // $this->view->message("+", json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ));

            if($this->model->addTask($data)){
                $this->view->location('admin/taskslist/'.$data['course']);
            }
        }
        $vars = [
            'course' => $this->modelCourse->getItem($this->route['courseid']),
        ];
        $this->view->render($vars);
    }

    public function newslistAction(){
        $vars = [
            'seo' => [
                'title' => 'Список новостей',
            ],
            'news' => $this->modelNews->getAll(),
        ];
        $this->view->render($vars);
    }

    public function addnewsAction(){
        if(!empty($_POST)){
            $data = $_POST;

            if(isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name'] != ''){
                if($file = $this->model->saveFile($_FILES['image'], 'public/img/news/', 'image')){
                    $data['image'] = $file;
                }
            }

            if($id = $this->modelNews->create($data)){
                $this->view->location('admin/newslist');
            }
        }
        $vars = [
            'usersList' => $this->modelAccount->getUsers(),
        ];
        $this->view->render($vars);
    }

    public function editnewsAction(){
        if(!empty($_POST)){
            $id = $_POST['newsid'];
            unset($_POST['newsid']);

            // Проверка на существование

            $data = $_POST;

            // $this->view->message("+", json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES ));

            if($this->modelNews->update($id, $data)){
                $this->view->location('admin/newslist');
            }
        }
        if(!$news = $this->modelNews->getItemEdit($this->route['newsid'])){
            $this->view->errorCode(404);
        }
        $vars = [
            'usersList' => $this->modelAccount->getUsers(),
            'news' => $news,
        ];
        $this->view->render($vars);
    }

    public function promocodelistAction(){
        $vars = [
            'seo' => [
                'title' => 'Список промокодов',
            ],
            'promocodes' => $this->model->promocodeList(),
        ];
        $this->view->render($vars);
    }

    public function addpromocodeAction(){
        if(!empty($_POST)){
            $data = $_POST;

            if($id = $this->model->createPromocode($data)){
                $this->view->location('admin/promocodelist');
            }
        }
        $vars = [
            'coursesList' => $this->modelCourse->getAll(),
        ];
        $this->view->render($vars);
    }

    public function editpromocodeAction(){
        if(!empty($_POST)){
            $id = $_POST['promocodeid'];
            unset($_POST['promocodeid']);

            // Проверка на существование

            $data = $_POST;

            if($this->model->updatePromocode($id, $data)){
                $this->view->location('admin/promocodelist');
            }
        }
        if(!$promocode = $this->model->promocodeInfo($this->route['promocodeid'])){
            $this->view->errorCode(404);
        }
        $vars = [
            'coursesList' => $this->modelCourse->getAll(),
            'promocode' => $promocode,
        ];
        $this->view->render($vars);
    }

    public function createuserAction(){
        if(!empty($_POST)){
            $data = $_POST;

            if(!$this->model->validate(['email'], $data)){
                $this->view->message('Ошибка', $this->model->error);
            }
            else if($this->model->checkExists('email', $data['email'])){
                $this->view->message('Ошибка', 'Пользователь с таким E-mail уже существует');
            }

            $this->modelAccount = $this->loadModel('account');

            $this->modelAccount->register($data);

            $this->view->message('Пользователь создан', '');
        }
        $vars = [
            'seo' => [
                'title' => 'Создание пользователя',
            ]
        ];
        $this->view->render($vars);
    }

    public function edituserAction(){
        $this->modelAccount = $this->loadModel('account');

        if(!empty($_POST)){
            $userid = $_POST['userid'];
            unset($_POST['userid']);

            $data = $_POST;

            if(!isset($data['public'])){
                $data['public'] = 0;
            }

            if(isset($_FILES['photo']['tmp_name']) && $_FILES['photo']['tmp_name'] != ''){
                if($file = $this->model->saveFile($_FILES['photo'], 'public/img/users/', 'image')){
                    $data['photo'] = $file;
                    if(!empty($data['oldphoto'])){
                        $oldPhotoPath = $_SERVER['DOCUMENT_ROOT'].'/public/img/users/'.$data['oldphoto'];
                        $oldPhotoThumbPath = $_SERVER['DOCUMENT_ROOT'].'/public/img/users/thumb/'.$data['oldphoto'];
                        if(file_exists($oldPhotoPath)){
                            unlink($oldPhotoPath);
                        }
                        if(file_exists($oldPhotoThumbPath)){
                            unlink($oldPhotoThumbPath);
                        }
                    }
                }
            }
            unset($data['oldphoto']);

            $this->modelAccount->saveUserData($userid, $data);
            $this->view->message('Данные сохранены', '');
        }

        if(!$userInfo = $this->modelAccount->getUser($this->route['username'])){
            $this->view->errorCode('404');
        }

        $vars = [
            'seo' => [
                'title' => 'Редактирование информации'
            ],
            'userInfo' => $userInfo,
        ];
        $this->view->render($vars);
    }

    public function courseteachersAction(){
        if(!empty($_POST)){
            $data = $_POST;
            $courseid = $this->route['courseid'];
            if(!$this->modelCourse->getItem($courseid)){
                $this->view->message('Ошибка', 'Неизвестный курс');
            }

            switch($data['action']){
                case 'delete':
                    $this->modelCourse->removeTeacher($courseid, $data['user']);
                    $status = [
                        'status' => 'delete'
                    ];
                    $this->view->data($status);
                    break;
                default:
                    $this->view->message('неизвестное действие', '');
            }

            $this->view->location('admin/course-'.$courseid.'/teachers');
        }
        if(!$course = $this->modelCourse->getItem($this->route['courseid'])){
            $this->view->error(404);
        }

        $vars = [
            'seo' => [
                'title' => 'Список преподавателей курса '.$course['name'],
            ],
            'course' => $course,
            'teachers' => $this->modelCourse->getTeachers($course['id'])
        ];
        $this->view->render($vars);
    }

    public function courseteachersaddAction(){
        if(!empty($_POST)){
            $data = $_POST;
            $courseId = $this->route['courseid'];
            if(!$this->modelCourse->getItem($courseId)){
                $this->view->message('Ошибка', 'Неизвестный курс');
            }

            $userId = $_POST['user'];

            if(!$this->modelCourse->addTeachers($courseId, $userId)){
                $this->view->message('Ошибка', $this->modelCourse->error);
            }

            $this->view->location('admin/course-'.$courseId.'/teachers');
        }
        if(!$course = $this->modelCourse->getItem($this->route['courseid'])){
            $this->view->error(404);
        }

        $vars = [
            'seo' => [
                'title' => 'Добавление преподавателя к курсу',
            ],
            'course' => $course,
            'usersList' => $this->modelAccount->getUsers(),
        ];
        $this->view->render($vars);
    }

    public function coursestudentsAction(){
        if(!empty($_POST)){
            $data = $_POST;
            $courseId = $this->route['courseid'];
            if(!$this->modelCourse->getItem($courseId)){
                $this->view->message('Ошибка', 'Неизвестный курс');
            }

            $userId = $data['user'];

            switch($data['action']){
                case 'delete':
                    $this->modelCourse->removeCourseStudent($courseId, $userId);
                    $status = [
                        'status' => 'delete'
                    ];
                    $this->view->data($status);
                    break;
                default:
                    $this->view->message('неизвестное действие', '');
            }

            $this->view->location('admin/course-'.$courseId.'/students');
        }

        if(!$course = $this->modelCourse->getItem($this->route['courseid'])){
            $this->view->error(404);
        }

        $vars = [
            'seo' => [
                'title' => 'Список студентов курса '.$course['name'],
            ],
            'course' => $course,
            'students' => $this->modelCourse->getCourseStudents($course['id'])
        ];
        $this->view->render($vars);
    }

    public function coursestudentsaddAction(){
        if(!empty($_POST)){
            $data = $_POST;
            $courseId = $this->route['courseid'];
            if(!$this->modelCourse->getItem($courseId)){
                $this->view->message('Ошибка', 'Неизвестный курс');
            }

            $userId = $data['user'];

            if(!$this->modelCourse->addCourseStudent($courseId, $userId)){
                $this->view->message('Ошибка', $this->modelCourse->error);
            }

            $this->view->location('admin/course-'.$courseId.'/students');
        }
        if(!$course = $this->modelCourse->getItem($this->route['courseid'])){
            $this->view->error(404);
        }

        $vars = [
            'seo' => [
                'title' => 'Добавление преподавателя к курсу',
            ],
            'course' => $course,
            'usersList' => $this->modelAccount->getUsers(),
        ];
        $this->view->render($vars);
    }
}