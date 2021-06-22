$('#btn-a-1').attr("disabled", false);
$('cart').html('<div class="cart-products product_bar"></div><div class="cart-discount"> </div><div class="cart-total"> </div><div class="cart-product-btn mt-4 btn-finalizar-carrito">');
$('btn-finalizar-compra').html('<div class="btn-finalizar-compra"></div>');

// refresh del carrito 
setInterval(() => {
    refreshCart($('body').attr('data-url'))
}, 1500);


function addToCart(form = "", product, url, flag, cant = '') {
    event.preventDefault();
    var amount = $('#product-stock-' + product).val();
    if (amount == null && cant != null) {
        amount = cant;
    }
    var data = (form) ? $("#" + form).serialize() : {
        product: product,
        amount: amount,
        flag: flag
    };
    var btn_finalizar_seguir = `
    <button onclick="$('#modalSP').modal('toggle');" class="btn btn-default text-uppercase fs-12"><b>` + lang['carrito']['seguir_compra'] + `</b></button>
    <a href="` + url + `/carrito" class="btn btn-default fs-12 text-uppercase"><b>` + lang['carrito']['finalizar_compra'] + `</b></a>`;
    $('#btn').html(btn_finalizar_seguir);
    $('#messageQuickAdd').hide();
    if ((product != '' && amount != '' && url != '') || form) {
        $.ajax({
            url: url + "/api/cart/add.php",
            type: "POST",
            data: data,
            success: function (data) {
                showMessage();
                data = JSON.parse(data);
                if (data['status']) {
                    getProductsRelatioship(url, data, flag);
                    if (flag != true) {
                        $('#modalSP').modal('toggle');
                    }
                    viewCart(url);
                } else {
                    $('#error').html('');
                    $('#error').append(data['message']);
                    $('#modalEP').modal('toggle');
                }
            }
        });
    }
}

function editCantidad(value, url, key, id, price) {
    $('.stock-' + id).val(value)
    var cantidad = value;
    if (cantidad > 0) {

        var total = price * cantidad;
        $.ajax({
            url: url + "/api/cart/edit.php",
            type: "POST",
            data: {
                key: key,
                cantidad: cantidad
            },
            success: (data) => {
                (window.location.href.indexOf("payment") >= 0) ? window.location.assign(url + '/checkout/shipping') : "";
                var data = JSON.parse(data);
                cartTotalPrice(Number(data['total']), Number(data['finalPrice']));
                $('.totalPrice-' + id).html('');
                $('.totalPrice-' + id).append('$' + total);
                if (data['discount']['cart'] != null) {
                    discount = elementExtra(data['discount'], url)
                    $('.cart-discount').html('');
                    $('.cart-discount').append(discount);
                }

            }
        });
    }
}

function deleteItem(url, id) {
    $.ajax({
        url: url + "/api/cart/delete.php",
        type: "POST",
        data: {
            id: id
        },
        success: (data) => {
            (window.location.href.indexOf("payment") >= 0) ? location.reload() : "";
            viewCart(url);
        }
    });
}


function showMessage() {
    success("");
    $('#messageQuickAdd').html(`<div class='alert alert-success fs-16 bold'>` + lang['carrito']['producto_agregado'] + ` </div><hr/>`);
    $('#messageQuickAdd').show(100);
}

function getProductsRelatioship(url, data, flag) {
    var relatedProducts_primary = $('#relations-products').html();
    $('#relations-products').html();
    if (!flag) {
        $.ajax({
            url: url + "/api/products/list-related-products.php",
            type: "POST",
            data: data,
            dataType: "html",
            success: function (data) {
                if (data != '') {
                    $('#relations-products').html('<h4 class="fs-20">' + lang['carrito']['sumar_compra'] + '</h4>' + data);
                }
            }
        });
        $('#modalSP').modal('toggle');
    } else {
        $('#relations-products').html(relatedProducts_primary);
    }
}

function refreshCart(url) {
    $.ajax({
        url: url + "/api/cart/total-price.php",
        type: "GET",
        success: function (data) {
            data = JSON.parse(data);
            $('.totalPriceCartNav').html("$" + data.total);
            $('.amountCartNav').html(data.amount);
        }
    });
}


//VIEW 
function viewCart(url) {
    $('.cart-products').html('');
    $('.cart-discount').html('');
    $.ajax({
        url: url + "/api/cart/view.php",
        type: "POST",
        success: (data) => {
            var cartProduct = '';
            var finalPrice = 0;
            var total = 0;
            var discount = '';
            console.log(data);
            var cart = JSON.parse(data);
            if (cart != 0) {
                console.log(cart);
                cart.forEach(function (element, key) {
                    (element['products'].hasOwnProperty('data')) ? cartProduct += elementProduct(element, key, url) : discount += elementExtra(element, url);

                    finalPrice = finalPrice + (element['cart']['precio'] * element['cart']['cantidad']);
                    if (Math.sign(element['cart']['precio']) > 0) {
                        total = total + (element['cart']['precio'] * element['cart']['cantidad']);
                    }
                });
                $('.btn-finalizar-carrito').removeClass('d-none');
            } else {
                cartProduct = lang['carrito']['carrito_vacio'];
                $('.btn-finalizar-carrito').addClass('d-none');
            }
            $('.cart-products').append(cartProduct);
            // $('.cart-discount').append(discount);
            cartTotalPrice(total, finalPrice);
        }
    });
}

function elementExtra(element, url) {
    if (element['cart']['descuento'] != null) {
        body = `<div class="d-block w-100">
        <span class="value text-uppercase pull-left"  >Descuento: <span class="text-uppercase" >` + element['cart']['descuento']['cod'] + `</span>
        <button class="btn btn-outline-dark btn-sm mr-10 ml-10 collapseDetail" type="button" data-bs-toggle="collapse" data-bs-target="#discountDetail" aria-expanded="false" aria-controls="collapseExample">
        <i class='fa fa-info'></i></button><a href="#" class="btn btn-outline-dark btn-sm" onclick="deleteItem('` + url + `','discount')"><i class="fa fa-trash"></i></a></span>
        <span class="price pull-right"  > $` + element['cart']['precio'].toFixed(2) + `</span></div>
        <div class="collapse" id="discountDetail">
        <div class="card card-body ">`;
        element['cart']['descuento']['products'].forEach(function (data) {
            body += `<div class="fs-12 discountText " > ` + data['titulo'] + ` ` + data['monto'] + `</div>`;
        });
        body += `</div></div>`;

    } else {
        body = `<span class="value text-uppercase fs-14">Costo de Envio: <span class="text-uppercase" >` + element['cart']['titulo'] + `</span></span>
        <span class="price fs-14">$` + element['cart']['precio'] + `</span>`;
    }
    discount = `<hr/><div class="cart-product-total">` + body + `</div><hr/>`;
    return discount;
}



function elementProduct(element, key, url) {
    var price = (element['products']["data"]["precio_final"]) ? element['products']["data"]["precio_final"] : "";
    var productPriceTotal = (Number(element['products']["data"]["precio_final"]) * element['cart']['cantidad']);
    var title = element["cart"]["opciones"]["texto"] != null ? element["cart"]["titulo"] + " " + element["cart"]["opciones"]["texto"] : element["cart"]["titulo"];
    cartProduct = `
    <div class="product-` + element['cart']['id'] + `">
        <div class="cart-product-wrapper mb-6">
            <div class="row mb-3">
                <div class="col-md-6 col-6">
                    <h3 class=" fs-14" style="margin-bottom: 2px !important"><a href="` + element['products']['link'] + `">` + title.toUpperCase() + `</a></h3>
                </div>
                <div class="col-md-3 col-3">
                    <span class=" new fs-12" style="color:gray">$` + price + ` x </span>
                    <input  min="1" value="` + element['cart']['cantidad'] + `" max="` + element['products']["data"]["stock"] + `" onchange="editCantidad(this.value,'` + url + `','` + key + `','` + element['cart']['id'] + `','` + price + `')" style="height:25px; width:45px; margin-left: 2px" type="number" name="stock" class="numberStock stock-` + element["cart"]["id"] + `">
                </div>
                <div class="col-md-2 col-2">
                    <span class="price mb-10">
                        <span class="new totalPrice-` + element['cart']['id'] + `"> $` + productPriceTotal.toFixed(2) + ` </span>
                    </span>
                </div>
                <div class="col-md-1 col-1">
                    <a onclick="deleteItem('` + url + `','` + key + `')"><i class="fa fa-trash"></i></a>
                </div>
            </div>
        </div>
    </div>`;
    return cartProduct;
}

function cartTotalPrice(total, finalPrice) {
    $('.cart-total').html('');
    total = (total == finalPrice) ? '' : '$' + total.toFixed(2);
    var body = `
    <div class="cart-product-total text-uppercase pull-right">
        <span class="value bold fs-20">` + lang['carrito']['total'] + `</span>
        <span class="price fs-18"><span class="old mr-10"> ` + total + `</span> $` + finalPrice.toFixed(2) + `</span>
    </div>`;
    $('.cart-total').append(body);
}


// END VIEW