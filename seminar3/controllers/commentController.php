<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-17
 * Time: 22:15
 */

include_once APP_PATH."models/comment.php";
include_once APP_PATH."integration/commentIntegration.php";

class CommentController {

	public function createComment(){
		if(!isset($_POST['recipeId']) || !isset($_POST['content'])){
			header("Location: ".LINK_PATH.'index.php?comment-made=-1');
			die();
		}

		$comment = new Comment();
		$comment->fillWithData($_POST['content'], $_POST['recipeId'], $_SESSION['currentUser'], null);
		$result = $comment->saveToStorage();

		$sRecipeUrl = LINK_PATH.'index.php?page=recipe&recipe='.$comment->getRecipeId();

		if($result === false){
			header("Location: $sRecipeUrl"."&comment-made=0");
		} else {
			header( "Location: $sRecipeUrl"."&comment-made=1");
		}
		die();
	}

	public function deleteComment(){
		if(!isset($_POST['commentId'])){
			header("Location: ".LINK_PATH.'index.php?page=home&comment-deleted=-1');
			die();
		}

		$comment = new Comment($_POST['commentId']);
		$result = $this->deleteIfUserIsAuthor($comment);
		$sRecipeUrl = LINK_PATH.'index.php?page=recipe&recipe='.$comment->getRecipeId();

		if($result === false){
			header("Location: $sRecipeUrl"."&comment-deleted=0");
		} else {
			header( "Location: $sRecipeUrl"."&comment-deleted=1");
		}
		die();
	}

	/**
	 * @param Comment $comment
	 *
	 * @return array|bool|int
	 */
	private function deleteIfUserIsAuthor($comment){
		if($_SESSION['currentUser'] === $comment->getAuthorId()){
			return $comment->deleteFromStorage();
		} else {
			return false;
		}
	}

	/**
	 * @param $iRecipeId
	 *
	 * @return Comment[]
	 */
	public function getCommentsByRecipe($iRecipeId){
		$commentDB = new CommentIntegration();
		$comments = array();

		$commentsData = $commentDB->getCommentsByRecipe($iRecipeId);

		foreach ($commentsData as $commentData){
			$comment = new Comment();
			$comment->commentFromDbData($commentData);
			array_push($comments, $comment);
		}

		return $comments;
	}
}