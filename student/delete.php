<?php

require('../autoload.php');

if(!Input::get('id') || !Input::get('table')){
    Redirect::to('index.php?page=dashboard');
}

$id = Input::get('id');
$table = Input::get('table');

switch($table){
    case 'curriculums':
        $curriculum = new Curriculum();
        $curriculum->delete($id);
        Session::flash('success', 'Curriculum deleted successfully!');
        Redirect::to('index.php?page=dashboard');
        break;
    case 'student_subjects':
        $student_subject = new StudentSubject();
        $student_subject->delete($id);
        Session::flash('success', 'Subject deleted successfully!');
        Redirect::to('index.php?page=curriculum&id=' . Input::get('cur_id'));
        break;
    default:
        Redirect::to('index.php?page=dashboard');
        break;
}
