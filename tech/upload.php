<?php
session_start();
require 'tech_view.php'
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/tech.css">
    <title>upload staff</title>
</head>
<body>
    
    <div class="">
        <div class="wrapper">
        <form action="tech.inc.php" method="post" enctype="multipart/form-data">
        <h3>UPLOAD USERS</h3>
        <input type="file" name="staff_lists"><button class="btn bright">Upload</button>
        </form>
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