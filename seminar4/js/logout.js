$(document).ready(function ($) {
    $("#logout-user").on('click', function (evt) {
        evt.preventDefault();
        $.ajax({
            type: "POST",
            url: "user.php",
            data:
                {
                    "action": "logout"
                },
            success: function (result) {
                window.location.href = "index.php"
            }
        });
    });
});