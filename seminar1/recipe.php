<?php
DEFINE("LINK_PATH", getenv("PRODUCTION") !== false ? "/seminar1/" : "/id1354/seminar1/");
DEFINE("APP_PATH", getenv( "PRODUCTION" ) !== false ? $_SERVER["DOCUMENT_ROOT"]."/seminar1/" : str_replace("\\", "/", __DIR__)."/");
include "./components/baseBody.php";
include_once "./controllers/recipeController.php";

if(!key_exists("recipe", $_GET)){
	header("Location: ".LINK_PATH.'index.php');
	die();
}

$pageHeadTag = function () {
	?>
	<link rel="stylesheet" href="<?php echo LINK_PATH; ?>css/recipe.css">
	<link rel="stylesheet" href="<?php echo LINK_PATH; ?>css/responsive/recipe-resp.css">
	<?php
};

$pageContent = function () {
	$recipes     = getRecipes();
	$ingredients = getIngredients();

	$currentRecipe = null;
	foreach ($recipes as $recipe) {
		if ($recipe['urlName'] === $_GET['recipe']) {
			$currentRecipe = $recipe;
			break;
		}
	}
	if ($currentRecipe === null) {
		die("No recipe with that name!");
	}
	?>
	<div class="recipe-wrapper px-5 d-flex flex-column justify-content-center align-items-start">
		<span class="mb-5">
			<span class="recipe-title"><?php echo $currentRecipe['title']; ?></span>
		</span>
		<div class="ingredients-wrapper mb-3">
			<ol>
				<?php foreach ($currentRecipe['ingredients'] as $ingredient): ?>
					<li class="mb-1"><?php echo $ingredients[$ingredient['id']]['name']."	-	".$ingredient['amount'].$ingredients[$ingredient['id']]['unit'] ?></li>
				<?php endforeach; ?>
			</ol>
		</div>
		<div class="instructions-wrapper">
			<ul class="instructions-list">
				<?php foreach ($currentRecipe['steps'] as $step): ?>
					<li class="mb-2"><?php echo parseRecipeInstruction($step['instruction'], $currentRecipe, $ingredients); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div id="recipe-hero" class="hero-img">
		<img class="featured-image" src="media/<?php echo $currentRecipe['heroImg']; ?>" alt="<?php echo $currentRecipe['name']; ?>">
	</div>
	<?php
};

$sidebarContent = function () {
	$recipes = getRecipes();
	?>
	<div class="side-bar-content text-center d-none d-md-flex flex-column justify-content-start">
		<h3 class="mb-3">All Recipes:</h3>
		<?php foreach ($recipes as $recipe): ?>
			<div class="recipe-link mb-3">
				<a href="?recipe=<?php echo $recipe['urlName']?>"><?php echo $recipe['title'] ?></a>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
};

printBody("recipe", $pageContent, $sidebarContent, $pageHeadTag);