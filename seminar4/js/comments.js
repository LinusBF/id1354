$(document).ready(function ($) {
	const printComments = (comments, userId) => {
        let container = $('#commentContainer');
        container.html("");
        comments.forEach(function (comment) {
            let commentHTML = "<div class=\"comment-container px-3 py-3 border-bottom border-secondary\">" +
				"<input name='commentId' type='hidden' value='" + comment['id'] + "' />" +
                "<div class=\"comment-header d-flex flex-row justify-content-between\">" +
                "<h5 class=\"text-info\">" + comment['authorName'] + "</h5>";
            if(userId === comment['authorId']){
                commentHTML += "<input class='commentId' type='hidden' value='" + comment['id'] + "'>" +
                    "<button type=\"button\" class=\"btn btn-link text-danger delete-comment\">delete</button>";
            }
            commentHTML += "</div><p>" + comment['content'] + "</p></div>";
            container.append(commentHTML);
        });
	};

	const fetchComments = (recipeId) => {
		$.ajax({
			type: "POST",
			url: "comment.php",
			data:
				{
					"action": "getComments",
					"recipeId": recipeId
				},
			success: function (result) {
				let parsedResult = JSON.parse(result);
				let comments = parsedResult['comments'];
				let userId = parsedResult['userId'];
                printComments(comments, userId);
			}
		});
	};

    const pollComments = () => {
    	let commentIds = [];

        $('#commentContainer').children('.comment-container').each(function () {
			const commentId = $(this).children("input[name='commentId']").val();
			commentIds.push(parseInt(commentId));
        });

        $.ajax({
            type: "POST",
            url: "comment.php",
			async: true,
            data:
                {
                    "action": "pollComments",
                    "recipeId": $("#recipeId").val(),
                    "clientCommentIds": commentIds
                },
            success: function (result) {
                let parsedResult = JSON.parse(result);
                let comments = parsedResult['comments'];
                let userId = parsedResult['userId'];
                printComments(comments, userId);
                setTimeout(pollComments());
            }
        });
    };


    $(".side-bar-content").on('click', "#create-comment", function (event) {
		event.preventDefault();

		$.ajax({
			type: "POST",
			url: "comment.php",
			data:
				{
					"action": "createComment",
					"recipeId": $("#recipeId").val(),
					"content": $("#commentContent").val()
				},
			success: function (result) {
				let parsedResult = JSON.parse(result);
				$("#commentContent").val("");
				fetchComments($("#recipeId").val());
			}
		});
	});

	$(".recipe-comments").on('click', '.delete-comment', function (event) {
		event.preventDefault();

		let commentId = $(event.target).siblings(".commentId")[0].value;

		$.ajax({
			type: "POST",
			url: "comment.php",
			data:
				{
					"action": "deleteComment",
					"commentId": commentId
				},
			success: function (result) {
				let parsedResult = JSON.parse(result);
				fetchComments($("#recipeId").val());
			}
		});
	});

	const addCommentFieldIfLoggedIn = () => {
        let userSession = $("#sessionUser").val();
        if(parseInt(userSession) > 0){
            $('.comment-form-container').html("<form class=\"d-flex flex-row justify-content-between\">" +
                "<div class=\"form-group w-75 mb-0\">" +
                "<input type=\"text\" class=\"form-control\" id=\"commentContent\" placeholder=\"Comment\">" +
                "</div>" +
                "<button id=\"create-comment\" class=\"btn btn-primary h-25 align-self-end\">Comment</button>" +
                "</form>");
        } else {
            $('.comment-form-container').html("");
        }
	};

	let cooldown = false;

	$(".user-nav").on('DOMNodeInserted DOMNodeRemoved', function() {
		if(cooldown) return;
		console.log("User menu changed!");
		cooldown = true;
		setTimeout(() => cooldown = false, 3000);
		fetchComments($("#recipeId").val());
		addCommentFieldIfLoggedIn();
	});

	fetchComments($("#recipeId").val());
	setTimeout(pollComments, 5000);
});