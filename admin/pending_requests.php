<?php
session_start();
require '../config/db.php';
require 'admin_model.php';
require 'admin_view.php';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Pending Requests</title>
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
                <div class="heading">Start Date-End Date</div>
                <div class="heading">Working Days</div>
                <div class="heading">Leave Purpose</div>
                <div class="heading">HOD Recommendation</div>
                <div class="heading">Action</div>
                <?php applicant_details_casual($pdo, $_SESSION['unit_id'], "casual");?>
            
            </div>

            <p class="leave_section">Annual Leave Section</p>
            <div class="grid_table_pending">
                <div class="heading">Name</div>
                <div class="heading">Relieving Officer</div>
                <div class="heading">Type</div>
                <div class="heading">Start Date-End Date</div>
                <div class="heading">Working Days</div>
                <div class="heading">HOD Recommendation</div>
                <div class="heading">Leave Record</div>
                <div class="heading">Action</div>
                <?php applicant_details_annual($pdo, $_SESSION['unit_id'], "annual");?>
            
            </div>
  </div>
        

</body>
</html>
