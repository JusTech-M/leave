
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
    <p class="recall"> Add Recall/Public Holidays</P>
    <div class="label">
        <div>From:</div>
        <div>To:</div>
        <div>Working Days:</div>
    </div>
        <form action="">
                <input type="date" name="start_date" id="start">
                <input type="date" name="end_date" id="end">
                <input type="number" name="working_days" id="num_working_days" readonly>
                <button class="btn red">Add</button>
        </form>
        </div>
       </div>

       <script src="../assets/js/recall.js"></script>
</body>
</html>