<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-30
 * Time: 04:26
 */

class Recipe {
	public $id;
	public $name;
	public $title;
	public $description;
	public $urlName;
	public $heroImg;
	public $thumbImg;
	public $ingredients;
	public $steps;

	/**
	 * Recipe constructor.
	 *
	 * @param $id
	 * @param $name
	 * @param $title
	 * @param $description
	 * @param $urlName
	 * @param $heroImg
	 * @param $thumbImg
	 * @param $ingredients
	 * @param $steps
	 */
	public function __construct( $id, $name, $title, $description, $urlName, $heroImg, $thumbImg, $ingredients, $steps ) {
		$this->id          = $id;
		$this->name        = $name;
		$this->title       = $title;
		$this->description = $description;
		$this->urlName     = $urlName;
		$this->heroImg     = $heroImg;
		$this->thumbImg    = $thumbImg;
		$this->ingredients = $this->parseDbArray($ingredients);
		$this->steps       = $this->parseDbArray($steps);
	}

	private function parseDbArray($arrayStr){
		$parsed = json_decode($arrayStr, false);
		return $parsed;
	}

}