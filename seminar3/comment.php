<?php
include_once "./controllers/commentController.php";

$controller = new CommentController();

$action = null;
if(isset($_GET['action'])){
	$action = $_GET['action'];
} else if(isset($_POST['action'])){
	$action = $_POST['action'];
}

if (isset($action) && !empty($action)) {
	$controller->{$action}();
}

header("Location: ".LINK_PATH.'index.php?');
