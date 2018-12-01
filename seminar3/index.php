<?php
DEFINE("LINK_PATH", getenv("PRODUCTION") !== false ? "/seminar3/" : "/id1354/seminar2/");
DEFINE("APP_PATH", getenv( "PRODUCTION" ) !== false ? $_SERVER["DOCUMENT_ROOT"]."/seminar3/" : str_replace("\\", "/", __DIR__)."/");
include_once APP_PATH."controllers/recipeController.php";
include_once APP_PATH."views/recipeView.php";

session_start();

if(isset($_GET['page']) && $_GET['page'] !== 'home'){
	switch ($_GET['page']){
		case "recipe":
			require_once './recipe.php';
			break;
		case "calendar":
			require_once './calendar.php';
			break;
	}
}
else {

	$controller = new RecipeController();
	$recipe = $controller->getRecipeFromStorage(1);
	$view = new RecipeView($controller, $recipe);

	if (isset($_GET['action']) && !empty($_GET['action'])) {
		$controller->{$_GET['action']}();
	}

	$view->index();
}
?>
