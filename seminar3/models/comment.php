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
		$recipeData = $this->commentIntegration->getComment($this->commentId);
		if($recipeData === false) return;
		$this->sContent    = $recipeData['content'];
		$this->recipeId    = $recipeData['recipe'];
		$this->authorId    = $recipeData['author'];
		$this->commentId   = $recipeData['id'];
		$this->dateCreated = $recipeData['created'];
	}

	public function fillWithData($dbResult){

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