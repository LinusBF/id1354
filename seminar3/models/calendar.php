<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-12-01
 * Time: 22:40
 */

require_once APP_PATH . "utils/calendarSchedule.php";

class Calendar {
	public $month;
	public $year;
	public $firstOfTheMonth;
	public $eventsByMonth;
	public $prevMonth;
	public $nextMonth;


	/**
	 * Calendar constructor.
	 *
	 * @param $month
	 * @param $year
	 */
	public function __construct( $month, $year ) {
		$this->month = ($month > 12 ? $month % 12 : $month);
		$this->month = ($month < 1 ? 12 : $this->month);
		$this->year = $year;
		$firstOfMonth = new DateTime();
		$prevMonth = new DateTime();
		$nextMonth = new DateTime();
		date_date_set($firstOfMonth, $this->year, $this->month, 1);
		date_date_set($prevMonth, $this->year, $this->month - 1, 1);
		date_date_set($nextMonth, $this->year, $this->month + 1, 1);
		$this->firstOfTheMonth = $firstOfMonth;
		$this->prevMonth       = $prevMonth;
		$this->nextMonth       = $nextMonth;
		$this->eventsByMonth   = CalendarSchedule::getEventsForMonth($this->year, $this->month);
	}

	/**
	 * @param DateTime $date
	 *
	 * @return array
	 */
	public function getEventByDate($date){
		$filterByDate = function ($e) use ($date){
			return $e->date == $date->format('Y-m-d');
		};
		return array_filter($this->eventsByMonth, $filterByDate);
	}
}