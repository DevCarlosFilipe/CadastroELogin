var formCad = $("#cadastro");
var formLogin = $("#login");
var inputName = $("#inputName");
var inputPass = $("#inputPass");
var inputColor = $("#inputColor");
var alertBox = $("#alert");
var test

formCad.submit(function (event) {
    $.post("http://localhost/test/data/backend.php", {
        typeIn: "signup",
        nome: inputName.val(),
        senha: inputPass.val(),
        color: inputColor.val()
    }).done(function (data) {
        data = JSON.parse(data);
        if (data.error != 0) {
            alertBox.removeClass("d-none")
            alertBox.text(data.error)
        } else {
            alertBox.addClass("d-none")
            window.location.assign("http://localhost/test/");
        }
        test = data
        console.log(data)
    });
    event.preventDefault();
});
formLogin.submit(function (event) {
    $.post("http://localhost/test/data/backend.php", {
        type: "login",
        nome: inputName.val(),
        senha: inputPass.val()
    }).done(function (data) {
        data = JSON.parse(data);
        if (data.error != 0) {
            alertBox.removeClass("d-none")
            alertBox.text(data.error)
        } else {
            alertBox.addClass("d-none")
            window.location.assign("http://localhost/test/user.php");
        }
        console.log(data)
    });
    event.preventDefault();
});
