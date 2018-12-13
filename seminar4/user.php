<?php
DEFINE("LINK_PATH", getenv("PRODUCTION") !== false ? "/seminar4/" : "/id1354/seminar4/");
DEFINE("APP_PATH", getenv( "PRODUCTION" ) !== false ? $_SERVER["DOCUMENT_ROOT"]."/seminar4/" : str_replace("\\", "/", __DIR__)."/");
include_once "./controllers/userController.php";

session_start();

$response = array(
    "status_code" => 500,
    "data" => "ERROR! Controller action not set!"
);

$controller = new UserController();

if (isset($_POST['action']) && !empty($_POST['action'])) {
    $response = $controller->{$_POST['action']}();
}

http_response_code($response['status_code']);

echo json_encode($response['data']);
die();

/*
 * NOT IMPLEMENTED
if(isset($_SESSION['currentUser'])){
	$user = User::getLoggedInUser();
	$view = new UserView($controller, $user);
	$view->show();
}
*/
