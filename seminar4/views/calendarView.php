<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-12-01
 * Time: 22:37
 */

require_once APP_PATH . "views/viewInterface.php";
require_once APP_PATH . "views/baseView.php";
require_once APP_PATH . "models/recipe.php";

class CalendarView implements iViewTemplate {

	private $calendar;

	/**
	 * CalendarView constructor.
	 *
	 * @param Calendar $calendar
	 */
	public function __construct($calendar) {
		$this->calendar = $calendar;
	}

	public function pageHeadTag() {
		?>
		<link rel="stylesheet" href="<?php echo LINK_PATH; ?>css/calendar.css">
		<link rel="stylesheet" href="<?php echo LINK_PATH; ?>css/responsive/calendar-resp.css">
		<?php
	}

	public function pageContent() {
		$dateCounter = $this->calendar->firstOfTheMonth;
		?>
		<div class="calendar-wrapper w-100 px-5 d-flex flex-column justify-content-center align-items-center">
			<ul class="calendar-list">
				<?php while ($dateCounter->format("m") == $this->calendar->month):

					$eventsAtDate = $this->calendar->getEventByDate($dateCounter);
					if(count($eventsAtDate) > 0):
						$eventAtDate = array_pop($eventsAtDate);
						$currentRecipe = new Recipe($eventAtDate->recipeId);?>
						<li class="calendar-day recipe-on-day"
						style="background-image: url('<?php echo LINK_PATH.'media/'.$currentRecipe->thumbImg;?>')"
						onclick="location.href='<?php echo LINK_PATH.'index.php?page=recipe&recipe='.$eventAtDate->recipeId;?>'">
					<?php else:?>
						<li class="calendar-day">
					<?php endif;?>
					<span><?php echo $dateCounter->format("j");?></span>
					</li>
					<?php date_add($dateCounter, new DateInterval("P1D"))?>
				<?php endwhile; ?>
			</ul>
		</div>
		<?php
	}

	public function sidebarContent() {
		$prevMonthLink = "year=".$this->calendar->year."&month=".($this->calendar->month - 1);
		$nextMonthLink = "year=".$this->calendar->year."&month=".($this->calendar->month + 1);
		?>
		<div class="side-bar-content text-center d-flex flex-column justify-content-start">
			<div class="d-none d-md-flex flex-column justify-content-start">
				<h3 class="mb-3">Recipes of <?php echo $this->calendar->firstOfTheMonth->format("M");?>:</h3>
				<?php foreach ($this->calendar->eventsByMonth as $event): ?>
					<div class="recipe-link mb-3 d-inline">
						<span><?php echo $event->date;?>:</span>
						<a href="<?php echo LINK_PATH."index.php?page=recipe&recipe=".$event->recipeId;?>">
							<?php
							$recipe = new Recipe($event->recipeId);
							echo $recipe->title;
							?>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="calendar-nav w-100">
				<hr class="d-none d-md-block w-75">
				<div class="w-100 px-3 d-flex justify-content-between">
					<a href="<?php echo LINK_PATH . "index.php?page=calendar&".$prevMonthLink ?>">
						&lt;&lt; <?php echo $this->calendar->prevMonth->format("M")?>
					</a>
					<a href="<?php echo LINK_PATH . "index.php?page=calendar&".$nextMonthLink ?>">
						<?php echo $this->calendar->nextMonth->format("M")?> &gt;&gt;
					</a>
				</div>
			</div>
		</div>
		<?php
	}

	public function index() {
		// TODO: Implement index() method.
	}

	public function show() {

		BaseView::printBody(
			'calendar',
			array( $this, 'pageHeadTag' ),
			array( $this, 'pageContent' ),
			array( $this, 'sidebarContent' )
		);
	}
}