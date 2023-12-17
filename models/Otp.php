<?php

class Otp extends Model{
    protected $table = 'otps';
    protected $primaryKey = 'id';
    
    public function __construct(){
        parent::__construct($this->table);
    }

    public function generate_otp(){
        $otp = rand(100000, 999999);
        return $otp;
    }

    //delete otp
    public function delete_otp($student_id){
        $this->db->query("DELETE FROM {$this->table} WHERE student_id = {$student_id}");
    }
}