
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
    <link rel="stylesheet" href="../assets/css/tech.css">
</head>
<body>

    <div class="container">
    <div class="head">
        <div class="logo"><img src="../img/img.png" alt=""></div>
        <!-- <h3>Staff dashboard</h3> -->
        <div class="profile">
            <div class="notify_icon">
                <img src="../img/notification.png" alt="">
                <div class="alart">1</div>
            </div>
            <div class="pic"><img src="../img/user.png" alt=""></div>
            <div class="admin_action">
                 <?php echo "<span>" . $_SESSION['name'] . "</span>"?>
            </div>
        </div>
    </div>

<div class="main">
    <div class="sidebars">
        <div class="profile">
            <div class="pic"><img src="../img/user.png" alt=""></div>
            <div class="greet">
                Welcome! <br><span> <?php echo $_SESSION['name']?></span>
            </div>
        </div>

        <div class="navmenu">
            <nav>
                <ul>
                    <li><a class="" href="../public/apply_leave.php">Apply for Leave</a></li>
                    <li><a class="" href="../public/leave_status.php">Track Leave</a></li>
                    <li><a href="../public/relieve.php">Relieve a Member of Staff</a></li>
                    <li><a href="../public/recall.php" class="recall"> Add Recall/Public Holidays</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="wrapper">
        <div class="background">
            <div class="top">
                 <h1 class="dashboard">Welcome to Staff Dashboard</h1>
                  <a class="" href="../public/logout.php">Logout</a>
            </div>

        <div class="grid">
            <div class="summary color1">
                <div class="text">
                    <span><?php echo display($leaveDetails['leeav_entitlement']) ?></span><br><br>
                    <p>No. of Outstanding Leave</p>
                </div>
                <div class="icon">
                <img src="../img/user.png" alt="">
                </div>

        
            </div>

            <div class="summary color2">
                <div class="text">
                    <span><?php echo display($leaveDetails['num_casual_leave'])?></span><br><br>
                    <p>No. of used Casual Leave</p>
                </div>
                <div class="icon">
                <img src="../img/user.png" alt="">
                </div>

        
            </div>

            <div class="summary color3">
                <div class="text">
                    <span><?php echo display($leaveDetails['num_used_leave']) ?></span><br><br>
                    <p>Total No. of used Leave</p>
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
    <script src="../assets/js/recall.js"></script>
</body>
</html>