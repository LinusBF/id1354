<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-15
 * Time: 18:29
 */

include_once APP_PATH."integration/dbConnection.php";

class UserIntegration {
	private const TABLE_NAME = "user";
	private const TABLE_SQL = "	
		CREATE TABLE " . UserIntegration::TABLE_NAME . " (
		 `ID` int(11) NOT NULL AUTO_INCREMENT,
		 `username` varchar(255) NOT NULL UNIQUE,
		 `email` varchar(255) NOT NULL UNIQUE,
		 `password` varchar(255),
		 PRIMARY KEY (`ID`)
	)";

	public function __construct() {
		$DB = new dbConnection();
		if($DB === false) return false;
		$migrated = $DB->migrateTable(UserIntegration::TABLE_NAME, UserIntegration::TABLE_SQL);
		if(!$migrated) return false;
	}

	/**
	 * @param User $user
	 *
	 * @return int ID of user inserted or updated
	 */
	public function putUser($user){
		$aUserParams = $user->toDbParams();
		if($aUserParams['ID'] === null){
			return $this->insertUser($aUserParams);
		} else {
			return $this->updateUser($aUserParams);
		}
	}

	private function insertUser($aUserParams){
		unset($aUserParams['ID']);
		$sArgs = implode(", ", array_keys($aUserParams));
		$sWildCards = implode(", ", array_fill(0, count($aUserParams), "?"));

		$sQuery = "INSERT INTO ".$this::TABLE_NAME." ($sArgs) VALUES ($sWildCards)";
		$aToBind = array();

		foreach ($aUserParams as $key => $value){
			$wildcard = "s";
			if(gettype($value) === "integer"){
				$wildcard = "i";
			}
			else if(gettype($value) === "double"){
				$wildcard = "d";
			}
			array_push($aToBind, array($wildcard, $value));
		}

		$DB = new dbConnection();
		return $DB->runQuery($sQuery, $aToBind, true);
	}

	private function updateUser($aUserParams){
		/* NOT IMPLEMENTED */
		return 0;
	}

	/**
	 * @param $iUserId
	 *
	 * @return array
	 */
	public function getUser($iUserId){
		$sQuery = "SELECT * FROM ".$this::TABLE_NAME." WHERE ID = ?";
		$aToBind = array(array("i", $iUserId));

		$DB = new dbConnection();
		$result = $DB->runQuery($sQuery, $aToBind);
		$aUserData = $result[0];

		return $aUserData;
	}

	/**
	 * @param $sUserName
	 *
	 * @return array
	 */
	public function getUserByName($sUserName){
		$sQuery = "SELECT * FROM ".$this::TABLE_NAME." WHERE username = ?";
		$aToBind = array(array("s", $sUserName));

		$DB = new dbConnection();
		$result = $DB->runQuery($sQuery, $aToBind);
		$aUserData = $result[0];

		return $aUserData;
	}

}