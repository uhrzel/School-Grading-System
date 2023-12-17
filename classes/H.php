<?php

class H{
    public static function dnd($data){
        echo '<pre>';
        echo print_r($data);
        echo '</pre>';
        die();
    }

    public static function sanitize($dirty){
        return htmlentities($dirty, ENT_QUOTES, 'UTF-8');
    }
}