<?php
include_once APP_PATH."models/calendar.php";
include_once APP_PATH."views/calendarView.php";

if(!key_exists("month", $_GET) || !key_exists("year", $_GET)){
	header("Location: ".LINK_PATH.'index.php');
	die();
}

$calendar = new Calendar($_GET['month'], $_GET['year']);
$view = new CalendarView($calendar);

$view->show();
