<?php

namespace app\models;

use app\core\Model;

class Project extends Model{
    public function projectsList(){
        return $this->db->row('SELECT p.id, p.name, p.description, p.timestart, u.id AS creatorid,u.fname AS creatorfname, u.lname AS creatorlname FROM projects p JOIN users u ON p.creator = u.id WHERE p.active = 1');
    }

    public function project($projectid){
        $params = [
            'id' => $projectid,
        ];
        $project = $this->db->row('SELECT p.id, p.name, p.description, p.timestart, u.id AS creatorid, u.fname AS creatorfname, u.lname AS creatorlname FROM projects p JOIN users u ON p.creator = u.id WHERE p.active = 1 AND p.id = :id', $params);
        if(empty($project)){
            return false;
        }
        return $project[0];
    }

    public function createProject($indata){
        $params = $this->textFormatting($indata);
        $params['timestart'] = time();
        $paramNandV = $this->db->paramNandV($params);

        $this->db->query('INSERT INTO `projects` ('.$paramNandV['N'].') VALUES ('.$paramNandV['V'].')', $params);
        return true;
    }
}