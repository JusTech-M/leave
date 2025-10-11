<?php
session_start();
require '../config/db.php';
require 'login_model.php';
require 'login_contr.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);

    
try {
    $user = get_user($pdo, $email);
    $errors = [];
    if(is_input_empty($email, $pass)){
        $errors["empty_input"] = "Fill in all feilds!";
    }

    if(!is_input_empty($email, $pass) && is_email_wrong($user)){
        $errors["wrong_email"] = "User does not exist!";
    }

     if(!is_email_wrong($user) && is_password_wrong($pass, $user['password'])){
            $errors["login_incorrect"] = "Email or Password Incorrect!";
     }

     if($errors){
            $_SESSION['errors_login'] = $errors;

            header("Location: login.php");
            die();
           
        }else{
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['unit_id'] = $user['unit_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['ref_no'] = $user['ref_no'];
            $_SESSION['leave_entitlement'] = $user['leeav_entitlement'];
            $_SESSION['num_casual_used'] = $user['num_casual_leave'];
            $_SESSION['name'] = $user['surname'] .' '.$user['othername'];

            if ($user['role'] === 'staff') header("Location: ../employee/dashboard.php");
            elseif ($user['role'] === 'head') header("Location: ../head/dashboard.php");
            elseif ($user['role'] === 'admin') header("Location: ../admin/dashboard.php");
            elseif ($user['role'] === 'director') header("Location: ../director/dashboard.php");
            elseif ($user['role'] === 'program_coordinator') header("Location: ../program/dashboard.php");
            elseif ($user['role'] === 'deputy_director') header("Location: ../deputy_director/dashboard.php");
            else header("Location: login.php");
            exit;
        }
     
        
    // if ($user && md5($pass) === $user['password']) {
       
    // } else {
    //   $errors["login_incorrect"] = "Email or Password Incorrect!";
    // }

    

    $pdo = null;
    $stmt = null;

    die(); 

} catch (PDOException $e) {
    die('Query failed: '. $e->getMessage());
}
}
