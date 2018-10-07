<?php

namespace app\models;

use app\core\Model;

class Project extends Model{
    public function projectsList(){
        return $this->db->row('SELECT p.id, p.name, p.description, p.timestart, u.id AS creatorid,u.fname AS creatorfname, u.lname AS creatorlname FROM projects p JOIN users u ON p.creator = u.id WHERE p.active = 1');
    }

    public function project($projectif){
        $params = [
            'id' => $projectif,
        ];
        $project = $this->db->row('SELECT p.id, p.name, p.description, p.timestart, u.id AS creatorid, u.fname AS creatorfname, u.lname AS creatorlname FROM projects p JOIN users u ON p.creator = u.id WHERE p.active = 1 AND p.id = :id', $params);
        if(empty($project)){
            return false;
        }
        return $project[0];
    }
}