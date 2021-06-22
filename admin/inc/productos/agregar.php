<?php
$productos = new Clases\Productos();
$idiomas = new Clases\Idiomas();
$imagenes = new Clases\Imagenes();
$categoria = new Clases\Categorias();
$atributo = new Clases\Atributos();
$subatributo = new Clases\Subatributos();
$idiomaGet = isset($_GET["idioma"]) ? $funciones->antihack_mysqli($_GET["idioma"]) : $_SESSION['lang'];
$cod = substr(md5(uniqid(rand())), 0, 10);
$categoriasData = $categoria->list(array("area = 'productos'"), "titulo ASC", "", $idiomaGet);
if (isset($_POST["agregar"])) {
    unset($_POST["agregar"]);
    if (isset($_POST["idiomasInput"])) {
        $idiomasInputPost =  $_POST["idiomasInput"];
        $idiomasInputPost[] = $idiomaGet;
    } else {
        $idiomasInputPost = [$idiomaGet];
    }
    unset($_POST["idiomasInput"]);
    $cod = $funciones->antihack_mysqli($_POST["cod"]);
    $array = $funciones->antihackMulti($_POST);
    if (isset($idiomasInputPost) && !empty($idiomasInputPost)) {
        foreach ($idiomasInputPost as $idiomasInputItem) {
            $array["idioma"] = $idiomasInputItem;
            $productos->add($array);
        }
    }
    if (isset($_FILES['files'])) {
        $imagenes->resizeImagesWithLanguage($cod, $_FILES['files'], "../assets/archivos", "../assets/archivos/recortadas", $array["titulo"], $idiomasInputPost);
    }
    $funciones->headerMove(URL_ADMIN . '/index.php?op=productos&accion=ver&idioma=' . $idiomaGet);
}



?>
<section class="invoice-edit-wrapper mt-40">
    <h4 class="mb-20">Agregar Producto</h4>
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
                <input type="hidden" name="cod" value="<?= $cod ?>">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body py-0">
                            <div class="row my-2 py-50">
                                <div class="col-sm-8 col-12 order-1 order-sm-1">
                                    <h6 class="invoice-to">Titulo</h6>
                                    <input name="titulo" type="text" class="form-control" placeholder="Nombre del Producto" required>
                                </div>
                                <div class="col-sm-4 col-12 order-2 order-sm-1">
                                    <h6 class="invoice-to">Codigo</h6>
                                    <input name="cod_producto" type="text" class="form-control" placeholder="0000">
                                </div>
                            </div>
                            <hr>
                            <div class="row my-2 py-50">
                                <div class="col-sm-4 col-12 order-1 order-sm-1  mb-30">
                                    <h6 class="invoice-to">Categoria</h6>
                                    <select name="categoria" class="form-control bg-transparent select2" id="categoria" onchange="getCategory('<?= URL_ADMIN ?>','subcategory','categoria','subcategoria')">
                                        <option value="">-- categorías --</option>
                                        <?php
                                        foreach ($categoriasData as $categoria) {
                                            echo "<option value='" . $categoria["data"]["cod"] . "'>" . mb_strtoupper($categoria["data"]["titulo"]) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-4 col-12 order-1 order-sm-1 mb-30">
                                    <h6 class="invoice-to">Subcategoria</h6>
                                    <select name="subcategoria" class="form-control bg-transparent select2" id="subcategoria"></select>

                                </div>
                                <div class="col-sm-2 col-12 order-2 order-sm-1">
                                    <h6 class="invoice-to">Peso</h6>
                                    <div class="input-group">
                                        <input name="peso" type="number" step="any" class="form-control" placeholder="0.00">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Kg</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 col-12 order-2 order-sm-1">
                                    <h6 class="invoice-to">Stock</h6>
                                    <input name="stock" type="text" class="form-control" placeholder="0000">
                                </div>
                                <div class="col-sm-4 col-12 order-2 order-sm-1">
                                    <h6 class="invoice-to">Precio</h6>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input name="precio" type="number" step="any" class="form-control" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-12 order-1 order-sm-1">
                                    <h6 class="invoice-to">Precio Descuento</h6>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input name="precio_descuento" type="number" step="any" class="form-control" placeholder="0.00">
                                    </div>
                                </div>
                                <div class="col-sm-4 col-12 order-1 order-sm-1">
                                    <h6 class="invoice-to">Precio Mayorista</h6>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input name="precio_mayorista" type="number" step="any" class="form-control" placeholder="0.00">
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
                                    <textarea name="desarrollo" class="form-control ckeditorTextarea"><?= isset($_POST["desarrollo"]) ? $_POST["desarrollo"] : ''; ?></textarea>
                                </div>
                                <div class="col-sm-12 col-12 order-2 order-sm-2 mt-20">
                                    <h6 class="invoice-to">Palabras Claves divididas por " , "</h6>
                                    <input name="keywords" class="form-control" type="text" value="<?= isset($_POST["keywords"]) ? $_POST["keywords"] : ''; ?>">
                                </div>
                                <div class="col-sm-12 col-12 order-3 order-sm-3  mt-20">
                                    <h6 class="invoice-to">Descripcion Breve</h6>
                                    <textarea name="description" class="form-control char-textarea" data-lenght="200" maxlength="200"><?= isset($_POST["description"]) ? $_POST["description"] : ''; ?></textarea>
                                    <small class="counter-value float-right mr-0" style="background-color: rgb(90, 141, 238);"><span class="char-count">0</span> / 200 </small>
                                </div>
                            </div>
                            <hr>
                            <div class="repeater-default">
                                <div class="form-group">
                                    <div class="col p-0">
                                        <a class="btn btn-primary" style="color:white" onclick="$('#variables').removeClass('hidden');"><i class="bx bx-plus"></i>
                                            Datos Variables Extras
                                        </a>
                                    </div>
                                </div>
                                <div class="row hidden" id="variables">
                                    <div class="bold mb-10 col-md-12">Los datos variables sirven para agregar más opciones a los productos, son variables del producto:</div>
                                    <?php for ($i = 1; $i <= 10; $i++) { ?>
                                        <label class="col-md-2">DATO VARIABLE <?= $i ?>:<br />
                                            <input type="text" name="variable<?= $i ?>" value="<?= isset($_POST["variable$i"]) ? $_POST["variable$i"] : ''; ?>">
                                        </label>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row my-2 py-50">
                                <div class="col-sm-6 col-12 order-1 order-sm-1">
                                    <h6 class="invoice-to">Imagenes</h6>
                                    <input name="files[]" class="form-control form-control-md" style="border:none" type="file" id="file" multiple="multiple" accept="image/*" />
                                </div>
                                <div class="col-sm-3 col-3 order-2 order-sm-2 mt-20">

                                    <div class="custom-control custom-switch custom-switch-glow ml-10">
                                        <span class="invoice-terms-title"> Mostrar en la Web</span>
                                        <input name="mostrar_web" type="checkbox" id="mostrar_web" class="custom-control-input" value="1">
                                        <label class="custom-control-label" for="mostrar_web">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-3 order-3 order-sm-3  mt-20">

                                    <div class="custom-control custom-switch custom-switch-glow ml-10">
                                        <span class="invoice-terms-title"> Envio Gratis</span>
                                        <input name="envioGratis" type="checkbox" id="envioGratis" class="custom-control-input" value="1">
                                        <label class="custom-control-label" for="envioGratis">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="btn btn-primary mt-10 mb-10" onclick="$('#idiomasCheckBox').show()">Republicar producto en otros idiomas</div>
                                <div class="row" id="idiomasCheckBox">
                                    <?php foreach ($idiomas->list(["cod != '$idiomaGet'"], "", "") as $idiomaItem) { ?>
                                        <div class="ml-10">
                                            <label for="idioma<?= $idiomaItem['data']['cod'] ?>">
                                                <input type="checkbox" name="idiomasInput[]" value="<?= $idiomaItem['data']['cod'] ?>" id="idioma<?= $idiomaItem['data']['cod'] ?>"> <?= $idiomaItem['data']['titulo'] ?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-12 mt-20">
                                <input type="submit" class="btn btn-primary btn-block subtotal-preview-btn" id="guardar" name="agregar" value="Crear Producto" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>


<!-- todo: pasar a script -->
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
                        $('#listAttr').append("<span class='text-uppercase mt-10'>" + texto + "</span>");
                        $('#listAttr').append(
                            "<span class='mt-10 ml-10 btn btn-warning btn-sm text-uppercase' onclick='openModal(\"<?= URL_ADMIN ?>/inc/productos/api/atributos/atributosModificar.php?cod=" + data[i]['atribute']['cod'] + "\",\"Modificar " + data[i]['atribute']['value'] + "\")'><i class='fa fa-edit'></i></span><br/>");
                    }

                    $('#variaciones').attr('disabled', false);
                    //si existen atributos mostrar variaciones
                    checkCombProducts();
                } else {
                    $('#variaciones').attr('disabled', true);
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
                        $('#listComb').append("<span class='text-uppercase mt-10'>" + texto + "</span>");
                        $('#listComb').append(
                            "<span class='mt-10 ml-10  btn btn-warning btn-sm text-uppercase' onclick='openModal(\"<?= URL_ADMIN ?>/inc/productos/api/variaciones/variacionesModificar.php?cod=" + data[i]['detail']['cod_combinacion'] + "&product=" + data[i]['product'] + "\",\"Modificar " + "\")'><i class='fa fa-edit'></i></span><br/>");
                    }
                }
            },
            error: function() {
                alert('Error occured');
            }
        });
    }

    checkCombProducts();
    checkAttrProducts();
</script>
<script>
    $('#idiomasCheckBox').hide();
</script>