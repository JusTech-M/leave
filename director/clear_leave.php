<?php
require "../config/db.php";
require "director_model.php";
require "../public/util.php";

if(isset($_GET['clear'])){
 
    $usedCasual = 0;
    $totalLeaveUsed = 0;
    $leaveEntitlement;

    //$levels = get_allUser_level($pdo);

    // foreach ($levels as $level) {
    //     if($level['level'] === 'snr'){
    //         $leaveEntitlement = 42;
    //     }elseif($level['level'] === 'jnr_5&6'){
    //         $leaveEntitlement = 30;
    //     }else{
    //         $leaveEntitlement = 26;
    //     }
    // }

    clear_leave($pdo, $usedCasual, $totalLeaveUsed);

    header("Location: dashboard.php");

}

//var_dump(get_allUser_level($pdo));

//echo 'working';