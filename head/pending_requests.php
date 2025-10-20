<?php
session_start();
require '../config/db.php';
require 'head_model.php';
require 'head_view.php';
require '../public/util_view.php';


?>
<!DOCTYPE html>
<html>
<head>
  <title>Head Pending Requests</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="container">
    <nav>
    <a href="dashboard.php" class="btn primary">Dashboard</a>
    <a href="../public/logout.php" class="btn primary">Logout</a>
    </nav>
    <div class="status">
            <p>Pending Leave Request</p>
        </div>
        <p class="leave_section">Casual Leave Section</p>
            <div class="grid_table_pending">
                <div class="heading">Name</div>
                <div class="heading">Relieving Officer</div>
                <div class="heading">Type</div>
                <div class="heading">Start Date</div>
                <div class="heading">End Date</div>
                <div class="heading">Working Days</div>
                <div class="heading">Leave Purpose</div>
                <div class="heading">Action</div>
                <?php applicant_details_casual($pdo, $_SESSION['unit_id'], "casual");?>
            
            </div>

            <p class="leave_section">Annual Leave Section</p>
            <div class="grid_table_pending">
                <div class="heading">Name</div>
                <div class="heading">Relieving Officer</div>
                <div class="heading">Type</div>
                <div class="heading">Start Date</div>
                <div class="heading">End Date</div>
                <div class="heading">Working Days</div>
                <div class="heading">Leave Record</div>
                <div class="heading">Action</div>
                <?php applicant_details_annual($pdo, $_SESSION['unit_id'], "annual");?>
            
            </div>

            <p class="leave_section">Recall/Public Holiday(s)</p>
            <div class="grid_table_pending">
                <div class="heading">S/N</div>
                <div class="heading">Name</div>
                <div class="heading">Designation</div>
                <div class="heading">Start Date</div>
                <div class="heading">End Date</div>
                <div class="heading">Working Days</div>
                <div class="heading">Recall/Public Holiday Title</div>
                <div class="heading">Action</div>
                <?php get_recall_publicHolidays($pdo, $_SESSION['unit_id']);?>
            
            </div>
  </div>
        

</body>
</html>
