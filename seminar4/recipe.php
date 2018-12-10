<?php
include_once APP_PATH."controllers/recipeController.php";
include_once APP_PATH."views/recipeView.php";

if(!key_exists("recipe", $_GET)){
	header("Location: ".LINK_PATH.'index.php');
	die();
}

$recipe = new Recipe($_GET['recipe']);
$controller = new RecipeController($recipe);
$view = new RecipeView($controller, $recipe);

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$controller->{$_GET['action']}();
}

$view->show();
