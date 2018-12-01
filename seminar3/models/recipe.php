<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-30
 * Time: 04:26
 */

require_once APP_PATH.'integration/recipeTable.php';

class Recipe {
	private $recipeIntegration;
	public $id;
	public $name;
	public $title;
	public $description;
	public $urlName;
	public $heroImg;
	public $thumbImg;
	public $ingredients;
	public $steps;
	public $comments;

	/**
	 * Recipe constructor.
	 *
	 * @param $id
	 */
	public function __construct( $id = null ) {
		$this->id                = $id;
		$this->recipeIntegration = new RecipeTable();
		$this->comments = [];
		if($id !== null){
			$this->gatherDataFromStorage();
		}
	}

	private function gatherDataFromStorage() {
		$recipeData = $this->recipeIntegration->getRecipeData($this->id);
		if($recipeData === false) return;
		$this->recipeFromDbData($recipeData);
	}

	private function recipeFromDbData($recipeData){
		$this->id          = $recipeData['ID'];
		$this->name        = $recipeData['name'];
		$this->title       = $recipeData['title'];
		$this->description = $recipeData['description'];
		$this->urlName     = $recipeData['urlName'];
		$this->heroImg     = $recipeData['heroImg'];
		$this->thumbImg    = $recipeData['thumbImg'];
		$this->ingredients = $this->parseDbArray($recipeData['ingredients']);
		$this->steps       = $this->parseDbArray($recipeData['steps']);
	}

	private function parseDbArray($arrayStr){
		$parsed = json_decode($arrayStr, false);
		return $parsed;
	}

	/**
	 * @param Comment[] $comments
	 */
	public function setComments($comments){
		$this->comments = $comments;
	}

	/**
	 * @return Comment[]
	 */
	public function getComments(): array {
		return $this->comments;
	}

	public function getRecipeUrl(){
		return LINK_PATH."index.php?page=recipe&recipe=".$this->id;
	}

	/**
	 * @return Recipe[]
	 */
	public static function getAllRecipes(){
		$recipes = array();
		$integration = new RecipeTable();
		$recipesData = $integration->getAllRecipeData();
		foreach ($recipesData as $recipeData){
			$recipe = new Recipe();
			$recipe->recipeFromDbData($recipeData);
			array_push($recipes, $recipe);
		}

		return $recipes;
	}

}