<?php

spl_autoload_register('myAutoLoader');

function myAutoLoader($className){
    $classes_path = "classes/";
    $models_path = "models/";
    $extension = ".php";
    $filename = $className . $extension;

    if(file_exists('../' . $classes_path . $filename)){
        require '../' . $classes_path . $filename;
    }elseif(file_exists($classes_path . $filename)){
        require $classes_path . $filename;
    }elseif(file_exists('../' . $models_path . $filename)){
        require '../' . $models_path . $filename;
    }elseif(file_exists($models_path . $filename)){
        require $models_path . $filename;
    }elseif(file_exists('../classes/PHPMailer/' . $filename)){
        require '../classes/PHPMailer/' . $filename;
    }elseif(file_exists('classes/PHPMailer/' . $filename)){
        require 'classes/PHPMailer/' . $filename;
    }elseif(file_exists('PHPMailer/' . $filename)){
        require 'PHPMailer/' . $filename;
    }else{
        die("The file {$className}.php was not found.");
    }
}

session_start();