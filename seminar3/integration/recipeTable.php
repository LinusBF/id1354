<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-17
 * Time: 21:13
 */

include_once APP_PATH."integration/dbConnection.php";

class RecipeTable {
	private const TABLE_NAME = "comment";
	private const TABLE_SQL = "	
		CREATE TABLE ".RecipeTable::TABLE_NAME." (
		 `ID` int(11) NOT NULL AUTO_INCREMENT,
		 `name` VARCHAR(255) NOT NULL,
		 `title` VARCHAR(255) NOT NULL,
		 `description` TEXT NOT NULL,
		 `urlName` VARCHAR(255) NOT NULL,
		 `heroImg` VARCHAR(255) NOT NULL,
		 `thumbImg` VARCHAR(255) NOT NULL,
		 `ingredients` TEXT,
		 `steps` TEXT NOT NULL,
		 PRIMARY KEY (`ID`),
	)";

	public function __construct() {
		$DB = new dbConnection();
		$DB->migrateTable(RecipeTable::TABLE_NAME, RecipeTable::TABLE_SQL);
	}
}