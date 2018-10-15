<?php

namespace app\models;

use app\core\Model;

class Course extends Model{
    public function courseInfo($courseId){
        $params = [
            'courseid' => $courseId,
        ];
        $course = $this->db->row('SELECT c.id, c.timestart, c.duration, c.payment, c.price, c.name, c.caption, c.description, c.program, c.projects, c.portfolio, c.image FROM courses c WHERE c.id = :courseid AND c.active = 1', $params);

        if(isset($course[0])){
            return $course[0];
        }else{
            return false;
        }
    }

    public function courseTeachers($courseId){
        $params = [
            'courseid' => $courseId,
        ];
        $teachers = $this->db->row('SELECT u.id, u.username, u.fname, u.lname, u.photo FROM courses_teachers ct JOIN users u ON ct.teacher=u.id WHERE ct.course = :courseid', $params);

        foreach($teachers as $key => $teacher){
            if($teacher['username'] == ''){
                $teachers[$key]['username'] = 'id'.$teacher['id'];
            }
        }

        return $teachers;
    }

    public function courseCurators($courseId){
        $params = [
            'courseid' => $courseId,
        ];
        $curators = $this->db->row('SELECT u.id, u.username, u.fname, u.lname, u.photo FROM user_courses uc JOIN users u ON uc.curator=u.id WHERE uc.course = :courseid GROUP BY u.id', $params);

        foreach($curators as $key => $curator){
            if($curator['username'] == ''){
                $curators[$key]['username'] = 'id'.$curator['id'];
            }
        }

        return $curators;
    }

    public function courseProgram($courseId){
        $params = [
            'courseid' => $courseId,
        ];
        return $this->db->row('SELECT cp.name, cp.description FROM courses_programs cp WHERE cp.course = :courseid', $params);
    }

    public function courseProjects($courseId){
        $params = [
            'courseid' => $courseId,
        ];
        return $this->db->row('SELECT p.id, p.name, p.caption FROM projects p WHERE p.course = :courseid', $params);
    }

    public function checkCourse($courseId, $userid = ''){
        if($userid == ''){
            $userid = $_SESSION['user']['id'];
        }

        $params = [
            'userid' => $userid,
            'courseid' => $courseId,
        ];
        $course = $this->db->row('SELECT c.id, c.type, c.timestart, c.name, c.description, u.percent FROM courses c JOIN user_courses u ON c.id=u.course WHERE u.user=:userid AND u.course = :courseid', $params);

        if(isset($course[0])){
            return $course[0];
        }else{
            return false;
        }
    }

    public function getTasksCourse($courseId, $userId = ''){
        if($userId == ''){
            $userId = $_SESSION['user']['id'];
        }

        $params = [
            'course' => $courseId,
        ];
        $tasksCourse = $this->db->row('SELECT * FROM courses_tasks WHERE course = :course',$params);
        $params = [
            'user' => $userId,
        ];
        $tasks = $this->db->row('SELECT task FROM user_tasks WHERE user = :user',$params);

        $taskId = [];
        foreach($tasks as $task){
            $taskId[] = $task['task'];
        }

        $params = [];
        $i=0;
        foreach($tasksCourse as $taskC){
            if(!in_array($taskC['id'], $taskId)){
                $params['task'.$i] = $taskC['id'];
                $params['user'.$i] = $_SESSION['user']['id'];
                if($i == 0){
                    $values = '(:task'.$i.',:user'.$i.')';
                }else{
                    $values .= ', (:task'.$i.',:user'.$i.')';
                }
                $i++;
            }
        }

       if(isset($values)){
            $this->db->query('INSERT INTO user_tasks (task, user) VALUES '.$values, $params);
       }
        $params = [
            'user' => $userId,
            'course' => $courseId
        ];
        $tasks = $this->db->row('SELECT t.id AS taskid, u.id, t.timestart, t.title, t.active, t.percent, u.status FROM courses_tasks t LEFT JOIN user_tasks u ON u.task=t.id WHERE u.user = :user AND t.course = :course',$params);
        return $tasks;
    }

    public function changeTask($taskId, $userid = ''){
        if($userid == ''){
            $userid = $_SESSION['user']['id'];
        }

        $params = [
            'task' => $taskId,
            'user' => $userid,
        ];
        $task = $this->db->row('SELECT t.id AS taskid, u.id, t.course, t.verify, t.active, t.percent, u.status FROM courses_tasks t JOIN user_tasks u ON u.task=t.id WHERE u.id = :task AND u.user=:user',$params);

        if(empty($task)){
            return [
                'error' => 'Ошибка инициализации'
            ];
        }else{
            $task = $task[0];
        }
        if($task['status'] == 'verify'){
            return [
                'error' => 'Это поле сейчас на стадии проверки'
            ];
        }

        $params = [
            'id' => $task['id'],
        ];
        if($task['verify'] == 1){
            if($task['status'] == 'done'){
                return [
                    'error' => 'Это поле уже проверено. Его нельзя менять'
                ];
            }
            if($task['taskid'] == '1'){
                if($_SESSION['user']['active'] == 1){
                    $params['status'] = 'done';
                }else{
                    return [
                        'error' => 'Вы не подтвердили свой email'
                    ];
                }
            }else{
                $params['status'] = 'verify';
            }
        }else{
            if($task['status'] == 'done'){
                $params['status'] = 'ndone';
            }else if($task['status'] == 'ndone'){
                $params['status'] = 'done';
            }
        }

        $this->db->query('UPDATE `user_tasks` SET `status` = :status WHERE id = :id', $params);
        $status = $params['status'];

        $params = [
            'user' => $userid,
            'statusN' => 'done',
            'course' => $task['course'],
        ];
        $allTask = $this->db->row('SELECT * FROM `courses_tasks` t JOIN `user_tasks` u ON u.task=t.id WHERE u.user=:user AND u.status=:statusN AND t.course = :course', $params);

        $allpercent = 0;
        foreach($allTask as $task){
            $allpercent += $task['percent'];
        }

        $params = [
            'percent' => $allpercent,
            'course' => $task['course'],
            'user' => $userid,
        ];
        $this->db->query('UPDATE `user_courses` SET `percent` = :percent WHERE `course` = :course AND `user` = :user', $params);

        return [
            'status' => $status,
            'percent' => $allpercent
        ];
    }

    public function grantApplicationUser($data){
        $varsAmo = [
            'name' => 'Заявка на грант',
            'nameCourse' => $data['course'],
            'sale' => 0,
            'contact_id' => $_SESSION['user']['amoid'],
        ];
        $this->amo->newLead($varsAmo);
        return true;
    }
    public function grantApplicationGuest($data){
        $varsAmo = [
            'name' => 'Заявка на грант',
            'nameCourse' => $data['course'],
            'sale' => 0,
        ];
        if($amoContact = $this->amo->searchContact($data['email'])){
            $varsAmo['contact_id'] = $amoContact['id'];
            $notes = [
                'Email: '.$data['email'],
                'Телефон: '.$data['phone'],
                'Город: '.$data['city'],
            ];
            $this->amo->addNotesContact($amoContact['id'],$notes);
        }else{
            $varsAmoNew = [
                'email' => $data['email'],
            ];

            if(isset($data['fio'])){
                $varsAmoNew['name'] = $data['fio'];
            }else{
                $varsAmoNew['name'] = $data['email'];
            }

            if(isset($dataPayer['city'])){
                $varsAmoNew['city'] = $data['city'];
            }

            if(isset($dataPayer['phone'])){
                $varsAmoNew['phone'] = $data['phone'];
            }

            $varsAmo['contact_id'] = $this->amo->newContact($varsAmoNew);
        }
        $amoid = $this->amo->newLead($varsAmo);

        return true;
    }
}