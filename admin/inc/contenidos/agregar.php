 <?php
    $contenido = new Clases\Contenidos();
    $idiomas = new Clases\Idiomas();
    $area = new Clases\Area();
    $imagenes = new Clases\Imagenes();
    $categorias = new Clases\Categorias();

    $getArea = isset($_GET["area"]) ? $funciones->antihack_mysqli($_GET["area"]) : '';
    $idiomaGet = isset($_GET["idioma"]) ? $funciones->antihack_mysqli($_GET["idioma"]) : $_SESSION['lang'];

    $areaData = $area->list(["cod = '$getArea'"], '', '', $idiomaGet, true);

    $categoriasData = $categorias->list(["area = '$getArea'"], "titulo ASC", "", $idiomaGet);
    $cod = substr(md5(uniqid(rand())), 0, 10);

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
                $contenido->add($array);
            }
        }
        if (isset($_FILES['files'])) {
            $imagenes->resizeImagesWithLanguage($cod, $_FILES['files'], "../assets/archivos", "../assets/archivos/recortadas", $array["titulo"], $idiomasInputPost);
        }
        $funciones->headerMove(URL_ADMIN . "/index.php?op=contenidos&accion=ver&area=" . $areaData['data']['cod'] . "&idioma=" . $idiomaGet);
    }
    ?>

 <div class="mt-20 ">
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
                     <hr />
                     <input type="hidden" name="area" value="<?= $getArea ?>">
                     <label class="col-md-5">Título
                         <input type="text" name="titulo" required>
                     </label>
                     <label class="col-md-5">Subtitulo
                         <input type="text" id="sub" name="subtitulo">
                     </label>
                     <label class="col-md-2">Código:<br />
                         <input type="text" name="cod" value="<?= $cod ?>">
                     </label>
                     <label class="col-md-4">
                         Categoría:<br />
                         <select name="categoria">
                             <option value="" selected>-- categorías --</option>
                             <?php
                                foreach ($categoriasData as $categoria) {
                                    echo "<option value='" . $categoria["data"]["cod"] . "'>" . mb_strtoupper($categoria["data"]["titulo"]) . "</option>";
                                }
                                ?>
                         </select>
                     </label>
                     <label class="col-md-4">
                         Subcategoría:<br />
                         <select name="subcategoria">
                             <option value="" selected>-- Sin subcategoría --</option>
                             <?php
                                foreach ($categoriasData as $categoria) {
                                ?>
                                 <optgroup label="<?= mb_strtoupper($categoria["data"]['titulo']) ?>">
                                     <?php
                                        foreach ($categoria["subcategories"] as $subcategorias) {
                                            echo "<option value='" . $subcategorias["data"]["cod"] . "'>" . mb_strtoupper($subcategorias["data"]["titulo"]) . "</option>";
                                        }
                                        ?>
                                 </optgroup>
                             <?php
                                }
                                ?>
                         </select>
                     </label>
                     <label class="col-md-4">Fecha:<br />
                         <input type="date" name="fecha" value="<?= date('Y-m-d') ?>">
                     </label>
                     <div class="col-md-12">
                         <hr style="border-style: dashed;">
                     </div>
                     <label class="col-md-12">Contenido:<br />
                         <textarea name="contenido" class="ckeditorTextarea" required></textarea>
                     </label>
                     <div class="col-md-12">
                         <hr style="border-style: dashed;">
                     </div>
                     <label class="col-md-12">Palabras claves dividas por ,<br />
                         <input type="text" name="keywords">
                     </label>
                     <label class="col-md-12">Descripción breve<br />
                         <textarea name="description"></textarea>
                     </label>
                     <br />
                     <label class="col-md-12">Link
                         <input type="text" id="link" name="link">
                     </label>
                     <br>
                     <div class="col-md-12">
                         <hr style="border-style: dashed;">
                     </div>
                     <label class="col-md-12">Imágenes:<br />
                         <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" />
                     </label>
                     <div class="col-md-12">
                         <div class="btn btn-primary mt-10 mb-10" onclick="$('#idiomasCheckBox').show()">Republicar contenido en otros idiomas</div>
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
                         <input type="submit" class="btn btn-block btn-primary" name="agregar" value="Agregar" />
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <script>
     $('#idiomasCheckBox').hide();
 </script>