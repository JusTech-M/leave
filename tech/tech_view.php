<?php
require '../config/db.php';
require '../register/register_model.php';
//require '../register/register_view.php';

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

function check_registration_errors(){
    if(isset($_SESSION['errors_register'])){
        echo '<br>';
        $errors = $_SESSION['errors_register'];
        foreach ($errors as $error) {
            echo "<div class='alert alert-error' id='error'>{$error}</div>";

        }

        unset($_SESSION['errors_register'] );
    }

}

function registerSuccess(){
    if(isset($_GET['register']) && $_GET['register'] == 'success'){
    echo '<br>';
     echo "<div class='alert alert-success' id='success'>Tech Officer successfully added </div>";
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
             <a href="edit.php?id='.$user['id'].'" class="btn primary">Edit</a>
            <button name="delete" value="delete" class="btn red">Delete</button></form></div>';
        }
    }

    unset($_SESSION['user']);     
}

function display_units($pdo){
    $units = get_units($pdo);

    foreach($units as $unit){
        $option = '<option value="'.$unit['id'].'">'.htmlspecialchars($unit['unit_name']).'</option>';
    }

    return $option;
}

function display_level($level){
    if($level === 'snr'){
            return '<option value="">-- Select level --</option>
                    <option value="snr" selected>Senior Staff</option>
                    <option value="jnr_5&6">Junior Staff(lv 5&6)</option>
                    <option value="jnr_1-4">Junior Staff(lv 1-4)</option>';
        }elseif($level === 'jnr_5&6'){
            return '<option value="">-- Select level --</option>
                    <option value="snr">Senior Staff</option>
                    <option value="jnr_5&6" selected>Junior Staff(lv 5&6)</option>
                    <option value="jnr_1-4">Junior Staff(lv 1-4)</option>';
        }else{
             return '<option value="">-- Select level --</option>
                    <option value="snr">Senior Staff</option>
                    <option value="jnr_5&6" >Junior Staff(lv 5&6)</option>
                    <option value="jnr_1-4" selected>Junior Staff(lv 1-4)</option>';
        }
}


function display_user_to_edit($pdo, $user){
    if(isset($_GET['id'])){

        echo '<form method="post" action="update.inc.php">
    <label>Surname</label><input type="text" name="surname" value="'.$user['surname'].'" required><br>
    <label>Othername</label><input type="text" name="othername" value="'.$user['othername'].'" required><br>
    <label>Reference No.</label><input type="text" name="ref_no" value="'.$user['ref_no'].'" required><br>
    <label>Email</label><input type="email" name="email" value="'.$user['email'].'" required><br>
    <label>Role</label>
    <select name="role" id="role" required>
      <option value="">-- Select role --</option>
      <option value="staff">Staff</option>
      <option value="program_coordinator">Program Coordinator</option>
      <option value="head">HOD</option>
      <option value="admin">Admin</option>
      <option value="deputy_director">Deputy Director</option>
      <option value="director">Director</option>
    </select><br>

    <label>Unit</label>
    <select name="unit_id" id="unit" required>
      <option value="">-- Select Unit --</option>'.display_units($pdo).'</select><br>
     <label>Level</label>
    <select name="level" id="level" required>'.display_level($user['level']).'</select><br>

    <label>Password</label><input type="password" name="password" required><br>
    <label>Confirm Password</label><input type="password" name="confirm_password" required><br>
   
    <button type="submit" class="btn primary">Submit</button>
  </form>';
    }
}


