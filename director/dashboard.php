<?php
session_start();
require '../public/util_view.php';
if(!isset($_SESSION['role'])) header("Location: ../login/login.php");
if ($_SESSION['role'] !== 'director') die("Access denied.");
?>

<?php 
    $html = '<div class="summary color1">
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

            <div class="summary color4">
                <div class="text">
                    <span>2</span><br><br>
                    <p>Total Rejected Leave</p>
                </div>
                <div class="icon">
                <img src="../img/user.png" alt="">
                </div>

        
            </div>';
?>

<?php include "../include/dashboard_director.php";?>