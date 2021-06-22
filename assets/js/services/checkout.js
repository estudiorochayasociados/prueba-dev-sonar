function addShipping() {
    event.preventDefault();
    $("#btn-shipping-1").hide();
    $('#btn-shipping-d').append("<button id='btn-shipping-2' class='btn ld-ext-right running' disabled><div class='ld ld-ring ld-spin'></div></button>");

    var url = $('#shipping-f').attr("data-url");
    $.ajax({
        url: url + "/api/stages/stage-1.php",
        type: "POST",
        data: $('#shipping-f').serialize(),
        success: function(data) {
            // console.log(data);
            data = JSON.parse(data);
            if (data['status'] == true) {
                window.location = url + "/checkout/billing";
            } else {
                $("#btn-shipping-1").show();
                $('#btn-shipping-2').remove();

                alertSide(data['message']);
            }
        }
    });
}

function addBilling() {
    event.preventDefault();
    $("#btn-billing-1").hide();
    $('#btn-billing-d').append("<button id='btn-billing-2' class='btn ld-ext-right running' disabled><div class='ld ld-ring ld-spin'></div></button>");

    var url = $('#billing-f').attr("data-url");
    $.ajax({
        url: url + "/api/stages/stage-2.php",
        type: "POST",
        data: $('#billing-f').serialize(),
        success: function(data) {
            // console.log(data);
            data = JSON.parse(data);
            if (data['status'] == true) {
                window.location = url + "/checkout/payment";
            } else {

                $("#btn-billing-1").show();
                $('#btn-billing-2').remove();

                alertSide(data['message']);
            }
        }
    });
}

function addPayment() {
    event.preventDefault();
    $("#btn-payment-1").hide();
    $('#btn-payment-d').append("<button id='btn-payment-2' class='btn ld-ext-right running pull-right' disabled><div class='ld ld-ring ld-spin'></div></button>");

    var url = $('#payment-f').attr("data-url");
    var cod = $('#payment-f').attr("data-cod");
    $.ajax({
        url: url + "/api/stages/stage-3.php",
        type: "POST",
        data: $('#payment-f').serialize(),
        success: function(data) {
            // console.log(data);

            data = JSON.parse(data);
            if (data['status'] == true) {
                if (data['type'] == 'API') {
                    $.ajax({
                        url: data['url'],
                        type: "POST",
                        data: {
                            cod: cod
                        },
                        beforeSend() {
                            $('#textS').append("<span class='fa fa-spinner fa-spin fa-3x'></span><br>");
                            $('#textS').append("<div class='text-uppercase text-center'>");
                            $('#textS').append("<p class='fs-18 mt-10'>EXCELENTE, ESTAMOS GENERANDO TU TICKET DE PAGO.</p>");
                            $('#textS').append("</div>");
                            $('#modalS').modal('toggle');
                        },
                        success: function(data) {
                            console.log();

                            data = JSON.parse(data);
                            if (data['status'] == true) {
                                // console.log(data);
                                window.location = data['url'];
                            } else {
                                $("#btn-payment-1").show();
                                $('#btn-payment-2').remove();

                                alertSide(data['message']);
                            }
                        },
                        error: function() {
                            alertSide('Ocurrio un error, vuelva a recargar la página.');
                        }
                    });
                } else {
                    window.location = data['url'];
                }
            } else {

                $("#btn-payment-1").show();
                $('#btn-payment-2').remove();

                alertSide(data['message']);
            }
        }
    });
}

function sendBuyTimer(url, cod) {
    try {
        sendBuy(url, cod);

    } catch (err) {
        setTimeout(sendBuyTimer, 1000);

    }
}


function stage1(data_, url) {
    $.ajax({
        url: url + "/api/stages/stage-1.php",
        type: "POST",
        data: JSON.parse(data_),
        success: function(data) {
            // console.log(data);
            stage2(data_, url);
        }
    })
}


function stage2(data_, url) {
    $.ajax({
        url: url + "/api/stages/stage-2.php",
        type: "POST",
        data: JSON.parse(data_),
        success: function(data) {
            // console.log(data);
            stage3(data_, url);
        }
    })
}

function stage3(data_, url) {
    $.ajax({
        url: url + "/api/stages/stage-3.php",
        type: "POST",
        data: JSON.parse(data_),
        success: function(data) {
            // console.log(data);
            window.location.assign(url + "/checkout/detail");
        }
    })
}

function sendBuy(url, cod) {
    $('#btn-send' + cod).prop("disabled", true);
    $.ajax({
        url: url + "/api/email/sendBuy.php",
        type: "POST",
        data: {
            cod: cod
        },
        beforeSend: function() {

            $('#textS').html('');
            $('#textS').append("<span class='fa fa-spinner fa-spin fa-3x'></span><br>");
            $('#textS').append("<div class='text-uppercase text-center'>");
            $('#textS').append("<p class='fs-18 mt-10'>EXCELENTE, ESTAMOS ENVIANDO UN EMAIL CON TODA LA INFORMACIÓN DEL PEDIDO.</p>");
            $('#textS').append("</div>");
            $('#modalS').modal('toggle');
        },
        success: function(data) {
            // console.log(data);

            $('#textS').html('');
            $('#textS').append("<i class='fa fa-check-circle fs-80' style='color:green'></i><br>");
            $('#textS').append("<div class='text-uppercase text-center'>");
            $('#textS').append("<p class='fs-18 mt-10'>EMAIL ENVIADO EXITOSAMENTE.</p>");
            $('#textS').append("</div>");
            if ($('#modalS').hasClass('show')) {

            } else {
                $('#modalS').modal('toggle');
            }
        }
    });
}

function editAndSendStatus(url, codPedido, estadoPedido, enviar) {
    event.preventDefault();
    $.ajax({
        url: url + "/api/email/editAndSendStatus.php",
        type: "POST",
        data: {
            codPedido: codPedido,
            estadoPedido: estadoPedido,
            enviar: enviar
        },
        beforeSend: function() {
            $('#textS').html('');
            $('#textS').append("<span class='fa fa-spinner fa-spin fa-3x'></span><br>");
            $('#textS').append("<div class='text-uppercase text-center'>");
            $('#textS').append("<p class='fs-18 mt-10'>EXCELENTE, ESTAMOS ENVIANDO UN EMAIL CON LA INFORMACION DEL ESTADO</p>");
            $('#textS').append("</div>");
            $('#modalS').modal('toggle');
        },
        success: function(data) {
            // console.log(data);

            data = JSON.parse(data);
            if (data['status']) {
                $('#textS').html('');
                $('#textS').append("<div class='text-uppercase text-center'>");
                $('#textS').append("<p class='fs-18 mt-10'>");
                $('#textS').append(data['message']);
                $('#textS').append("</p>");
                $('#textS').append("</div>");
            }
            setTimeout(() => {
                location.reload();
            }, 1000)
        }
    });
}

function printContent(id) {
    var restorepage = $('body').html();
    var printcontent = $('#' + id).clone();

    $('body').empty().html(printcontent);
    window.print();
    $('body').html(restorepage);
}