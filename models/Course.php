<?php

class Course extends Model{
    protected $table = 'courses';
    protected $primaryKey = 'id';
    
    public function __construct(){
        parent::__construct($this->table);
    }

    public function get_course_info($course_id){
        $this->db->query("SELECT * FROM courses WHERE id = {$course_id}");
        return $this->db->first();
    }
}