var start = 0;
var limit = 16;
var order = 'id ASC';
var url = $("body").attr("data-url");


getData();

function checkRefresh(id) {
    if ($("#" + id).prop('checked')) {
        $("#" + id).prop("checked", false);
    } else {
        $("#" + id).prop("checked", true);
    }
    $("#" + id).trigger("change");
}

function orderBy(value) {
    order = value;
    getData();
}

function loadMore() {
    disableLoadMore();
    start += limit;
    getData('add');
}

function disableLoadMore() {
    $('#grid-products-btn').hide();
}

function enableLoadMore() {
    $('#grid-products-btn').show();
}

function getData(type) {
    const list = (type != 'add') ? true : false;

    if (url) {
        $.ajax({
            url: url + "/api/products/get_products.php?start=" + start + "&limit=" + limit + "&order=" + order,
            type: "POST",
            data: $('#filter-form').serialize(),
            success: (data) => {
                var productsData = JSON.parse(data);
                list ? reset() : enableLoadMore();
                if (!productsData.products.length) disableLoadMore();
                productsData.products.forEach(element => {
                    product = createElement(element, productsData.user);
                    $('.grid-products').append(product);
                });
            }
        });
    }
}


function getDataFavorites() {
    var user = $(".grid-favorites").attr("data-favorites");
    var url__2 = $(".grid-favorites").attr("data-url");
    if (url__2) {
        $.ajax({
            url: url__2 + "/api/favorites/favorite.php",
            type: "GET",
            data: { user: user },
            success: (data) => {
                disableLoadMore();
                var productsData = JSON.parse(data);
                productsData.products.forEach(element => {
                    product = createElement(element, true, col = 12);
                    $('.grid-favorites').append(product);
                });
            }
        });
    }
}



function createElement(element, user, col = 4) {
    var price_old = (element["data"]["precio_descuento"] != null && element["data"]["precio_descuento"] != 0) ? "$" + element["data"]["precio"] : "";
    var price = (element["data"]["precio_final"]) ? "$" + element["data"]["precio_final"] : "";
    var img = element["images"][0]["url"];
    var category = element["data"]["categoria_titulo"] != null ? element["data"]["categoria_titulo"] : '';
    var subcategory = element["data"]["subcategoria_titulo"] != null ? " / " + element["data"]["subcategoria_titulo"] : '';
    var description = element["data"]["descripton"] != null ? element["data"]["descripton"] : '';
    var link = element['link'];
    var user_login = (user == '') ? 'd-none' : '';
    var fecha = new Date(element['data']["fecha"]);
    var fecha2 = new Date(element['data']["fecha"]);
    var dias = 1; // Número de días a agregar
    fecha.setDate(fecha.getDate() + dias);
    var fecha = fecha2.getTime() <= fecha.getTime() ? lang['productos']['nuevo'] : '';

    var txtPorcent = '';
    if (element["data"]["precio_descuento"]) {
        total = element["data"]["precio"];
        porcentaje = (element["data"]["precio_final"] / total) * 100 - 100;
        porcentaje = Math.floor(porcentaje);
        if (porcentaje < -4) {
            var txtPorcent = porcentaje + "%";
        }
    }


    if (element['favorite']['data'] != null) {
        var hiddenAddFav = 'd-none';
        var hiddenDeleteFav = '';
    } else {
        var hiddenAddFav = '';
        var hiddenDeleteFav = 'd-none';
    }

    if (element["data"]["precio_final"] > 0 && element["data"]["stock"] > 0) {
        if (element["data"]['variable1'] == null) {
            var btnCompra =
                `<div class="d-flex align-items-center justify-content-between">
                <input type="number" style='border-radius:5px 0px 0px 5px !important' step="1"  class="form-control"   name="stock" id="product-stock-` + element["data"]["cod"] + `" min="1" max="` + element["data"]["stock"] + `"   value="1">
                <button style='padding:10.5px;border-radius: 0px 5px 5px 0px   !important' class="btn btn-sm btn-block btn-outline-dark btn-hover-primary" onclick="addToCart('','` + element["data"]["cod"] + `','` + url + `',false)" title="` + lang['productos']['agregar_carrito'] + `"><i class="icon-basket"></i></button>
            </div>`
        } else {
            var btnCompra =
                `<div class="d-flex align-items-center justify-content-between">
                    <a href="`+ link + `" style='padding:10.5px;border-radius: 5px   !important' class="btn btn-sm btn-block btn-outline-dark btn-hover-primary" title="` + lang['productos']['ver_producto'] + `"><i class="fa fa-search"></i></a>
                </div>`
        }
    } else {
        var btnCompra = `<div class=" d-flex align-items-center justify-content-between" style="place-content: center!important;color:red">` + lang['productos']['sin_stock'] + `</div>`

    }


    var product = `
    <div class="col-sm-6 col-md-4 col-lg-` + col + ` mb-30">
        <div class="card product-card" style="min-height: 490px;">
            <div class="card-body">
                <div class="product-thumbnail position-relative">
                    <span class="badge badge-success top-left">` + txtPorcent + `</span>
                    <span class="badge badge-danger top-right">` + fecha + `</span>
                    <a href="` + link + `">
                        <img style="object-fit:contain;width:300px;height:300px" class="first-img" src="` + img + `" alt="` + element["data"]["titulo"].toUpperCase() + `" />
                    </a>
                    <ul class="actions d-flex justify-content-center hidden-md-down">
                        <li>
                            <div class="` + user_login + `">
                                <a title="Eliminar de Favorito" style="color:red" class="action wishlist ` + hiddenDeleteFav + ` btn-deleteFavorite-` + element["data"]["cod"] + `"  onclick="deleteFavorite('` + element["data"]["cod"] + `')"><i class="fa fa-heart" aria-hidden="true" style="color:red>"></i></a>
                                <a title="Agregar a Favorito"    class="action wishlist ` + hiddenAddFav + ` btn-addFavorite-` + element["data"]["cod"] + `" onclick="addFavorite('` + element["data"]["cod"] + `')"><i class="fa fa-heart" aria-hidden="true" style="color:white>"></i></a>
                            </div>
                        </li>
                        <li>
                            <a class="action" href="` + link + `" >
                                <span data-toggle="tooltip" data-placement="bottom" title="`+ lang["productos"]["ver_producto"] + `" class="icon-magnifier"></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="product-desc py-0 px-0"style="min-height:150px">
                    <a class="blog-link theme-color text-uppercase" href="` + link + `" tabindex="0">` + category + subcategory + `</a>
                    <h3 class="title fs-14">
                        <a href="` + link + `">` + element["data"]["titulo"].toUpperCase() + `</a>
                    </h3>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="product-price">
                            <del class="del">` + price_old + `</del>
                            <span class="onsale">` + price + `</span>
                        </span>
                    </div>
                </div>
                ` + btnCompra + `
                <div class="d-flex align-items-center justify-content-between hidden-md-up">
                    <a title="Eliminar de Favorito" style='text-align-last: center;border:none;margin-top: .5rem;color:red;padding:10.5px;' class=" ` + user_login + `btn btn-sm btn-block btn-outline-dark btn-hover-primary wishlist ` + hiddenDeleteFav + ` btn-deleteFavorite-` + element["data"]["cod"] + `"  onclick="deleteFavorite('` + element["data"]["cod"] + `')"><i class="fa fa-heart" aria-hidden="true" style="color:red>"></i></a>
                    <a title="Agregar a Favorito"   style='text-align-last: center;border:none;margin-top: .5rem;padding:10.5px;' class=" ` + user_login + `btn btn-sm btn-block btn-outline-dark btn-hover-primary wishlist ` + hiddenAddFav + ` btn-addFavorite-` + element["data"]["cod"] + `" onclick="addFavorite('` + element["data"]["cod"] + `')"><i class="fa fa-heart" aria-hidden="true" style="color:white>"></i></a>
                    <a style='border:none;padding:10px;' class="btn btn-sm btn-block btn-outline-dark btn-hover-primary" href="` + link + `" ><span data-toggle="tooltip" data-placement="bottom" title="` + lang['productos']['ver_producto'] + `" class="icon-magnifier"></span></a>
                </div>
            </div>
        </div>
    </div>`;
    return product;
}

function modalquickview(cod) {
    $('#modalPr-precio').html('');
    $('#modalPr-cod').html('');
    $('#modalPr-desarrollo').html('');
    $('#modalPr-stock').html('');
    $('#modalPr-button').html('');
    $('#modalPr-img').html('');
    $('#modalPr-titulo').html('');
    $('#modalPr-variacion').html('');

    $.ajax({
        url: url + "/api/products/get_one_product.php",
        type: "POST",
        data: { cod: cod },
        success: (data) => {
            var productData = JSON.parse(data);
            var price_old = (productData["product"]["data"]["precio_descuento"] != null && productData["product"]["data"]["precio_descuento"] != 0) ? "$" + productData["product"]["data"]["precio"] : "";
            var price = (productData["product"]["data"]["precio_final"]) ? "$" + productData["product"]["data"]["precio_final"] : "";
            var cod_product = productData["product"]["data"]["cod_producto"] != null ? "Codigo: " + productData["product"]["data"]["cod_producto"] : '';
            var fast_add_cart = ((productData["product"]["data"]["precio_final"] == 0) || (productData["product"]["data"]["stock"] == 0) || productData["product"]["combination"].length < 1) ? "hidden" : "";
            var category = productData["product"]["data"]["categoria_titulo"] != null ? productData["product"]["data"]["categoria_titulo"] : '';
            var subcategory = productData["product"]["data"]["subcategoria_titulo"] != null ? " / " + productData["product"]["data"]["subcategoria_titulo"] : '';
            var desarrollo = productData["product"]["data"]["desarrollo"] != null ? productData["product"]["data"]["desarrollo"] : '';
            var link = url + "/producto/" + encodeURIComponent(productData["product"]['data']['titulo']) + "/" + productData["product"]['data']['cod'];
            if (productData["product"]["data"]["imagenes_rutas"] != null) {
                productData.product.data.imagenes_rutas.forEach(imgData => {
                    img = `
                           <a class="swiper-slide" href="#">
                           <img class="w-100" src="` + url + `/` + imgData + `" alt="Product">
                           </a>
                          `;
                    $('#modalPr-img').append(img);
                });
            } else {
                $('#modalPr-img').append(`<a class="swiper-slide" href="#"><img class="w-100" src="` + url + `/assets/archivos/sin_imagen.jpg" alt="Product"></a>`);
            }



            if (productData.attr.length >= 1) {
                var variation = `
                <input type='hidden' name='product' id='product' value='` + productData["product"]["data"]["cod"] + `'>
                <input type='hidden' name='combination' id='combination' value='false'>
                <input type='hidden' name='amount-atributes' value='` + productData.attr.length + `'>
                `;
                productData.attr.forEach(attrData => {

                    variation += `
                                  <div class="form-group">
                                  <label for="FormControl[` + attrData['atribute']['cod'] + `]">` + attrData['atribute']['value'].toUpperCase() + `</label>
                                  <select class="form-control" id="FormControl[` + attrData['atribute']['cod'] + `]" name="atribute[` + attrData['atribute']['cod'] + `]" onchange="refreshFront('combination','btn-a-1','stockModal-` + productData["product"]["data"]["cod"] + `','priceModal')" required>
                                      <option disabled selected></option>
                                 `;
                    attrData.atribute.subatributes.forEach(options => {
                        variation += ` <option value="` + options['cod'] + `">` + options['value'] + `</option>`;
                    });
                    variation += `</select></div>`;
                });

                $('#modalPr-variacion').append(variation);
            } else { }


            var prices = `
                          <span class="regular-price" id="priceModal">` + price + `</span>
                          <span class="old-price"><del>` + price_old + `</del></span>
                         `;
            var buttons = `
                         <div class="add-to_cart mb-3">
                         <a class="btn btn-outline-dark btn-hover-primary" id="btn-a-1" onclick="addToCart('','` + productData["product"]["data"]["cod"] + `','` + url + `',false,'Modal')">Agregar al carrito</a>
                         </div>
                         <div class="add-to-wishlist mb-3">
                         <a class="btn btn-outline-dark btn-hover-primary" href="wishlist.html">Agregar a favoritos</a>
                         </div>
                        `;

            $('#modalPr-titulo').append('<h2 class="product-title">' + productData["product"]["data"]["titulo"].toUpperCase() + '</h2>');
            $('#modalPr-precio').append(prices);
            $('#modalPr-cod').append('<span>' + cod_product + '</span>');
            $('#modalPr-desarrollo').append(desarrollo);
            $('#modalPr-stock').append('Cantidad: <input id="stockModal-' + productData["product"]["data"]["cod"] + '"  value="1" min="1" max="' + productData["product"]["data"]["stock"] + '" type="number">');

            $('#modalPr-button').append(buttons);
        }
    });


}

function appendProducts(data) {
    if (Array.isArray(data)) {
        if (data.length < limit) {
            disableLoadMore();
        }

    } else {
        /*notFound();*/
    }
}

function loader() {
    $('.grid-products').append("" +
        "<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12' id='loader'>" +
        "    <div class='product-wrap mb-10 mt-100 mb-400'>" +
        "        <div class='product-content text-center'>" +
        "            <i class='fa fa-circle-o-notch fa-spin fa-3x fs-70'></i>" +
        "        </div>" +
        "    </div>" +
        "</div>"
    );
}

function notFound() {
    reset();
    $('.grid-products').append("" +
        "<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>" +
        "    <div class='product-wrap mb-35'>" +
        "        <div class='product-content text-center'>" +
        "            <i class='fa fa-times-circle fs-100' style='color: red'></i>" +
        "            <h4>No se encontró ningun producto con esas características.</h4>" +
        "        </div>" +
        "    </div>" +
        "</div>"
    );
    disableLoadMore();
}

function reset() {
    $('.grid-products').html('');
}