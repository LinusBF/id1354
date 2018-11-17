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

		$iUserId = $userDB->putUser($user);

		if($iUserId === false){
			return false;
		}

		return new User($sUserName, $sEmail, $sHashedPass, $iUserId);
	}

	/**
	 * @param $iUserId
	 *
	 * @return User
	 */
	public static function get($iUserId){
		$userDB = new UserTable();

		return $userDB->getUser($iUserId);
	}

	/**
	 * @param $sUserName
	 *
	 * @return User
	 */
	private static function getByName($sUserName){
		$userDB = new UserTable();

		return $userDB->getUserByName($sUserName);
	}

	public static function authUser($sUserName, $sRawPass){
		return UserController::getByName($sUserName)->auth($sRawPass);
	}

}