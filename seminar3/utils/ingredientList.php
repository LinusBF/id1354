<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-12-01
 * Time: 10:57
 */

class IngredientList {
	public static function getAllIngredients(){
		$data = json_decode(file_get_contents(APP_PATH."data/recipes.json"), false);
		return $data->ingredients;
	}
}