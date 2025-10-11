<?php
session_start();
require '../config/db.php';
require 'login_model.php';
require 'login_contr.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $pass = trim($_POST['password']);
    $confirmPass = trim($_POST['confirm_password']);

    
try {
    $user = get_user($pdo, $email);
    $errors = [];
    if(is_input_empty($email, $pass)){
        $errors["empty_input"] = "Fill in all feilds!";
    }

    if(!is_input_empty($email, $pass) && is_email_wrong($user)){
        $errors["wrong_email"] = "User does not exist!";
    }

    //  if(!is_email_wrong($user) && is_password_wrong($pass, $user['password'])){
    //         $errors["login_incorrect"] = "Email or Password Incorrect!";
    //  }

     if($pass !== $confirmPass){
            $errors["password_not_match"] = "Password and Confirm Password does not match";
        }


     if($errors){
            $_SESSION['errors_login'] = $errors;

            header("Location: reset.php");
            die();
           
        }else{
            reset_password($pdo, $pass, $email);
            header("Location: reset.php?reset=success");
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
