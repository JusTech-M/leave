
<?php
$leaveDetails = get_app($pdo, $_SESSION['user_id']);

function display($check){
    $value = empty($check)?0:$check;
    return $value;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="wrapper">
        <div class="background">
            <div class="top">
                 <h1 class="dashboard">Staff Dashboard</h1>
                  <a class="" href="../public/logout.php">Logout</a>
            </div>
            <div class="">
           
            <?php echo "<h1 class='welcome'> Welcome " . $_SESSION['name'] . "</h1>"?>
           
        </div>
        
         <div class="leave_details">
             <p>No. of Outstanding Leave: <span><?php echo display($leaveDetails['leeav_entitlement']) ?></span></p>
            <p>No. of used Casual Leave: <span><?php echo display($leaveDetails['num_casual_leave'])?></span></p>
            <p>Total No. of used Leave: <span><?php echo display($leaveDetails['num_used_leave']) ?></span></p>
        </div>

       <div class="action">
        <button class="btn white"><a class="white" href="../public/leave_status.php">Track Leave</a></button>
        <button class="btn white"><a href="../public/relieve.php">Relieve a Member of Staff</a></button>
         <button class="btn bright"><a class="bright" href="../public/apply_leave.php">Apply for Leave</a></button>
    </div>
    <a href="../public/recall.php" class="recall"> Add Recall/Public Holidays</a>
        </div>
       </div>

       <script src="../assets/js/recall.js"></script>
</body>
</html>