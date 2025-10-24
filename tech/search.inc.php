<?php
session_start();
require "../config/db.php";
require "tech_model.php";
require '../public/util.php';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $userRefNum = $_POST['app_id'];
    $email = $_POST['app_id'];
    $unitName = $_POST['app_id'];
    


    $errors = [];

    $unitId = get_unit_id_by_name($pdo, $unitName);

    // if(!$unitId){
    //    $errors['invalid_unit'] = "Unit does not exist"; 
    // }

    if(empty($userRefNum)){
        $errors['empty_field'] = "Insert Reference Number";
    }

    $user = userRefNum($pdo, $userRefNum, $email, $unitId['id']);

    if(!$user && !empty($userRefNum)){
        $errors['user_not_exist'] = "User does not exist";
    }

    if($errors){
        $_SESSION['errors'] = $errors;
        header("Location: delete_user.php");
        die();
    }

    $_SESSION['user'] = $user;
    header("Location: delete_user.php");
    die();

}else{
    header("Location: ../login/login.php");
    die();
}