<?php
$descuento = new Clases\Descuentos();
$descuentos = $descuento->list("", "id DESC", "");
?>


<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <h4 class="mt-20 pull-left">Descuentos</h4>
                        <a class="btn btn-success pull-right text-uppercase mt-15 " href="<?= URL_ADMIN ?>/index.php?op=descuentos&accion=agregar">
                            AGREGAR DESCUENTO
                        </a>
                        <div class="clearfix"></div>
                        <hr />
                        <fieldset class="form-group position-relative has-icon-left mb-20">
                            <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
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
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Título</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Código Descuento</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Monto</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Ajustes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (is_array($descuentos)) {
                                                    foreach ($descuentos as $descuento_) {
                                                        if ($descuento_["data"]["tipo"] == 0) {
                                                            $monto = '$' . $descuento_["data"]["monto"];
                                                        } elseif ($descuento_["data"]["tipo"] == 1) {
                                                            $monto = '%' . $descuento_["data"]["monto"];
                                                        }

                                                ?>
                                                        <tr role="row" class="odd">
                                                            <td> <?= mb_strtoupper($descuento_["data"]["titulo"]) ?> </td>
                                                            <td> <?= mb_strtoupper($descuento_["data"]["cod"]) ?> </td>
                                                            <td><?= mb_strtoupper($monto) ?></td>
                                                            <td>
                                                                <a data-toggle="tooltip" data-placement="top" title="Modificar" href="<?= URL_ADMIN ?>/index.php?op=descuentos&accion=modificar&cod=<?= $descuento_["data"]["cod"] ?>">
                                                                    <span class=" badge badge-light-secondary">
                                                                        <div class="fonticon-wrap">
                                                                            <i class="bx bx-cog fs-20" style="color:#666;"></i>
                                                                        </div>
                                                                    </span> </a>

                                                                <a data-toggle="tooltip" data-placement="top" title="Eliminar" href="<?= URL_ADMIN ?>/index.php?op=descuentos&accion=ver&borrar=<?= $descuento_["data"]["cod"] ?>">
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
    $descuento->set("cod", $cod);
    $descuento->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=descuentos");
}
?>