<?php

class Student extends Model{
    protected $table = 'students';
    protected $primaryKey = 'id';
    
    public function __construct(){
        parent::__construct($this->table);
    }

    public function isLoggedIn(){
        return (Session::exists('student')) ? true : false;
    }

    public function login($id_number, $password){
        $res = $this->db->query("SELECT * FROM {$this->table} WHERE id_number = ? OR email = ?", [$id_number, $id_number]);
        if($res->count()){
            $data = $res->first();
            if($password === $data->password){
                return $res;
            }

            return false;
        }

        return false;
    }

    public function change_password($id, $password){
        $this->db->query("UPDATE {$this->table} SET password = ? WHERE id = ?", [$password, $id]);
    }

    public function logout(){
        Session::delete('student');
    }

    // get student full name
    public function get_full_name($id){
        $this->db->query("SELECT * FROM students WHERE id = {$id}");
        $student = $this->db->first();
        return $student->first_name . ' ' . $student->last_name;
    }
}