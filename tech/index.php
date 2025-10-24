<?php 
session_start();
//require 'login_view.php';

?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="login-wrapper">
  <h2>Login</h2>
 <div class="main">
  <div class="login">
     <?php //check_login_errors(); ?>
  <form method="post" action="login.inc.php">
    <!--<label>Email: </label>--><input type="email" name="email" placeholder="Email" required><br>
    <!--<label>Password: </label>--><input type="password" name="password" placeholder="password" required><br>
    <button type="submit" class="btn primary">Login</button>
  </form>
  <p>Don't have an account? <a class="primary" href="../register/register.php">Register</a></p>
  <p style="margin-top:20px;"><a class="primary" style="background-color:transparent; color:#000869;" href="reset.php">Forgot Password? Click Here</a></p>
  </div>
  <div class="imgdiv"><img src="" alt=""></div>
 </div>
</div>
<script src="../assets/js/script.js"></script>
</body>
</html>
