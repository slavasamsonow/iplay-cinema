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

    public function getTasksCourse($courseId, $userid = ''){
        if($userid == ''){
            $userid = $_SESSION['user']['id'];
        }

        $params = [
            'userid' => $userid,
        ];
        $tasks = $this->db->row('SELECT t.id AS taskid, u.id, t.timestart, t.description, t.active, t.percent, u.status FROM courses_tasks t LEFT JOIN user_tasks u ON u.task=t.id WHERE u.user = :userid',$params);

        $params = [];
        $i=0;
        foreach($tasks as $task){
            if($task['timestart'] <= time()){
                if(!isset($task['id'])){
                    $params['task'.$i] = $task['taskid'];
                    $params['user'.$i] = $_SESSION['user']['id'];
                    if($i == 0){
                        $values = '(:task'.$i.',:user'.$i.')';
                    }else{
                        $values .= ', (:task'.$i.',:user'.$i.')';
                    }
                }
            }
            $i++;
        }

        if(isset($values)){
            $this->db->query('INSERT INTO user_tasks (task, user) VALUES '.$values, $params);

            $params = [
                'userid' => $userid,
            ];
            $tasks = $this->db->row('SELECT t.id AS taskid, u.id, t.timestart, t.description, t.active, t.percent, u.status FROM courses_tasks t LEFT JOIN user_tasks u ON u.task=t.id WHERE u.user = :userid',$params);
        }

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
            return 'error';
        }else{
            $task = $task[0];
        }
        if($task['status'] == 'verify'){
            return 'error';
        }

        $params = [
            'id' => $task['id'],
        ];
        if($task['verify'] == 1){
            if($task['status'] == 'done'){
                return 'error';
            }
            if($task['taskid'] == '1'){
                if($_SESSION['user']['active'] == 1){
                    $params['status'] = 'done';
                }else{
                    $params['status'] = 'ndone';
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