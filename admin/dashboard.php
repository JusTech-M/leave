<?php
session_start();
require "../config/db.php";
require "../public/util.php";
require "../public/util_view.php";
if(!isset($_SESSION['role'])) header("Location: ../login/login.php");
if ($_SESSION['role'] !== 'admin') die("Access denied.");
//
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

            <div class="summary color1">
                <div class="text">
                    <span>200</span><br><br>
                    <p>Total No. of Staff</p>
                </div>
                <div class="icon">
                <img src="../img/user.png" alt="">
                </div>

        
            </div>

            <div class="summary color2">
                <div class="text">
                    <span>22</span><br><br>
                    <p>Total No. of Leave Applicant</p>
                </div>
                <div class="icon">
                <img src="../img/user.png" alt="">
                </div>

        
            </div>

            <div class="summary color3">
                <div class="text">
                    <span>20</span><br><br>
                    <p>Total Appoved Leave</p>
                </div>
                <div class="icon">
                <img src="../img/user.png" alt="">
                </div>

        
            </div>

            <div>
                 <button class="btn red" id="clear"> Reset Leave </button>

                <div id="confirm">
                    <p>Are you sure you want to Reset Leave for all staff?</p>
                    <form action="clear_leave.php" method = "GET"><button class="btn normal" id="yes_action" name="clear">Reset</button></form>
                    <button class="btn bright" id="back">Back</button>
                </div>
            </div>
            '
?>

<?php include_once "../include/dashboard_admin_hod.php"?>
