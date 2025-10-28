<?php
session_start();
require '../config/db.php';
require 'leave_view.php';
require 'util_view.php';
if(!isset($_SESSION['role'])) header('Location: ../login/login.php');



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Status</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="head">
            <h1 >Your Leave Status</h1>
            <!-- idrole from util_view.php -->
            <a href="../<?php echo idrole($_SESSION['role']); ?>/dashboard.php" class="btn primary">Dashboard</a>
        </div>
        <?php leave_status($pdo, $_SESSION['user_id']); ?>
        <div class="grid_table">
           <?php leave_status_declined($pdo, $_SESSION['user_id']); ?>
        </div>
    </div>
</body>
</html>