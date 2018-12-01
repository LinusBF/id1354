<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-15
 * Time: 18:06
 */

include_once APP_PATH."models/user.php";
include_once APP_PATH."integration/userTable.php";

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

	/**
	 * @param $sUserName
	 * @param $sEmail
	 * @param $sRawPass
	 *
	 * @return bool|User
	 */
	public static function create($sUserName, $sEmail, $sRawPass){
		$sHashedPass = password_hash($sRawPass, PASSWORD_DEFAULT);
		$user = new User($sUserName, $sEmail, $sHashedPass);
		$userDB = new UserTable();
		if($userDB === false) return false;

		$iUserId = $userDB->putUser($user);

		if($iUserId === false){
			return false;
		}

		return new User($sUserName, $sEmail, $sHashedPass, $iUserId);
	}

	/**
	 * @param $iUserId
	 *
	 * @return bool|User
	 */
	public static function get($iUserId){
		$userDB = new UserTable();
		if($userDB === false) return false;

		return $userDB->getUser($iUserId);
	}

	/**
	 * @param $sUserName
	 *
	 * @return bool|User
	 */
	private static function getByName($sUserName){
		$userDB = new UserTable();
		if($userDB === false) return false;

		return $userDB->getUserByName($sUserName);
	}

	private function authUser($sUserName, $sRawPass){
		$user = new User($sUserName);
		$auth = $user->auth($sRawPass);
		return $auth;
	}

}