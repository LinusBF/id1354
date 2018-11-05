<?php

/**
 * @return array
 */
function getDatesWithRecipe(){
    $recipes = json_decode(file_get_contents(APP_PATH."data/calendar.json"), true);
    return $recipes['calendar'];
}

function getRecipesForMonth($year, $month){
    $recipes = json_decode(file_get_contents(APP_PATH."data/calendar.json"), true);
    $recipesInMonth = [];
    foreach($recipes as $recipeDay){
        $date = date_create_from_format("Y-M-j", $recipeDay['date']);
        if(date_format($date, "Y") == $year && date_format($date, "M") == $month) {
            array_push($recipesInMonth, $recipeDay);
        }
    }
    return $recipesInMonth;
}