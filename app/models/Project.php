<?php

namespace app\models;

use app\core\Model;

class Project extends Model{
    /**
     * Список проектов
     *
     * @return array
     */
    // todo Переименовать в getActiveProjects
    public function projectsList(){
        return $this->db->row('SELECT p.*, u.id AS creatorid,u.fname AS creatorfname, u.lname AS creatorlname FROM projects p JOIN users u ON p.creator = u.id WHERE p.active = 1');
    }

    /**
     * Информация о проекте
     *
     * @param $projectid
     *
     * @return bool
     */
    // todo переименовать в getProjectInfo
    public function projectInfo($projectid){
        $params = [
            'id' => $projectid,
        ];
        $project = $this->db->row('SELECT p.*, u.id AS creatorid, u.fname AS creatorfname, u.lname AS creatorlname FROM projects p JOIN users u ON p.creator = u.id WHERE p.id = :id', $params);
        if(empty($project)){
            return false;
        }
        return $project[0];
    }

    /**
     * Возврат информации для редактировани
     *
     * @param $projectid
     *
     * @return mixed
     */
    // todo переименовать в getProjectEditInfo
    public function projectEditInfo($projectid){
        return $this->processTextOut($this->projectInfo($projectid));
    }

    /**
     * Создание проекта
     *
     * @param $indata
     *
     * @return string
     */
    public function createProject($indata){
        $params = $this->processTextIn($indata);
        $params['timestart'] = time();
        $paramNandV = $this->db->paramNandV($params);

        $this->db->query('INSERT INTO `projects` ('.$paramNandV['N'].') VALUES ('.$paramNandV['V'].')', $params);
        return $this->db->lastInsertId();
    }

    /**
     * Обноваление инфы о проекте
     *
     * @param $id
     * @param $indata
     *
     * @return bool
     */
    public function updateProject($id, $indata){
        $params = $this->processTextIn($indata);
        $paramNV = $this->db->paramNV($params);
        $params['id'] = $id;

        $this->db->query('UPDATE `projects` SET '.$paramNV.' WHERE `id` = :id', $params);
        return true;
    }
}