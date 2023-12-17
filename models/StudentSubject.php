<?php

class StudentSubject extends Model{
    protected $table = 'student_subjects';
    protected $primaryKey = 'id';
    
    public function __construct(){
        parent::__construct($this->table);
    }
    
    public function get_student_subjects($student_id){
        $this->db->query("SELECT * FROM student_subjects WHERE student_id = {$student_id}");
        return $this->db->results();
    }

    public function findByTeacherAndSubject($teacher_id, $subject_id, $curriculum_id){
        $this->db->query("SELECT * FROM student_subjects WHERE teacher_id = {$teacher_id} AND subject_id = {$subject_id} AND curriculum_id = {$curriculum_id}");
        return $this->db->first();
    }

    public function findByStudentAndSubject($student_id, $subject_id){
        $this->db->query("SELECT * FROM student_subjects WHERE student_id = {$student_id} AND subject_id = {$subject_id}");
        return $this->db->first();
    }

    public function count_student_subjects($student_id){
        $this->db->query("SELECT * FROM student_subjects WHERE student_id = {$student_id}");
        return $this->db->count();
    }
}