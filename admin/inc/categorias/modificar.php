 <?php
    $categorias = new Clases\Categorias();
    $imagenes = new Clases\Imagenes();
    $area = new Clases\Area();

    $cod = isset($_GET["cod"]) ? $funciones->antihack_mysqli($_GET["cod"]) : '';
    $borrarImg = isset($_GET["borrarImg"]) ? $funciones->antihack_mysqli($_GET["borrarImg"]) : '';
    $idiomaGet = isset($_GET["idioma"]) ? $funciones->antihack_mysqli($_GET["idioma"]) : $_SESSION['lang'];

    $data = $categorias->list(["cod = '$cod'"], "", "", $idiomaGet, true);

    $imagenes->set("idioma", $idiomaGet);
    $areas = $area->list([], "", "", $idiomaGet);

    if ($borrarImg != '') {
        $imagenes->set("id", $borrarImg);
        $imagenes->set("idioma", $idiomaGet);
        $imagenes->delete();
        $funciones->headerMove(URL_ADMIN . "/index.php?op=categorias&accion=modificar&idioma=$idiomaGet&cod=$cod");
    }

    if (isset($_POST["modificar"])) {
        unset($_POST["modificar"]);
        $array = $funciones->antihackMulti($_POST);
        $categorias->edit($array, ["cod = '$cod'", "idioma = '$idiomaGet'"]);

        if (isset($_FILES['files'])) {
            $imagenes->resizeImagesWithLanguage($cod, $_FILES['files'], "../assets/archivos", "../assets/archivos/recortadas", $array["titulo"], [$idiomaGet]);
        }
        $funciones->headerMove(URL_ADMIN . "/index.php?op=categorias&accion=ver&idioma=$idiomaGet");
    }


    ?>
 <div class="mt-20 card">
     <div class="card">
         <div class="card-header">
             <h4 class="card-title text-uppercase text-center">
                 Categorías
             </h4>
             <hr style="border-style: dashed;">
         </div>
         <div class="card-content">
             <div class="card-body">
                 <form method="post" class="row" enctype="multipart/form-data">
                     <input type="hidden" name="idioma" value="<?= $idiomaGet ?>">
                     <label class="col-md-4">Código:<br />
                         <input type="text" value="<?= $data['data']["cod"] ?>" name="cod" disabled required>
                     </label>
                     <label class="col-md-4">Título:<br />
                         <input type="text" value="<?= $data['data']["titulo"] ?>" name="titulo" required>
                     </label>
                     <label class="col-md-4">Área:<br />
                         <select name="area" required>
                             <option value="<?= $data['data']["area"] ?>" selected><?= $data['data']["area"]  ?></option>
                             <option>---------------</option>
                             <?php
                                if (isset($areas)) {
                                    foreach ($areas as $areaItem) { ?>
                                     <option value="<?= $areaItem['data']['cod'] ?>"><?= $areaItem['data']['titulo'] ?></option>
                             <?php }
                                }
                                ?>
                             <option value="banners">Banners</option>
                             <option value="productos">Productos</option>
                             <option value="landing">Landing</option>
                             <option value="menu">Menu</option>
                         </select>
                     </label>
                     <label class="col-md-12 mt-10">Descripción:<br />
                         <textarea class="form-control" name="descripcion"><?= $data['data']["descripcion"] ?></textarea>
                     </label>
                     <div class="col-md-12">
                         <hr style="border-style: dashed;">
                     </div>
                     <?php
                        if (!empty($data['image'])) {
                        ?>
                         <div class='col-md-2 mb-20 mt-20'>
                             <div style="height:200px;background:url(<?= '../' . $data['image']['ruta']; ?>) no-repeat center center/contain;">
                             </div>
                             <a href="<?= URL_ADMIN . '/index.php?op=categorias&accion=modificar&cod=' . $data['data']['cod'] . '&borrarImg=' . $data['image']['id'] . '&idioma=' . $idiomaGet ?>" class="btn btn-sm pull-left btn-danger">
                                 BORRAR IMAGEN
                             </a>
                             <?php
                                if ($data['image']["orden"] == 0) {
                                ?>
                                 <a href="<?= URL_ADMIN . '/index.php?op=categorias&accion=modificar&cod=' . $data['data']['cod'] . '&ordenImg=' . $data['image']['cod'] ?>" class="btn btn-sm pull-right btn-warning">
                                     <i class="fa fa-star"></i>
                                 </a>
                             <?php
                                } else {
                                ?>
                                 <a href="#" class="btn btn-sm pull-right btn-success">
                                     <i class="fa fa-star"></i>
                                 </a>
                             <?php
                                }
                                ?>
                             <div class="clearfix"></div>
                         </div>
                     <?php
                        } else {
                        ?>
                         <label class="col-md-7">Imágenes:<br />
                             <input type="file" id="file" name="files[]" accept="image/*" />
                         </label>
                     <?php
                        }
                        ?>
                     <div class="col-md-12 mt-20">
                         <input type="submit" class="btn btn-primary btn-block" name="modificar" value="Modificar Categoría" />
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>