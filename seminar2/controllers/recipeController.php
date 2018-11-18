<?php

/**
 * @return array
 */
function getRecipes(){
	$recipes = json_decode(file_get_contents(APP_PATH."data/recipes.json"), false);
	return $recipes->recipes;
}

/**
 * @param $iRecipeId
 *
 * @return array|bool
 */
function getRecipeById($iRecipeId){
	$recipes = json_decode(file_get_contents(APP_PATH."data/recipes.json"), false);
	$currentRecipe = false;
	foreach ($recipes->recipes as $recipe) {
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
 * @return array|bool
 */
function getRecipeByUrlName($sUrlName){
	$recipes = json_decode(file_get_contents(APP_PATH."data/recipes.json"), false);
	$currentRecipe = false;
	foreach ($recipes->recipes as $recipe) {
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
function getIngredients(){
	$recipes = json_decode(file_get_contents(APP_PATH."data/recipes.json"), false);
	return $recipes->ingredients;
}

/**
 * @return int - The recipe ID of the featured item on the home page
 */
function getFeaturedId(){
	$recipes = json_decode(file_get_contents(APP_PATH."data/recipes.json"), false);
	return $recipes->featured;
}

/**
 * @param $instruction - The recipe instruction to parse
 * @param $recipe - The recipe the instruction is located in
 * @param $ingredients - List of all available ingredients
 *
 * @return string - The formatted HTML to show the instruction
 */
function parseRecipeInstruction($instruction, $recipe, $ingredients){
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