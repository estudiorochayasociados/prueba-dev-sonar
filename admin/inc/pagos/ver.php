<?php
$pagos = new Clases\Pagos();
$data = $pagos->list('', '', '');
?>

<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <h4 class="mt-20">Pagos</h4>
                        <a class="btn btn-success text-uppercase mb-20 " href="<?= URL_ADMIN ?>/index.php?op=pagos&accion=agregar">
                            AGREGAR PAGOS
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
                                                    <th width="250px" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Título</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Recargo/Descuento</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Minimo</th>
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
                                                            <?php $porcentaje = isset($data_['data']["aumento"]) ?  $data_['data']["aumento"] : $data_['data']["disminuir"];
                                                            if (isset($data_['data']["aumento"])) {
                                                                echo "<td>" . $porcentaje . "% de Recargo</td>";
                                                            } elseif (isset($data_['data']["disminuir"])) {
                                                                echo "<td>" . $porcentaje . "% de Descuento</td>";
                                                            } else {
                                                                echo "<td></td>";
                                                            }
                                                            $minimo = isset($data_['data']["minimo"]) ?  $data_['data']["minimo"] : 0;
                                                            ?>
                                                            <td>$ <?= $minimo ?></td>
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
                                                                }
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php if ($data_['data']["estado"] == 1) {
                                                                ?>
                                                                    <a data-toggle="tooltip" data-placement="top" title="Activo" href="<?= URL_ADMIN . '/index.php?op=pagos&cod=' . $data_['data']['cod'] . '&active=0' ?>">
                                                                        <span class=" badge badge-light-success">
                                                                            <div class="fonticon-wrap">
                                                                                <i class="bx bx-show-alt fs-20" style="color:#666;"></i>
                                                                            </div>
                                                                        </span>
                                                                    </a>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <a data-toggle="tooltip" data-placement="top" title="No activo" href="<?= URL_ADMIN . '/index.php?op=pagos&cod=' . $data_['data']['cod'] . '&active=1' ?>">
                                                                        <span class=" badge badge-light-warning">
                                                                            <div class="fonticon-wrap">
                                                                                <i class="bx bx-hide fs-20" style="color:#666;"></i>
                                                                            </div>
                                                                        </span>
                                                                    </a>
                                                                <?php
                                                                } ?>
                                                                <a data-toggle="tooltip" data-placement="top" title="Modificar" href="<?= URL_ADMIN ?>/index.php?op=pagos&accion=modificar&cod=<?= $data_['data']["cod"] ?>">
                                                                    <span class=" badge badge-light-secondary">
                                                                        <div class="fonticon-wrap">
                                                                            <i class="bx bx-cog fs-20" style="color:#666;"></i>
                                                                        </div>
                                                                    </span>
                                                                </a>
                                                                <a class="deleteConfirm" data-toggle="tooltip" data-placement="top" title="Eliminar" href="<?= URL_ADMIN ?>/index.php?op=pagos&accion=ver&borrar=<?= $data_['data']["cod"] ?>">
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
    $pagos->set("cod", $cod);
    $pagos->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=pagos");
}
if (isset($_GET["active"])) {
    $pagos->set("estado", isset($_GET["active"]) ? $funciones->antihack_mysqli($_GET["active"]) : '');
    $pagos->set("cod", isset($_GET["cod"]) ? $funciones->antihack_mysqli($_GET["cod"]) : '');
    $pagos->changeState();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=pagos");
}
?>