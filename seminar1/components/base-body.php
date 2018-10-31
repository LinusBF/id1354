<?php
include ROOT_PATH."components/menu.php";

function printBody( $contentFunc, Callable $sidebarFunc = null) {
	?>
	<html>
	<head>
		<?php include ROOT_PATH."components/default-head.php" ?>
		<title>ID1354 - Seminar 1</title>
	</head>
	<body>
	<div class="content-wrapper w-100 d-flex flex-row justify-content-start align-content-center">
		<div class="left-side h-100 w-25 align-self-center pb-3">
			<?php
			getMenu("index");
			if($sidebarFunc != null) $sidebarFunc();
			?>
		</div>
		<div class="right-side h-100 w-75 py-3 d-flex flex-column justify-content-center">
			<?php $contentFunc(); ?>
		</div>
	</div>
	<?php include ROOT_PATH."components/default-footer.php" ?>
	</body>
	</html>
	<?php
}

?>