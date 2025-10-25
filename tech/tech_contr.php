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

