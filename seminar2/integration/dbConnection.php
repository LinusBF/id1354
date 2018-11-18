<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-15
 * Time: 18:31
 */

class dbConnection {
	private const LOCAL_SQL = array(
		"serverName" => "localhost",
		"username" => "root",
		"password" => "",
		"database" => "id1354"
	);

	private $server;
	private $userName;
	private $password;
	private $database;

	public function __construct() {
		$blEnvSet = getenv("CLEARDB_DATABASE_URL") !== false;
		$SQLSettings = null;
		if($blEnvSet) $SQLSettings = parse_url(getenv("CLEARDB_DATABASE_URL"));
		$this->server = ($blEnvSet ? $SQLSettings['host'] : dbConnection::LOCAL_SQL['serverName']);
		$this->userName = ($blEnvSet ? $SQLSettings['user'] : dbConnection::LOCAL_SQL['username']);
		$this->password = ($blEnvSet ? $SQLSettings['pass'] : dbConnection::LOCAL_SQL['password']);
		$this->database = ($blEnvSet ? substr($SQLSettings["path"], 1) : dbConnection::LOCAL_SQL['database']);
		$connection = $this->newConnection();

		if ($connection->connect_error) {
			return false;
		}

		$connection->close();

		return true;
	}

	private function newConnection(){
		return new mysqli($this->server, $this->userName, $this->password, $this->database);
	}

	public function migrateTable($sTableName, $sCreationSQL){
		$sSQL = "SHOW TABLES LIKE '$sTableName';";
		$connection = $this->newConnection();

		$result = $connection->query($sSQL);
		if ($result !== true) {
			$connection->close();
			return false;
		}

		if($result->num_rows < 1){
			$createdStatus = $connection->query($sCreationSQL);
			$connection->close();
			return $createdStatus;
		}


		$connection->close();
		return true;
	}

	/**
	 * @param $sQuery
	 * @param $aToBind
	 * @param bool $blGetInsertId
	 *
	 * @return array|bool|int
	 */
	public function runQuery($sQuery, $aToBind, $blGetInsertId = false){
		$connection = $this->newConnection();
		$stmt = $connection->prepare($sQuery);
		var_dump($connection->error_list);
		return false;

		$aWildcardTypes = array_map(function($i) {
			return $i[0];
		}, $aToBind);
		$aWildcardValues = array_map(function($i) {
			return $i[1];
		}, $aToBind);

		$stmt->bind_param(implode("", $aWildcardTypes), ...$aWildcardValues);

		$executionStatus = $stmt->execute();

		// If it's a insert command, return inserted ID on success, false on failure.
		if($blGetInsertId){
			return ($executionStatus ? $connection->insert_id : false);
		}

		$result = $stmt->get_result();

		// If it's any other command than SELECT, get_results will return false.
		// Execution boolean should then be returned
		if($result === false){
			return $executionStatus;
		}

		// If it's a SELECT command, store the returned results in an array and return it.
		$aRows = array();
		while ($row = $result->fetch_assoc()){
			array_push($aRows, $row);
		}

		return $aRows;
	}

	/*
	NOT IN USE - NEEDS TO BE MODIFIED BEFORE USE


	public function insertIntoTable($sTableName, $aArgs, $aParams){
		$connection = $this->newConnection();
		$fEscapeVar = function ($e) use (&$connection) {
			return mysqli_real_escape_string($connection, $e);
		};

		$sEscapedTableName = $fEscapeVar($sTableName);
		$aEscapedArgs = array_map($fEscapeVar, $aArgs);
		$aEscapedParams = array_map($fEscapeVar, $aParams);
		$sArgList = implode(", ", $aEscapedArgs);
		$aParamList = implode(", ", $aEscapedParams);
		$sUpdateList = "";

		foreach ($aEscapedArgs as $i => $arg){
			$sUpdateList .= $arg." = ".$aParamList[$i].", ";
		}

		$sUpdateList = substr($sUpdateList, 0, -2);

		$sSQL = "INSERT INTO $sEscapedTableName ($sArgList) VALUES ($aParamList) ON DUPLICATE KEY UPDATE $sUpdateList;";

		var_dump($sSQL);

		$result = $connection->query($sSQL);

		return $connection->insert_id;
	}

	public function getElemFromTable($sTableName, $sKey, $mNeedle){
		$connection = $this->newConnection();
		$fEscapeVar = function ($e) use (&$connection) {
			return mysqli_real_escape_string($connection, $e);
		};

		$sEscapedTableName = $fEscapeVar($sTableName);
		$sEscapedKey = $fEscapeVar($sKey);
		$sEscapedNeedle = $fEscapeVar($mNeedle);

	}

	*/
}