<?php
DEFINE( "ROOT_PATH", getenv( "PRODUCTION" ) !== false ? "/seminar1/" : "/id1354/seminar1/" );
include "./components/baseBody.php";
include_once "./controllers/recipeController.php";

$pageHeadTag = function () {
	?>
	<link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/recipe.css">
	<?php
};

$pageContent = function () {
	$recipes = getRecipes();
	$ingredients = getIngredients();

	$currentRecipe = null;
	foreach ($recipes as $recipe){
		if($recipe['urlName'] === $_GET['recipe']){
			$currentRecipe = $recipe;
			break;
		}
	}
	if($currentRecipe === null) die("No recipe with that name!");
	?>
	<div class="recipe-wrapper px-5 d-flex flex-column justify-content-center align-items-center">
		<span class="mb-3">
			<h2 class="recipe-title"><?php echo $currentRecipe['title'];?></h2>
		</span>
		<ol>
			<?php foreach ($currentRecipe['steps'] as $step):?>
			<li class="mb-1"><?php echo parseRecipeInstruction($step['instruction'], $currentRecipe, $ingredients);?></li>
			<?php  endforeach;?>
		</ol>
	</div>
	<div id="recipe-hero" class="hero-img">
		<img class="" src="media/<?php echo $currentRecipe['heroImg'];?>" alt="<?php echo $currentRecipe['name'];?>">
	</div>
	<?php
};

$sidebarContent = function (){
	$recipes = getRecipes();
	?>
	<div class="side-bar-content text-center d-flex flex-column justify-content-center">
		<h3 class="mb-3">All Recipes:</h3>
		<?php foreach ($recipes as $recipe):?>
		<div>
			<h4><?php echo $recipe['title']?></h4>
		</div>
		<?php endforeach;?>
	</div>
	<?php
};

printBody("recipe", $pageContent, $sidebarContent, $pageHeadTag);