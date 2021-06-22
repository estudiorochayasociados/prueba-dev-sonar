 <?php
    $categorias = new Clases\Categorias();
    $subcategorias = new Clases\Subcategorias();
    $funciones = new Clases\PublicFunction();
    $area = new Clases\Area();
    $idiomas = new Clases\Idiomas();
    $idiomaGet = isset($_GET["idioma"]) ? $funciones->antihack_mysqli($_GET["idioma"]) : $_SESSION['lang'];
    $getArea = isset($_GET["area"]) ? $funciones->antihack_mysqli($_GET["area"]) : '';
    $data = $categorias->list([], '', '', $idiomaGet);
    if ($getArea != '') {
        $categorias->deleteForArea($getArea);
        $funciones->headerMove(URL_ADMIN . "/index.php?op=categorias&accion=ver&idioma=$idiomaGet");
    } ?>
 <div class="content-wrapper">
     <div class="content-body">
         <section class="users-list-wrapper">
             <div class="users-list-table">
                 <h4 class="mt-20 pull-left">Categorias</h4>
                 <div class="dropdown pull-right">
                     <div class="dropdown mb-1">
                         <button type="button" style="padding-top:8px;padding-bottom:8px" class="btn btn-danger  dropdown-toggle ml-10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             BORRAR POR AREA
                         </button>
                         <div class="dropdown-menu">
                             <a class="dropdown-item deleteConfirm" href="<?= URL_ADMIN ?>/index.php?op=categorias&accion=ver&idioma=<?= $idiomaGet ?>&area=productos">
                                 <span>productos</span>
                             </a>
                             <a class="dropdown-item deleteConfirm" href="<?= URL_ADMIN ?>/index.php?op=categorias&accion=ver&idioma=<?= $idiomaGet ?>&area=banners">
                                 <span>banners</span>
                             </a>
                             <?php
                                $areas = $area->list([], "titulo ASC", "", $idiomaGet);
                                foreach ($areas as $areaData) { ?>
                                 <li>
                                     <a class="dropdown-item deleteConfirm" href="<?= URL_ADMIN ?>/index.php?op=categorias&accion=ver&idioma=<?= $idiomaGet ?>&area=<?= $areaData['data']['cod'] ?>">
                                         <span><?= mb_strtolower($areaData['data']['titulo']) ?></span>
                                     </a>
                                 </li>
                             <?php } ?>
                         </div>
                     </div>
                 </div>
                 <div class="dropdown pull-right">
                     <div class="btn-group dropleft mb-1">
                         <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             AGREGAR
                         </button>
                         <div class="dropdown-menu">
                             <a class="dropdown-item" href="<?= URL_ADMIN ?>/index.php?op=categorias&accion=agregar&idioma=<?= $idiomaGet ?>">
                                 CATEGORIAS
                             </a>
                             <a class="dropdown-item" target="_blank" href="<?= URL_ADMIN ?>/index.php?op=subcategorias&accion=agregar&idioma=<?= $idiomaGet ?>">
                                 SUBCATEGORIAS
                             </a>
                         </div>
                     </div>
                 </div>
                 <div class="clearfix"></div>

                 <div class="clearfix"></div>
                 <hr />
                 <table id="users-list-datatable" class="table">
                     <thead>
                         <th width="600px">
                             Título
                         </th>

                         <th>
                             Área
                         </th>
                         <th width="200px">
                             Ajustes
                         </th>
                     </thead>
                     <ul class="nav nav-tabs">
                         <?php
                            foreach ($idiomas->list("", "id ASC", "") as $key => $idioma_) {
                                $url =  URL_ADMIN . "/index.php?op=categorias&accion=ver&idioma=" . $idioma_["data"]["cod"];
                            ?>
                             <a class="nav-link <?= CANONICAL == $url ? "active" : '' ?> " href="<?= $url ?>"><?= mb_strtoupper($idioma_["data"]["titulo"]) ?></a>
                         <?php } ?>
                     </ul>
                     <tbody>
                         <?php
                            if (is_array($data)) {
                                foreach ($data as $val) { ?>
                                 <tr>
                                     <td>
                                         <div class="row">
                                             <div class="card " style="width:100%">
                                                 <span><?= mb_strtoupper($val['data']["titulo"]) ?> </span>
                                                 <?php if (!empty($val['subcategories'])) { ?>
                                                     <div class="heading-elements">
                                                         <ul class="list-inline mb-0">
                                                             <li>
                                                                 <a data-action="collapse">
                                                                     <i class="bx bx-chevron-down fs-30"></i>
                                                                 </a>
                                                             </li>
                                                         </ul>
                                                     </div>
                                                     <div class="card-content collapse ">
                                                         <div class="card-body">
                                                             <?php foreach ($val['subcategories'] as $sub) { ?>
                                                                 <hr>
                                                                 <?= $sub['data']["titulo"] ?>
                                                                 <a href='<?= URL_ADMIN ?>/index.php?op=subcategorias&accion=modificar&cod=<?= $sub['data']["cod"] ?>&idioma=<?= $sub['data']["idioma"] ?>' data-toggle="tooltip" data-placement="top" title="Modificar" class="pull-right ml-20">
                                                                     <span class=" badge badge-light-secondary">
                                                                         <div class="fonticon-wrap">
                                                                             <i class="bx bx-cog fs-16" style="color:#666;"></i>
                                                                         </div>
                                                                     </span>
                                                                 </a>
                                                                 <a href='<?= URL_ADMIN ?>/index.php?op=categorias&accion=ver&borrarSubcategorias=<?= $sub['data']["cod"] ?>&idioma=<?= $sub['data']["idioma"] ?>' data-toggle="tooltip" data-placement="top" title="Eliminar" class="pull-right ">
                                                                     <span class=" badge badge-light-danger">
                                                                         <div class="fonticon-wrap">
                                                                             <i class="bx bx-trash fs-16" style="color:#666;"></i>
                                                                         </div>
                                                                     </span>
                                                                 </a>
                                                             <?php } ?>
                                                         </div>
                                                     </div>
                                                 <?php } ?>
                                             </div>
                                         </div>
                                     </td>
                                     <td>
                                         <?= mb_strtoupper($val['data']["area"]) ?>
                                     </td>
                                     <td>
                                         <a data-toggle="tooltip" data-placement="top" title="Modificar" href="<?= URL_ADMIN ?>/index.php?op=categorias&accion=modificar&cod=<?= $val['data']["cod"] ?>&idioma=<?= $idiomaGet ?>">
                                             <span class=" badge badge-light-secondary">
                                                 <div class="fonticon-wrap">
                                                     <i class="bx bx-cog fs-20" style="color:#666;"></i>
                                                 </div>
                                             </span>
                                         </a>
                                         <a class="deleteConfirm" data-toggle="tooltip" data-placement="top" title="Eliminar" href="<?= URL_ADMIN ?>/index.php?op=categorias&accion=ver&borrar=<?= $val['data']["cod"] ?>&idioma=<?= $idiomaGet ?>">
                                             <span class=" badge badge-light-danger">
                                                 <div class="fonticon-wrap">
                                                     <i class="bx bx-trash fs-20" style="color:#666;"></i>
                                                 </div>
                                             </span>
                                         </a>
                                     </td>
                                 </tr>
                         <?php
                                }
                            }
                            ?>
                     </tbody>
                 </table>
             </div>
         </section>
     </div>
 </div>
 <?php
    if (isset($_GET["borrar"])) {
        $cod = isset($_GET["borrar"]) ? $funciones->antihack_mysqli($_GET["borrar"]) : '';
        $categorias->set("cod", $cod);
        $categorias->set("idioma", $idiomaGet);
        $categorias->delete();
        $funciones->headerMove(URL_ADMIN . "/index.php?op=categorias&accion=ver&idioma=" . $idiomaGet);
    }

    if (isset($_GET["borrarSubcategorias"])) {
        $cod = isset($_GET["borrarSubcategorias"]) ? $funciones->antihack_mysqli($_GET["borrarSubcategorias"]) : '';
        $subcategorias->set("cod", $cod);
        $subcategorias->set("idioma", $idiomaGet);
        $subcategorias->delete();
        $funciones->headerMove(URL_ADMIN . "/index.php?op=categorias&accion=ver&idioma=" . $idiomaGet);
    }
    ?>