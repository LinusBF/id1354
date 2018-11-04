<?php
include ROOT_PATH."components/menu.php";

function printBody($pageName, $contentFunc, Callable $sidebarFunc = null, Callable $headTag = null) {
	?>
	<html>
	<head>
		<?php
		include ROOT_PATH."components/defaultHead.php";
		if($headTag != null){
			$headTag();
		}
		?>
		<title>ID1354 - Seminar 1</title>
	</head>
	<body>
	<div class="content-wrapper w-100 d-flex flex-row justify-content-start align-content-center">
		<div class="left-side h-100 align-self-center pb-3">
			<?php
			getMenu($pageName);
			if($sidebarFunc != null){
				$sidebarFunc();
			} else {
				?>
				<span class="side-bar-fallback">Recipes</span>
				<?php
			}
			?>
		</div>
		<div class="right-side h-100 d-flex flex-row justify-content-end">
			<?php $contentFunc(); ?>
		</div>
	</div>
	<?php include ROOT_PATH."components/defaultFooter.php" ?>
	</body>
	</html>
	<?php
}

?>