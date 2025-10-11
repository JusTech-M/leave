<?php

function calculateResumptionDate($endDate, $extraDaysWorked, $pdo) {
    $date = new DateTime($endDate);

    // fetch all public holidays
    $stmt = $pdo->query("SELECT holiday_date FROM public_holidays");
    $holidays = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Start from the next day
    $date->modify('+1 day');

    $daysToAdd = $extraDaysWorked;

    // Keep extending until we’ve added all extra days + skipped weekends/holidays
    while ($daysToAdd > 0 || in_array($date->format('N'), [6, 7]) || in_array($date->format('Y-m-d'), $holidays)) {
        // If it's a working day, reduce daysToAdd
        if (!in_array($date->format('N'), [6, 7]) && !in_array($date->format('Y-m-d'), $holidays)) {
            if ($daysToAdd > 0) {
                $daysToAdd--;
            } else {
                break;
            }
        }
        $date->modify('+1 day');
    }

    return $date->format('Y-m-d');
}
