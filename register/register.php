<?php
session_start();
require '../config/db.php';
require 'register_view.php';
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="container">
  <h2>Register</h2>
  <?php 
  check_register_errors(); 
  display_form_submit()
  ?>
  <form method="post" action="register.inc.php">
    <label>Surname</label><input type="text" name="surname" required><br>
    <label>Othername</label><input type="text" name="othername" required><br>
    <label>Reference No.</label><input type="text" name="ref_no" required><br>
    <label>Email</label><input type="email" name="email" required><br>
    <label>Role</label>
    <select name="role" id="role" required>
      <option value="">-- Select role --</option>
      <option value="staff">Staff</option>
      <option value="program_coordinator">Program Coordinator</option>
      <option value="head">HOD</option>
      <option value="admin">Admin</option>
      <option value="deputy_director">Deputy Director</option>
      <option value="director">Director</option>
    </select><br>

    <label>Unit</label>
    <select name="unit_id" id="unit" required>
      <option value="">-- Select Unit --</option>
      <?php display_units($pdo); ?>
    </select><br>
     <label>Level</label>
    <select name="level" id="level" required>
      <option value="">-- Select level --</option>
      <option value="snr">Senior Staff</option>
      <option value="jnr_5&6">Junior Staff(lv 5&6)</option>
      <option value="jnr_1-4">Junior Staff(lv 1-4)</option>
    </select><br>

    <label>Password</label><input type="password" name="password" required><br>
    <label>Confirm Password</label><input type="password" name="confirm_password" required><br>
   
    <button type="submit" class="btn primary">Register</button>
  </form>
  <p>Already registered? <a href="../login/login.php" class="btn primary">Login</a></p>
</div>

<script src="../assets/js/script.js"></script>
</body>
</html>
