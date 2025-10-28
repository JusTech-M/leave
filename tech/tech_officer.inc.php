<?php
session_start();
require "../config/db.php";
require "tech_model.php";
require "tech_contr.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    try {
        $users = get_user($pdo, $username);

         $errors = [];
            if(is_input_fields_empty($username, $email, $password, $confirmPassword)){
                $errors["empty_input"] = "Fill in all feilds!";
            }

            if(is_username_taken($users)){
                $errors["username_taken"] = "Username is used!";
            }

            if(is_email_invalid($email)){
                $errors["invalid_email"] = "Invalid email used";
            }

            if($password !== $confirmPassword){
                $errors["password_not_match"] = "Password does not match with the Confirm Password";
            }

            if($errors){
                    $_SESSION['errors_register'] = $errors;

                    header("Location: add_tech_officer.php");
                    die();
                
            }
        add_user($pdo, $username, $email, $password);
        header("Location: add_tech_officer.php?register=success");
    } catch (PDOException $e) {
        die('Query failed: '. $e->getMessage());
    }

}else{
    header('Location: index.php');
}