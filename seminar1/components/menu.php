<?php

function getMenu($sActive) {
	$sActiveHTML = " <span class='sr-only'>(current)</span>";
	$aRecipes = array(
		array(
			"id"   => "mballs",
			"name" => "Meatballs",
			"link" => ROOT_PATH . "pages/recipes/meatballs.php"
		),
		array(
			"id" => "pcakes",
			"name" => "Pancakes",
			"link" => ROOT_PATH."pages/recipes/pancakes.php"
		)
	);
	?>
	<nav class="navbar navbar-expand-lg navbar-dark">
		<a class="navbar-brand" href="<?php echo ROOT_PATH."index.php";?>">Recipes.com</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
				aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
					   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Recipes<?php echo ($sActive === "recipe" ? $sActiveHTML : "")?>
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<?php foreach ($aRecipes as $recipe):?>
							<a class="dropdown-item" href="<?php echo $recipe['link']; ?>">
								<?php echo $recipe['name'];; ?>
							</a>
						<?php endforeach;?>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo ROOT_PATH."pages/calendar.php";?>">
						Calendar<?php echo ($sActive === "calendar" ? $sActiveHTML : "")?>
					</a>
				</li>
			</ul>
		</div>
	</nav>
	<?php
}
?>