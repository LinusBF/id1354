<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-17
 * Time: 21:19
 */

class Comment {

	private $commentIntegration;
	protected $commentId;
	protected $recipeId;
	protected $authorId;
	public $sContent;
	public $dateCreated;

	/**
	 * Comment constructor.
	 *
	 * @param $id
	 */
	public function __construct( $id = null ) {
		$this->commentId          = $id;
		$this->commentIntegration = new CommentTable();
		if($id !== null){
			$this->gatherDataFromStore();
		}
	}

	private function gatherDataFromStore() {
		$commentData = $this->commentIntegration->getComment($this->commentId);
		if($commentData === false) return;
		$this->sContent    = $commentData['content'];
		$this->recipeId    = $commentData['recipe'];
		$this->authorId    = $commentData['author'];
		$this->commentId   = $commentData['ID'];
		$this->dateCreated = $commentData['created'];
	}

	public function fillWithData($commentData){
		$this->sContent    = $commentData['content'];
		$this->recipeId    = $commentData['recipe'];
		$this->authorId    = $commentData['author'];
		$this->commentId   = $commentData['ID'];
		$this->dateCreated = $commentData['created'];
	}

	public function getId(){
		return $this->commentId;
	}

	public function getRecipeId(){
		return $this->recipeId;
	}

	public function getAuthorId(){
		return $this->authorId;
	}

	public function getContent(){
		return $this->sContent;
	}

	public function getCreated(){
		return $this->dateCreated;
	}

	/**
	 * @param Comment $comment
	 *
	 * @return bool
	 */
	public function equalTo($comment){
		return ( $this->commentId !== null && $comment->commentId !== null) && $this->commentId === $comment->commentId;
	}

	public function toDbParams(){
		return array(
			"ID" => $this->commentId,
			"recipe" => $this->recipeId,
			"author" => $this->authorId,
			"content" => $this->sContent,
			"created" => $this->dateCreated
		);
	}
}