<?php

require_once APP_PATH.'controllers/commentController.php';
require_once APP_PATH.'models/recipe.php';

class RecipeController{
	private $commentController;

	/**
	 * RecipeController constructor.
	 *
	 * @param Recipe $recipe
	 */
	public function __construct($recipe) {
		$this->commentController = new CommentController();
		$comments = $this->commentController->getCommentsByRecipe($recipe->id);
		$recipe->setComments($comments);
	}
}