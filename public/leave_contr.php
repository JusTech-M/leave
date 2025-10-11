<?php
function getWorkingDays($startDate, $endDate, $holidays = []) {
    $start = new DateTime($startDate);
    $end = new DateTime($endDate);
    $end->modify('+1 day'); // include end date
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($start, $interval, $end);

    $workingDays = 0;

    foreach ($daterange as $date) {
        $dayOfWeek = $date->format("N"); // 1 (Mon) to 7 (Sun)
        $dateStr = $date->format("Y-m-d");

        if ($dayOfWeek < 6 && !in_array($dateStr, $holidays)) {
            $workingDays++;
        }
    }

    return $workingDays;
}


function officer_not_a_member_of_staff($pdo, $relievingEmail){
    if(!get_relieve_email($pdo, $relievingEmail)){
        return true;
    }else{
        return false;
    }
}

function officer_not_in_the_same_unit($pdo, $relievingEmail){
    if(!get_relieve_unit_id($pdo, $relievingEmail)){
        return true;
    }else{
        return false;
    }
}



