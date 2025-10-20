<?php
session_start();
require '../config/db.php';
//require 'leave_model.php';
require 'leave_view.php';
require 'util_view.php';
if(!isset($_SESSION['role'])) header("Location: ../login/login.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>relieve</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="head">
            <!-- idrole from util_view.php -->
            <a href="../<?php idrole($_SESSION['role']); ?>/dashboard.php" class="btn primary">Dashboard</a>
        </div>
        <div class="status">
            <p>List Of Staff That Want You To Relieve Them</p>
        </div>
        
            <div class="grid_table_relieve">
                <div class="heading">S/N</div>
                <div class="heading">Name</div>
                <div class="heading">Leave Type</div>
                <div class="heading">Start Date</div>
                <div class="heading">End Date</div>
                <div class="heading">Total No. of Days</div>
                <div class="heading">Action</div>
                <?php applicant_details($pdo, $_SESSION['email']);?>
            
            </div>
    </div>
</body>
</html>