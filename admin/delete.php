<?php

require('../autoload.php');

if(!Input::get('id') || !Input::get('table')){
    Redirect::to('index.php?page=dashboard');
}

$id = Input::get('id');
$table = Input::get('table');

switch($table){
    case 'teachers':
        $teacher = new Teacher;
        $teacher->delete($id);
        Session::flash('success', 'Teacher deleted successfully.');
        Redirect::to('index.php?page=teachers');
        break;
    case 'students':
        $student = new Student;
        $student->delete($id);
        Session::flash('success', 'Student deleted successfully.');
        Redirect::to('index.php?page=students');
        break;
    case 'subjects':
        $subject = new Subject;
        $subject->delete($id);
        Session::flash('success', 'Subject deleted successfully.');
        Redirect::to('index.php?page=subjects');
        break;
    case 'curriculums':
        $curriculum = new Curriculum;
        $curriculum->delete($id);
        Session::flash('success', 'Curriculum deleted successfully.');
        Redirect::to('index.php?page=dashboard');
        break;
    case 'courses':
        $course = new Course;
        $course->delete($id);
        Session::flash('success', 'Course deleted successfully.');
        Redirect::to('index.php?page=courses');
        break;
    case 'student_subjects':
        $student_subject = new StudentSubject;
        $student_subject->delete($id);
        Session::flash('success', 'Student subject deleted successfully.');
        Redirect::to('index.php?page=student&id=' . Input::get('student_id'));
        break;
    default:
        Redirect::to('index.php?page=dashboard');
        break;
}
