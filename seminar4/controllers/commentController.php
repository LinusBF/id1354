<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-17
 * Time: 22:15
 */

include_once APP_PATH."models/comment.php";
include_once APP_PATH."models/user.php";
include_once APP_PATH."integration/commentIntegration.php";

class CommentController {

	public function createComment(){
		if(!isset($_POST['recipeId']) || !isset($_POST['content'])){
			return array('status_code' => 400, "data" => "ERROR! Missing POST params!");
		}

		$comment = new Comment();
		$comment->fillWithData($_POST['content'], $_POST['recipeId'], $_SESSION['currentUser'], null);
		$result = $comment->saveToStorage();

		if($result === false){
			return array(
				"status_code" => 500,
				"data" => array("error" => "Could not create comment!")
			);
		} else {
			return array(
				"status_code" => 200,
				"data" => array("success" => "Comment created!")
			);
		}
	}

	public function deleteComment(){
		if(!isset($_POST['commentId'])){
			return array('status_code' => 400, "data" => "ERROR! Missing POST params!");
		}

		$comment = new Comment($_POST['commentId']);
		$result = $this->deleteIfUserIsAuthor($comment);

		if($result === false){
			return array(
				"status_code" => 401,
				"data" => array("error" => "Could not delete comment! Are you the author?")
			);
		} else {
			return array(
				"status_code" => 200,
				"data" => array("success" => "Comment deleted!")
			);
		}
	}

	public function getComments() {

		if(!isset($_POST['recipeId'])){
			return array('status_code' => 400, "data" => "ERROR! Missing POST params!");
		}

		$comments = $this->getCommentsByRecipe($_POST['recipeId']);
		$formattedComments = $this->packageCommentsForJSON($comments);

		return array(
			"status_code" => 200,
			"data" => array(
				"userId" => (isset($_SESSION['currentUser']) ? $_SESSION['currentUser'] : -1),
				"comments" => $formattedComments)
		);
	}

	public function pollComments(){
        if(!isset($_POST['recipeId']) || !isset($_POST['clientCommentIds'])){
            return array('status_code' => 400, "data" => "ERROR! Missing POST params!");
        }

        set_time_limit(0);

        $clientCommentIds = $_POST['clientCommentIds'];

        while(true) {
            $comments = $this->getCommentsByRecipe($_POST['recipeId']);
            $commentIds = array();
            foreach ($comments as $comment){
                array_push($commentIds, $comment->getId());
            }

            if(count($clientCommentIds) !== count($commentIds)){
                $formattedComments = $this->packageCommentsForJSON($comments);

                return array(
                    "status_code" => 200,
                    "data" => array(
                        "userId" => (isset($_SESSION['currentUser']) ? $_SESSION['currentUser'] : -1),
                        "comments" => $formattedComments)
                );
            }
            session_write_close();
            sleep(1);
            session_start();
        }

        return array('status_code' => 500, "data" => "Polling error!");
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

    /**
     * @param Comment[] $comments
     *
     * @return array
     */
    public function packageCommentsForJSON($comments){
        $formattedComments = array();

        foreach ($comments as $comment){
            $escapedAndFormattedComment = array(
                "id" => $comment->getId(),
                "authorId" => $comment->getAuthorId(),
                "authorName" => htmlspecialchars(User::getAuthorToComment($comment)->username, ENT_QUOTES, 'UTF-8'),
                "content" => htmlspecialchars($comment->sContent, ENT_QUOTES, 'UTF-8')
            );
            array_push($formattedComments, $escapedAndFormattedComment);
        }

        return $formattedComments;
    }
}