<?php

include_once APP_PATH."models/recipe.php";
include_once APP_PATH."controllers/userController.php";


function getMenu($sActive) {
	$aRecipes = Recipe::getAllRecipes();
	$today = new DateTime();
	$calendarDate = "?year=".$today->format("Y")."&month=".$today->format("m");
	?>
	<nav class="navbar navbar-expand-sm navbar-dark main-nav">
		<a class="navbar-brand" href="<?php echo LINK_PATH . "index.php";?>">TastyRecipes.com</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
				aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle <?php echo ($sActive === "recipe" ? "active" : "")?>" href="#" id="navbarDropdown" role="button"
					   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Recipes
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<?php foreach ($aRecipes as $recipe):?>
							<a class="dropdown-item" href="<?php echo LINK_PATH . "recipe.php?recipe=" . $recipe->urlName; ?>">
								<?php echo $recipe->name; ?>
							</a>
						<?php endforeach;?>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link <?php echo ($sActive === "calendar" ? "active" : "")?>" href="<?php echo LINK_PATH . "calendar.php".$calendarDate;?>">
						Calendar
					</a>
				</li>
			</ul>
		</div>
	</nav>
	<?php
}

function getUserMenu(){
	?>
	<nav class="navbar navbar-expand-sm navbar-dark user-nav">
	<?php
	if(isset($_SESSION['currentUser'])):
	$loggedInUser = UserController::get($_SESSION['currentUser']);?>
		<ul class="navbar-nav w-100 d-flex flex-row justify-content-between">
			<li class="nav-item">
				<a class="nav-link text-success" href="<?php echo LINK_PATH . "user.php?userId=" . $loggedInUser->getId(); ?>">
					<?php echo $loggedInUser->getName(); ?>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-warning" href="<?php echo LINK_PATH . "user.php?logout=1"; ?>">
					Logout
				</a>
			</li>
		</ul>
	<?php else:?>
		<ul class="navbar-nav w-100 d-flex flex-row justify-content-center">
			<li class="nav-item mr-5">
				<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#registerModal">
					Register!
				</button>
			</li>
			<li class="nav-item">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">
					Login
				</button>
			</li>
		</ul>
	<?php endif; ?>
	</nav>
	<?php
}
?>