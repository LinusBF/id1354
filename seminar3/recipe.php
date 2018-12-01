<?php
include_once "./controllers/recipeController.php";
include_once "./views/recipeView.php";

if(!key_exists("recipe", $_GET)){
	header("Location: ".LINK_PATH.'index.php');
	die();
}

$controller = new RecipeController();
$recipe = $controller->getRecipeFromStorage($_GET['recipe']);
$view = new RecipeView($controller, $recipe);

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$controller->{$_GET['action']}();
}

$view->show();
