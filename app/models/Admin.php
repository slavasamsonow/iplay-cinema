<?php

namespace app\models;

use app\core\Model;

class Admin extends Model{
    public function getNoverifyTasks(){
        $params = [
            'status' => 'verify',
        ];
        $tasks = $this->db->row('SELECT ut.id, ut.description, ct.title, c.name AS `course_name`, u.fname AS `user_fname`, u.lname AS `user_lname`
        FROM user_tasks ut
        JOIN courses_tasks ct ON ut.task = ct.id
        JOIN courses c ON ct.course = c.id
        JOIN users u ON ut.user = u.id
        WHERE `status` = :status'
        , $params);
        return $tasks;
    }

    public function saveStatusTask($data){
        $params = [
            'status' => $data['status'],
            'description' => $data['description'],
        ];
        $paramNV = $this->db->paramNV($params);

        $params['id'] = $data['id'];

        $this->db->query('UPDATE `user_tasks` SET '.$paramNV.' WHERE `id` = :id', $params);

        $params = [
            'id' => $data['id'],
        ];
        $course_user = $this->db->row('SELECT ut.user, ct.course FROM `user_tasks` ut JOIN `courses_tasks` ct ON ut.task = ct.id WHERE ut.id = :id', $params);

        $params = [
            'user' => $course_user[0]['user'],
            'statusN' => 'done',
            'course' => $course_user[0]['course'],
        ];
        $allTask = $this->db->row('SELECT * FROM `courses_tasks` t JOIN `user_tasks` u ON u.task=t.id WHERE u.user=:user AND u.status=:statusN AND t.course = :course', $params);

        $allpercent = 0;
        foreach($allTask as $task){
            $allpercent += $task['percent'];
        }

        $params = [
            'percent' => $allpercent,
            'course' => $course_user[0]['course'],
            'user' => $course_user[0]['user'],
        ];
        $this->db->query('UPDATE `user_courses` SET `percent` = :percent WHERE `course` = :course AND `user` = :user', $params);

        return [
            'id' => $data['id'],
            'status' => $data['status'],
        ];
    }
}