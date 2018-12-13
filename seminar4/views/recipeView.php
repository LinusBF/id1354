<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-30
 * Time: 04:15
 */

require_once APP_PATH . "views/viewInterface.php";
require_once APP_PATH . "views/baseView.php";
require_once APP_PATH . "utils/ingredientList.php";

class RecipeView implements iViewTemplate {

	private $controller;
	private $recipe;

	/**
	 * RecipeView constructor.
	 *
	 * @param RecipeController $controller
	 * @param Recipe $recipe
	 */
	public function __construct( $controller, $recipe ) {
		$this->controller = $controller;
		$this->recipe     = $recipe;
	}

	public function pageHeadTag() {
		?>
		<link rel="stylesheet" href="<?php echo LINK_PATH; ?>css/recipe.css">
		<link rel="stylesheet" href="<?php echo LINK_PATH; ?>css/comment.css">
		<link rel="stylesheet" href="<?php echo LINK_PATH; ?>css/responsive/recipe-resp.css">
		<?php
	}

	public function pageHeadTagIndex() {
		?>
		<link rel="stylesheet" href="<?php echo LINK_PATH; ?>css/index.css">
		<link rel="stylesheet" href="<?php echo LINK_PATH; ?>css/responsive/index-resp.css">
		<?php
	}

	public function pageContent() {
		$ingredients = IngredientList::getAllIngredients();
		if ( $this->recipe->id !== null ) :
			?>
			<div class="recipe-wrapper px-5 d-flex flex-column justify-content-center align-items-start">
		<span class="mb-5">
			<span class="recipe-title"><?php echo $this->recipe->title; ?></span>
		</span>
				<div class="ingredients-wrapper mb-3">
					<ol>
						<?php foreach ( $this->recipe->ingredients as $ingredient ): ?>
							<li class="mb-1"><?php echo $ingredients[ $ingredient->id ]->name . "	-	" . $ingredient->amount . $ingredients[ $ingredient->id ]->unit ?></li>
						<?php endforeach; ?>
					</ol>
				</div>
				<div class="instructions-wrapper">
					<ul class="instructions-list">
						<?php foreach ( $this->recipe->steps as $step ): ?>
							<li class="mb-2"><?php echo $this->parseRecipeInstruction( $step->instruction, $ingredients ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
			<div id="recipe-hero" class="hero-img">
				<img class="" src="media/<?php echo $this->recipe->heroImg; ?>"
					 alt="<?php echo $this->recipe->name; ?>">
			</div>
		<?php
		else:
			?>
			<div class="w-100 px-5 d-flex flex-row justify-content-center align-items-center">
		<span class="mb-5">
			<span class="recipe-title">No recipe with that name exists on this site!</span>
		</span>
			</div>
		<?php
		endif;
	}

	public function pageContentIndex() {
		?>
		<div class="featured-description px-5 py-4 py-sm-0 d-flex flex-column justify-content-center align-items-center">
		<span class="mb-3">
			<span class="recipe-title"><?php echo $this->recipe->title; ?></span>
		</span>
			<p class="mb-5"><?php echo $this->recipe->description; ?></p>
			<a class="btn btn-primary" href="<?php echo $this->recipe->getRecipeUrl() ?>"
			   role="button">
				Cook this menu
			</a>
		</div>
		<div id="recipe-hero" class="hero-img">
			<img class="" src="media/<?php echo $this->recipe->heroImg; ?>"
				 alt="<?php echo $this->recipe->name; ?>">
		</div>
		<?php
	}

	public function sidebarContent() {
		if ( $this->recipe->id !== null ):
			$aComments = $this->recipe->getComments();
			?>
			<div class="side-bar-content text-center d-none d-md-flex flex-column justify-content-start">
				<input id="recipeId" type="hidden" name="recipeId" value="<?php echo $this->recipe->id; ?>">
				<h3 class="mb-3">Recipe Comments:</h3>
				<div id="commentContainer" class="recipe-comments">
				<?php
					foreach ( $aComments as $comment ) {
						$author = User::getAuthorToComment( $comment );
						$this->printComment( $comment, $author );
					}
					?>
				</div>
				<?php
				if ( isset( $_SESSION['currentUser'] ) ):
					?>
					<input id="sessionUser" type="hidden" value="<?php echo $_SESSION['currentUser']; ?>">
					<div class="comment-form-container align-self-center">
						<form class="d-flex flex-row justify-content-between" method="POST"
							  action="<?php echo LINK_PATH . "index.php"; ?>">
							<input type="hidden" name="page" value="comment">
							<input type="hidden" name="action" value="createComment">
							<div class="form-group w-75 mb-0">
								<input type="text" class="form-control" id="commentContent" name="content"
									   aria-describedby="commentHelp" placeholder="Comment">
							</div>
							<button id="create-comment" class="btn btn-primary h-25 align-self-end">Comment</button>
						</form>
					</div>
				<?php else:?>
					<input id="sessionUser" type="hidden" value="-1">
					<div class="comment-form-container align-self-center"></div>
				<?php endif; ?>
			</div>
		<?php
		endif;
	}

	public function sidebarContentIndex() {
		?>
		<div class="side-bar-content text-center d-flex flex-column justify-content-start">
			<h3 class="mb-3">Welcome to Tasty Recipes!</h3>
			<p class="px-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
				Curabitur efficitur erat nec tortor finibus varius.
				<br>
				Fusce porta risus ut tincidunt luctus. Fusce in mauris nulla.
				Maecenas lorem enim, elementum in tincidunt at, egestas vitae lacus.
				<br>
				<br>
				Etiam egestas finibus faucibus. Curabitur diam purus, tristique ac arcu id, posuere dapibus lectus.
				Morbi vel odio ut dolor tempus viverra at quis tortor. Nunc hendrerit elit a nibh finibus malesuada.
				<br>
				Etiam id blandit magna, sit amet ultricies mi. Curabitur accumsan consequat facilisis.
				Mauris egestas lacus a risus elementum gravida. Nulla euismod sapien eu ultrices fermentum.</p>
		</div>
		<?php
	}

	public function footerContent() {
		?>
		<script src="<?php echo LINK_PATH . "js/comments.js"; ?>"></script>
		<?php
	}

	public function show() {
		BaseView::printBody(
			'recipe',
			array( $this, 'pageHeadTag' ),
			array( $this, 'pageContent' ),
			array( $this, 'sidebarContent' ),
			array( $this, 'footerContent' )
		);
	}

	public function index() {
		BaseView::printBody(
			'index',
			array( $this, 'pageHeadTagIndex' ),
			array( $this, 'pageContentIndex' ),
			array( $this, 'sidebarContentIndex' )
		);
	}

	/**
	 * @param Comment $comment
	 * @param User $author
	 */
	private function printComment( $comment, $author ) {
		?>
		<div class="comment-container px-3 py-3 border-bottom border-secondary">
			<div class="comment-header d-flex flex-row justify-content-between">
				<h5 class="text-info"><?php echo $author->getName(); ?></h5>
				<?php if ( isset( $_SESSION['currentUser'] ) && $_SESSION['currentUser'] === $comment->getAuthorId() ): ?>
					<form class="d-none" id="delComment<?php echo $comment->getId(); ?>"
						  action="<?php echo LINK_PATH . "index.php"; ?>" method="POST">
						<input type="hidden" name="page" value="comment">
						<input type="hidden" name="action" value="deleteComment">
						<input type="hidden" name="commentId" value="<?php echo $comment->getId(); ?>">
					</form>
					<button type="button" class="btn btn-link text-danger"
							onclick="document.getElementById('delComment<?php echo $comment->getId(); ?>').submit()">
						delete
					</button>
				<?php endif; ?>
			</div>
			<p><?php echo htmlspecialchars( $comment->sContent, ENT_QUOTES, 'UTF-8' ); ?></p>
		</div>
		<?php
	}

	private function parseRecipeInstruction( $step, $ingredients ) {
		$pattern = '/({\\d+})/';
		$recipe  = $this->recipe;

		$replaceFunction = function ( $match ) use ( &$ingredients, &$recipe ) {
			$ingredientId     = substr( $match[0], 1, 1 );
			$ingredient       = $ingredients[ $ingredientId ];
			$ingredientAmount = null;
			foreach ( $recipe->ingredients as $i ) {
				if ( $i->id == $ingredientId ) {
					$ingredientAmount = $i->amount;
					break;
				}
			}
			$tooltipString = $ingredientAmount . $ingredient->unit;
			$text          = $ingredient->name;
			$tooltipHtml   = "<a class='tooltip-btn' href='#'
						data-toggle='tooltip' data-placement='top' title='$tooltipString'>
						$text</a>";

			return ( $tooltipHtml );
		};

		$parsedInstruction = preg_replace_callback( $pattern, $replaceFunction, $step );

		return $parsedInstruction;
	}
}