<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-12-01
 * Time: 12:25
 */

class BaseView {

	public static function printBody($pageName, callable $headTag, callable $mainContent, callable $sideContent, callable $footer = null){
		include_once APP_PATH."components/menu.php";
		include_once  APP_PATH."components/errorHandler.php";
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<?php
			include APP_PATH."components/defaultHead.php";
			$headTag();
			?>
			<title>ID1354 - Seminar 1</title>
		</head>
		<body>
		<?php displayAlertMessages();?>
		<div class="content-wrapper w-100 d-flex flex-column flex-md-row justify-content-start align-content-center">
			<div class="left-side h-100 align-self-center pb-3">
				<?php
				getMenu($pageName);
				$sideContent();
				getUserMenu();
				?>
			</div>
			<div class="right-side h-100 d-flex flex-column flex-sm-row justify-content-center justify-content-sm-end">
				<?php $mainContent(); ?>
			</div>
		</div>
		<?php include APP_PATH."components/defaultFooter.php" ?>
		<?php include APP_PATH."components/modals.php" ?>
		<?php if(isset($footer)){$footer();}?>
		</body>
		</html>
		<?php
	}

}