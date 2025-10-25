<?php
require '../config/db.php';
require '../register/register_model.php';

function check_login_errors(){
    if(isset($_SESSION['errors_login'])){
        echo '<br>';
        $errors = $_SESSION['errors_login'];
        foreach ($errors as $error) {
            echo "<div class='alert alert-error' id='error'>{$error}</div>";

        }

        unset($_SESSION['errors_login'] );
    }

}

function displayError(){
    if(isset($_SESSION['errors'])){
        $errors = $_SESSION['errors'];
        echo "<hr><b>Errors</b>";
        foreach($errors as $error){
           echo "<p class='alert-error'>{$error}</p>";
        }
        unset($_SESSION['errors']);
    }
}

// function displaySummary(){
//     if(isset($_GET['upload']) && $_GET['upload'] === 'success'){
//         echo "<h3>Upload Summary</h3>";
//         echo "<p class='alert-success'>Successful:".$_SESSION['success']."</p>";
//         echo "<p class='alert-success'>Failed: ".$_SESSION['failed']."</p>";
//         echo "<p class='alert-success'>Skipped:".$_SESSION['failed']."</p>";
//     }
// }

function displaymsg(){
    if(isset($_SESSION['messsage'])){
        echo $_SESSION['messsage'];
    }

    unset($_SESSION['messsage']);

}

function displaySummary(){
    if(isset($_GET['upload']) && $_GET['upload'] === 'success'){
        echo "<h3>Upload Summary</h3>";
        echo "<p class='alert-success'>Successful:".$_SESSION['success']."</p>";
        echo "<p class='alert-success'>Failed: ".$_SESSION['failed']."</p>";
        echo "<p class='alert-success'>Skipped:".$_SESSION['failed']."</p>";
    }elseif(isset($_GET['delete']) && $_GET['delete'] === 'success'){
        echo "<p class='alert-success'>User Deleted</p>";
    }
}

// ================= Get array index of unit ===========================

function display_unit($units, $index){
    if(isset($_SESSION['user'])){
        $users = $_SESSION['user'];
        foreach($users as $user){
            if($user['role'] === "admin"){
                return "Admin";
            }elseif($user['role'] === "program_coordinator"){
                return "Program Coordinator";
            }else{
                return $units[$index]['unit_name'];
            }
        }
    }
}



function search_user($pdo){
    if(isset($_SESSION['user'])){
        $units = get_units($pdo);
        $users = $_SESSION['user'];
        foreach($users as $user){
             $index = array_search($user['unit_id'], array_column($units, 'id'));
            echo '<div class="heading">REFERENCE NUMBER</div>
            <div class="heading">NAME</div>
            <div class="heading">ROLE</div>
            <div class="heading">DEPARTMENT</div>
            <div class="heading">ACTION</div>
            <div>'.$user['ref_no'].'</div>
            <div>'.$user['surname']. ' '.$user['othername'].'</div>
            <div>'.$user['role'].'</div>
            <div>'.display_unit($units, $index).'</div>
            <div><form method="post" action="delete.inc.php">
            <input type="hidden" value="'.$user['ref_no'].'" name="ref_no">
            <button name="delete" value="delete" class="btn red">Delete</button></form></div>';
        }
    }

    unset($_SESSION['user']);
        
}



