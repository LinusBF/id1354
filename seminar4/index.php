<?php
DEFINE("LINK_PATH", getenv("PRODUCTION") !== false ? "/seminar4/" : "/id1354/seminar4/");
DEFINE("APP_PATH", getenv( "PRODUCTION" ) !== false ? $_SERVER["DOCUMENT_ROOT"]."/seminar4/" : str_replace("\\", "/", __DIR__)."/");
include_once APP_PATH."controllers/recipeController.php";
include_once APP_PATH."views/recipeView.php";

session_start();

function indexPage() {
	$recipe = new Recipe(1);
	$controller = new RecipeController($recipe);
	$view = new RecipeView($controller, $recipe);
	$view->index();
}

$page = null;
if(isset($_GET['page'])){
	$page = $_GET['page'];
} else if(isset($_POST['page'])){
	$page = $_POST['page'];
}


if(isset($page)){
	$pages = array("recipe", "calendar", "user", "comment");
	if(in_array($page, $pages)){
		require_once APP_PATH.$page.'.php';
	} else {
		indexPage();
	}
}
else {
	indexPage();
}
