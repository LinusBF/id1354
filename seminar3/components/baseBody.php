<?php
include APP_PATH."components/menu.php";
include APP_PATH."components/errorHandler.php";

session_start();

/**
 * @param string $pageName
 * @param iViewTemplate $view
 */
function printBody($pageName, $view) {
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<?php
		include APP_PATH."components/defaultHead.php";
		$view->pageHeadTag();
		?>
		<title>ID1354 - Seminar 1</title>
	</head>
	<body>
	<?php displayAlertMessages();?>
	<div class="content-wrapper w-100 d-flex flex-column flex-md-row justify-content-start align-content-center">
		<div class="left-side h-100 align-self-center pb-3">
			<?php
			getMenu($pageName);
			$view->sidebarContent();
			getUserMenu();
			?>
		</div>
		<div class="right-side h-100 d-flex flex-column flex-sm-row justify-content-center justify-content-sm-end">
			<?php $view->pageContent(); ?>
		</div>
	</div>
	<?php include APP_PATH."components/defaultFooter.php" ?>
	<?php include APP_PATH."components/modals.php" ?>
	</body>
	</html>
	<?php
}

?>