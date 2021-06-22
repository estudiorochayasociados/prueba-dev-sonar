$('table').addClass("table-hover");
$('input[type=text]').addClass("form-control");
$('input[type=date]').addClass("form-control");
$('input[type=url]').addClass("form-control");
$('input[type=number]').addClass("form-control");
$('select').addClass("form-control");
$('textarea').addClass("form-control");

$(function() {
    $('[data-toggle="tooltip"]').tooltip();
})

$('.deleteConfirm').on("click", function(e) {
    e.preventDefault();
    var choice = confirm("¿Estás seguro de eliminar?");
    if (choice) {
        window.location.href = $(this).attr('href');
    }
});

$(".ckeditorTextarea").each(function() {
    CKEDITOR.replace(this, {
        customConfig: 'config.js',
        filebrowserBrowseUrl: 'ckfinder/ckfinder.html',
        filebrowserImageBrowseUrl: 'ckfinder/ckfinder.html?type=Images&responseType=json',
        filebrowserFlashBrowseUrl: 'ckfinder/ckfinder.html?type=Flash&responseType=json',
        filebrowserUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
        filebrowserImageUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json',
        filebrowserFlashUploadUrl: 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash&responseType=json'
    });
});

$(document).ready(function() {
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

function agregar_input(div, name) {
    var cod = 1 + Math.floor(Math.random() * 999999);
    $('#' + div).append('<div class="col-md-12 input-group" id="' + cod + '"><input onkeydown="return (event.keyCode!=13);" type="text" class="form-control mb-10 mr-10" name="' + name + '[' + cod + '][atributo]"><input id="tg' + cod + '" onkeydown="return (event.keyCode!=13);" type="text" class="form-control mb-10 mr-10" name="' + name + '[' + cod + '][valores]"></div>');
    $('#' + cod).append(' <div class="input-group-addon"><a href="#" onclick="$(\'#' + cod + '\').remove()" class="btn btn-primary"> <i class="fas fa-minus"></i> </a> </div>');
    $('#tg' + cod).tagify();
}


function agregar_atributo(div) {
    var cod = 1 + Math.floor(Math.random() * 999999);
    $('#' + div).append('<div class="input-group" id="' + cod + '"><input onkeydown="return (event.keyCode!=13);" type="text" class="form-control mb-10 mr-10" name="atributo[]"></div>');
    $('#' + cod).append(' <div class="input-group-addon"><a href="#" onclick="$(\'#' + cod + '\').remove()" class="btn btn-primary"> <i class="fas fa-minus"></i> </a> </div>');
}


function AgregarCombinacion(id, destino, total) {
    if ($('[id=combinaciones]').length <= total - 1) {
        $random = Math.floor((Math.random() * 1000) + 1);

        var newItem = $("#" + id).clone();
        newItem.find("input[name]").each(function() {
            var nameCurrent = $(this).attr("name");
            nameCurrent = nameCurrent.slice(0, -1);
            $(this).attr("name", nameCurrent + $random + "]");
        });
        newItem.find("select option").each(function() {
            $(this).removeAttr("selected");
        });
        newItem.find("select").each(function() {
            $(this).children().each(function(key, value) {
                if (key == 0) {
                    $(this).attr("selected", "selected");
                }
                console.log(key + '-' + value);
            });
        });
        newItem.find("input[value]").each(function() {
            $(this).attr("value", 0);
        });
        newItem.appendTo("#" + destino);
    }
}

function _ajax(params, url, type) {
    $.ajax({
        url: url,
        type: type,
        data: {
            params
        },
        success: function(data) {
            return data;
        }
    });
}

$('.modal-page-ajax').click(function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    var titulo = $(this).attr('data-title');
    $('#contenidoForm').load(url, function(result) {
        $('#moda-page-ajax').modal('show');
        $('.modal-title').html(titulo);
        e.preventDefault();
    })
});


function openModal(url, titulo) {
    $('#contenidoForm').load(url, function(result) {
        $('#moda-page-ajax').modal('show');
        $('.modal-title').html(titulo);
        e.preventDefault();
    })
};

function checkSliderProps() {
    if ($('#chsub').prop('checked')) {
        $('#sub').attr('required', true);
    } else {
        $('#sub').attr('required', false);
    }
    if ($('#chli').prop('checked')) {
        $('#link').attr('required', true);
    } else {
        $('#link').attr('required', false);
    }
}

function errorMessage(message) {
    toastr.error(message, '', {
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

function successMessage(message) {
    toastr.success(message, '', {
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


function changeStatus(id, url) {
    var val;
    var value = $('#' + id).prop('checked');
    if (value) {
        val = "'1'";
    } else {
        val = "'0'";
    }

    editProduct(idioma, id, url, val);
}

function changePriceDiscount(price, id, url, typeAndValue, value) {
    var value = $("#" + id).val();
    var type = typeAndValue.slice(0, 1);
    var typeAndValue = typeAndValue.replace("$", "");
    var typeAndValue = typeAndValue.replace("%", "");

    if (type == "%") {
        //CALCULAR A PARTIR DEL PRECIO DESUENTO
        var porcentajeFinal = (value * 100) / price;
        porcentajeFinal = 100 - porcentajeFinal;
        editProduct(idioma, id, url, porcentajeFinal, value, true);
        setTimeout(function() {
            location.reload();
        }, 1500);

    } else {
        //CALCULAR A PARTIR DEL PORCENTAJE
        var porcentajeFinal = (price * value) / 100;
        var precioFinal = price - porcentajeFinal;
        editProduct(idioma, id, url, value, precioFinal, true);
        setTimeout(function() {
            location.reload();
        }, 1500);
    }
}

function editProduct(idioma, id, url, value = false, ) {
    event.preventDefault();
    var data_ = id.split("-");
    var url_admin = $("#grid-products").attr("data-url");
    console.log(url_admin);
    $.ajax({
        url: url + '/api/productos/edit.php',
        type: "POST",
        data: {
            idioma: idioma,
            attr: data_[0],
            value: (value) ? value : "'" + $("#" + id).val() + "'",
            cod: data_[1]
        },
        success: function(data) {
            if (data) {
                successMessage("Producto " + data_[1] + " actualizado correctamente");
                if (data_[0] == 'categoria') {
                    getCategory(url_admin, 'subcategory', id, 'subcategoria-' + data_[1], idioma);
                    debugger;
                }
            } else {
                errorMessage("El producto " + data_[1] + " no se ha actualizado");
            }
        }
    });
}

function exportTableToExcel(tableID, filename = '') {
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

    // Specify file name
    filename = filename ? filename + '.xls' : 'excel_data.xls';

    // Create download link element
    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);

    if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

        // Setting the file name
        downloadLink.download = filename;

        //triggering the function
        downloadLink.click();
    }
}

function getCategory(url, flag, idSelect, idNextSelect, idioma) {
    var value = $('#' + idSelect).val();
    console.log(value);
    $.ajax({
        url: url + "/api/categories/getCategory.php",
        type: "POST",
        data: {
            flag: flag,
            value: value,
            idioma: idioma
        },
        success: function(data) {
            console.log(data);
            data = JSON.parse(data);
            $("#" + idNextSelect).html("<option value=''>Elegi opción</option>")
            data.forEach((data_) => {
                $("#" + idNextSelect).append("<option value='" + data_.data.cod + "'>" + data_.data.titulo + "</option>")
            })
        },
        error: function() {
            alert('Error occured');
        }
    });
}

function attrSelect(url) {
    var table = $("#select_table").val();
    var url = $('#select_table').attr("data-url");
    //console.log(table);
    $.ajax({
        url: url + '/api/excel/get_attr.php',
        type: "POST",
        data: {
            table: table
        },
        success: (data) => {
            var data = JSON.parse(data);
            $('#select_attr').html("");
            if (data.status) {
                Object.keys(data.attr).forEach(function(key) {
                    var select = (key == 'cod') ? 'hidden selected disabled' : '';
                    var option = `
                <option ` + select + `  value="` + key + `" data-icon="bx bx-user">` + data.attr[key] + `</option>
                `;
                    $('#select_attr').append(option);
                });
            }

        }
    });
}

function check(url, code, flag) {
    if (flag == 0) {
        flag = 1;
        $.ajax({
            url: url + "/admin/api/pedidos/checkView.php",
            type: "POST",
            data: {
                code: code,
                flag: flag
            },
            success: function(data) {
                $('#notOpen' + code).addClass("hidden");
                $('#viewed' + code).removeClass("hidden");
            }
        });
    }
}

function changeLabel(cod, url) {
    $.ajax({
        url: url + "/admin/api/idiomas/change-default.php",
        type: "POST",
        data: {
            cod: cod
        },
        success: function(data) {
            location.reload()
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