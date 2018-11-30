<?php

/**
 * @param Comment $comment
 * @param User $author
 */
function printComment($comment, $author){
	?>
	<div class="comment-container px-3 py-3 border-bottom border-secondary">
		<div class="comment-header d-flex flex-row justify-content-between">
			<h5 class="text-info"><?php echo $author->getName(); ?></h5>
			<?php if(isset($_SESSION['currentUser']) && $_SESSION['currentUser'] === $comment->getAuthorId()):?>
			<form class="d-none" id="delComment<?php echo $comment->getId(); ?>"
				action="<?php echo LINK_PATH."comment.php";?>" method="POST">
				<input type="hidden" name="action" value="DeleteComment">
				<input type="hidden" name="commentId" value="<?php echo $comment->getId(); ?>">
			</form>
			<button type="button" class="btn btn-link text-danger"
					onclick="document.getElementById('delComment<?php echo $comment->getId(); ?>').submit()">
				delete
			</button>
			<?php endif; ?>
		</div>
		<p><?php echo $comment->sContent; ?></p>
	</div>
	<?php
}
