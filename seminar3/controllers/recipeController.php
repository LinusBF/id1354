<?php

require_once APP_PATH.'controllers/commentController.php';
require_once APP_PATH.'models/recipe.php';

class RecipeController{
	private $commentController;

	public function __construct() {
		$this->commentController = new CommentController();
	}

	/**
	 * @param $id
	 *
	 * @return Recipe
	 */
	public function getRecipeFromStorage($id){
		$recipe = new Recipe($id);
		$comments = $this->commentController->getCommentsByRecipe($id);
		$recipe->setComments($comments);
		return $recipe;
	}
}