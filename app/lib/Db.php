<?php

namespace app\lib;

use PDO;

class Db{

    protected $db;

    public function __construct(){
        $config = require 'app/config/db.php';
        $this->db = new PDO('mysql:host='.$config['host'].';dbname='.$config['db'].';charset=UTF8', $config['user'], $config['pass']);
    }

    public function query($sql, $params = []){
        $stmt = $this->db->prepare($sql);
        if(!empty($params)){
            foreach($params as $key => $val){
                if(is_int($val)){
                    $type = PDO::PARAM_INT;
                }else{
                    $type = PDO::PARAM_STR;
                }
                $stmt->bindValue(':'.$key, $val, $type);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    public function row($sql, $params = []){
        $result = $this->query($sql, $params);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = []){
        $result = $this->query($sql, $params);
        return $result->fetchColumn();
    }

    public function lastInsertId(){
        return $this->db->lastInsertId();
    }

    public function paramNV($params){
        $paramNV = '';
        foreach($params as $param => $val){
            $paramNV .= $param.' = :'.$param.', ';
        }
        $paramNV = substr($paramNV, 0, -2);
        return $paramNV;
    }

    public function paramNandV($params){
        $paramN = '';
        $paramV = '';
        foreach($params as $key => $val){
            $paramN .= $key.', ';
            $paramV .= ':'.$key.', ';
        }
        $paramN = substr($paramN, 0, -2);
        $paramV = substr($paramV, 0, -2);
        return $paramNandV = [
            'N' => $paramN,
            'V' => $paramV,
        ];
    }
}