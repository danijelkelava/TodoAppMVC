<?php 
session_start();

spl_autoload_register(function ($class_name){

    if (file_exists("./objects/" . $class_name . ".php")){
        require_once "./objects/" . $class_name . ".php";
    }elseif(file_exists("./Controllers/" . $class_name . ".php")){
        require_once "./Controllers/" . $class_name . ".php";
    }

});

require_once "Routes.php";

Helper::checkRoute();
?>

