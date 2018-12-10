<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-17
 * Time: 21:13
 */

include_once APP_PATH."integration/dbConnection.php";

class RecipeIntegration {
	private const TABLE_NAME = "recipe";
	private const TABLE_SQL = "	
		CREATE TABLE " . RecipeIntegration::TABLE_NAME . " (
		 `ID` int(11) NOT NULL AUTO_INCREMENT,
		 `name` VARCHAR(255) NOT NULL,
		 `title` VARCHAR(255) NOT NULL,
		 `description` TEXT NOT NULL,
		 `urlName` VARCHAR(255) NOT NULL,
		 `heroImg` VARCHAR(255) NOT NULL,
		 `thumbImg` VARCHAR(255) NOT NULL,
		 `ingredients` TEXT,
		 `steps` TEXT NOT NULL,
		 PRIMARY KEY (`ID`)
	)";
	private static $initializedData = false;

	public function __construct() {
		$DB = new dbConnection();
		$DB->migrateTable(RecipeIntegration::TABLE_NAME, RecipeIntegration::TABLE_SQL);
		$this->addDefaultRecipes();
	}

	private function addDefaultRecipes(){
		if(RecipeIntegration::$initializedData) return;
		$recipes = $this->getAllRecipeData();
		if(count($recipes) < 1){
			$sSQL = "INSERT INTO ".RecipeIntegration::TABLE_NAME." (`ID`, `name`, `title`, `description`, `urlName`, `heroImg`, `thumbImg`, `ingredients`, `steps`) VALUES
                    (1,
                    'Meatballs',
                    'Glorious swedish meatballs',
                    'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                    'meatballs',
                    'meatballsHighRes.jpg',
                    'meatballsThumb.jpg',
                    '[
                    {\"id\": 0,\"amount\": \"30\"},
                    {\"id\": 1,\"amount\": \"1\"},
                    {\"id\": 2,\"amount\": \"about 1\"},
                    {\"id\": 3,\"amount\": \"about 1\"},
                    {\"id\": 4,\"amount\": \"500\"},
                    {\"id\": 5,\"amount\": \"1\"},
                    {\"id\": 6,\"amount\": \"400\"}
                    ]',
                    '[
                    {\"nr\": 1,\"instruction\": \"Get all the ingredients...\"},
                    {\"nr\": 2,\"instruction\": \"Put the {4} in a large bowl.\"},
                    {\"nr\": 3,\"instruction\": \"Add the {0}, {2} & {3} to the bowl and mix everything.\"},
                    {\"nr\": 4,\"instruction\": \"Add the {1} and {5} and mix again.\"},
                    {\"nr\": 5,\"instruction\": \"Roll your meatballs to your desired size.\"}
                    ]'),
                    (2,
                    'Pancakes',
                    'Amazingly simple pancakes',
                    'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                    'pancakes',
                    'pancakesHighRes.jpg',
                    'pancakesThumb.png',
                    '[
                    {\"id\": 0,\"amount\": \"150\"},
                    {\"id\": 1,\"amount\": \"3\"},
                    {\"id\": 2,\"amount\": \"about 0.5\"},
                    {\"id\": 7,\"amount\": \"500\"},
                    {\"id\": 8,\"amount\": \"1\"}
                    ]',
                    '[
                    {\"nr\": 1,\"instruction\": \"Get all the ingredients...\"},
                    {\"nr\": 2,\"instruction\": \"Combine the dry ingredients ({0} and {2}) into a large bowl.\"},
                    {\"nr\": 3,\"instruction\": \"Stir in half of the {7} until the mixture is smooth.\"},
                    {\"nr\": 4,\"instruction\": \"Add the rest of the {7} and stir in the {1}.\"},
                    {\"nr\": 5,\"instruction\": \"Melt the {8} in a pan and add to the batter.\"},
                    {\"nr\": 6,\"instruction\": \"Fry thin pancakes in a frying pan. Serve with strawberries and whip cream.\"}
                    ]'
                    );";
			$DB = new dbConnection();
			$DB->runQuery($sSQL, array(), true);
			RecipeIntegration::$initializedData = true;
		}
	}

	public function getAllRecipeData(){
		$sQuery = "SELECT * FROM ".$this::TABLE_NAME;

		$DB = new dbConnection();
		$result = $DB->runQuery($sQuery, array());

		if($result === false){
			return false;
		}

		$recipes = array();
		foreach ($result as $recipeData){
			array_push($recipes, $recipeData);
		}
		return $recipes;
	}

	public function getRecipeData($id){
		$sQuery = "SELECT * FROM ".$this::TABLE_NAME." WHERE ID = ?";
		$aToBind = array(array("i", $id));

		$DB = new dbConnection();
		$result = $DB->runQuery($sQuery, $aToBind);

		if($result === false){
			return false;
		}

		$aRecipeData = $result[0];

		return $aRecipeData;
	}
}