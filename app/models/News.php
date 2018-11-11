<?php

namespace app\models;

use app\core\Model;

class News extends Model{
    /**
     * Список активных новостей
     * @return array
     */
    // todo перименовать в getActiveNews
    // todo пагинация
    public function newsList(){
        $news = $this->db->row('SELECT * FROM news n WHERE n.active = 1 ORDER BY n.timestart DESC');
        return $news;
    }

    /**
     * Информация новости
     *
     * @param $newsid
     *
     * @return array|bool
     */
    // todo переименовать в getNewsInfo
    public function newsInfo($newsid){
        $params = [
            'id' => $newsid
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
}