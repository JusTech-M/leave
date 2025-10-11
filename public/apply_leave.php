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
    
    display_form_submit();

    display_errors();
    
    
    ?>
    <h2>Apply for Leave</h2>
        <label>Leave Type:</label>
        <select name="leave_type" id="leaveType" required>
            <option value="casual">Casual Leave</option>
            <option value="annual">Annual Leave</option>
            <!-- <option value="recall_publicHolidayForm">Recall/Public Holiday</option> -->
        </select><br>
            <form method="post" id="casualLeaveForm" action="casual.inc.php" class="casual_leave">
                <input type="text" value="Casual Leave" name="casual_leave" readonly>
                <label>Name:</label>
                <input type="text" name="employee_name" value="<?php echo htmlspecialchars($_SESSION['name']);?>" required><br>
                <label>Designation:</label><input type="text" name="designation" required><br>
                <label>Department:</label><input type="text" name="department" value="<?php display_unit($units, $index);?>" required><br>
                
                <h3>Proposed Date of Leave:</h3><br>
                <label>Start Date: </label>
                <input type="date" name="start_date" id="casual_start" onchange="updateDays('casual')" required><br><br>
                
                <label>End Date: </label>
                <input type="date" name="end_date" id="casual_end" onchange="updateDays('casual')" required><br><br>
                
                <label>Total No. of Working Days: </label>
                <input type="number" name="Total_working_days" id="casual_days" required readonly><br><br>
                
                <label>Purpose of Leave:</label>
                <textarea name="leave_purpose" required></textarea><br><br>
                
                <label>Relieving Officer Name:</label><input type="text" name="relieving_name" required><br>
                <label>Relieving Officer Email:</label><input type="email" name="relieving_email" required><br>
                
                <button type="submit" class="btn primary">Submit</button>
        </form>

       <form method="post" id="annualLeaveForm" class="annual_leave hide" action="annual.inc.php">
                <input type="text" value="Annual Leave" name="annual_leave" readonly>
                <label>Name:</label>
                <input type="text" name="employee_name" value="<?php echo htmlspecialchars($_SESSION['name']);?>" required><br>
                <label>Designation:</label><input type="text" name="designation" required><br>
                <label>Department:</label><input type="text" name="department" value="<?php display_unit($units, $index);?>" required><br>
                
                <h3>Proposed Date of Annual Leave:</h3><br>
                <label>Start Date: </label>
                <input type="date" id="annual_start" name="start_date" onchange="updateDays('annual')" required><br><br>
                
                <label>End Date: </label>
                <input type="date" id="annual_end" name="end_date" onchange="updateDays('annual')" required><br><br>
                
                <label>Total No. of Working Days: </label>
                <input type="number" name="working_days" id="annual_days" required readonly><br><br>

                <label>Have you within the last 12 months been(or currently) on a leave of absence, study leave or Maternity Leave? </label>
                Yes <input type="radio" name="onLeave" id="onLeave" value="yes" checked require> No <input type="radio" name="onLeave" id="onLeave" value="no" require><br>
                <div class="yes"><br>
                
                <h3>If yes, indicate the period:</h3><br>
                 <label for="">From: </label><input type="date" name="on_leave_start" id="onLeaveStart" required><br><br>
                 <label for="">To: </label><input type="date" name="on_leave_end" id="onLeaveEnd" required><br><br>

                <div id="approvedNotStart" >
                <label>Has any of the above leave been approved but which you are yet to start?</label>
                Yes <input type="radio" name="onLeaveApproved" id="onLeaveApproved" value="yes"> No <input type="radio" name="onLeaveApproved" id="onLeaveApproved" value="no"><br>
                <div class="yes"><br>
                    <h3>If yes, indicate the period:</h3><br>
                    <label for="">From: </label><input type="date" name="on_leave_start_approved" id="onLeaveStart"><br><br>
                    <label for="">To: </label><input type="date" name="on_leave_end_approved" id="onLeaveEnd" ><br><br>
                </div>
                 <label for="">Approved deffered Leave No. of Days: </label><input type="number" name="deffered_leave" ><br><br>
            </div>
            <label>Relieving Officer Name:</label><input type="text" name="relieving_name"><br>
            <label>Relieving Officer Email:</label><input type="email" name="relieving_email"><br>
            <button type="submit" class="btn primary">Submit</button>
    </form>

         <!-- <form method="post" id="recall_publicHolidayForm" action="casual.i.php" class="recall_publicHolidayForm ">
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
                <textarea name="leave_purpose" required></textarea><br><br>
            
                
                <button type="submit" class="btn primary">Submit</button>
    </form> -->

    <?php  ?>
</div>

<script src="../assets/js/apply_leave.js"></script>
</body>
</html>