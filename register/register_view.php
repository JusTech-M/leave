<?php

require '../config/db.php';
require 'register_model.php';


function display_units($pdo){
    $units = get_units($pdo);

    foreach($units as $unit){
        echo '<option value="'.$unit['id'].'">'.htmlspecialchars($unit['unit_name']).'</option>';
    }
}


function check_register_errors(){
    if(isset($_SESSION['errors_register'])){
    $errors = $_SESSION['errors_register'];
     echo '<br>';
    foreach($errors as $error){
        echo "<div class='alert alert-error' id='error'>{$error}</div>";
    }

    unset($_SESSION['errors_register']);  
    } 
    // else if(isset($_GET['signup']) && $_GET['signup'] === "success"){
    //     echo '<br>';
    //     echo "<div class='alert alert-error'>  </div>";
    // }
}

function display_form_submit(){
    if(isset($_GET['signup']) && $_GET['signup'] === 'success'){
    echo '<br>';
    echo '<div class="alert alert-success" id="error">Registration Successful proceed to login</div>';
}
}
