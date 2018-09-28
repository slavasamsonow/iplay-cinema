<?php

namespace app\models;

use app\core\Model;

class Course extends Model{
    public function checkCourse($courseId, $userid = ''){
        if($userid == ''){
            $userid = $_SESSION['user']['id'];
        }

        $params = [
            'userid' => $userid,
            'courseid' => $courseId,
        ];
        $course = $this->db->row('SELECT c.id, c.name, c.description, c.teacher, c.curator, u.percent FROM courses c JOIN user_courses u ON c.id=u.course WHERE u.user=:userid AND u.course = :courseid', $params);

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
}