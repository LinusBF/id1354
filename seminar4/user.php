<?php
DEFINE("LINK_PATH", getenv("PRODUCTION") !== false ? "/seminar3/" : "/id1354/seminar3/");
DEFINE("APP_PATH", getenv( "PRODUCTION" ) !== false ? $_SERVER["DOCUMENT_ROOT"]."/seminar3/" : str_replace("\\", "/", __DIR__)."/");
include_once "./controllers/userController.php";

$response = array(
    "status_code" => 500,
    "response" => array()
);

if(!isset($_POST['callee'])){
    $response['status_code'] = 400;
}

if(!isset($_POST['username']) || !isset($_POST['password'])){
    header("Location: ".LINK_PATH.'index.php?page='.$_POST['callee'].'&user-login=-1');
    die();
}

$controller = new UserController();

if (isset($_GET['action']) && !empty($_GET['action'])) {
	$controller->{$_GET['action']}();
}

header("Location: ".LINK_PATH.'index.php?');

/*
 * NOT IMPLEMENTED
if(isset($_SESSION['currentUser'])){
	$user = User::getLoggedInUser();
	$view = new UserView($controller, $user);
	$view->show();
}
*/
