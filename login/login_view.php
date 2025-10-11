<?php

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

function password_reset(){
    if(isset($_GET['reset']) && $_GET['reset'] === 'success'){
    echo '<p>Your Password is Reset <a class="primary" href="../login/login.php">Click here to login</a></p>';
}
}

