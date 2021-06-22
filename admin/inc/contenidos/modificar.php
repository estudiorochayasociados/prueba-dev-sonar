<?php
$contenido = new Clases\Contenidos();
$area = new Clases\Area();
$imagenes = new Clases\Imagenes();
$categorias = new Clases\Categorias();

$getArea = isset($_GET["area"]) ? $funciones->antihack_mysqli($_GET["area"]) : '';
$cod = isset($_GET["cod"]) ? $funciones->antihack_mysqli($_GET["cod"]) : '';
$borrarImg = isset($_GET["borrarImg"]) ? $funciones->antihack_mysqli($_GET["borrarImg"]) : '';
$idiomaGet = isset($_GET["idioma"]) ? $funciones->antihack_mysqli($_GET["idioma"]) : $_SESSION['lang'];

$areaData = $area->list(["cod = '$getArea'"], '', '', $idiomaGet, true);

$categoriasData = $categorias->list(["area = '$getArea'"], "titulo ASC", '', $idiomaGet);
$contenidoSingle = $contenido->list(["filter" => ["cod = '$cod'"], "images" => true], $idiomaGet, true);

//CAMBIAR ORDEN DE LAS IMAGENES
if (isset($_GET["ordenImg"]) && isset($_GET["idImg"])) {
    $imagenes->set("id", $funciones->antihack_mysqli($_GET["idImg"]));
    $imagenes->orden = $funciones->antihack_mysqli($_GET["ordenImg"]);
    $imagenes->setOrder();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=contenidos&area=$getArea&accion=modificar&cod=$cod&idioma=$idiomaGet");
}
//BORRAR IMAGEN
if ($borrarImg != '') {
    $imagenes->set("id", $borrarImg);
    $imagenes->set("idioma", $idiomaGet);
    $imagenes->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=contenidos&area=$getArea&accion=modificar&cod=$cod&idioma=$idiomaGet");
}
if (isset($_POST["modificar"])) {
    unset($_POST["modificar"]);
    unset($_POST["idioma"]);
    unset($_POST["cod"]);
    $array = $funciones->antihackMulti($_POST);
    $contenido->edit($array, ["cod = '$cod'", "idioma = '$idiomaGet'"]);
    if ($_FILES['files']) {
        $imagenes->resizeImagesWithLanguage($cod, $_FILES['files'], "../assets/archivos", "../assets/archivos/recortadas", $array["titulo"], [$idiomaGet]);
    }
    $funciones->headerMove(URL_ADMIN . "/index.php?op=contenidos&accion=ver&area=$getArea&idioma=$idiomaGet");
}
?>
<div class="mt-20 card">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-uppercase text-center">
                <?= $areaData['data']['titulo'] ?>
            </h4>
            <hr style="border-style: dashed;">
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="post" class="row" enctype="multipart/form-data">
                    <input type="hidden" name="idioma" value="<?= $idiomaGet ?>">
                    <label class="col-md-5">
                        Título
                        <input type="text" value="<?= $contenidoSingle['data']["titulo"] ?>" name="titulo">
                    </label>
                    <label class="col-md-4">
                        Subtitulo
                        <input type="text" id="sub" value="<?= $contenidoSingle['data']["subtitulo"] ?>" name="subtitulo">
                    </label>
                    <label class="col-md-3">
                        Código:<br />
                        <input type="text" name="cod" disabled value="<?= $contenidoSingle["data"]["cod"] ?>">
                    </label>
                    <label class="col-md-5">
                        Categoría:<br />
                        <select name="categoria">
                            <option value="">-- categorías --</option>
                            <?php
                            foreach ($categoriasData as $categoria) {
                                $selected = ($contenidoSingle["data"]["categoria"] == $categoria["data"]["cod"]) ? "selected" : '';
                                echo "<option value='" . $categoria["data"]["cod"] . "' $selected >" . mb_strtoupper($categoria["data"]["titulo"]) . "</option>";
                            }
                            ?>
                        </select>
                    </label>
                    <label class="col-md-4">
                        Subcategoría:<br />
                        <select name="subcategoria">
                            <option value="">-- Sin subcategoría --</option>
                            <?php
                            foreach ($categoriasData as $categoria) {
                            ?>
                                <optgroup label="<?= mb_strtoupper($categoria["data"]['titulo']) ?>">
                                    <?php
                                    foreach ($categoria["subcategories"] as $subcategorias) {
                                        $selected = ($contenidoSingle["data"]["subcategoria"] == $subcategorias["data"]["cod"]) ? "selected" : '';
                                        echo "<option value='" . $subcategorias["data"]["cod"] . "' $selected >" . mb_strtoupper($subcategorias["data"]["titulo"]) . "</option>";
                                    }
                                    ?>
                                </optgroup>
                            <?php
                            }
                            ?>
                        </select>
                    </label>
                    <label class="col-md-3">
                        Fecha:<br />
                        <input type="date" name="fecha" value="<?= $contenidoSingle["data"]["fecha"] ?>">
                    </label>

                    <div class="col-md-12">
                        <hr style="border-style: dashed;">
                    </div>
                    <label class="col-md-12">
                        Contenido:<br />
                        <textarea name="contenido" class="ckeditorTextarea" required>
                            <?= $contenidoSingle["data"]["contenido"]; ?>
                        </textarea>
                    </label>
                    <div class="col-md-12">
                        <hr style="border-style: dashed;">
                    </div>
                    <label class="col-md-12">
                        Palabras claves dividas por ,<br />
                        <input type="text" name="keywords" value="<?= $contenidoSingle["data"]["keywords"] ?>">
                    </label>
                    <label class="col-md-12">
                        Descripción breve<br />
                        <textarea name="description"><?= $contenidoSingle["data"]["description"] ?></textarea>
                    </label>
                    <br />
                    <label class="col-md-12">Link
                        <input type="text" id="link" name="link" value="<?= $contenidoSingle["data"]["link"] ?>">
                    </label>
                    <div class="col-md-12">
                        <div class="row">
                            <?php
                            if (isset($contenidoSingle['images']) && !empty($contenidoSingle['images'])) {
                                foreach ($contenidoSingle['images'] as $key => $img) {
                                    $img_id = $img['id'];

                            ?>
                                    <div class='col-md-2 mb-20 mt-20'>
                                        <div style="height:200px;background:url('<?= $img['url'] ?>') no-repeat center center/contain;">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mt-10">
                                                <a href="<?= URL_ADMIN . '/index.php?op=contenidos&accion=modificar&area=' . $getArea . '&cod=' . $cod . '&borrarImg=' . $img_id . '&idioma=' . $idiomaGet ?>" class="btn btn-sm btn-block btn-danger">
                                                    BORRAR IMAGEN
                                                </a>
                                            </div>
                                            <div class="col-md-6 mt-10">
                                                <select onchange='$(location).attr("href", "<?= CANONICAL ?>&idImg=<?= $img_id ?>&ordenImg="+$(this).val())'>
                                                    <?php
                                                    for ($i = 0; $i < count($contenidoSingle['images']); $i++) {
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
                        </div>
                    </div>
                    <div class="clearfix">
                    </div>
                    <div class="col-md-12">
                        <hr style="border-style: dashed;">
                    </div>
                    <label class="col-md-12">
                        Imágenes:<br />
                        <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" />
                    </label>
                    <div class="clearfix">
                    </div>
                    <br />
                    <div class="col-md-12 mt-20">
                        <input type="submit" class="btn btn-block btn-primary" name="modificar" value="Modificar" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>