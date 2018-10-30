<?php
DEFINE("ROOT_PATH", getenv ("PRODUCTION") !== false ? "/seminar1/" : "/id1354/seminar1/");
include "./components/menu.php";
?>
<html>
<head>
	<?php include "./components/default-head.php" ?>
	<title>ID1354 - Seminar 1</title>
</head>
<body>
	<?php  getMenu("index"); ?>
	<div class="mt-3 d-flex flex-column justify-content-center">
		<div id="recipeSlide" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">
				<div class="carousel-item active">
					<img class="d-block w-100" src="media/meatballs.jpg" alt="Meatballs">
				</div>
				<div class="carousel-item">
					<img class="d-block w-100" src="media/pancakes.jpg" alt="Pancakes">
				</div>
			</div>
		</div>
	</div>
	<?php include "./components/default-footer.php" ?>
</body>
</html>