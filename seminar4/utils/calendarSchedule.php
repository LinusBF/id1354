<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-12-01
 * Time: 22:22
 */

class CalendarSchedule {
	public static function  getEventsForMonth($year, $month){
		$calendar = json_decode(file_get_contents(APP_PATH."data/calendar.json"), false);
		$calendarInMonth = [];
		foreach($calendar->calendar as $recipeDay){
			$date = date_create_from_format("Y-m-d", $recipeDay->date);
			if($date->format("Y") == $year && $date->format("m") == $month) {
				array_push($calendarInMonth, $recipeDay);
			}
		}
		return $calendarInMonth;
	}
}