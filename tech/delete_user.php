<?php

session_start();
require '../config/db.php';
require '../public/util.php';
require 'tech_view.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/tech.css">
    <title>Delete</title>
</head>
<body>
    
    <div class="">
        <div class="wrapper">
        <form action="search.inc.php" method="post">
        <h3>UPDATE/DELETE USERS</h3>
        <input type="text" name="app_id" placeholder="Enter User Email/Reference Number"><button class="btn bright">Search</button>
        </form>

        <div class="grid_table">
            <?php search_user($pdo); ?>
        </div>
        <div class="msg">
            <?php   
                displayError(); 
                displaySummary();
                displaymsg();
                
            ?>
        </div>
        </div>
    </div>
    
</body>
</html>