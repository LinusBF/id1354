<?php
DEFINE("LINK_PATH", getenv("PRODUCTION") !== false ? "/seminar2/" : "/id1354/seminar2/");
DEFINE("APP_PATH", getenv( "PRODUCTION" ) !== false ? $_SERVER["DOCUMENT_ROOT"]."/seminar2/" : "/id1354/seminar2/");

if(!key_exists("month", $_GET) || !key_exists("year", $_GET)){
	header("Location: ".LINK_PATH.'index.php');
	die();
}

include "./components/baseBody.php";
include_once "./controllers/recipeController.php";
include_once "./controllers/calendarController.php";

$pageHeadTag = function () {
	if($_GET['month'] > 12) $_GET['month'] = 1;
	if($_GET['month'] < 1) $_GET['month'] = 12;
	?>
	<link rel="stylesheet" href="<?php echo LINK_PATH; ?>css/calendar.css">
	<link rel="stylesheet" href="<?php echo LINK_PATH; ?>css/responsive/calendar-resp.css">
	<?php
};

$pageContent = function () {
	$recipes = getRecipes();
	$recipesByMonth = getRecipesForMonth($_GET['year'], $_GET['month']);
	$firstOfTheMonth = new DateTime();
	date_date_set($firstOfTheMonth, $_GET['year'], $_GET['month'], 1);

	$filterByDate = function ($e) use ($firstOfTheMonth){
		return $e['date'] == $firstOfTheMonth->format('Y-m-d');
	}
	?>
	<div class="calendar-wrapper w-100 px-5 d-flex flex-column justify-content-center align-items-center">
		<ul class="calendar-list">
			<?php while ($firstOfTheMonth->format("m") == $_GET['month']):

				$recipeAtDate = array_filter($recipesByMonth, $filterByDate);
				if(count($recipeAtDate) > 0):
					$currentRecipe = $recipes[array_pop($recipeAtDate)['recipeId']];?>
				<li class="calendar-day recipe-on-day"
					style="background-image: url('<?php echo LINK_PATH.'media/'.$currentRecipe['thumbImg'];?>')"
					onclick="location.href='<?php echo LINK_PATH.'recipe.php?recipe='.$currentRecipe['urlName'];?>'">
				<?php else:?>
				<li class="calendar-day">
				<?php endif;?>
					<span><?php echo $firstOfTheMonth->format("j");?></span>
				</li>
				<?php date_add($firstOfTheMonth, new DateInterval("P1D"))?>
			<?php endwhile; ?>
		</ul>
	</div>
	<?php
};

$sidebarContent = function () {
	$recipes = getRecipes();
	$recipesByMonth = getRecipesForMonth($_GET['year'], $_GET['month']);

	$firstOfTheMonth = new DateTime();
	$prevMonth = new DateTime();
	$nextMonth = new DateTime();
	date_date_set($firstOfTheMonth, $_GET['year'], $_GET['month'], 1);
	date_date_set($prevMonth, $_GET['year'], $_GET['month'] - 1, 1);
	date_date_set($nextMonth, $_GET['year'], $_GET['month'] + 1, 1);

	$prevMonthLink = "?year=".$_GET['year']."&month=".($_GET['month'] - 1);
	$nextMonthLink = "?year=".$_GET['year']."&month=".($_GET['month'] + 1);
	?>
	<div class="side-bar-content text-center d-flex flex-column justify-content-start">
		<div class="d-none d-md-flex flex-column justify-content-start">
			<h3 class="mb-3">Recipes of <?php echo $firstOfTheMonth->format("M");?>:</h3>
			<?php foreach ($recipesByMonth as $recipe): ?>
				<div class="recipe-link mb-3 d-inline">
					<span><?php echo $recipe['date'];?>:</span>
					<a href="<?php echo LINK_PATH."recipe.php?recipe=".$recipes[$recipe['recipeId']]['urlName']?>"><?php echo $recipes[$recipe['recipeId']]['title'] ?></a>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="calendar-nav w-100">
			<hr class="d-none d-md-block w-75">
			<div class="w-100 px-3 d-flex justify-content-between">
				<a href="<?php echo LINK_PATH . "calendar.php".$prevMonthLink ?>">&lt;&lt; <?php echo $prevMonth->format("M")?></a>
				<a href="<?php echo LINK_PATH . "calendar.php".$nextMonthLink ?>"><?php echo $nextMonth->format("M")?> &gt;&gt;</a>
			</div>
		</div>
	</div>
	<?php
};

printBody("calendar", $pageContent, $sidebarContent, $pageHeadTag);