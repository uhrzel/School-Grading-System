<?php

class Database{
    protected static $instance = null;
    private $pdo, $query, $error = false, $results, $count = 0, $lastInsertId = null;

    private function __construct(){
        try{
            $this->pdo = new PDO('mysql:host='.Config::get('mysql/host').';dbname='.Config::get('mysql/database'), Config::get('mysql/user'), Config::get('mysql/password'), Config::get('mysql/options'));
        }catch(PDOException $e){
            die('Could not connect to database.'.$e->getMessage());
        }
    }
    
    public static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new Database();
        }
        
        return self::$instance;
    }

    public function query($sql, $params = []){
        $this->error = false;
        if($this->query = $this->pdo->prepare($sql)){
            $x = 1;
            if(count($params)){
                foreach($params as $param){
                    $this->query->bindValue($x, $param);
                    $x++;
                }
            }

            if($this->query->execute()){
                $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
                $this->count = $this->query->rowCount();
                $this->lastInsertId = $this->pdo->lastInsertId();
            }else{
                $this->error = true;
            }
        }

        return $this;
    }

    // insert, update, delete
    public function insert($table, $fields = []){
        $fieldString = '';
        $valueString = '';
        $values = [];

        foreach($fields as $field => $value){
            $fieldString .= '`'.$field.'`,';
            $valueString .= '?,';
            $values[] = $value;
        }

        $fieldString = rtrim($fieldString, ',');
        $valueString = rtrim($valueString, ',');

        $sql = "INSERT INTO {$table} ({$fieldString}) VALUES ({$valueString})";

        if(!$this->query($sql, $values)->error()){
            return true;
        }

        return false;
    }

    public function update($table, $id, $fields = []){
        $fieldString = '';
        $values = [];

        foreach($fields as $field => $value){
            $fieldString .= ' '.$field.' = ?,';
            $values[] = $value;
        }

        $fieldString = trim($fieldString);
        $fieldString = rtrim($fieldString, ',');

        $sql = "UPDATE {$table} SET {$fieldString} WHERE id = {$id}";

        if(!$this->query($sql, $values)->error()){
            return true;
        }

        return false;
    }

    public function delete($table, $id){
        if($this->query("DELETE FROM {$table} WHERE id = {$id}")){
            return true;
        }
    }

    public function deleteAll($table){
        if($this->query("DELETE FROM {$table}")){
            return true;
        }
    }

    public function results(){
        return $this->results;
    }

    public function first(){
        if($this->count()){
            return $this->results()[0];
        }
    }

    public function error(){
        return $this->error;
    }

    public function count(){
        return $this->count;
    }

    public function lastInsertId(){
        return $this->lastInsertId;
    }
}