<?php
session_start();
require '../config/db.php';
require 'leave_model.php';

if (isset($_POST['clear'])){
    clearLeave($pdo, $_SESSION['user_id']);

    header('Location: leave_status.php');
    die();
}