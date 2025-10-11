<?php
session_start();
if(!isset($_SESSION['role'])) header("Location: ../login/login.php");
if ($_SESSION['role'] !== 'director') die("Access denied.");
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
                <h1 class="dashboard">Director Dashboard</h1>
                <a class="" href="../public/logout.php">Logout</a>
                </div>
            <div class="">
            
                <?php echo "<h1 class='welcome'> Welcome Director</h1>"?>
            
            </div>

       <div class="action">
        <button class="btn bright"><a class="bright" href="pending_requests.php"> Pending Leave Request </a></button>
        <button class="btn red" id="clear"> Reset Leave </button>

        <div id="confirm">
            <p>Are you sure you want to Reset Leave for all staff?</p>
            <form action="clear_leave.php" method = "GET"><button class="btn normal" id="yes_action" name="clear">Reset</button></form>
            <button class="btn bright" id="back">Back</button>
        </div>
    </div>
        </div>
       </div>

<script src="../assets/js/clear.js"></script>
</body>
</html>