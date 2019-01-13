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

    public $sReturnPage;
    public $aReturnOptions;
    private $callee;
    private $username;
    private $password;
    private $email;

    public function __construct() {
        $this->sReturnPage = "index.php";
        $this->aReturnOptions = array();
    }

    public function setUserData($callee, $username, $password, $email = null){
        $this->callee = $callee;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }

    public function login(){
        if(!isset($this->callee)){
		    return false;
		}

        $this->aReturnOptions['page'] = $this->callee;

		if(!isset($this->username) || !isset($this->password)){
            $this->aReturnOptions['user-login'] = -1;
            return false;
		}

		$authorized = $this->authUser($this->username, $this->password);

		if($authorized === false){
            $this->aReturnOptions['user-login'] = 0;
            return false;
		} else {
			$_SESSION['currentUser'] = $authorized;
            $this->aReturnOptions['user-login'] = 1;
            return true;
		}
	}

	public function logout(){
		session_destroy();
        $this->aReturnOptions['logged-out'] = 1;
		return true;
	}

	public function register(){
		if(!isset($this->callee)){
		    return false;
		}

		if(!isset($this->username) || !isset($this->email) || !isset($this->password)){
            $this->aReturnOptions['user-created'] = -1;
            return false;
		}

		$newUser = new User();
		$newUser->fillWithData($this->username, $this->email, $this->password);
		$userId = $newUser->storeUser();

		if($userId === false){
            $this->aReturnOptions['user-created'] = 0;
            return false;
		} else {
            $this->aReturnOptions['user-created'] = 1;
            $this->aReturnOptions['newUser'] = $newUser->getId();
            return true;
		}
	}

	private function authUser($sUserName, $sRawPass){
		$user = new User($sUserName);
		$auth = $user->auth($sRawPass);
		return $auth;
	}

}