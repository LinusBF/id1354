<?php

/**
 * @return array
 */
function getDatesWithRecipe(){
    $calendar = json_decode(file_get_contents(APP_PATH."data/calendar.json"), true);
    return $calendar['calendar'];
}

function getRecipesForMonth($year, $month){
    $calendar = json_decode(file_get_contents(APP_PATH."data/calendar.json"), true);
    $calendarInMonth = [];
    foreach($calendar['calendar'] as $recipeDay){
        $date = date_create_from_format("Y-m-d", $recipeDay['date']);
        if($date->format("Y") == $year && $date->format("m") == $month) {
            array_push($calendarInMonth, $recipeDay);
        }
    }
    return $calendarInMonth;
}