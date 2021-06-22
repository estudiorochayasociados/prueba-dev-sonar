var url = $("body").attr("data-url");

function alertSide(message) {
    toastr.warning(message, '', {
        "closeButton": true,
        "debug": true,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    });
}

function success(latest) {
    toastr.success('Nuevo articulo agregado', latest, {
        "closeButton": true,
        "debug": true,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    });
}

function successMessage(latest) {
    toastr.success(latest, '', {
        "closeButton": true,
        "debug": true,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    });
}

function CaptchaCallback(id, cod) {
    try {
        grecaptcha.render(id, {
            'sitekey': cod
        });
    } catch {
        grecaptcha.render(id, {
            'sitekey': cod
        });
    }
};

///Agregado 23/07/2020
function refreshFront(combination, btn, amount, price) {

    var url = $('#cart-f').attr("data-url");
    console.log($('#cart-f').serialize());
    $.ajax({
        url: url + "/api/atributes/refreshFront.php",
        type: "POST",
        data: $('#cart-f').serialize(),
        success: function (data) {
            console.log(data);
            data = JSON.parse(data);
            if (data['combination'] == true && data['price'] != '') {
                $("#" + combination).val(data['combination']);
                $("#" + btn).prop("disabled", false);
                $("#" + amount).prop("disabled", false);
                $("#" + amount).attr({
                    "max": data['stock']
                });
                $("#" + price).html('');
                $("#" + price).append("$" + data['price']);
            } else {
                $("#" + btn).prop("disabled", true);
                $("#" + amount).prop("disabled", true);
            }
            if (data['stock'] == "0") {
                $("#" + btn).prop("disabled", true);
                $("#" + amount).prop("disabled", true);
            }
        }
    });
}

function refreshWithImg(variable) {
    $('option').not(new_selection).removeAttr('selected');
    var new_selection = $(".refreshWithImg").find('option:selected');
    $('option').not(new_selection).removeAttr('selected');
    if (variable != '') $('select option:contains("' + variable + '")').prop('selected', 'selected');
}

function refreshWithSelect() {
    var new_selection = $(".refreshWithImg").find('option:selected');
    $('option').not(new_selection).removeAttr('selected');
    new_selection.attr("selected", "selected");
    debugger;
    var attr = $(".refreshWithImg").find('option:selected').attr("data-value");
    $('#' + attr).click();
    debugger;
}

///Agregado 06/01/2021
async function addComments(url, idForm) {
    event.preventDefault();
    captcha = await getTokenCaptcha();
    grecaptcha.ready(function () {
        grecaptcha.execute(captcha, {
            action: 'submit'
        }).then(function (token) {
            $("#" + idForm + " input[name=captcha-response]").val(token);
            $.ajax({
                url: url + "/api/comments/addComments.php",
                type: "POST",
                data: $("#" + idForm).serialize(),
                success: function (data) {
                    data = JSON.parse(data);
                    if (data['status']) {
                        successMessage(data['message']);
                        location.reload();
                    } else {
                        alertSide(data['message']);
                    }
                }
            });
        });
    });
}

function deleteComments(admin, url, id) {
    url = url;
    if (admin == 1) {
        $.ajax({
            url: url + "/api/comments/deleteComments.php",
            type: "POST",
            data: { "id": id },
            success: function (data) {
                data = JSON.parse(data);
                if (data['status']) {
                    successMessage(data['message']);
                    location.reload();
                } else {
                    alertSide(data['message']);
                }
            }
        });

    }
}

function getTokenCaptcha() {
    grecaptcha.ready(function () {
        grecaptcha.execute(captcha, {
            action: 'submit'
        }).then(function (token) {
            return token;
        });
    });
}

function cambiarProvincia() {
    var url = $('#provincia').attr("data-url");
    elegido = $('#provincia').val();
    // console.log(elegido);
    $.ajax({
        type: "GET",
        url: url + "/assets/inc/localidades.inc.php",
        data: "elegido=" + elegido,
        dataType: "html",
        success: function (data) {
            $('#localidad option').remove();
            var substr = data.split(';');
            for (var i = 0; i < substr.length; i++) {
                var value = substr[i];
                $("#localidad").append(
                    $("<option></option>").attr("value", value).text(value)
                );
            }
        }
    });
}
function changeLang(url, cod = '') {
    var cod = (cod != '') ? cod : $('#selectLang').val();
    $.ajax({
        url: url + "/api/idioma/change-default.php",
        type: "POST",
        data: {
            cod: cod
        },
        success: function (data) {
            data = JSON.parse(data);
            if (data["status"]) {
                location.reload()
            }
        }
    });
}
function addFavorite(product) {
    $.ajax({
        url: url + "//api/favorites/favorite.php",
        type: "POST",
        data: { product: product },
        success: (data) => {
            $(".btn-addFavorite-" + product).addClass("d-none");
            $(".btn-deleteFavorite-" + product).removeClass("d-none");
        }
    });
}

function deleteFavorite(product) {
    $.ajax({
        url: url + "//api/favorites/favorite.php",
        type: "DELETE",
        data: { product: product },
        success: (data) => {
            $(".btn-addFavorite-" + product).removeClass("d-none");
            $(".btn-deleteFavorite-" + product).addClass("d-none");
        }
    });

}
$("#provincia").change(function () {
    cambiarProvincia()
});

