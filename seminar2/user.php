<?php
DEFINE("LINK_PATH", getenv("PRODUCTION") !== false ? "/seminar2/" : "/id1354/seminar2/");
DEFINE("APP_PATH", getenv( "PRODUCTION" ) !== false ? $_SERVER["DOCUMENT_ROOT"]."/seminar2/" : "/id1354/seminar2/");
include "./components/baseBody.php";
include_once "./controllers/userController.php";

if(!key_exists("userId", $_GET)
   && !key_exists("logout", $_GET)
   && !key_exists("action", $_POST)
){
	header("Location: ".LINK_PATH.'index.php?user-created=-1');
	die();
}

if(isset($_POST['action']) && $_POST['action'] === "CreateUser"){
	if(!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password'])){
		header("Location: ".LINK_PATH.'index.php?user-created=-1');
		die();
	}

	$newUser = UserController::create($_POST['username'], $_POST['email'], $_POST['password']);

	if($newUser === false){
		header("Location: ".LINK_PATH.'index.php?user-created=0');
	} else {
		header( "Location: " . LINK_PATH . 'index.php?user-created=1&newUser=' . $newUser->getId() );
	}
	die();
}

if(isset($_POST['action']) && $_POST['action'] === "LoginUser"){
	if(!isset($_POST['username']) || !isset($_POST['password'])){
		header("Location: ".LINK_PATH.'index.php?user-login=-1');
		die();
	}

	$authorized = UserController::authUser($_POST['username'], $_POST['password']);

	if($authorized === false){
		header("Location: ".LINK_PATH.'index.php?user-login=0');
	} else {
		$_SESSION['currentUser'] = $authorized;
		header( "Location: " . LINK_PATH . 'index.php?user-login=1');
	}
	die();
}

if(isset($_GET['logout']) && $_GET['logout'] == 1){
	session_destroy();
	header("Location: ".LINK_PATH.'index.php?logged-out=1');
	die();
}