<?php
include APP_PATH."components/menu.php";

session_start();

function printBody($pageName, $contentFunc, Callable $sidebarFunc = null, Callable $headTag = null) {
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<?php
		include APP_PATH."components/defaultHead.php";
		if($headTag != null){
			$headTag();
		}
		?>
		<title>ID1354 - Seminar 1</title>
	</head>
	<body>
	<div class="content-wrapper w-100 d-flex flex-column flex-md-row justify-content-start align-content-center">
		<div class="left-side h-100 align-self-center pb-3">
			<?php
			getMenu($pageName);
			if($sidebarFunc != null){
				$sidebarFunc();
			} else {
				?>
				<span class="side-bar-fallback"> --- Recipes ---</span>
				<?php
			}
			getUserMenu();
			?>
		</div>
		<div class="right-side h-100 d-flex flex-column flex-sm-row justify-content-center justify-content-sm-end">
			<?php $contentFunc(); ?>
		</div>
	</div>
	<?php include APP_PATH."components/defaultFooter.php" ?>
	<?php include APP_PATH."components/modals.php" ?>
	</body>
	</html>
	<?php
}

?>