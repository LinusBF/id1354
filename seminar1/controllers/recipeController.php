<?php

/**
 * @return array
 */
function getRecipes(){
	$recipes = json_decode(file_get_contents(APP_PATH."data/recipes.json"), true);
	return $recipes['recipes'];
}

function getIngredients(){
	$recipes = json_decode(file_get_contents(APP_PATH."data/recipes.json"), true);
	return $recipes['ingredients'];
}

function getFeaturedId(){
	$recipes = json_decode(file_get_contents(APP_PATH."data/recipes.json"), true);
	return $recipes['featured'];
}

function parseRecipeInstruction($instruction, $recipe, $ingredients){
	$pattern = '/({\\d+})/';
	$replaceFunction = function ($match) use (&$ingredients){
		return ($ingredients[substr($match[0], 1, 1)]['name']);
	};
	$parsedInstruction = preg_replace_callback($pattern, $replaceFunction, $instruction);

	return $parsedInstruction;
}