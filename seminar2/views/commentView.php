<?php

/**
 * @param Comment $comment
 * @param User $author
 */
function printComment($comment, $author){
	?>
	<div class="comment-container px-3 py-3 border-bottom border-secondary">
		<h5 class="text-info"><?php echo $author->getName(); ?></h5>
		<p><?php echo $comment->sContent; ?></p>
	</div>
	<?php
}
