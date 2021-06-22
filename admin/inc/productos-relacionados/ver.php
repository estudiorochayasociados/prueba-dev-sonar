<?php
$f = new Clases\PublicFunction();
$productos_relacionados = new Clases\ProductosRelacionados();
$productos = new Clases\Productos();

$filter = [];
isset($_GET["busqueda"]) ? $filter[] = 'titulo like "%' . $f->antihack_mysqli($_GET["busqueda"]) . '%"' : '';
$productos_relacionados_ = $productos_relacionados->listAdmin($filter);
?>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">

                        <h4 class="mt-20 pull-left">Productos Relacionados</h4>
                        <a class="btn btn-success pull-right text-uppercase mt-15 " href="<?= URL_ADMIN ?>/index.php?op=productos-relacionados&accion=agregar">
                            AGREGAR NUEVA RELACION
                        </a>
                        <div class="clearfix"></div>
                        <hr />

                        <form method="get">
                            <input name="op" value="productos-relacionados" type="hidden" />
                            <input name="accion" value="ver" type="hidden" />
                            <input name="pagina" value="<?= $pagina ?>" type="hidden" />
                            <input class="form-control" name="busqueda" type="text" placeholder="Buscar.." />
                        </form>
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?php
                                        foreach ($productos_relacionados_ as $productos_relacionados__) {
                                            $productos_relacionados_explode = explode(",", $productos_relacionados__['data']['productos_cod']);
                                        ?>
                                            <table class="table zero-configuration dataTable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                                <thead>
                                                    <tr role="row">
                                                        <th width="300px" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">
                                                            <?= $productos_relacionados__['data']['titulo'] ?>
                                                        </th>
                                                        <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 400px;">
                                                            Código Productos
                                                        </th>
                                                        <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 220px;">
                                                            <!-- Modificar -->
                                                            <a data-toggle="tooltip" data-placement="top" title="Modificar" href="<?= URL_ADMIN ?>/index.php?op=productos-relacionados&accion=modificar&cod=<?= $productos_relacionados__["data"]["cod"] ?>">
                                                                <span class=" badge badge-light-secondary">
                                                                    <div class="fonticon-wrap">
                                                                        <i class="bx bx-cog fs-20" style="color:#666;"></i>
                                                                    </div>
                                                                </span>
                                                            </a>
                                                            <!-- Agregar (=Modificar) -->
                                                            <a data-toggle="tooltip" data-placement="top" title="Agregar" href="<?= URL_ADMIN ?>/index.php?op=productos-relacionados&accion=modificar&cod=<?= $productos_relacionados__["data"]["cod"] ?>">
                                                                <span class=" badge badge-light-success">
                                                                    <div class="fonticon-wrap">
                                                                        <i class="bx bx-plus fs-20" style="color:#666;"></i>
                                                                    </div>
                                                                </span>
                                                            </a>
                                                            <!-- Eliminar -->
                                                            <a class="deleteConfirm" data-toggle="tooltip" data-placement="top" title="Eliminar" href="<?= URL_ADMIN ?>/index.php?op=productos-relacionados&accion=ver&borrar=<?= $productos_relacionados__["data"]["cod"] ?>">
                                                                <span class=" badge badge-light-danger">
                                                                    <div class="fonticon-wrap">
                                                                        <i class="bx bx-trash fs-20" style="color:#666;"></i>
                                                                    </div>
                                                                </span>
                                                            </a>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <?php
                                                if (is_array($productos_relacionados_explode)) {
                                                    foreach ($productos_relacionados_explode as $producto_explode) {
                                                        $productos_ = $productos->list(["filter" => ["productos.cod = '$producto_explode'"]], $_SESSION['lang'])[0]; ?>
                                                        <tbody>
                                                            <tr>
                                                                <td> <?= mb_strtoupper($productos_["data"]["titulo"]) ?> </td>
                                                                <td> <?= mb_strtoupper($productos_["data"]["cod"]) ?> </td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </table>
                                        <?php
                                        }
                                        ?>
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
if (isset($_GET["borrar"])) {
    $cod = isset($_GET["borrar"]) ? $funciones->antihack_mysqli($_GET["borrar"]) : '';
    $productos_relacionados->set("cod", $cod);
    $productos_relacionados->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=productos-relacionados");
}
?>