$(document).ready(function ($) {
    $("#login-user").on('click', function () {
        $.ajax({
            type: "POST",
            url: "user.php",
            data:
            {
                "action": "login",
                "username": $("#userNameLogin").val(),
                "password": $("#userPasswordLogin").val()
            },
            success: function (result) {
                let parsedResult = JSON.parse(result);
                $('#loginModal').modal('hide');
                $(".user-nav").html('<ul class="navbar-nav w-100 d-flex flex-row justify-content-between">' +
                    '<li id="usernameContainer" class="nav-item">' +
                    '<a class="nav-link text-success" href="' + parsedResult['userLink'] + '">' +
                    parsedResult['name'] +
                    '</a>' +
                    '</li>' +
                    '<li id="logoutContainer" class="nav-item">' +
                    '<a id="logout-user" class="nav-link text-warning">Logout</a>' +
                    '</li>' +
                    '</ul>');
            }
        });
    });
});