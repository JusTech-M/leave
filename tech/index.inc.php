<?php
session_start();
require "../config/db.php";
require "tech_model.php";
require "tech_contr.php";
//require "../config/db.php";

if($_SERVER['REQUEST_METHOD'] === "POST"){

    $username = $_POST['username'];
    $pass = $_POST['password'];

    try {
        $user = get_user($pdo, $username);
            $errors = [];
            if(is_input_empty($username, $pass)){
                $errors["empty_input"] = "Fill in all feilds!";
            }

            if(!is_input_empty($username, $pass) && is_username_wrong($user)){
                $errors["wrong_username"] = "User does not exist!";
            }

            // if(!is_email_wrong($user) && is_password_wrong($pass, $user['password'])){
            //         $errors["login_incorrect"] = "Email or Password Incorrect!";
            // }

            if($errors){
                    $_SESSION['errors_login'] = $errors;

                    header("Location: index.php");
                    die();
                
            }
            $_SESSION['role'] = 'tech';
            header("Location: dashboard.php");

    } catch (PDOException $e) {
        die('Query failed: '. $e->getMessage());
    }
}else{
    header("Location: index.php");
}