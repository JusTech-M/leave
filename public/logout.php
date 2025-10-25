<?php
session_start();

if($_SESSION['role'] === 'tech'){
    session_destroy();
    header("Location: ../tech/index.php");
}else{
    session_destroy();
    header("Location: ../login/login.php");
}
exit;
