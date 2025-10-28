<?php
session_start();
require "../config/db.php";
require "../public/util.php";
require "../public/util_view.php";
if(!isset($_SESSION['role'])) header("Location: ../login/login.php");
if ($_SESSION['role'] !== 'head') die("Access denied.");

$leaveDetails = get_app($pdo, $_SESSION['user_id']);

?>

<?php 
$html = '<div class="summary color1">
                <div class="text">
                    <span>'.display($leaveDetails['leeav_entitlement']) .'</span><br><br>
                    <p>No. of Outstanding Leave</p>
                </div>
                <div class="icon">
                <img src="../img/user.png" alt="">
                </div>

        
            </div>

            <div class="summary color2">
                <div class="text">
                    <span>'.display($leaveDetails['num_casual_leave']).'</span><br><br>
                    <p>No. of used Casual Leave</p>
                </div>
                <div class="icon">
                <img src="../img/user.png" alt="">
                </div>

        
            </div>

            <div class="summary color3">
                <div class="text">
                    <span>'.display($leaveDetails['num_used_leave']).'</span><br><br>
                    <p>Total No. of used Leave</p>
                </div>
                <div class="icon">
                <img src="../img/user.png" alt="">
                </div>

        
            </div>

            <div class="summary color4">
                <div class="text">
                    <span>2</span><br><br>
                    <p>Total Rejected Leave</p>
                </div>
                <div class="icon">
                <img src="../img/user.png" alt="">
                </div>

        
            </div>
            '
?>

<?php include_once "../include/dashboard_admin_hod.php"?>
