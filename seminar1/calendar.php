<?php
DEFINE("LINK_PATH", getenv("PRODUCTION") !== false ? "/seminar1/" : "/id1354/seminar1/");
DEFINE("APP_PATH", getenv( "PRODUCTION" ) !== false ? $_SERVER["DOCUMENT_ROOT"]."/seminar1/" : "/id1354/seminar1/");
include "./components/baseBody.php";
include_once "./controllers/calendarController.php";

$pageContent = function () {
	$recipesByMonth = getRecipesForMonth($_GET['year'], $_GET['month']);
	$firstOfTheMonth = new DateTime();
	date_date_set($firstOfTheMonth, $_GET['year'], $_GET['month'], 0);
	?>
	<div class="recipe-wrapper px-5 d-flex flex-column justify-content-center align-items-start">
		<div class="ingredients-wrapper mb-3">
			<ol>
				<?php while (date_format($firstOfTheMonth, "M") == $_GET['month']): ?>
					<li class="mb-1"><?php echo date_format($firstOfTheMonth, "j");?></li>
					<?php date_add($firstOfTheMonth, new DateInterval("P1D"))?>
				<?php endwhile; ?>
			</ol>
		</div>
	</div>
	<?php
};

printBody("calendar", $pageContent);