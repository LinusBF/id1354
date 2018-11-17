<?php
DEFINE("LINK_PATH", getenv("PRODUCTION") !== false ? "/seminar2/" : "/id1354/seminar2/");
DEFINE("APP_PATH", getenv( "PRODUCTION" ) !== false ? $_SERVER["DOCUMENT_ROOT"]."/seminar2/" : "/id1354/seminar2/");
include "./components/baseBody.php";
include_once "./controllers/recipeController.php";

$pageHeadTag = function () {
	?>
	<link rel="stylesheet" href="<?php echo LINK_PATH; ?>css/index.css">
	<link rel="stylesheet" href="<?php echo LINK_PATH; ?>css/responsive/index-resp.css">
	<?php
};

$pageContent = function () {
	$recipes = getRecipes();
	$featuredRecipe = $recipes[getFeaturedId()];
	?>
	<div class="featured-description px-5 py-4 py-sm-0 d-flex flex-column justify-content-center align-items-center">
		<span class="mb-3">
			<span class="recipe-title"><?php echo $featuredRecipe['title'];?></span>
		</span>
		<p class="mb-5"><?php echo $featuredRecipe['shortDesc'];?></p>
		<a class="btn btn-primary" href="<?php echo LINK_PATH . "recipe.php?recipe=" . $featuredRecipe['urlName']; ?>" role="button">
			Cook this menu
		</a>
	</div>
	<div id="recipe-hero" class="hero-img">
		<img class="" src="media/<?php echo $featuredRecipe['heroImg'];?>" alt="<?php echo $featuredRecipe['name'];?>">
	</div>
	<?php
};

$sideBarContent = function () {
	?>
	<div class="side-bar-content text-center d-flex flex-column justify-content-start">
		<h3 class="mb-3">Welcome to Tasty Recipes!</h3>
		<p class="px-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
			Curabitur efficitur erat nec tortor finibus varius.
			<br>
			Fusce porta risus ut tincidunt luctus. Fusce in mauris nulla.
			Maecenas lorem enim, elementum in tincidunt at, egestas vitae lacus.
			<br>
			<br>
			Etiam egestas finibus faucibus. Curabitur diam purus, tristique ac arcu id, posuere dapibus lectus.
			Morbi vel odio ut dolor tempus viverra at quis tortor. Nunc hendrerit elit a nibh finibus malesuada.
			<br>
			Etiam id blandit magna, sit amet ultricies mi. Curabitur accumsan consequat facilisis.
			Mauris egestas lacus a risus elementum gravida. Nulla euismod sapien eu ultrices fermentum.</p>
	</div>
	<?php
};

printBody("index", $pageContent, $sideBarContent, $pageHeadTag);
?>
