<?php

class Teacher extends Model{
    protected $table = 'teachers';
    protected $primaryKey = 'id';
    
    public function __construct(){
        parent::__construct($this->table);
    }

    public function isLoggedIn(){
        return (Session::exists('teacher')) ? true : false;
    }

    public function login($username, $password){
        $res = $this->db->query("SELECT * FROM {$this->table} WHERE username = ? OR email = ?", [$username, $username]);
        if($res->count()){
            $user = $res->first();
            if($password === $user->password){
                Session::put('teacher', $user->id);
                return true;
            }
        }

        return false;
    }

    public function logout(){
        Session::delete('teacher');
    }

    public function get_full_name($id){
        $res = $this->db->query("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
        if($res->count()){
            $user = $res->first();
            return $user->first_name . ' ' . $user->last_name;
        }

        return false;
    }
}