<?php

class Model{
    protected $db, $table, $data, $error = false, $results, $count, $lastInsertId;

    public function __construct($table){
        $this->db = Database::getInstance();
        $this->table = $table;
    }

    public function create($fields = []){
        $this->db->insert($this->table, $fields);
        $this->lastInsertId = $this->db->lastInsertId();
        return $this->db->count();
    }

    public function update($id, $fields = []){
        $this->db->update($this->table, $id, $fields);
        return $this->db->count();
    }

    public function delete($id){
        $this->db->delete($this->table, $id);
        return $this->db->count();
    }

    public function deleteAll(){
        $this->db->deleteAll($this->table);
        return $this->db->count();
    }

    public function findById($id){
        $this->db->query("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
        if($this->db->count() > 0){
            return $this->db->first();
        }
    }

    public function where($where = []){
        $this->db->query("SELECT * FROM {$this->table} WHERE {$where[0]} {$where[1]} ?", [$where[2]]);
        if($this->db->count() > 0){
            $this->results = $this->db->results();
            $this->count = $this->db->count();
            return $this;
        }
    }

    public function find($id){
        $this->db->query("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
        if($this->db->count() > 0){
            $this->results = $this->db->results();
            $this->count = $this->db->count();
            return $this;
        }
    }

    public function findBy($field, $value){
        $this->db->query("SELECT * FROM {$this->table} WHERE {$field} = ?", [$value]);
        if($this->db->count() > 0){
            $this->results = $this->db->results();
            $this->count = $this->db->count();
            return $this;
        }
    }

    public function findAll($order = ''){
        $this->db->query("SELECT * FROM {$this->table} {$order}");
        return $this->db->results();
    }

    public function first(){
        if($this->count > 0){
            return $this->results[0];
        }else{
            return $this->results;
        }
    }

    public function count(){
        return $this->count;
    }

    public function lastInsertId(){
        return $this->lastInsertId;
    }

    public function error(){
        return $this->error;
    }

    public function results(){
        return $this->results;
    }

    public function __get($name){
        return $this->$name;
    }
}