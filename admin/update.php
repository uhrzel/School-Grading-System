<?php

require('../autoload.php');

if(!Input::get('table') || !Input::get('id')){
    Redirect::to('index.php?page=dashboard');
}

$id = Input::get('id');
$table = Input::get('table');

switch($table){
    case 'teachers':
        $teacher = new Teacher;
        $teacher->update($id, [
            'username' => Input::get('username'),
            'email' => Input::get('email'),
            'password' => Input::get('password'),
            'firstname' => Input::get('firstname'),
            'lastname' => Input::get('lastname')
        ]);
        Session::flash('success', 'Teacher updated successfully.');
        Redirect::to('index.php?page=teachers');
        break;
    default:
        Redirect::to('index.php?page=dashboard');
        break;
}
