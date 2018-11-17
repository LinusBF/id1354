<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-15
 * Time: 17:53
 */

class User {

	protected $sPassword;
	protected $iUserID;
	public $sUsername;
	public $sEmail;

	/**
	 * Account constructor.
	 *
	 * @param string $sUsername
	 * @param string $sEmail
	 * @param string $sPassword
	 * @param int $iUserID
	 */
	public function __construct($sUsername, $sEmail, $sPassword, $iUserID = null) {
		$this->sUsername = $sUsername;
		$this->sEmail    = $sEmail;
		$this->sPassword = $sPassword;
		$this->iUserID = $iUserID;
	}

	public function getId(){
		return $this->iUserID;
	}

	public function getName(){
		return $this->sUsername;
	}

	public function getEmail(){
		return $this->sEmail;
	}

	/**
	 * @param Account $uUser
	 *
	 * @return bool
	 */
	public function equalTo($uUser){
		return ($this->iUserID !== null && $uUser->iUserID !== null) && $this->iUserID === $uUser->iUserID;
	}

	public function toDbParams(){
		return array(
			"ID" => $this->iUserID,
			"username" => $this->sUsername,
			"email" => $this->sEmail,
			"password" => $this->sPassword
		);
	}

	public function auth($sRawPass){
		return (password_verify($sRawPass, $this->sPassword) ? $this->getId() : false);
	}


}