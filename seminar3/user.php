<?php
DEFINE("LINK_PATH", getenv("PRODUCTION") !== false ? "/seminar3/" : "/id1354/seminar3/");
DEFINE("APP_PATH", getenv( "PRODUCTION" ) !== false ? $_SERVER["DOCUMENT_ROOT"]."/seminar3/" : str_replace("\\", "/", __DIR__)."/");
include_once "./controllers/userController.php";
include_once "./views/userView.php";


$controller = new UserController();
$view = new UserView($controller);

$view->performUserAction();

$view->redirect();

/*
 * NOT IMPLEMENTED
if(isset($_SESSION['currentUser'])){
	$user = User::getLoggedInUser();
	$view = new UserView($controller, $user);
	$view->show();
}
*/
