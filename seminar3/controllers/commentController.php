<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-17
 * Time: 22:15
 */

include_once APP_PATH."models/comment.php";
include_once APP_PATH."integration/commentTable.php";

class CommentController {
	/**
	 * @param $sContent
	 * @param $iRecipeId
	 * @param $iAuthorID
	 *
	 * @return bool|Comment
	 */
	public function createComment($sContent, $iRecipeId, $iAuthorID){
		$comment = new Comment($sContent, $iRecipeId, $iAuthorID);
		$commentDB = new CommentTable();

		$iCommentId = $commentDB->putComment($comment);

		if($iCommentId === false){
			return false;
		}

		return CommentController::get($iCommentId);
	}

	public function deleteComment($iCommentId){
		$comment = CommentController::get($iCommentId);
		if($_SESSION['currentUser'] === $comment->getAuthorId()){
			$commentDB = new CommentTable();
			return $commentDB->deleteComment($comment->getId());
		} else {
			return false;
		}
	}

	/**
	 * @param $iCommentId
	 *
	 * @return Comment
	 */
	public function getComment($iCommentId){
		$commentDB = new CommentTable();

		return $commentDB->getComment($iCommentId);
	}

	/**
	 * @param $iUserId
	 *
	 * @return Comment[]
	 */
	public function getCommentsByAuthor($iUserId){
		$commentDB = new CommentTable();

		return $commentDB->getCommentsByUser($iUserId);
	}

	/**
	 * @param $iRecipeId
	 *
	 * @return Comment[]
	 */
	public function getCommentsByRecipe($iRecipeId){
		$commentDB = new CommentTable();

		return $commentDB->getCommentsByRecipe($iRecipeId);
	}
}