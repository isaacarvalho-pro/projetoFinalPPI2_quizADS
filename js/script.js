$(document).ready(function () {
    $('#mostrar-cadastro').click(function () {
        $('#login-container').hide();
        $('#cadastro-container').show();
    });

    $('#mostrar-login').click(function () {
        $('#cadastro-container').hide();
        $('#login-container').show();
    });

    $('#btn-cadastrar').click(function () {
        $.post('php/cadastro.php', {
            nome: $('#nome').val(),
            email: $('#cad-email').val(),
            senha: $('#cad-senha').val()
        }, function (data) {
            alert(data);
        });
    });

    $('#btn-login').click(function () {
        $.post('php/login.php', {
            email: $('#email').val(),
            senha: $('#senha').val()
        }, function (data) {
            if (data === 'admin') {
                window.location.href = 'admin.html';
            } else if (data === 'user') {
                window.location.href = 'quiz.html';
            } else {
                alert(data);
            }
        });
    });
});
