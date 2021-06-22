 <?php
    $contenidos = new Clases\Contenidos();
    $area = new Clases\Area();
    $categoria = new Clases\Categorias();
    $funciones = new Clases\PublicFunction();
    $idiomas = new Clases\Idiomas();

    $getArea = isset($_GET["area"]) ? $funciones->antihack_mysqli($_GET["area"]) : '';
    $idioma = isset($_GET["idioma"]) ? $funciones->antihack_mysqli($_GET["idioma"]) : $_SESSION['lang'];
    $areaData = $area->list(["cod = '$getArea'"], '', '', $idioma, true);
    $categoriasData = $categoria->list(["area = '" . $areaData['data']['titulo'] . "'"], "titulo ASC", "", $idioma);
    $contenidoData = $contenidos->list(["filter" => ["area = '$getArea'"], "category" => true], $idioma);
    ?>
 <section id="basic-datatable">
     <div class="row">
         <div class="col-12">
             <div class="card">
                 <div class="card-content">
                     <div class="card-body card-dashboard">
                         <h4 class="mt-20 pull-left"><?= $areaData['data']['titulo'] ?></h4>
                         <a class="btn btn-success pull-right text-uppercase mt-15 " href="<?= URL_ADMIN ?>/index.php?op=contenidos&accion=agregar&area=<?= $areaData['data']['cod'] ?>&idioma=<?= $idioma ?>">
                             AGREGAR <?= $areaData['data']['titulo'] ?>
                         </a>
                         <div class="clearfix"></div>
                         <hr />
                         <fieldset class="form-group position-relative has-icon-left mb-20">
                             <input type="search" class="form-control" id="myInput" type="text" placeholder="Buscar..">
                             <div class="form-control-position">
                                 <i class="bx bx-search"></i>
                             </div>
                         </fieldset>
                         <div class="table-responsive">
                             <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                 <div class="row">
                                     <div class="col-sm-12">
                                         <table class="table zero-configuration dataTable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                             <thead>
                                                 <tr role="row">
                                                     <th></th>
                                                     <th >Título</th>
                                                     <th>Categoria</th>
                                                     <th></th>
                                                 </tr>
                                             </thead>
                                             <div>
                                                 <ul class="nav nav-tabs">
                                                     <?php
                                                        foreach ($idiomas->list("", "id ASC", "") as $key => $idioma_) {
                                                            $url =  URL_ADMIN . "/index.php?op=contenidos&accion=ver&area=" . $areaData['data']['cod'] . "&idioma=" . $idioma_["data"]["cod"];
                                                        ?>
                                                         <a class="nav-link <?= CANONICAL == $url ? "active" : '' ?> " href="<?= $url ?>"><?= mb_strtoupper($idioma_["data"]["titulo"]) ?></a>
                                                     <?php } ?>
                                                 </ul>
                                                 <div class="tab-content pl-0">
                                                     <tbody>
                                                         <?php
                                                            if (is_array($contenidoData)) {
                                                                foreach ($contenidoData as $contenido) { ?>
                                                                 <tr role="row" class="odd">
                                                                     <td><img src="<?= URL_ADMIN ?>/img/idiomas/<?= $contenido["data"]["idioma"] ?>.png" width="40" /></td>
                                                                     <td>
                                                                         <span class="invoice-customer"><?= mb_strtoupper($contenido['data']['titulo']) ?></span>
                                                                     </td>
                                                                     <td>
                                                                         <?= mb_strtoupper($contenido["data"]["categoria_titulo"]) ?>
                                                                     </td>
                                                                     <td>
                                                                         <a data-toggle="tooltip" data-placement="top" title="Modificar" href="<?= URL_ADMIN . '/index.php?op=contenidos&accion=modificar&cod=' . $contenido['data']['cod'] . "&area=" . $areaData['data']['cod'] . "&idioma=" . $idioma ?>">
                                                                             <span class=" badge badge-light-secondary">
                                                                                 <div class="fonticon-wrap">
                                                                                     <i class="bx bx-cog fs-20" style="color:#666;"></i>
                                                                                 </div>
                                                                             </span>
                                                                         </a>
                                                                         <?php if (in_array(1, $_SESSION["admin"]["rol"])) { ?>
                                                                             <a class="deleteConfirm" data-toggle="tooltip" data-placement="top" title="Eliminar" href="<?= URL_ADMIN . '/index.php?op=contenidos&accion=ver&area=' . $areaData['data']['cod'] . '&borrar=' . $contenido['data']['cod'] . '&idioma=' . $idioma ?>">
                                                                                 <span class=" badge badge-light-danger ">
                                                                                     <div class="fonticon-wrap">
                                                                                         <i class="bx bx-trash fs-20" style="color:#666;"></i>
                                                                                     </div>
                                                                                 </span>
                                                                             </a>
                                                                         <?php } ?>
                                                                     </td>
                                                                 </tr>
                                                         <?php
                                                                }
                                                            }
                                                            ?>
                                                     </tbody>
                                                 </div>

                                         </table>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>
 <?php
    $borrar = isset($_GET["borrar"]) ? $funciones->antihack_mysqli($_GET["borrar"]) : '';
    if ($borrar != '') {
        $contenidos->set("cod", $borrar);
        $contenidos->set("idioma", $idioma);
        $contenidos->delete();
        $funciones->headerMove(URL_ADMIN . "/index.php?op=contenidos&accion=ver&area=" . $areaData['data']['cod'] . "&idioma=" . $idioma);
    }
    ?>