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
	$replaceFunction = function ($match) use (&$ingredients, &$recipe){
		$ingredientId = substr($match[0], 1, 1);
		$ingredient = $ingredients[$ingredientId];
		$ingredientAmount = null;
		foreach ($recipe['ingredients'] as $i) {
			if ($i['id'] == $ingredientId) {
				$ingredientAmount = $i['amount'];
				break;
			}
		}
		$tooltopString = $ingredientAmount.$ingredient['unit'];
		$tooltopContent = $ingredient['name'];
		$tooltipHtml = "<a class='tooltip-btn' href='#'
						data-toggle='tooltip' data-placement='top' title='$tooltopString'>
						$tooltopContent</a>";
		return ($tooltipHtml);
	};
	$parsedInstruction = preg_replace_callback($pattern, $replaceFunction, $instruction);

	return $parsedInstruction;
}