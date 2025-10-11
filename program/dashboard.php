<?php
session_start();
require "../config/db.php";
require "../public/util.php";
if(!isset($_SESSION['role'])) header("Location: ../login/login.php");
if ($_SESSION['role'] !== 'program_coordinator') die("Access denied.");

?>

<?php include_once "../include/dashboard_employee.php"?>