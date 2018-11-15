<?php

namespace app\models;

use app\core\Model;

class News extends Model{
    /**
     * Создание новости
     * @return string
     */
    public function create(){
        $params = $this->processTextIn($indata);
        $params['timestart'] = $this->toUnixTime($params['timestart']);
        $paramNandV = $this->db->paramNandV($params);

        $this->db->query('INSERT INTO news ('.$paramNandV['N'].') VALUES ('.$paramNandV['V'].')', $params);
        return $this->db->lastInsertId();
    }

    /**
     * Обновление новости
     *
     * @param $id
     * @param $data
     *
     * @return bool
     */
    public function update($id, $data){
        $params = $this->processTextIn($data);
        $params['timestart'] = $this->toUnixTime($params['timestart']);
        if(!isset($params['active'])){
            $params['active'] = 0;
        }
        $paramNV = $this->db->paramNV($params);
        $params['id'] = $id;

        $this->db->query('UPDATE news SET '.$paramNV.' WHERE `id` = :id', $params);
        return true;
    }

    /**
     * Возвращает список новостей
     * @return array
     */
    public function getAll(){
        $news = $this->db->row('SELECT n.*, u.fname, u.lname, u.id AS authorId FROM news n JOIN users u ON n.author = u.id ORDER BY n.timestart DESC');
        foreach($news as $key => $newsitem){
            $news[$key]['author'] = $newsitem['fname'].' '.$newsitem['lname'];
            unset($newsitem['fname'], $newsitem['lname']);
        }
        return $news;
    }

    /**
     * Возвращает список активных новостей
     * @return array
     */
    public function getActive(){
        $news = $this->getAll();
        foreach($news as $key => $newsitem){
            if($newsitem['active'] == 0){
                unset($news[$key]);
            }
        }
        return $news;
    }

    /**
     * Возвращает данные новости
     *
     * @param $id
     *
     * @return bool
     */
    public function getItem($id){
        $params = [
            'id' => $id,
        ];
        $news = $this->db->row('SELECT n.*, u.fname, u.lname, u.id AS authorId FROM news n JOIN users u ON n.author = u.id WHERE n.id = :id', $params);
        if(empty($news)){
            return false;
        }

        $news = $news[0];
        $news['author'] = $news['fname'].' '.$news['lname'];
        unset($news['fname'], $news['lname']);

        return $news;
    }

    public function getItemActive($id){
        $params = [
            'id' => $id,
        ];
        $news = $this->db->row('SELECT n.*, u.fname, u.lname, u.id AS authorId FROM news n JOIN users u ON n.author = u.id WHERE n.id = :id AND n.active = 1', $params);
        if(empty($news)){
            return false;
        }

        $news = $news[0];
        $news['author'] = $news['fname'].' '.$news['lname'];
        unset($news['fname'], $news['lname']);

        return $news;
    }

    /**
     * Возвращает данные новости для редактирования
     *
     * @param $id
     *
     * @return bool|mixed
     */
    public function getItemEdit($id){
        if(!$news = $this->getItem($id)){
            return false;
        }
        return $this->processTextOut($news);
    }
}