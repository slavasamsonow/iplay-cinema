<?php

namespace app\models;

use app\core\Model;

class Admin extends Model{
    public function getNoverifyTasks(){
        $params = [
            'status' => 'verify',
        ];
        $tasks = $this->db->row('SELECT ut.id, ct.name, c.name AS `course_name`, u.fname AS `user_fname`, u.lname AS `user_lname`
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
            'comment' => $data['comment'],
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

    public function userslist(){
        return $this->db->row('SELECT u.id, u.fname, u.lname FROM users u');
    }

    public function projectsList(){
        return $this->db->row('SELECT p.*, u.id AS creatorid,u.fname AS creatorfname, u.lname AS creatorlname FROM projects p JOIN users u ON p.creator = u.id');
    }

    public function courseEditInfo($courseid){
        $params = [
            'id' => $courseid,
        ];
        $course = $this->db->row('SELECT * FROM courses c WHERE c.id = :id', $params);
        if(empty($course)){
            return false;
        }
        return $this->processTextOut($course[0]);
    }

    public function coursesTypeList(){
        return $this->db->row('SELECT ct.id, ct.name FROM courses_type ct');
    }

    public function coursesList(){
        $courses = $this->db->row('SELECT * FROM courses c ORDER BY c.timestart ASC');
        return $courses;
    }

    public function createCourse($indata){
        $params = $this->processTextIn($indata);
        $params['timestart'] = $this->toUnixtime($params['datetime']);
        unset($params['datetime']);
        $paramNandV = $this->db->paramNandV($params);

        $this->db->query('INSERT INTO `courses` ('.$paramNandV['N'].') VALUES ('.$paramNandV['V'].')', $params);
        return $this->db->lastInsertId();
    }

    public function updateCourse($id, $indata){
        $params = $this->processTextIn($indata);
        $params['timestart'] = $this->toUnixtime($params['datetime']);
        unset($params['datetime']);
        $paramNV = $this->db->paramNV($params);
        $params['id'] = $id;

        $this->db->query('UPDATE `courses` SET '.$paramNV.' WHERE `id` = :id', $params);
        return true;
    }

    public function userCoursesList($param = []){
        if(isset($param['users'])){
            $usl['users'] = 'uc.user IN('.$param['users'].')';
        }
        if(isset($param['courses'])){
            $usl['courses'] = 'uc.course IN('.$param['courses'].')';
        }

        $uslText = '';
        if(!empty($usl)){
            foreach($usl as $uslItem){
                if($uslText == ''){
                    $uslText = ' WHERE '.$uslItem;
                }
                $uslText .= 'AND '.$uslItem;
            }
        }
        $query = 'SELECT
        u.id AS userid, u.fname, u.lname,
        c.id AS courseid, c.name AS coursename, c.type,
        uc.percent
        FROM user_courses uc
        JOIN users u ON uc.user = u.id
        JOIN courses c ON uc.course = c.id'.
        $uslText
        .'
        ORDER BY uc.course ASC, u.fname ASC, u.lname ASC';
        $userCoursesList = $this->db->row($query);
        foreach($userCoursesList as $key=>$userCourses){
            if($userCourses['type'] == 0){
                unset($userCoursesList[$key]);
            }else{
                $userCoursesList[$key]['fullName'] = $userCourses['fname'].' '.$userCourses['lname'];
            }
        }
        return $userCoursesList;
    }

    public function deleteUserCourse($data){
        if(!isset($data['user']) || !isset($data['course'])){
            return ['error' => 'Нет входных данных'];
        }

        $params = [
            'user' => $data['user'],
            'course' => $data['course']
        ];
        $id = $this->db->column('SELECT uc.id FROM user_courses uc WHERE uc.user = :user AND uc.course = :course', $params);
        if(!$id){
            return ['error' => 'У этого пользователя нет этого курса'];
        }

        $params = [
            'id' => $id,
        ];
        $this->db->query('DELETE FROM user_courses WHERE id = :id', $params);
        return [
            'status' => 'delete',
        ];
    }

    public function addUserCourse($data){
        if(!isset($data['user']) || !isset($data['course'])){
            return ['error' => 'Нет входных данных'];
        }

        $params = [
            'user' => $data['user'],
            'course' => $data['course']
        ];
        $id = $this->db->column('SELECT uc.id FROM user_courses uc WHERE uc.user = :user AND uc.course = :course', $params);
        if($id){
            return ['error' => 'У этого пользователя уже есть этот курс'];
        }

        $paramNandV = $this->db->paramNandV($params);
        $this->db->query('INSERT INTO user_courses ('.$paramNandV['N'].') VALUES ('.$paramNandV['V'].')', $params);

        $params = [
            'users' => $data['user'],
            'courses' => $data['course']
        ];
        $userCourse = $this->userCoursesList($params)[0];
        return [
            'status' => 'add',
            'user' => $userCourse
        ];
    }
}