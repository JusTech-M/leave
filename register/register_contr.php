<?php

function is_input_empty($surname, $othername, $refNo, $email, $role, $level, $pass, $confirmPass ){
    if(empty($surname) || empty($othername) || empty($refNo) || empty($email) || empty($role) || empty($level) || empty($pass) || empty($confirmPass)){
        return true;
    } else {
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


function is_email_registered($pdo, $email){
     if(get_email($pdo, $email)){
        return true;
     } else {
        return false;
     }
   
}
