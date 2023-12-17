<?php

require('../autoload.php');

if(!Input::get('table')){
    Redirect::to('index.php?page=dashboard');
}

$table = Input::get('table');

switch($table){
    case 'teachers':
        $teacher = new Teacher;
        $otp = new Otp;
        $email = new Email;
        $otp_code = $otp->generate_otp();
        $teacher->create([
            'username' => Input::get('username'),
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            'firstname' => Input::get('firstname'),
            'lastname' => Input::get('lastname')
        ]);
        $email->send(Input::get('email'), 'Your OTP Code', "Your OTP Code is: {$otp_code}");
        Session::flash('success', 'Teacher created successfully. Please check your email for your OTP code.');
        Redirect::to('index.php?page=teachers');
        break;
    case 'students':
        $student = new Student;
        $student->create([
            'course_id' => Input::get('course_id'),
            'id_number' => Input::get('id_number'),
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            'firstname' => Input::get('firstname'),
            'lastname' => Input::get('lastname')
        ]);
        Session::flash('success', 'Student created successfully.');
        Redirect::to('index.php?page=students');
        break;
    case 'subjects':
        $subject = new Subject;
        $subject->create([
            'curriculum_id' => Input::get('curriculum_id'),
            'teacher_id' => Input::get('teacher_id'),
            'subject_code' => Input::get('subject_code'),
            'subject_description' => Input::get('subject_description'),
            'subject_units' => Input::get('subject_units')
        ]);
        Session::flash('success', 'Subject created successfully.');
        Redirect::to('index.php?page=subjects');
        break;
    case 'curriculums':
        $curriculum = new Curriculum;
        $curriculum->create([
            'student_id' => Input::get('student_id'),
            'curriculum_year_level' => Input::get('curriculum_year_level'),
            'curriculum_session' => Input::get('curriculum_session'),
            'curriculum_school_year' => Input::get('curriculum_school_year')
        ]);
        Session::flash('success', 'Curriculum created successfully.');
        Redirect::to('index.php?page=curriculums');
        break;
    case 'courses':
        $course = new Course;
        $course->create([
            'course_code' => Input::get('course_code'),
            'course_description' => Input::get('course_description')
        ]);
        Session::flash('success', 'Course created successfully.');
        Redirect::to('index.php?page=courses');
        break;
    default:
        Redirect::to('index.php?page=dashboard');
        break;
}
