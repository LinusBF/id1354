<?php
DEFINE("LINK_PATH", getenv("PRODUCTION") !== false ? "/seminar2/" : "/id1354/seminar2/");
DEFINE("APP_PATH", getenv( "PRODUCTION" ) !== false ? $_SERVER["DOCUMENT_ROOT"]."/seminar2/" : str_replace("\\", "/", __DIR__)."/");
include "./components/baseBody.php";
include_once "./controllers/recipeController.php";
include_once "./controllers/commentController.php";
include_once "./controllers/userController.php";
include_once "./views/commentView.php";

if(!key_exists("recipe", $_GET)){
	header("Location: ".LINK_PATH.'index.php');
	die();
}

$recipeController = new RecipeController();

$pageHeadTag = function () {
	?>
	<link rel="stylesheet" href="<?php echo LINK_PATH; ?>css/recipe.css">
	<link rel="stylesheet" href="<?php echo LINK_PATH; ?>css/comment.css">
	<link rel="stylesheet" href="<?php echo LINK_PATH; ?>css/responsive/recipe-resp.css">
	<?php
};

$pageContent = function () use (&$recipeController) {
	$ingredients = $recipeController->getIngredients();

	$currentRecipe = $recipeController->getRecipeByUrlName($_GET['recipe']);
	if ($currentRecipe !== false) :
	?>
	<div class="recipe-wrapper px-5 d-flex flex-column justify-content-center align-items-start">
		<span class="mb-5">
			<span class="recipe-title"><?php echo $currentRecipe->title; ?></span>
		</span>
		<div class="ingredients-wrapper mb-3">
			<ol>
				<?php foreach ($currentRecipe->ingredients as $ingredient): ?>
					<li class="mb-1"><?php echo $ingredients[$ingredient->id]->name."	-	".$ingredient->amount.$ingredients[$ingredient->id]->unit ?></li>
				<?php endforeach; ?>
			</ol>
		</div>
		<div class="instructions-wrapper">
			<ul class="instructions-list">
				<?php foreach ($currentRecipe->steps as $step): ?>
					<li class="mb-2"><?php echo RecipeController::parseRecipeInstruction($step->instruction, $currentRecipe, $ingredients); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div id="recipe-hero" class="hero-img">
		<img class="" src="media/<?php echo $currentRecipe->heroImg; ?>" alt="<?php echo $currentRecipe->name; ?>">
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
};

$sidebarContent = function () use (&$recipeController) {
	$currentRecipe = $recipeController->getRecipeByUrlName($_GET['recipe']);
	if ($currentRecipe !== null):
		$aComments = CommentController::getByRecipe($currentRecipe->id);
	?>
	<div class="side-bar-content text-center d-none d-md-flex flex-column justify-content-start">
		<h3 class="mb-3">Recipe Comments:</h3>
		<div class="recipe-comments">
		<?php
			foreach ($aComments as $comment) {
				$author = UserController::get( $comment->getAuthorId() );
				printComment($comment, $author);
			}
		?>
		</div>
		<?php
			if(isset($_SESSION['currentUser'])):
		?>
		<div class="comment-form-container align-self-center">
			<form class="d-flex flex-row justify-content-between" method="POST" action="<?php echo LINK_PATH."comment.php";?>">
				<input type="hidden" name="action" value="AddComment">
				<input type="hidden" name="recipeId" value="<?php echo $currentRecipe->id; ?>">
				<div class="form-group w-75 mb-0">
					<input type="text" class="form-control" id="commentContent" name="content" aria-describedby="commentHelp" placeholder="Comment">
				</div>
				<button type="submit" class="btn btn-primary h-25 align-self-end">Comment</button>
			</form>
		</div>
		<?php endif;?>
	</div>
<?php
	endif;
};

printBody("recipe", $pageContent, $sidebarContent, $pageHeadTag);