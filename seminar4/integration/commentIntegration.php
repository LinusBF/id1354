<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-17
 * Time: 21:13
 */

include_once APP_PATH."integration/dbConnection.php";

class CommentIntegration {
	private const TABLE_NAME = "comment";
	private const TABLE_SQL = "	
		CREATE TABLE " . CommentIntegration::TABLE_NAME . " (
		 `ID` int(11) NOT NULL AUTO_INCREMENT,
		 `recipe` int(11) NOT NULL,
		 `author` int(11) NOT NULL,
		 `content` TEXT NOT NULL,
		 `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		 PRIMARY KEY (`ID`),
		 KEY `author` (`author`),
		 CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`author`) REFERENCES `user` (`ID`)
	)";

	public function __construct() {
		$DB = new dbConnection();
		$DB->migrateTable(CommentIntegration::TABLE_NAME, CommentIntegration::TABLE_SQL);
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
		/* NOT IMPLEMENTED */
		return 0;
	}

	public function deleteComment($iCommentId){
		$sQuery = "DELETE FROM ".$this::TABLE_NAME." WHERE ID = ?";
		$aToBind = array(array("i", $iCommentId));

		$DB = new dbConnection();
		$result = $DB->runQuery($sQuery, $aToBind);

		return $result;
	}

	/**
	 * @param int $iCommentId
	 *
	 * @return bool|array
	 */
	public function getComment($iCommentId){
		$sQuery = "SELECT * FROM ".$this::TABLE_NAME." WHERE ID = ?";
		$aToBind = array(array("i", $iCommentId));

		$DB = new dbConnection();
		$result = $DB->runQuery($sQuery, $aToBind);

		if($result === false){
			return false;
		}

		$aCommentData = $result[0];

		return $aCommentData;
	}

	/**
	 * @param int $iRecipeId
	 *
	 * @return bool|array[]
	 */
	public function getCommentsByRecipe($iRecipeId){
		$sQuery = "SELECT * FROM ".$this::TABLE_NAME." WHERE recipe = ?";
		$aToBind = array(array("i", $iRecipeId));

		$DB = new dbConnection();
		$result = $DB->runQuery($sQuery, $aToBind);

		if($result === false){
			return false;
		}

		$aComments = array();
		foreach ($result as $aCommentData){
			array_push($aComments, $aCommentData);
		}

		return $aComments;
	}
}