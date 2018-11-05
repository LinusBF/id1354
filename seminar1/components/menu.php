<?php

include_once APP_PATH."controllers/recipeController.php";

function getMenu($sActive) {
	$aRecipes = getRecipes();
	$today = new DateTime();
	$calendarDate = "?year=".$today->format("Y")."&month=".$today->format("m");
	?>
	<nav class="navbar navbar-expand-lg navbar-dark">
		<a class="navbar-brand" href="<?php echo LINK_PATH . "index.php";?>">Recipes.com</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
				aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle <?php echo ($sActive === "recipe" ? "active" : "")?>" href="#" id="navbarDropdown" role="button"
					   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Recipes
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<?php foreach ($aRecipes as $recipe):?>
							<a class="dropdown-item" href="<?php echo LINK_PATH . "recipe.php?recipe=" . $recipe['urlName']; ?>">
								<?php echo $recipe['name'];; ?>
							</a>
						<?php endforeach;?>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php echo ($sActive === "calendar" ? "active" : "")?>" href="<?php echo LINK_PATH . "calendar.php".$calendarDate;?>">
						Calendar
					</a>
				</li>
			</ul>
		</div>
	</nav>
	<?php
}
?>