async function loginUser() {
    event.preventDefault();
    $("#ingresar").hide();
    $('#btn-l').append("<button id=\"btn-login\" class=\"btn ld-ext-right running\" disabled><div class='ld ld-ring ld-spin'></div></button>");
    $('#l-error').html('');

    var url = $('#login').attr("data-url");
    var link = ($('#login').attr("data-link")) ? $('#login').attr("data-link") : false;
    if (!link) {
        var link = url + "/sesion";
    }
    captcha = await getTokenCaptcha();
    grecaptcha.ready(function() {
        grecaptcha.execute(captcha, {
            action: 'submit'
        }).then(function(token) {
            $("#login input[name=captcha-response]").val(token);
            $.ajax({
                url: url + "/api/user/login.php",
                type: "POST",
                data: $('#login').serialize(),
                success: function(data) {
                    data = JSON.parse(data);
                    if (data['status']) {
                        window.location.assign(link);
                    } else {
                        alertSide(data['message']);
                        $('l-pass').html('');
                        $("#ingresar").show();
                        $('#btn-login').remove();
                    }
                },
                error: function() {
                    alertSide('Ocurrio un error, vuelva a recargar la página.');
                }
            });
        });
    });
}

async function registerUser() {
    event.preventDefault();
    $("#registrar").hide();
    $('#btn-r').append("<button id=\"btn-register\" class=\"btn ld-ext-right running\" disabled><div class='ld ld-ring ld-spin'></div></button>");
    var url = $('#register').attr("data-url");
    var type = $('#register').attr("data-type");
    $('#r-error').html('');
    captcha = await getTokenCaptcha();
    grecaptcha.execute(captcha, {
        action: 'submit'
    }).then(function(token) {
        $("#register input[name=captcha-response]").val(token);
        $.ajax({
            url: url + "/api/user/register.php",
            type: "POST",
            data: $('#register').serialize(),
            beforeSend: function() {
                $('#textS').html('');
                $('#textS').append("<span class='fa fa-spinner fa-spin fa-3x'></span><br>");
                $('#textS').append("<div class='text-uppercase text-center'>");
                $('#textS').append("<p class='fs-18 mt-10'>EXCELENTE, AGUARDE UNOS MOMENTOS Y SERA REDIRECCIONADO.</p>");
                $('#textS').append("</div>");
                $('#modalS').modal('toggle');
            },
            success: function(data) {
                data = JSON.parse(data);
                if (data['status']) {
                    $.ajax({
                        url: url + "/api/email/sendRegister.php",
                        type: "POST",
                        data: {
                            cod: data['cod']
                        },
                        success: function() {
                            if (type == 'stages') {
                                window.location = url + "/checkout";
                            } else {
                                window.location = url + "/sesion";
                            }
                        },
                        error: function() {}
                    });
                } else {
                    if ($('#modalS').hasClass('show')) {
                        $('#modalS').modal('toggle');
                    }
                    $('#r-error').append("<div class='alert alert-danger'>" + data['message'] + "</div>");
                    $('#modalS').modal('toggle');
                    $('r-pass').html('');
                    $('#btn-register').remove();
                    $("#registrar").show();
                }
            },
            error: function() {
                $('#r-error').append("<div class='alert alert-danger'>Ocurrio un error, vuelva a recargar la página.</div>");
            }
        });
    });
}