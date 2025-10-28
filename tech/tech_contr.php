<?php

function is_input_empty($username, $pass){
    if(empty($username) || empty($pass)){
        return true;
    } else {
        return false;
 }
     
} 

function is_username_wrong($result){
    if(!$result){
        return true;
    }else{
        return false;
    }
}

function is_password_wrong($pass, $hashedpassword){
    if(!password_verify($pass, $hashedpassword)){
        return true;
    }else{
        return false;
    }
}

function is_input_fields_empty($username, $email, $password, $confirmPassword){
    if(empty($username) || empty($email) || empty($password) || empty($confirmPassword)){
        return true;
    }else{
        return false;
    }
}

function is_username_taken($result){
    if($result){
        return true;
    }else{
        return false;
    }
}

function is_email_invalid($email){
     if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
     } else {
        return false;
     }
   
}
