<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-15
 * Time: 18:06
 */

include_once APP_PATH."models/user.php";
include_once APP_PATH."integration/userIntegration.php";

class UserController {

	public function login(){

	    if(!isset($_POST['username']) || !isset($_POST['password'])){
	        return array('status_code' => 400, "data" => "ERROR! Missing POST params!");
        }

		$authorized = $this->authUser($_POST['username'], $_POST['password']);

		if($authorized === false){
            return array('status_code' => 401, "data" => "Unauthorized!");
		} else {
			$_SESSION['currentUser'] = $authorized;
			$user = User::getLoggedInUser();
            return array('status_code' => 200, "data" => array(
                'id' => $authorized,
                'userLink' => LINK_PATH . "index.php?page=user&userId=" . $authorized,
                'name' => htmlspecialchars($user->getName(), ENT_QUOTES, 'UTF-8')
            ));
		}
	}

	public function logout(){
		session_destroy();
		return array('status_code' => 200, "data" => array("success" => "Logged out!"));
	}

	public function register(){

		if(!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password'])){
			return array('status_code' => 400, "data" => "ERROR! Missing POST params!");
		}

		$newUser = new User();
		$newUser->fillWithData($_POST['username'], $_POST['email'], $_POST['password']);
		$userId = $newUser->storeUser();

		if($userId === false){
			header("Location: ".LINK_PATH.'index.php?page='.$_POST['callee'].'&user-created=0');
		} else {
			header( "Location: " . LINK_PATH . 'index.php?page='.$_POST['callee'].'&user-created=1&newUser=' . $newUser->getId() );
		}
		die();
	}

	private function authUser($sUserName, $sRawPass){
		$user = new User($sUserName);
		$auth = $user->auth($sRawPass);
		return $auth;
	}

}