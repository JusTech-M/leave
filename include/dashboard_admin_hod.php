
<?php
function idrole($role){
    if($role === "admin") echo "Admin";
    if($role === "head") echo "HOD";
}

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
    <title><?php idrole($_SESSION['role']); ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="wrapper">
        <div class="background">
            <div class="top">
                <h1 class="dashboard"><?php idrole($_SESSION['role']); ?> Dashboard</h1>
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
        <button class="btn white"><a  href="../public/apply_leave.php">Apply for Leave</a></button>
        <button class="btn bright"><a class="bright" href="pending_requests.php">Pending Leave Request </a></button>
    </div>
        </div>
       </div>
</body>
</html>
