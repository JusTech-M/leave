<?php
session_start();
require '../config/db.php';
require '../register/register_model.php';
require 'leave_view.php';

if(!isset($_SESSION['role'])) header("Location: ../login/login.php");

$units = get_units($pdo);

// ================= Get array index of unit ===========================
$index = array_search($_SESSION['unit_id'], array_column($units, 'id'));
function display_unit($units, $index){
    if($_SESSION['role'] === "admin"){
        echo "Admin";
    }elseif($_SESSION['role'] === "program_coordinator"){
        echo "Program Coordinator";
    }else{
        echo $units[$index]['unit_name'];
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Apply for Leave</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="container">
    
    <?php 
    goto_dashboard();

    not_onLeave();
    
    // display_form_submit();

    // display_errors();
    
    
    ?>
    <h2>Add Recall/Public Holidays</h2>
    
         <form method="post" id="recall_publicHolidayForm" action="recall.inc.php" class="recall_publicHolidayForm ">
                <label>Name:</label>
                <input type="text" name="employee_name" value="<?php echo htmlspecialchars($_SESSION['name']);?>" required><br>
                <label>Designation:</label><input type="text" name="designation" required><br>
                <label>Department:</label><input type="text" name="department" value="<?php display_unit($units, $index);?>" required><br>
                
                <h3>Recall/Publc holiday Date:</h3><br>
                <label>Start Date: </label>
                <input type="date" name="start_date" id="recall_start" onchange="updateDays('recall')" required><br><br>
                
                <label>End Date: </label>
                <input type="date" name="end_date" id="recall_end" onchange="updateDays('recall')" required><br><br>
                
                <label>Total No. of Working Days: </label>
                <input type="number" name="Total_working_days" id="recall_days" required readonly><br><br>
                
                <label>Reason for Recall/ Holiday Title:</label>
                <textarea name="recall_purpose" required></textarea><br><br>
            
                
                <button type="submit" class="btn primary">Submit</button>
    </form>

    <?php  ?>
</div>

<script src="../assets/js/apply_leave.js"></script>
</body>
</html>