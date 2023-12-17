<?php

class Subject extends Model{
    protected $table = 'subjects';
    protected $primaryKey = 'id';
    
    public function __construct(){
        parent::__construct($this->table);
    }

    // get total subject units
    public function get_total_units(){
        $total_units = 0;
        $subjects = $this->findAll();
        foreach($subjects as $s){
            $total_units += $s->subject_units;
        }
        return $total_units;
    }

    // check if subject code and course id exists
    public function subject_code_exists($subject_code, $course_id){
        $this->db->query("SELECT * FROM subjects WHERE subject_code = ? AND course_id = ?", [$subject_code, $course_id]);
        if($this->db->count() > 0){
            return true;
        }
        return false;
    }

    // get all students under subject
    public function get_students($subject_id, $curriculum_id){
        $this->db->query("SELECT * FROM student_subjects WHERE subject_id = {$subject_id} AND curriculum_id = {$curriculum_id}");
        return $this->db->results();
    }

    public function get_subject_info($subject_id){
        $this->db->query("SELECT * FROM subjects WHERE id = {$subject_id}");
        return $this->db->first();
    }

    //get subject code
    public function get_subject_code($subject_id){
        $this->db->query("SELECT * FROM subjects WHERE id = {$subject_id}");
        return $this->db->first()->subject_code;
    }
}