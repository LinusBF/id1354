$(document).ready(function ($) {
    const updateUserNav = (username = null) => {
        if(username){
            $(".user-nav").html('<ul class="navbar-nav w-100 d-flex flex-row justify-content-between">' +
                '<li id="usernameContainer" class="nav-item">' +
                '<a class="nav-link text-success" href="#">' + username + '</a>' +
                '</li>' +
                '<li id="logoutContainer" class="nav-item">' +
                '<a id="logout-user" class="nav-link text-warning">Logout</a>' +
                '</li>' +
                '</ul>');
        } else {
            $(".user-nav").html('<ul class="navbar-nav w-100 d-flex flex-row justify-content-between">' +
                '<li class="nav-item mr-5">' +
                '<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#registerModal">Register</button>' +
                '</li>' +
                '<li class="nav-item">' +
                '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#loginModal">Login</button>' +
                '</li>' +
                '</ul>');
        }
    };

    $("#loginModal").on('click', "#login-user", function (event) {
		event.preventDefault();
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
                $("#sessionUser").val(parsedResult['id']);
                updateUserNav(parsedResult['name']);
            }
        });
    });

    $(".user-nav").on('click', '#logout-user', function (evt) {
        evt.preventDefault();
        $.ajax({
            type: "POST",
            url: "user.php",
            data:
                {
                    "action": "logout"
                },
            success: function (result) {
                updateUserNav();
            }
        });
    });

    $("#registerModal").on('click', "#register-user", function (event) {
		event.preventDefault();
        $.ajax({
            type: "POST",
            url: "user.php",
            data:
            {
                "action": "register",
                "username": $("#userNameReg").val(),
                "email": $("#userEmailReg").val(),
                "password": $("#userPasswordReg").val()
            },
            success: function (result) {
                let parsedResult = JSON.parse(result);
                $('#registerModal').modal('hide');
                updateUserNav();
            }
        });
    });
});