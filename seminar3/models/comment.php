<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-17
 * Time: 21:19
 */

class Comment {

	protected $iCommentID;
	protected $iRecipeID;
	protected $iAuthorID;
	public $sContent;
	public $dateCreated;

	/**
	 * Account constructor.
	 *
	 * @param string $sContent
	 * @param int $iRecipeID
	 * @param int $iAuthorID
	 * @param int $iCommentID
	 * @param DateTime $created
	 */
	public function __construct($sContent, $iRecipeID, $iAuthorID, $iCommentID = null, $created = null) {
		$this->sContent = $sContent;
		$this->iRecipeID = $iRecipeID;
		$this->iAuthorID = $iAuthorID;
		$this->iCommentID = $iCommentID;
		$this->dateCreated = $created;
	}

	public function getId(){
		return $this->iCommentID;
	}

	public function getRecipeId(){
		return $this->iRecipeID;
	}

	public function getAuthorId(){
		return $this->iAuthorID;
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
		return ($this->iCommentID !== null && $comment->iCommentID !== null) && $this->iCommentID === $comment->iCommentID;
	}

	public function toDbParams(){
		return array(
			"ID" => $this->iCommentID,
			"recipe" => $this->iRecipeID,
			"author" => $this->iAuthorID,
			"content" => $this->sContent,
			"created" => $this->dateCreated
		);
	}
}