<?php
DEFINE("LINK_PATH", getenv("PRODUCTION") !== false ? "/seminar2/" : "/id1354/seminar2/");
DEFINE("APP_PATH", getenv( "PRODUCTION" ) !== false ? $_SERVER["DOCUMENT_ROOT"]."/seminar2/" : str_replace("\\", "/", __DIR__)."/");
include "./components/baseBody.php";
include_once "./controllers/commentController.php";
include_once "./controllers/recipeController.php";

if(!key_exists("action", $_POST)
	|| !key_exists("currentUser", $_SESSION)
){
	header("Location: ".LINK_PATH.'index.php?action=-1');
	die();
}

$recipeController = new RecipeController();

if($_POST['action'] === "AddComment"){
	if(!isset($_POST['recipeId']) || !isset($_POST['content'])){
		header("Location: ".LINK_PATH.'index.php?comment-made=-1');
		die();
	}

	$comment = CommentController::create($_POST['content'], $_POST['recipeId'], $_SESSION['currentUser']);
	$recipe = $recipeController->getRecipeById(intval($_POST['recipeId']));
	$sRecipeUrl = LINK_PATH.'recipe.php?recipe='.$recipe->urlName;

	if($comment === false){
		header("Location: $sRecipeUrl"."&comment-made=0");
	} else {
		header( "Location: $sRecipeUrl"."&comment-made=1");
	}
	die();
}

if($_POST['action'] === "DeleteComment"){
	if(!isset($_POST['commentId'])){
		header("Location: ".LINK_PATH.'index.php?comment-deleted=-1');
		die();
	}

	$comment = CommentController::get($_POST['commentId']);
	$result = CommentController::delete($_POST['commentId']);
	$recipe = $recipeController->getRecipeById($comment->getRecipeId());
	$sRecipeUrl = LINK_PATH.'recipe.php?recipe='.$recipe->urlName;

	if($result === false){
		header("Location: $sRecipeUrl"."&comment-deleted=0");
	} else {
		header( "Location: $sRecipeUrl"."&comment-deleted=1");
	}
	die();
}


header("Location: ".LINK_PATH.'index.php');
die();