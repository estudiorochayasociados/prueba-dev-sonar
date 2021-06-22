<?php
$estados = new Clases\EstadosPedidos();
$data = $estados->list('id != 0', '', '');
?>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <h4 class="mt-20">Estados</h4>
                        <a class="btn btn-success text-uppercase mb-20 " href="<?= URL_ADMIN ?>/index.php?op=estados-pedidos&accion=modificar">
                            AGREGAR ESTADO
                        </a>
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
                                                    <th width="280px" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Título</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Tipo de Estado</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Envio Email</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Ajustes</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (is_array($data)) {
                                                    foreach ($data as $data_) { ?>
                                                        <tr role="row" class="odd">
                                                            <td><?= strtoupper($data_['data']["titulo"]) ?></td>
                                                            <td>
                                                                <?php switch ($data_['data']["estado"]) {
                                                                    case 1:
                                                                        echo "<span class='badge badge-circle-light-warning'><i class='bx bxs-hourglass'></i> PENDIENTE</span>";
                                                                        break;
                                                                    case 2:
                                                                        echo "<span class='badge badge-circle-light-success'><i class='bx bx-money'></i> APROBADO</span>";
                                                                        break;
                                                                    case 3:
                                                                        echo "<span class='badge badge-circle-light-danger'><i class='bx bx-dislike'></i> RECHAZADO</span>";
                                                                        break;
                                                                }  ?>
                                                            </td>
                                                            <td>
                                                                <span class=" <?= $data_['data']["enviar"] == 1 ? "badge badge-light-success"  : "badge badge-light-danger" ?>">
                                                                    <?=
                                                                    $data_['data']["enviar"] == 1 ? $enviarStatus = "on" :  $enviarStatus = "off";
                                                                    ?>
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a data-toggle="tooltip" data-placement="top" title="Modificar" href="<?= URL_ADMIN ?>/index.php?op=estados-pedidos&accion=modificar&id=<?= $data_['data']["id"] ?>">
                                                                    <span class=" badge badge-light-secondary">
                                                                        <div class="fonticon-wrap">
                                                                            <i class="bx bx-cog fs-20" style="color:#666;"></i>
                                                                        </div>
                                                                    </span>
                                                                    <a data-toggle="tooltip" data-placement="top" title="Eliminar" href="<?= URL_ADMIN ?>/index.php?op=estados-pedidos&accion=ver&borrar=<?= $data_['data']["id"] ?>">
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
    $id = isset($_GET["borrar"]) ? $funciones->antihack_mysqli($_GET["borrar"]) : '';
    $estados->set("id", $id);
    $estados->delete($id);
    $funciones->headerMove(URL_ADMIN . "/index.php?op=estados-pedidos");
}
// if (isset($_GET["active"])) {
//     $estados->set("estado", isset($_GET["active"]) ? $funciones->antihack_mysqli($_GET["active"]) : '');
//     $estados->set("id", isset($_GET["id"]) ? $funciones->antihack_mysqli($_GET["id"]) : '');
//     $estados->changeState();
//     $funciones->headerMove(URL_ADMIN . "/index.php?op=estados-pedidos");
// }
?>