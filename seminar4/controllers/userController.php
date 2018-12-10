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
		if(!isset($_POST['callee'])){
			header("Location: ".LINK_PATH.'index.php');
			die();
		}

		if(!isset($_POST['username']) || !isset($_POST['password'])){
			header("Location: ".LINK_PATH.'index.php?page='.$_POST['callee'].'&user-login=-1');
			die();
		}

		$authorized = $this->authUser($_POST['username'], $_POST['password']);

		if($authorized === false){
			header("Location: ".LINK_PATH.'index.php?page='.$_POST['callee'].'&user-login=0');
		} else {
			$_SESSION['currentUser'] = $authorized;
			header("Location: ".LINK_PATH.'index.php?page='.$_POST['callee'].'&user-login=1');
		}
		die();
	}

	public function logout(){
		session_destroy();
		header("Location: ".LINK_PATH.'index.php?logged-out=1');
		die();
	}

	public function register(){
		if(!isset($_POST['callee'])){
			header("Location: ".LINK_PATH.'index.php');
			die();
		}

		if(!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['password'])){
			header("Location: ".LINK_PATH.'index.php?page='.$_POST['callee'].'&user-created=-1');
			die();
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