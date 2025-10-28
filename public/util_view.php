<?php
// =========================================================== This function is used at include folder ====================================================

function idrole($role){
    if($role === "admin") return "admin";
    if($role === "head") return "head";
    if($role === "staff") return "employee";
    if($role === "program_coordinator") return "program";
    if($role === "director") return "Director";
    if($role === "deputy_director") return "Deputy Director";
}

function display_units($pdo){
    $units = get_units($pdo);

    foreach($units as $unit){
        echo '<option value="'.$unit['id'].'">'.htmlspecialchars($unit['unit_name']).'</option>';
    }
}


function displayHtml($html){
    return $html;
}

function display($check){
    $value = empty($check)?0:$check;
    return $value;
}

function adminSec(){
    
}
