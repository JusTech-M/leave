
<?php
// function idrole($role){
//     if($role === "admin") return "Admin Sec";
//     if($role === "head") return "HOD";
// }



function displayRole(){
            if(idrole($_SESSION['role']) === 'admin'){
                return "<h1 class='welcome'> Welcome to Administrative Secretary Dashboard</h1>";
            }else{
                return  "<h1 class='welcome'> Welcome to HOD Dashboard</h1>";
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo idrole($_SESSION['role']); ?></title>
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
                 <?php echo "<span>" . idrole($_SESSION['role']) . "</span>"?>
            </div>
        </div>
    </div>

<div class="main">
    <div class="sidebars">
        <div class="profile">
            <div class="pic"><img src="../img/user.png" alt=""></div>
            <div class="greet">
                Welcome! <br><span> <?php echo idrole($_SESSION['role'])?></span>
            </div>
        </div>

        <div class="navmenu">
            <nav>
                <ul>
                    <li><a class="" href="../public/apply_leave.php">Apply for Leave</a></li>
                    <li><a class="" href="../public/leave_status.php">Track Leave</a></li>
                    <li><a href="../public/relieve.php">Relieve a Member of Staff</a></li>
                    <li><a href="../public/recall.php" class="recall"> Add Recall/Public Holidays</a></li>
                    <li><a class="" href="pending_requests.php">Pending Leave Request </a></li>
                    
                </ul>
            </nav>
        </div>
    </div>

    <div class="wrapper">
        <div class="background">
            <div class="top">
                <?php echo displayRole(); ?>
                  <a class="" href="../public/logout.php">Logout</a>
            </div>

        <div class="grid">
            <?php echo displayHtml($html); ?>
        </div>
        </div>
        </div>
        </div>
</div>

<script src="../assets/js/clear.js"></script>
</body>
</html>
