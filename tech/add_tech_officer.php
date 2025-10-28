<?php
session_start();
 if(!isset($_SESSION['role']) || (isset($_SESSION['role']) && $_SESSION['role'] !== 'tech')){
    header("Location: index.php");
    die();
 }

 require 'tech_view.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add tech officer</title>
    <link rel="stylesheet" href="../assets/css/tech.css">
</head>
<body>
    <div class="center">
        <div class="form_container">
        <h1>Add a Technical Officer</h1>
        <form action="tech_officer.inc.php" method="post">
        <input type="text" placeholder="Username" name="username">
        <input type="email" placeholder="Email Address" name="email">
        <input type="password" placeholder="Password" name="password">
        <input type="password" placeholder="Comfirm Password" name="confirm_password">
        <button type="submit"> Submit </button>
    </form>
    <?php
        registerSuccess(); 
        check_registration_errors(); 
    ?>
    </div>
    </div>
    
</body>
</html>