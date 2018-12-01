<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-15
 * Time: 17:53
 */

require_once APP_PATH.'integration/userTable.php';

class User {

	private $userIntegration;
	protected $id;
	protected $password;
	public $username;
	public $email;

	/**
	 * User constructor.
	 *
	 * @param string $name
	 */
	public function __construct($name = null) {
		$this->username                = $name;
		$this->userIntegration = new UserTable();
		if($name !== null){
			$this->gatherDataFromStorage();
		}
	}

	private function gatherDataFromStorage(){
		$userData = $this->userIntegration->getUserByName($this->username);
		if($userData === false) return;
		$this->userFromDbData($userData);
	}

	private function userFromDbData($userData){
		$this->id = $userData['ID'];
		$this->username = $userData['username'];
		$this->email    = $userData['email'];
		$this->password = $userData['password'];
	}

	public function fillWithData($username, $email, $rawPassword){
		$hashedPassword = password_hash($rawPassword, PASSWORD_DEFAULT);
		$this->username = $username;
		$this->email    = $email;
		$this->password = $hashedPassword;
	}

	public function storeUser(){
		$userId = $this->userIntegration->putUser($this);
		$this->id = $userId;
		return $userId;
	}

	public function getId(){
		return $this->id;
	}

	public function getName(){
		return $this->username;
	}

	public function getEmail(){
		return $this->email;
	}

	/**
	 * @param User $uUser
	 *
	 * @return bool
	 */
	public function equalTo($uUser){
		return ($this->id !== null && $uUser->id !== null) && $this->id === $uUser->id;
	}

	public function toDbParams(){
		return array(
			"ID" => $this->id,
			"username" => $this->username,
			"email" => $this->email,
			"password" => $this->password
		);
	}

	public function auth($sRawPass){
		return (password_verify($sRawPass, $this->password) ? $this->getId() : false);
	}

	public static function getLoggedInUser(){
		$integration = new UserTable();
		$userData = $integration->getUser($_SESSION['currentUser']);
		$loggedInUser = new User();
		$loggedInUser->userFromDbData($userData);
		return $loggedInUser;
	}

	/**
	 * @param Comment $comment
	 *
	 * @return User
	 */
	public static function getAuthorToComment($comment){
		$integration = new UserTable();
		$userData = $integration->getUser($comment->getAuthorId());
		$authorUser = new User();
		$authorUser->userFromDbData($userData);
		return $authorUser;
	}


}