<?php

class RecipeController{
	public const USE_JSON = 1;
	public const USE_XML = 2;
	private $aRecipeData;
	private $aIngredientData;
	private $iFeaturedRecipe;

	public function __construct($method = RecipeController::USE_XML) {
		if($method = $this::USE_JSON){
			$data = json_decode(file_get_contents(APP_PATH."data/recipes.json"), false);
			$this->aRecipeData = $data->recipes;
			$this->aIngredientData = $data->ingredients;
			$this->iFeaturedRecipe = $data->featured;
		}
		else {
			$xml = simplexml_load_file(APP_PATH."data/recipes.xml");
			$data = json_decode(file_get_contents(APP_PATH."data/recipes.json"), false);
			$this->aRecipeData = $xml->cookbook;
			$this->aIngredientData = $data->ingredients;
			$this->iFeaturedRecipe = $data->featured;
		}
	}


	/**
	 * @return array|SimpleXMLElement
	 */
	public function getRecipes(){
		return $this->aRecipeData;
	}

	/**
	 * @param $iRecipeId
	 *
	 * @return object|bool
	 */
	public function getRecipeById($iRecipeId){
		$currentRecipe = false;
		foreach ($this->aRecipeData as $recipe) {
			if ($recipe->id === $iRecipeId) {
				$currentRecipe = $recipe;
				break;
			}
		}
		return $currentRecipe;
	}


	/**
	 * @param $sUrlName
	 *
	 * @return object|bool
	 */
	public function getRecipeByUrlName($sUrlName){
		$currentRecipe = false;
		foreach ($this->aRecipeData as $recipe) {
			if ($recipe->urlName === $sUrlName) {
				$currentRecipe = $recipe;
				break;
			}
		}
		return $currentRecipe;
	}

	/**
	 * @return array
	 */
	public function getIngredients(){
		return $this->aIngredientData;
	}

	/**
	 * @return int - The recipe ID of the featured item on the home page
	 */
	public function getFeaturedId(){
		return $this->iFeaturedRecipe;
	}

	/**
	 * @param $instruction - The recipe instruction to parse
	 * @param $recipe - The recipe the instruction is located in
	 * @param $ingredients - List of all available ingredients
	 *
	 * @return string - The formatted HTML to show the instruction
	 */
	public static function parseRecipeInstruction($instruction, $recipe, $ingredients){
		$pattern = '/({\\d+})/';

		$replaceFunction = function ($match) use (&$ingredients, &$recipe){
			$ingredientId = substr($match[0], 1, 1);
			$ingredient = $ingredients[$ingredientId];
			$ingredientAmount = null;
			foreach ($recipe->ingredients as $i) {
				if ($i->id == $ingredientId) {
					$ingredientAmount = $i->amount;
					break;
				}
			}
			$tooltipString = $ingredientAmount.$ingredient->unit;
			$text = $ingredient->name;
			$tooltipHtml = "<a class='tooltip-btn' href='#'
						data-toggle='tooltip' data-placement='top' title='$tooltipString'>
						$text</a>";
			return ($tooltipHtml);
		};

		$parsedInstruction = preg_replace_callback($pattern, $replaceFunction, $instruction);

		return $parsedInstruction;
	}
}