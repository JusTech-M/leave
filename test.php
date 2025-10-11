<?php
require 'config/db.php';
require 'public/casual_model.php';
$holidays = [];

        if(get_public_holidays($pdo)){
            $publicHolidays = get_public_holidays($pdo);
            foreach ($publicHolidays as $holiday) {
                array_push($holidays, $holiday);
            }
        }


        var_dump($holidays);