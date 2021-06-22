var start = 0;
var limit = 25;
var order = '';
var url_admin = $("#grid-products").attr("data-url");
var idioma = $("#grid-products").attr("data-idioma");
const url = $("#grid-products").attr("data-url");
var nameColumn = localStorage.getItem("key") ? localStorage.getItem("key") : '';
var shcolumn;
var position = 0;

$(document).ready(() => {
    getData();

});

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

function reset() {
    $('#grid-products').html('');
}

function toggleColumn(name = '') {
    var nameColumn = localStorage.getItem("key") ? localStorage.getItem("key") : '';
    if (name != '' || name != undefined || name != null) {
        if (nameColumn.indexOf("," + name) == -1) {
            newNameColumn = nameColumn + "," + name;
            localStorage.setItem("key", newNameColumn);
            var shcolumn = "." + name;
            $(shcolumn).toggle();
        } else {
            $("." + name).show();
            newNameColumn = nameColumn.replace("," + name, "")
            localStorage.setItem("key", newNameColumn);
        }
    }
}



function hideColumnLoadMore() {
    if (localStorage.getItem("key") != null) {
        key = localStorage.getItem("key").split(",");
        key.forEach(name => {
            if (name) {
                $("#lb-" + name).attr("checked", "true");
                $("." + name).hide();
            }
        });
    }
}

function getData(type, cod_ = '') {
    const list = (type != 'add') ? true : false;

    if (list) {
        toggleColumn('mostrar_web');
        toggleColumn('meli');
        toggleColumn('envio_gratis');
        toggleColumn('keywords');
    }
    if (url_admin) {}
    $.ajax({
        url: url_admin + "/api/productos/list.php?start=" + start + "&limit=" + limit + "&order=" + order + "&idioma=" + idioma,
        type: "GET",
        data: $('#filter-form').serialize(),
        success: async(data) => {
            var data = JSON.parse(data);
            (list) ? reset(): enableLoadMore();
            (data.product.length) ? '' : disableLoadMore();
            data.product.forEach(elementProduct => {
                var cod = elementProduct['data']['cod'];
                var idioma = elementProduct['data']['idioma'];
                var cod_product = elementProduct['data']['cod_producto'];
                var meliAdd = (elementProduct['data']['meli'] == 1) ? 'd-none' : '';
                var meliDelete = (elementProduct['data']['meli'] == 1) ? '' : 'd-none';
                var mostrar_web = (elementProduct['data']['mostrar_web'] == 1) ? 'checked' : '';
                var envio_gratis = (elementProduct['data']['envio_gratis'] == 1) ? 'checked' : '';
                var txtCod = elementProduct['data']['cod_producto'] != null ? '<br/><span class="invoice-customer"> <b>COD:</b>' + elementProduct['data']['cod_producto'] + '</span>' : '';
                var precio = elementProduct['data']['precio'] == null ? ' ' : elementProduct['data']['precio'];
                var precio_descuento = elementProduct['data']['precio_descuento'] == null ? ' ' : elementProduct['data']['precio_descuento'];
                var precio_mayorista = elementProduct['data']['precio_mayorista'] == null ? ' ' : elementProduct['data']['precio_mayorista'];
                var keywords = elementProduct['data']['keywords'] == null ? ' ' : elementProduct['data']['keywords'];
                var stock = elementProduct['data']['stock'] == null ? ' ' : elementProduct['data']['stock'];
                var peso = elementProduct['data']['peso'] == null ? ' ' : elementProduct['data']['peso'];
                if (data.category != '') {
                    var catData = listOptionCat(data.category, elementProduct['data']['categoria']);
                    var subcatData = listOptionSubcat(data.category, elementProduct['data']['subcategoria'], elementProduct['data']['categoria']);
                }
                var productData = `
                    <tr id='` + cod + `'  >
                    <td class="titulo"  >
                        <input class="borderInputBottom invoice-customer" style="width:300px !important"   onchange='editProduct("` + idioma + `","titulo-` + cod + `","` + url_admin + `")' id='titulo-` + cod + `' name='titulo' value='` + elementProduct['data']['titulo'] + `' />
                         ` + txtCod + `
                    </td>
                    <td class="precio"><input class="borderInputBottom invoice-amount" style='width:auto' onchange='editProduct("` + idioma + `","precio-` + cod + `","` + url_admin + `")' id='precio-` + cod + `' name='precio' value='` + precio + `' /></td>
                    <td class="precio_descuento"> <input class="borderInputBottom" style='width:auto' onchange='editProduct("` + idioma + `","precio_descuento-` + cod + `","` + url_admin + `")' id='precio_descuento-` + cod + `' name='precio_descuento' value='` + precio_descuento + `' /></td>
        
                    <td class="precio_mayorista"> <input class="borderInputBottom" style='width:auto' onchange='editProduct("` + idioma + `","precio_mayorista-` + cod + `","` + url_admin + `")' id='precio_mayorista-` + cod + `' name='precio_mayorista' value='` + precio_mayorista + `' /></td>
                    <td class="categoria">
                        <select style="width: 150px;" class="form-control fs-12 invoice-item-select" onchange='editProduct("` + idioma + `","categoria-` + cod + `","` + url_admin + `")' id='categoria-` + cod + `' name='categoria' value='#categoria option:selected'>
                        <option value="">-- categorías --</option>
                         ` + catData + `
                        </select >
                    </td >
                     <td class="subcategoria">
                        <select style="width: 150px;" class="form-control fs-12 invoice-item-select select2" onchange='editProduct("` + idioma + `","subcategoria-` + cod + `","` + url_admin + `")' id='subcategoria-` + cod + `' name='subcategoria' value='#subcategoria option:selected'>
                            ` + subcatData + `
                        </select>
                    </td>
                    <td class="keywords"><input class=" borderInputBottom" style='width:auto' onchange='editProduct("` + idioma + `","keywords-` + cod + `","` + url_admin + `")' id='keywords-` + cod + `' name='keywords' value='` + keywords + `' /></td>
                    <td class="stock"><input class=" borderInputBottom" style='width:auto' onchange='editProduct("` + idioma + `","stock-` + cod + `","` + url_admin + `")' id='stock-` + cod + `' name='stock' value='` + stock + `' /></td>
                    <td class="peso"><input class="borderInputBottom" style='width:auto' onchange='editProduct("` + idioma + `","peso-` + cod + `","` + url_admin + `")' id='peso-` + cod + `' name='peso' value='` + peso + `' />kg</td>
                    <td class="meli" width="80" class="text-center">
                    <button class="btn btn-info ` + meliAdd + `" data-toggle="modal" data-target="#modalAdd" id="btn-add-modal-` + cod_product + `" onclick="meliModal('` + cod + `')">VINCULAR</button>
                    <button class="btn btn-danger  ` + meliDelete + `"  id="btn-delete-modal-` + cod_product + `" >Vinculado</button>
                    </td>
                    <td class="envio_gratis" width="80" class="text-center">
                        <input type="checkbox" class=" borderInputBottom" style='width:auto' onchange='changeStatus("envio_gratis-` + cod + `","` + url_admin + `")' id='envio_gratis-` + cod + `' name='envio_gratis' ` + envio_gratis + ` />
                    </td>
                    <td class="motrar_web" width="80" class="text-center">
                        <input type="checkbox" class=" borderInputBottom" style='width:auto' onchange='changeStatus("mostrar_web-` + cod + `","` + url_admin + `")' id='mostrar_web-` + cod + `' name='mostrar_web' ` + mostrar_web + ` />
                    </td>
                    <td class="text-left ">
                        <div class="btn-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <a data-toggle="tooltip" data-placement="top" title="Modificar" href="` + url_admin + `/index.php?op=productos&accion=modificar&cod=` + elementProduct['data']['cod'] + `&idioma=` + elementProduct['data']['idioma'] + `">
                                        <span class=" badge badge-light-secondary">
                                            <div class="fonticon-wrap">
                                                <i class="bx bx-cog fs-20" style="color:#666;"></i>
                                            </div>
                                        </span>
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a class"deleteConfirm" data-toggle="tooltip" data-placement="top" title="Eliminar" href="` + url_admin + `/index.php?op=productos&accion=ver&borrar=` + elementProduct['data']['cod'] + `&idioma=` + elementProduct['data']['idioma'] + ` ">
                                        <span class=" badge badge-light-danger">
                                            <div class="fonticon-wrap">
                                                <i class="bx bx-trash fs-20" style="color:#666;"></i>
                                            </div>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr >`;
                $('#grid-products').append(productData);
            });
            await hideColumnLoadMore();
        }
    });
}

function listOptionCat(category, productCod) {
    var catData = "";
    category.forEach(elementCategory => {
        if (productCod == elementCategory['data']['cod']) {
            catData += ` <option value='` + elementCategory['data']['cod'] + `' selected >` + elementCategory['data']['titulo'].toUpperCase() + `</option>`;
        } else {
            catData += ` <option value='` + elementCategory['data']['cod'] + `'>` + elementCategory['data']['titulo'].toUpperCase() + `</option>`;
        }
    });
    return catData;
}

function listOptionSubcat(category, productCodSubCat, codCat) {
    var subcatData = "";
    category.forEach(elementCategory => {
        if(elementCategory['subcategories'] != ''){
        elementCategory['subcategories'].forEach(elementSubcategory => {
            if (elementSubcategory['data']['categoria'] == codCat) {
                if (productCodSubCat == elementSubcategory['data']['cod']) {
                    subcatData += ` <option value='` + elementSubcategory['data']['cod'] + `' selected >` + elementSubcategory['data']['titulo'].toUpperCase() + `</option>`;
                } else {
                    subcatData += ` <option value='` + elementSubcategory['data']['cod'] + `'>` + elementSubcategory['data']['titulo'].toUpperCase() + `</option>`;
                }
            }
        });
    }
    });
    return subcatData;
}