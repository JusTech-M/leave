<?php
session_start();
if(!isset($_SESSION['role'])) header("Location: ../login/login.php");
if ($_SESSION['role'] !== 'deputy_director') die("Access denied.");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Director's page</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="wrapper">
        <div class="background">
            <div class="top">
                <h1 class="dashboard">Deputy Director Dashboard</h1>
                <a class="" href="../public/logout.php">Logout</a>
                </div>
            <div class="">
            
                <?php echo "<h1 class='welcome'> Welcome Deputy Director</h1>"?>
            
            </div>

       <div class="action">
        <button class="btn bright"><a class="bright" href="pending_requests.php">Pending Leave Request </a></button>
    </div>
        </div>
       </div>
</body>
</html>