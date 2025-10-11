<?php


function applicant_details_annual($pdo, $unit_id, $type){
    $applicant_details = get_leave_request($pdo);
    if($applicant_details){
        $unit_id = $_SESSION['unit_id'];
        
    foreach($applicant_details as $apps){
        $recommendation = !$apps["hod_recommendation"]?"No comment":$apps["hod_recommendation"];

        if($apps["leave_type"] === 'Annual Leave' && $type === "annual"){
             echo '<div>'.$apps["surname"].'<br>'.$apps["othername"].'</div>
                <div>'.$apps["relieving_officer"].'</div>
                <div>'.$apps["leave_type"].'</div>
                <div>'.$apps["start_date"].'<br>'.$apps["end_date"].'</div>
                <div>'.$apps["working_days"].'</div>
                <div>'.$recommendation.'</div>
                <div>
                <h5>currently(or been) on leave </h5>
                From: '.$apps["is_onLeaveStart"].'<br>To: '.$apps["is_onLeaveStart"].'<br>
                 <h5>Days Approved</h5>
                From: '.$apps["is_onLeaveStartApproved"].'<br>To: '.$apps["is_onLeaveStartApproved"].'<br>
                <h5>No. of Deffered Leave:</h5> '.$apps["defferedLleave"].'
                </div>
                <div><form method="post" action="admin.inc.php" class="note">
                            <input type="hidden" name="id" value="'.$apps['id'].'">
                            <input type="hidden" name="user_id" value="'.$apps['user_id'].'">
                            <input type="hidden" name="unit_id" value="'.$unit_id.'">
                            <textarea name="note" placeholder="Comment" ></textarea><br>
                            <button name="action" value="approve" class="btn yellow">Approved</button>
                            <button name="action" value="reject" class="btn normal">Reject</button>
                        </form></div>';
        }
           
        
    }
    }else{
            echo '<div class="no_leave"> No Annual Leave </div>';
        }
    //$count = 1;
}

function applicant_details_casual($pdo, $unit_id, $type){
    $applicant_details = get_leave_request($pdo, $unit_id);

    if($applicant_details){
        $unit_id = $_SESSION['unit_id'];
    foreach($applicant_details as $apps){
        $recommendation = !$apps["hod_recommendation"]?"No comment":$apps["hod_recommendation"];

        if($apps["leave_type"] === 'Casual Leave' && $type === "casual"){
              echo '<div>'.$apps["surname"].'<br>'.$apps["othername"].'</div>
                <div>'.$apps["relieving_officer"].'</div>
                <div>'.$apps["leave_type"].'</div>
                <div>'.$apps["start_date"].'<br>'.$apps["end_date"].'</div>
                <div>'.$apps["working_days"].'</div>
                <div>'.$apps["reason"].'</div>
                <div>'.$recommendation.'</div>
                <div><form method="post" action="admin.inc.php" class="note">
                            <input type="hidden" name="id" value="'.$apps['id'].'">
                            <input type="hidden" name="user_id" value="'.$apps['user_id'].'">
                            <input type="hidden" name="unit_id" value="'.$unit_id.'">
                            <textarea name="note" placeholder="Comment" ></textarea><br>
                            <button name="action" value="approve" class="btn yellow">Approved</button>
                            <button name="action" value="reject" class="btn normal">Reject</button>
                        </form></div>';

        }
    }

    }else{
            echo '<div class="no_leave"> No Casual Leave </div>';
        }
    //$count = 1;
    
}