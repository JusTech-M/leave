
<?php
// function idrole($role){
//     if($role === "director") return "Director";
//     if($role === "deputy_director") return "Deputy Director";
// }

//$leaveDetails = get_app($pdo, $_SESSION['user_id']);

// function display($check){
//     $value = empty($check)?0:$check;
//     return $value;
// }

function displayRole(){
            if(idrole($_SESSION['role']) === 'Director'){
                echo "<h1 class='welcome'> Welcome to Director's Dashboard</h1>";
            }else{
                echo "<h1 class='welcome'> Welcome to Deputy Director Dashboard</h1>";
            }
        }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Director's page</title>
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
                    
                    <li><a class="" href="pending_requests.php">Pending Leave Request </a></li>
                    
                </ul>
            </nav>
        </div>
    </div>

    <div class="wrapper">
        <div class="background">
            <div class="top">
                <?php displayRole(); ?>
                  <a class="" href="../public/logout.php">Logout</a>
            </div>

        <div class="grid">
            <?php echo displayHtml($html); ?>
        </div>
        </div>
        </div>
        </div>
</div>
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

<!-- <script src="../assets/js/clear.js"></script> -->
</body>
</html>