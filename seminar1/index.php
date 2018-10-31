<?php
DEFINE( "ROOT_PATH", getenv( "PRODUCTION" ) !== false ? "/seminar1/" : "/id1354/seminar1/" );
include "./components/base-body.php";

$pageContent = function () {
	?>
	<div id="recipeSlide" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			<div class="carousel-item active">
				<img class="d-block w-100" src="media/meatballs.jpg" alt="Meatballs">
			</div>
			<div class="carousel-item">
				<img class="d-block w-100" src="media/pancakes.jpg" alt="Pancakes">
			</div>
		</div>
	</div>
	<?php
};

printBody($pageContent);
?>
