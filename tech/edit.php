<?php
session_start();
require '../config/db.php';
require '../public/util.php';
require 'tech_view.php';
 if(!isset($_SESSION['role']) || (isset($_SESSION['role']) && $_SESSION['role'] !== 'tech')){
    header("Location: index.php");
    die();
 }

?>

<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="../assets/css/style.css"></head>
<body>
<div class="container">
  <h2>Edit Staff Info</h2>
  <?php 
  //check_register_errors(); 
  //display_form_submit()
  ?>
  <!-- <form method="post" action="register.inc.php">
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
      <?php// display_units($pdo); ?>
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
  </form> -->

  <?php 
        $id = $_GET['id'];
        $user = get_user_to_edit($pdo, $id);
    display_user_to_edit($pdo, $user);
  ?>
</div>

<script src="../assets/js/script.js"></script>
</body>
</html>
