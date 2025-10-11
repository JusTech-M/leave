<?php
session_start();
require '../config/db.php';
require 'register_model.php';
require 'register_contr.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $surname = trim($_POST['surname']);
    $othername = trim($_POST['othername']);
    $refNo = trim($_POST['ref_no']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $unit_id = !empty($_POST['unit_id'])?$_POST['unit_id']:null;
    $level = $_POST['level'];
    $pass = ($_POST['password']);
    $confirmPass = ($_POST['confirm_password']);


    try {

        if($role === "director") $unit_id = null ;
        if($role === "admin") $unit_id = null ;
        if($role === "program_coordinator") $unit_id = null ;
        if($role === "deputy_director") $unit_id = null ;
        $leaveEntitlement;
        if($level === 'snr'){
            $leaveEntitlement = 42;
        }elseif($level === 'jnr_5&6'){
            $leaveEntitlement = 30;
        }else{
            $leaveEntitlement = 26;
        }

        $errors = [];
        if(is_input_empty($surname, $othername, $refNo, $email, $role, $level, $pass, $confirmPass )){
            $errors["empty_input"] = "Fill in all feilds!";
        }
        if(is_email_invalid($email)){
            $errors["invalid_email"] = "invalid email used!";
        }
        if(is_email_registered($pdo, $email)){
            $errors["email_used"] = "Email is already registered!";
        }

        if($pass !== $confirmPass){
            $errors["password_not_match"] = "Password and Confirm Password does not match";
        }

        if($errors){
            $_SESSION['errors_register'] = $errors;

            $signupData = [
                'username' => $usernmame,
                'email' => $email
            ];

            $_SESSION['signup_data'] = $signupData;
            header("Location: register.php");
            die();
           
        }

        set_user($pdo, $surname, $othername, $refNo, $email, $role, $unit_id, $level, $pass, $leaveEntitlement);

        header("Location: register.php?signup=success");
        exit;
       
    } catch (PDOException $e) {
        die('Query failed: '. $e->getMessage());
    }
}

