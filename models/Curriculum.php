<?php

class Curriculum extends Model{
    protected $table = 'curriculums';
    protected $primaryKey = 'id';
    
    public function __construct(){
        parent::__construct($this->table);
    }

    // get curriculum info
    public function get_curriculum_info($curriculum_id){
        $this->db->query("SELECT * FROM curriculums WHERE id = {$curriculum_id}");
        return $this->db->first();
    }
}