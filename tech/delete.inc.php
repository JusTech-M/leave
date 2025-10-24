<?php
session_start();
require "../config/db.php";
require "tech_model.php";

if($_SERVER['REQUEST_METHOD']=='POST'){
    $userRefNum = $_POST['ref_no'];

    // $errors = [];

    // if($errors){
    //     $_SESSION['errors'] = $errors;
    //     header("Location: delete_user.php");
    //     die();
    // }
    try {
        //$_SESSION['user'] = $user;
        deleteUser($pdo, $userRefNum);
        header("Location: delete_user.php?delete=success");
        die();
    } catch (PDOException $e) {
         die("Query Failed: ". $e->getMessage());
    }
    
}else{
    header("Location: ../login/login.php");
    die();
}