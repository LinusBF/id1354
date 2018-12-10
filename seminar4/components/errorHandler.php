<?php

function displayAlertMessages(){
	$dataInsufficient = function (){
		?>
		<div class="alert alert-danger" role="alert">
			Incorrect data supplied!
		</div>
		<?php
	};

	if(isset($_GET['action']) && $_GET['action'] === -1){
		$dataInsufficient();
	}
	else if(isset($_GET['user-created']) && $_GET['user-created'] === "-1"){
		$dataInsufficient();
	}
	else if(isset($_GET['user-created']) && $_GET['user-created'] === "0"){
		?>
		<div class="alert alert-warning" role="alert">
			User could not be created!
		</div>
		<?php
	}
	else if(isset($_GET['user-created']) && $_GET['user-created'] === "1"){
		?>
		<div class="alert alert-success" role="alert">
			User was created! Please login!
		</div>
		<?php
	}
	else if(isset($_GET['user-login']) && $_GET['user-login'] === "-1"){
		$dataInsufficient();
	}
	else if(isset($_GET['user-login']) && $_GET['user-login'] === "0"){
		?>
		<div class="alert alert-warning" role="alert">
			Wrong username/password!
		</div>
		<?php
	}
	else if(isset($_GET['user-login']) && $_GET['user-login'] === "1"){
		?>
		<div class="alert alert-success" role="alert">
			Welcome!
		</div>
		<?php
	}
	else if(isset($_GET['logged-out']) && $_GET['logged-out'] === "1"){
		?>
		<div class="alert alert-success" role="alert">
			Logged Out!
		</div>
		<?php
	}
	else if(isset($_GET['comment-made']) && $_GET['comment-made'] === "-1"){
		$dataInsufficient();
	}
	else if(isset($_GET['comment-made']) && $_GET['comment-made'] === "0"){
		?>
		<div class="alert alert-warning" role="alert">
			Comment could not be made!
		</div>
		<?php
	}
	else if(isset($_GET['comment-made']) && $_GET['comment-made'] === "1"){
		?>
		<div class="alert alert-success" role="alert">
			Thank you for your comment!
		</div>
		<?php
	}
	else if(isset($_GET['comment-deleted']) && $_GET['comment-deleted'] === "-1"){
		$dataInsufficient();
	}
	else if(isset($_GET['comment-deleted']) && $_GET['comment-deleted'] === "0"){
		?>
		<div class="alert alert-warning" role="alert">
			Comment could not be deleted!
		</div>
		<?php
	}
	else if(isset($_GET['comment-deleted']) && $_GET['comment-deleted'] === "1"){
		?>
		<div class="alert alert-success" role="alert">
			Comment removed!
		</div>
		<?php
	}
}