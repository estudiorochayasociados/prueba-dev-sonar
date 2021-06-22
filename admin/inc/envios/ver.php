<?php
$envios = new Clases\Envios();
$data = $envios->list('', '', '');
?>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">

                        <h4 class="mt-20 pull-left">ENVIOS</h4>
                        <a class="btn btn-success pull-right text-uppercase mt-15 " href="<?= URL_ADMIN ?>/index.php?op=envios&accion=agregar">
                            AGREGAR ENVIO
                        </a>
                        <div class="clearfix"></div>
                        <hr />
                        <fieldset class="form-group position-relative has-icon-left mb-20">
                            <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
                            <div class="form-control-position">
                                <i class="bx bx-search"></i>
                            </div>
                        </fieldset>
                        <div class="clearfix"></div>
                        <hr />

                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table zero-configuration dataTable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                                <tr role="row">
                                                    <th width="280px" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Título</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Peso</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Precio</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Limite</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Usuarios</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Ajustes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (is_array($data)) {
                                                    foreach ($data as $data_) { ?>
                                                        <tr role="row" class="odd">
                                                            <td><?= strtoupper($data_['data']["titulo"]) ?></td>
                                                            <td><?= strtoupper($data_['data']["peso"]) ?> kg</td>
                                                            <td>$<?= strtoupper($data_['data']["precio"]) ?></td>
                                                            <td>$<?= strtoupper($data_['data']["limite"]) ?></td>
                                                            <td>
                                                                <?php switch ($data_['data']["tipo_usuario"]) {
                                                                    case 1:
                                                                        echo "MINORISTA";
                                                                        break;
                                                                    case 2:
                                                                        echo "MAYORISTA";
                                                                        break;
                                                                    default:
                                                                        echo "AMBOS";
                                                                        break;
                                                                }  ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($data_['data']["estado"] == 1) { ?>
                                                                    <a data-toggle="tooltip" data-placement="top" title="Activo" href="<?= URL_ADMIN ?>/index.php?op=envios&cod=<?= $data_['data']['cod'] ?>&active=0' ?>">
                                                                        <span class=" badge badge-light-success">
                                                                            <div class="fonticon-wrap">
                                                                                <i class="bx bx-show-alt fs-20" style="color:#666;"></i>
                                                                            </div>
                                                                        </span>
                                                                    </a>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <a data-toggle="tooltip" data-placement="top" title="No activo" href="<?= URL_ADMIN ?>/index.php?op=envios&cod=<?= $data_['data']['cod'] ?>&active=1' ?>">
                                                                        <span class=" badge badge-light-warning">
                                                                            <div class="fonticon-wrap">
                                                                                <i class="bx bx-hide fs-20" style="color:#666;"></i>
                                                                            </div>
                                                                        </span>
                                                                    </a>
                                                                <?php
                                                                } ?>
                                                                <a data-toggle="tooltip" data-placement="top" title="Modificar" href="<?= URL_ADMIN ?>/index.php?op=envios&accion=modificar&cod=<?= $data_['data']["cod"] ?>">
                                                                    <span class=" badge badge-light-secondary">
                                                                        <div class="fonticon-wrap">
                                                                            <i class="bx bx-cog fs-20" style="color:#666;"></i>
                                                                        </div>
                                                                    </span>
                                                                    <a class="deleteConfirm" data-toggle="tooltip" data-placement="top" title="Eliminar" href="<?= URL_ADMIN ?>/index.php?op=envios&accion=ver&borrar=<?= $data_['data']["cod"] ?>">
                                                                        <span class=" badge badge-light-danger">
                                                                            <div class="fonticon-wrap">
                                                                                <i class="bx bx-trash fs-20" style="color:#666;"></i>
                                                                            </div>
                                                                        </span>
                                                                    </a>
                                                            </td>
                                                        </tr>
                                                <?php }
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
    $envios->set("cod", $cod);
    $envios->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=envios");
}
if (isset($_GET["active"])) {
    $envios->set("estado", isset($_GET["active"]) ? $funciones->antihack_mysqli($_GET["active"]) : '');
    $envios->set("cod", isset($_GET["cod"]) ? $funciones->antihack_mysqli($_GET["cod"]) : '');
    $envios->changeState();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=envios");
}
?>