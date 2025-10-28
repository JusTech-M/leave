<?php
session_start();
 if(!isset($_SESSION['role']) || (isset($_SESSION['role']) && $_SESSION['role'] !== 'tech')){
    header("Location: index.php");
    die();
 }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/tech.css">
    <title>tech page</title>
</head>
<body>

<div class="container">
    <div class="head">
        <div class="logo"><img src="../img/img.png" alt=""></div>
        <h3>Tech dashboard</h3>
        <div class="profile">
            <div class="notify_icon">
                <img src="../img/notification.png" alt="">
                <div class="alart">1</div>
            </div>
            <div class="pic"><img src="../img/user.png" alt=""></div>
            <div class="admin_action">
                <span>tech officer ></span>
            </div>
        </div>
    </div>

<div class="main">
    <div class="sidebars">
        <div class="profile">
            <div class="pic"><img src="../img/user.png" alt=""></div>
            <div class="greet">
                Welcome! <br><span>Tech officer</span>
            </div>
        </div>

        <div class="navmenu">
            <nav>
                <ul>
                    <li><a href="../register/register.php">Add Member</a></li>
                    <li><a href="delete_user.php">Delete Member</a></li>
                    <li><a href="update_user.php">Update Member profile</a></li>
                    <li><a href="upload.php">Upload staff list</a></li>
                    <li><a href="add_tech_officer.php">Add Tech Officer</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="wrapper">
        <div class="background">
            <div class="top">
                 <h1 class="dashboard">Welcome to Tech Dashboard</h1>
                  <a class="" href="../public/logout.php">Logout</a>
            </div>

        <div class="grid">
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

            <div class="summary color4">
                <div class="text">
                    <span>2</span><br><br>
                    <p>Total Rejected Leave</p>
                </div>
                <div class="icon">
                <img src="../img/user.png" alt="">
                </div>

        
            </div>
            
        </div>
        </div>
        </div>
        </div>
</div>



</body>
</html>