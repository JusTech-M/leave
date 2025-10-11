<?php
// =========================================================== This function is used at include folder ====================================================

function idrole($role){
    if($role === "admin") echo "admin";
    if($role === "head") echo "head";
    if($role === "staff") echo "employee";
    if($role === "program_coordinator") echo "program";
}