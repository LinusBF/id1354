<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-17
 * Time: 21:13
 */

include_once APP_PATH."integration/dbConnection.php";

class CommentTable {
	private const TABLE_NAME = "comment";
	private const TABLE_SQL = "	
		CREATE TABLE ".CommentTable::TABLE_NAME." (
		 `ID` int(11) NOT NULL AUTO_INCREMENT,
		 `recipe` int(11) NOT NULL,
		 `author` int(11) NOT NULL,
		 `content` TEXT NOT NULL UNIQUE,
		 `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		 PRIMARY KEY (`ID`),
		 KEY `author` (`author`),
		 CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`author`) REFERENCES `user` (`ID`)
	)";

	public function __construct() {
		$DB = new dbConnection();
		$DB->migrateTable(CommentTable::TABLE_NAME, CommentTable::TABLE_SQL);
	}

	/**
	 * @param Comment $comment
	 *
	 * @return int ID of comment inserted or updated
	 */
	public function putComment($comment){
		$aCommentParams = $comment->toDbParams();
		if($aCommentParams['ID'] === null){
			return $this->insertComment($aCommentParams);
		} else {
			return $this->updateComment($aCommentParams);
		}
	}

	private function insertComment($aCommentParams){
		unset($aCommentParams['ID']);
		$sArgs = implode(", ", array_keys($aCommentParams));
		$sWildCards = implode(", ", array_fill(0, count($aCommentParams), "?"));

		$sQuery = "INSERT INTO ".$this::TABLE_NAME." ($sArgs) VALUES ($sWildCards)";
		$aToBind = array();

		foreach ($aCommentParams as $key => $value){
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

	private function updateComment($aCommentParams){
		$userId = $aCommentParams['ID'];
		unset($aCommentParams['ID']);
		$aSets = array();

		foreach (array_keys($aCommentParams) as $key){
			array_push($aSets, $key." = "."?");
		}

		$sSetString = implode(", ", $aSets);

		$sQuery = "UPDATE ".$this::TABLE_NAME." SET $sSetString WHERE ID = ?";
		$aToBind = array();

		foreach (array_values($aCommentParams) as $value){
			$wildcard = "s";
			if(gettype($value) === "integer"){
				$wildcard = "i";
			}
			else if(gettype($value) === "double"){
				$wildcard = "d";
			}
			array_push($aToBind, array($wildcard, $value));
		}

		//Add user ID to WHERE wildcard
		array_push($aToBind, array("i", $userId));

		$DB = new dbConnection();
		return $DB->runQuery($sQuery, $aToBind);
	}

	/**
	 * @param int $iCommentId
	 *
	 * @return Comment
	 */
	public function getComment($iCommentId){
		$sQuery = "SELECT * FROM ".$this::TABLE_NAME." WHERE ID = ?";
		$aToBind = array(array("i", $iCommentId));

		$DB = new dbConnection();
		$result = $DB->runQuery($sQuery, $aToBind);
		$aCommentData = $result[0];

		return new Comment($aCommentData['content'], $aCommentData['recipe'], $aCommentData['author'], $aCommentData['ID'], $aCommentData['created']);
	}

	/**
	 * @param int $iUserId
	 *
	 * @return Comment[]
	 */
	public function getCommentsByUser($iUserId){
		$sQuery = "SELECT * FROM ".$this::TABLE_NAME." WHERE author = ?";
		$aToBind = array(array("i", $iUserId));

		$DB = new dbConnection();
		$result = $DB->runQuery($sQuery, $aToBind);
		$aComments = array();
		foreach ($result as $aCommentData){
			array_push($aComments, new Comment($aCommentData['content'], $aCommentData['recipe'], $aCommentData['author'], $aCommentData['ID'], $aCommentData['created']));
		}

		return $aComments;
	}

	/**
	 * @param int $iRecipeId
	 *
	 * @return Comment[]
	 */
	public function getCommentsByRecipe($iRecipeId){
		$sQuery = "SELECT * FROM ".$this::TABLE_NAME." WHERE recipe = ?";
		$aToBind = array(array("i", $iRecipeId));

		$DB = new dbConnection();
		$result = $DB->runQuery($sQuery, $aToBind);
		$aComments = array();
		foreach ($result as $aCommentData){
			array_push($aComments, new Comment($aCommentData['content'], $aCommentData['recipe'], $aCommentData['author'], $aCommentData['ID'], $aCommentData['created']));
		}

		return $aComments;
	}
}