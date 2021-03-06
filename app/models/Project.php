<?php

namespace app\models;

use app\core\Model;

class Project extends Model{
    /**
     * Возвращает список всех проектов
     * @return array
     */
    public function getProjects(){
        return $this->db->row('SELECT p.*, u.id AS creatorid, u.fname AS creatorfname, u.lname AS creatorlname FROM projects p JOIN users u ON p.creator = u.id');
    }

    /**
     * Список активных проектов
     *
     * @return array
     */
    public function getActiveProjects(){
        return $this->db->row('SELECT p.*, u.id AS creatorid, u.fname AS creatorfname, u.lname AS creatorlname FROM projects p JOIN users u ON p.creator = u.id WHERE p.active = 1');
    }

    /**
     * Информация о проекте
     *
     * @param $projectid
     *
     * @return bool
     */
    public function getItem($projectid){
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
     * Видео проекта
     *
     * @param $projecid
     */
    public function getItemVideo($videoid){
        $params = [
            'id' => $videoid,
        ];
        $video = $this->db->row('SELECT pv.* FROM project_video pv WHERE pv.id = :id', $params);
        if(!empty($video)){
            return $video[0];
        }
    }

    /**
     * Видео проекта
     *
     * @param $projecid
     */
    public function getItemVideos($projectid){
        $params = [
            'project' => $projectid,
        ];
        $videos = $this->db->row('SELECT pv.* FROM project_video pv WHERE pv.project = :project ORDER BY pv.id DESC ', $params);
        return $videos;
    }

    /**
     * Возврат информации для редактировани
     *
     * @param $projectid
     *
     * @return mixed
     */
    public function getItemEdit($projectid){
        return $this->processTextOut($this->getItem($projectid));
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
    public function updateProject($id, $data){
        if(!isset($data['active'])){
            $data['active'] = 0;
        }

        $params = $this->processTextIn($data);
        $paramNV = $this->db->paramNV($params);
        $params['id'] = $id;

        $this->db->query('UPDATE `projects` SET '.$paramNV.' WHERE `id` = :id', $params);
        return true;
    }

    public function checkAccess($project){
        if(isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin' || isset($_SESSION['user']) && $project['creatorid'] == $_SESSION['user']['id']){
            return true;
        }
        else{
            return false;
        }
    }

    public function addVideo($indata){
        $params = $this->processTextIn($indata);
        $params['timestart'] = time();
        if(!isset($params['active'])){
            $params['active'] = 0;
        }
        $paramNandV = $this->db->paramNandV($params);

        $this->db->query('INSERT INTO `project_video` ('.$paramNandV['N'].') VALUES ('.$paramNandV['V'].')', $params);
        return $this->db->lastInsertId();
    }

    public function editVideo($id, $indata){
        $params = $this->processTextIn($indata);
        $paramNV = $this->db->paramNV($params);
        $params['id'] = $id;

        $this->db->query('UPDATE `project_video` SET '.$paramNV.' WHERE `id` = :id', $params);
        return true;
    }
}