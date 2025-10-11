<?php 
session_start();
require 'login_view.php';
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="login-wrapper">
  <h2>Login</h2>
 <div class="main">
  <div class="login">
     <?php check_login_errors(); ?>
  <form method="post" action="reset.inc.php">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="New password" required><br>
    <input type="password" name="confirm_password" placeholder="Confirm password" required><br>
    <button type="submit" class="btn primary">Reset</button>
  </form>
  <?php password_reset(); ?>
  </div>
  <div class="imgdiv"><img src="" alt=""></div>
 </div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>