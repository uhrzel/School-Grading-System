<?php

class Admin extends Model{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    
    public function __construct(){
        parent::__construct($this->table);
    }

    public function isLoggedIn(){
        return (Session::exists('admin_id')) ? true : false;
    }

    public function login($username, $password){
        $res = $this->findBy('username', $username);
        if($res->count() > 0){
            $data = $res->first();
            if($password === $data->password){
                return $res;
            }

            return false;

        }else{
            return false;
        }
    }

    public function logout(){
        Session::delete('admin_id');
    }
}