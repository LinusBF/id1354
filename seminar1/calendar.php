<?php
DEFINE( "ROOT_PATH", getenv( "PRODUCTION" ) !== false ? "/seminar1/" : "/id1354/seminar1/" );
include "./components/baseBody.php";
include_once "./controllers/recipeController.php";

$pageContent = function () {
	?>
	<span>This is a calendar</span>
	<?php
};

printBody("calendar", $pageContent);