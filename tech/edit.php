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
<head><link rel="stylesheet" href="../assets/css/tech.css"></head>
<body>
<div class="container">
  <?php 
  //check_register_errors(); 
  //display_form_submit()
  $user = display_user_to_edit($pdo, $user);
  ?>
  <div class="form_container">
    <h1>Edit a member of Staff profile</h1>
    <form method="post" action="update.inc.php">
      <input type="text" name="surname" value="<?php echo $user['surname'] ?>" required><br>
      <input type="text" name="othername" value="<?php echo $user['othername'] ?>" required><br>
      <input type="text" name="ref_no" value="<?php echo $user['ref_no'] ?>" required><br>
      <input type="email" name="email" value="<?php echo $user['email'] ?>" required><br>

      <select name="role" id="role" required>
        <option value="">-- Select role --</option>
          <?php
                $roles = ["staff", "program_coordinator", "head", "admin", "deputy_director", "director"];
                foreach ($roles as $role) {
                    $selected = ($user['role'] === $role) ? 'selected' : '';
                    echo "<option value='$role' $selected>" . ucfirst(str_replace('_', ' ', $role)) . "</option>";
                }
                  ?>
      </select><br>

      <select name="unit_id" id="unit" required>
        <option value="">-- Select Unit --</option> 
            <?php
                $units = get_units($pdo);
                foreach ($units as $unit) {
                  $selected = ($unit['id'] == $user['unit_id']) ? 'selected' : '';
                  echo "<option value='{$unit['id']}' $selected>" . htmlspecialchars($unit['unit_name']) . "</option>";
                }
            ?>
      </select><br>
      <select name="level" id="level" required>
            <?php
              $levels = ["snr" => "Senior Staff", "jnr_5&6" => "Junior Staff (Lv 5&6)", "jnr_1-4" => "Junior Staff (Lv 1–4)", "admin" => "Admin", "director" => "Director"];
              foreach ($levels as $key => $label) {
                  $selected = ($user['level'] === $key) ? 'selected' : '';
                    echo "<option value='$key' $selected>$label</option>";
                }
              ?>

      </select><br>

      <!-- <label>Password</label><input type="password" name="password" required><br>
      <label>Confirm Password</label><input type="password" name="confirm_password" required><br> -->
    
      <button type="submit" class="btn primary">Update</button>
  </form>
  </div>
</div>

<script src="../assets/js/script.js"></script>
</body>
</html>
