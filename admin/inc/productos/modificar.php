<?php
require '../vendor/autoload.php';
$productos = new Clases\Productos();
$imagenes = new Clases\Imagenes();
$categoria = new Clases\Categorias();
$atributo = new Clases\Atributos();
$idiomaGet = isset($_GET["idioma"]) ? $funciones->antihack_mysqli($_GET["idioma"]) : $_SESSION['lang'];

$cod = isset($_GET["cod"]) ? $funciones->antihack_mysqli($_GET["cod"]) : '';
$borrarImg = isset($_GET["borrarImg"]) ? $funciones->antihack_mysqli($_GET["borrarImg"]) : '';
$categoriasData = $categoria->list(array("area = 'productos'"), "titulo ASC", "", $idiomaGet);
$data = [
    "filter" => ["productos.cod = '$cod'"],
    "admin" => true,
    "category" => true,
    "subcategory" => true,
    "images" => true,
];

$producto = $productos->list($data, $idiomaGet, true);
$atributo->set("productoCod", $producto['data']['cod']);
$atributosArray = $atributo->list();

//CAMBIAR ORDEN DE LAS IMAGENES
if (isset($_GET["ordenImg"]) && isset($_GET["idImg"])) {
    $imagenes->set("id", $funciones->antihack_mysqli($_GET["idImg"]));
    $imagenes->orden = $funciones->antihack_mysqli($_GET["ordenImg"]);
    $imagenes->setOrder();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=productos&accion=modificar&cod=$cod&idioma=$idiomaGet");
}
//BORRAR IMAGEN
if ($borrarImg != '') {
    $imagenes->set("id", $borrarImg);
    $imagenes->set("idioma", $idiomaGet);
    $imagenes->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=productos&accion=modificar&cod=$cod&idioma=$idiomaGet");
}

if (isset($_POST["modificar"])) {
    unset($_POST["modificar"]);
    $array = $funciones->antihackMulti($_POST);
    $productos->edit($array, ["cod = '$cod'", "idioma = '$idiomaGet'"]);
    if ($_FILES['files']) {
        $imagenes->resizeImagesWithLanguage($cod, $_FILES['files'], "../assets/archivos", "../assets/archivos/recortadas", $array["titulo"], [$idiomaGet]);
    }
    $funciones->headerMove(URL_ADMIN . "/index.php?op=productos&accion=ver&idioma=$idiomaGet");
}
?>
<section class="invoice-edit-wrapper mt-40">
    <h4 class="mb-20">Editar Producto</h4>
    <div class="row">
        <div class="col-xl-12 col-md-12 col-12 order-1">
            <?php
            if (!empty($error)) {
            ?>
                <div class="alert alert-danger" role="alert"><?= $error; ?></div>
            <?php
            }
            ?>
            <form method="post" id="form" enctype="multipart/form-data">
                <input type="hidden" name="idioma" value="<?= $idiomaGet ?>">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body py-0">
                            <div class="row my-2 py-50">
                                <div class="col-sm-8 col-12 order-1 order-sm-1">
                                    <h6 class="invoice-to">Titulo</h6>
                                    <input name="titulo" type="text" class="form-control" placeholder="Nombre del Producto" value="<?= $producto["data"]["titulo"] ?>" required>
                                </div>
                                <div class="col-sm-4 col-12 order-2 order-sm-1">
                                    <h6 class="invoice-to">Codigo</h6>
                                    <input name="cod_producto" type="text" class="form-control" placeholder="0000" value="<?= $producto["data"]["cod_producto"] ?>">
                                </div>
                            </div>
                            <hr>
                            <div class="row my-2 py-50">
                                <div class="col-sm-4 col-12 order-1 order-sm-1  mb-30">
                                    <h6 class="invoice-to">Categoria</h6>
                                    <select name="categoria" class="form-control bg-transparent select2" id="categoria" onchange="getCategory('<?= URL_ADMIN ?>','subcategory','categoria','subcategoria','<?=$idiomaGet?>')">
                                        <option value="">-- categorías --</option>
                                        <?php
                                        foreach ($categoriasData as $categoria) {
                                            if ($producto["data"]["categoria"] == $categoria["data"]["cod"]) {
                                                echo "<option value='" . $categoria["data"]["cod"] . "' selected>" . mb_strtoupper($categoria["data"]["titulo"]) . "</option>";
                                            } else {
                                                echo "<option value='" . $categoria["data"]["cod"] . "'>" . mb_strtoupper($categoria["data"]["titulo"]) . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-4 col-12 order-1 order-sm-1 mb-30">
                                    <h6 class="invoice-to">Subcategoria</h6>
                                    <select name="subcategoria" class="form-control bg-transparent select2" id="subcategoria">
                                        <option selected value="<?= $producto["data"]["subcategoria"] ?>"><?= $producto["data"]["subcategoria_titulo"] ?></option>
                                    </select>
                                </div>
                                <div class="col-sm-2 col-12 order-2 order-sm-1">
                                    <h6 class="invoice-to">Peso</h6>
                                    <div class="input-group">
                                        <input name="peso" type="number" step="any" class="form-control" placeholder="0.00" value="<?= $producto["data"]["peso"] ?>">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Kg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-12 order-2 order-sm-1">
                                    <h6 class="invoice-to">Stock</h6>
                                    <input name="stock" type="text" class="form-control" placeholder="0000" value="<?= $producto["data"]["stock"] ?>">
                                </div>
                                <div class="col-sm-4 col-12 order-2 order-sm-1">
                                    <h6 class="invoice-to">Precio</h6>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input name="precio" type="number" step="any" class="form-control" placeholder="0.00" value="<?= $producto["data"]["precio"] ? $producto["data"]["precio"] : '0' ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-12 order-1 order-sm-1">
                                    <h6 class="invoice-to">Precio Descuento</h6>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input name="precio_descuento" type="number" step="any" class="form-control" placeholder="0.00" value="<?= $producto["data"]["precio_descuento"] ? $producto["data"]["precio_descuento"] : '0' ?>">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-12 order-1 order-sm-1">
                                    <h6 class="invoice-to">Precio Mayorista</h6>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input name="precio_mayorista" type="number" step="any" class="form-control" placeholder="0.00" value="<?= $producto["data"]["precio_mayorista"] ? $producto["data"]["precio_mayorista"] : '0' ?>">
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row my-2 py-50">
                                <div class="col-sm-6 col-12 order-1 order-sm-1">
                                    <button href="<?= URL_ADMIN ?>/inc/productos/api/atributos/atributosAgregar.php?cod=<?= $cod ?>" data-title="Agregar Atributos" class="btn btn-info modal-page-ajax">AGREGAR ATRIBUTOS +</button>
                                    <div id="listAttr">

                                    </div>
                                </div>
                                <div class="col-sm-6 col-12 order-2 order-sm-2">
                                    <button href="<?= URL_ADMIN ?>/inc/productos/api/variaciones/variacionesAgregar.php?cod=<?= $cod ?>" data-title="Agregar Variaciones" id="variaciones" class="btn btn-info modal-page-ajax">AGREGAR VARIACIONES +</button>
                                    <div id="listComb" class=""></div>
                                </div>
                            </div>
                            <hr>

                            <div class="row my-2 py-50">
                                <div class="col-sm-12 col-12 order-1 order-sm-1">
                                    <h6 class="invoice-to">Desarrollo</h6>
                                    <textarea name="desarrollo" class="form-control ckeditorTextarea"><?= $producto["data"]["desarrollo"] ?></textarea>
                                </div>
                                <div class="col-sm-12 col-12 order-2 order-sm-2 mt-20">
                                    <h6 class="invoice-to">Palabras Claves divididas por " , "</h6>
                                    <input name="keywords" class="form-control" type="text" value="<?= $producto["data"]["keywords"] ?>">
                                </div>
                                <div class="col-sm-12 col-12 order-3 order-sm-3  mt-20">
                                    <h6 class="invoice-to">Descripcion Breve</h6>
                                    <textarea name="description" class="form-control char-textarea" data-lenght="200" maxlength="200"><?= $producto["data"]["description"] ?></textarea>
                                    <small class="counter-value float-right mr-0" style="background-color: rgb(90, 141, 238);"><span class="char-count"><?= strlen($producto["data"]["description"]) ?></span> / 200 </small>
                                </div>
                            </div>
                            <hr>
                            <div class="repeater-default">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="bold mb-10 col-md-12">Los datos variables sirven para agregar más opciones a los productos, son variables del producto:</div>
                                        <?php for ($i = 1; $i <= 10; $i++) { ?>
                                            <div class="col-sm-3 col-12 order-<?= $i ?> order-sm-<?= $i ?>">
                                                <h6 class="invoice-to">Dato extra <?= $i ?></h6>
                                                <input type="text" class="form-control" name="variable<?= $i ?>" value="<?= isset($producto["data"]["variable$i"]) ? $producto["data"]["variable$i"] : ''; ?>">
                                            </div>
                                        <?php }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row my-2 py-50">
                                 <?php
                            if (isset($producto['images'][0]['id']) && !empty($producto['images'])) {
                                foreach ($producto['images'] as $key => $img) {
                                    $img_id = $img['id'];

                            ?>
                                    <div class='col-md-2 mb-20 mt-20'>
                                        <div style="height:200px;background:url('<?= $img['url'] ?>') no-repeat center center/contain;">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mt-10">
                                                <a href="<?= URL_ADMIN . '/index.php?op=productos&accion=modificar&cod=' . $cod . '&borrarImg=' . $img_id . '&idioma=' . $idiomaGet ?>" class="btn btn-sm btn-block btn-danger">
                                                    BORRAR IMAGEN
                                                </a>
                                            </div>
                                            <div class="col-md-6 mt-10">
                                                <select onchange='$(location).attr("href", "<?= CANONICAL ?>&idImg=<?= $img_id ?>&ordenImg="+$(this).val())'>
                                                    <?php
                                                    for ($i = 0; $i < count($producto['images']); $i++) {
                                                    ?>
                                                        <option value='<?= $i ?>' <?= ($img['orden'] == $i) ? 'selected' : '' ?>><?= $i ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <i>orden</i>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
                                <div class="col-sm-12 col-12 order-1 order-sm-1">
                                    <h6 class="invoice-to">Imagenes</h6>
                                    <input name="files[]" class="form-control form-control-md" style="border:none" type="file" id="file" multiple="multiple" accept="image/*" />
                                </div>
                            </div>
                            <div class="row my-2 py-50">
                                <div class="col-sm-3 col-3 order-2 order-sm-2 mt-20">
                                    <div class="custom-control custom-switch custom-switch-glow ml-10">
                                        <span class="invoice-terms-title"> Mostrar en la Web</span>
                                        <input name="mostrar_web" type="checkbox" id="mostrar_web" class="custom-control-input" value="1" <?= ($producto["data"]["mostrar_web"] == 1) ? "checked" : "" ?>>
                                        <label class="custom-control-label" for="mostrar_web">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-3 order-3 order-sm-3  mt-20">
                                    <div class="custom-control custom-switch custom-switch-glow ml-10">
                                        <span class="invoice-terms-title"> Envio Gratis</span>
                                        <input name="envio_gratis" type="checkbox" id="envioGratis" class="custom-control-input" value="1" <?= ($producto["data"]["envio_gratis"] == 1) ? "checked" : "" ?>>
                                        <label class="custom-control-label" for="envioGratis">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-20">
                                <input type="submit" class="btn btn-primary btn-block subtotal-preview-btn" id="guardar" name="modificar" value="Modificar Producto" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<script>
    function checkAttrProducts() {
        $.ajax({
            url: "<?= URL_ADMIN ?>/inc/productos/api/atributos/atributosVer.php",
            type: "GET",
            data: {
                cod: "<?= $cod ?>"
            },
            success: function(data) {
                data = JSON.parse(data);
                $('#listAttr').html('');
                if (data.length != 0) {
                    for (i = 0; i < data.length; i++) {
                        var texto = "<strong>" + data[i]["atribute"]["value"] + ": </strong>";
                        for (o = 0; o < data[i]["atribute"]["subatributes"].length; o++) {
                            texto += data[i]["atribute"]["subatributes"][o]["value"] + " | ";
                        }
                        $('#listAttr').append("<span class='text-uppercase'>" + texto + "</span>");
                        $('#listAttr').append(
                            "<span class='mt-10 ml-10 btn btn-warning btn-sm text-uppercase' onclick='openModal(\"<?= URL_ADMIN ?>/inc/productos/api/atributos/atributosModificar.php?cod=" + data[i]['atribute']['cod'] + "\",\"Modificar " + data[i]['atribute']['value'] + "\")'><i class='fa fa-edit'></i></span><br/>");
                    }
                }
            },
            error: function() {
                alert('Error occured');
            }
        });
    }

    function checkCombProducts() {
        $.ajax({
            url: "<?= URL_ADMIN ?>/inc/productos/api/variaciones/variacionesVer.php",
            type: "GET",
            data: {
                cod: "<?= $cod ?>"
            },
            success: function(data) {
                data = JSON.parse(data);
                $('#listComb').html('');
                if (data.length != 0) {
                    for (i = 0; i < data.length; i++) {
                        var texto = "";
                        for (o = 0; o < data[i]["combination"].length; o++) {
                            texto += data[i]["combination"][o]["value"] + " | ";
                        }
                        texto += " <strong>Precio:</strong> $" + data[i]['detail']['precio'] + " <strong>Stock:</strong> " + data[i]['detail']['stock'];
                        if (data[i]['detail']['mayorista'] > 0) {
                            texto += " <strong>Precio Mayorista:</strong> $" + data[i]['detail']['mayorista'];
                        } else {
                            texto += " <strong>Precio Mayorista:</strong> No posee";
                        }
                        $('#listComb').append("<span class='text-uppercase '>" + texto + "</span>");
                        $('#listComb').append(
                            "<span class='mt-10 ml-10 btn btn-warning btn-sm text-uppercase' onclick='openModal(\"<?= URL_ADMIN ?>/inc/productos/api/variaciones/variacionesModificar.php?cod=" + data[i]['detail']['cod_combinacion'] + "&product=" + data[i]['product'] + "\",\"Modificar " + "\")'><i class='fa fa-edit'></i></span><br/>");
                    }
                }
            },
            error: function() {
                alert('Error occured');
            }
        });
    }

    checkAttrProducts();
    checkCombProducts();
</script>