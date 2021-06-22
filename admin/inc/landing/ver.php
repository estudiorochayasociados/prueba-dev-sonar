<?php
$landing = new Clases\Landing();
$funciones = new Clases\PublicFunction();
$data = $landing->list('', '', '');
?>

<div class="content-wrapper">
    <div class="content-body">
        <section class="users-list-wrapper">
            <div class="users-list-table">
                <h4 class="mt-20 pull-left">Landing</h4>
                <a class="btn btn-success pull-right text-uppercase mt-15 " href="<?= URL_ADMIN ?>/index.php?op=landing&accion=agregar">
                    AGREGAR Landing
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
                    <table id="users-list-datatable" class="table">
                        <thead>
                            <th>
                                Título
                            </th>
                            <th>
                                Link de Campaña
                            </th>
                            <th>
                                Ajustes
                            </th>
                        </thead>
                        <tbody>
                            <?php
                            if (is_array($data)) {
                                foreach ($data as $data_) {
                                    $link = URL . "/landing/" . $funciones->normalizar_link($data_['data']["titulo"]) . "/" . $data_['data']["cod"];
                            ?>
                                    <tr>
                                        <td>
                                            <?= strtoupper($data_['data']["titulo"]) ?>
                                        </td>
                                        <td>
                                            <a href="<?= $link ?>" style="color:#666" target="_blank"><?= $link ?></a>
                                        </td>
                                        <td>
                                            <a data-toggle="tooltip" data-placement="top" title="Peticiones" href="<?= URL_ADMIN ?>/index.php?op=landing&accion=verSubs&cod=<?= $data_['data']["cod"] ?>">
                                                <span class=" badge badge-light-info">
                                                    <div class="fonticon-wrap">
                                                        <i class="bx bx-user-x fs-20" style="color:#666;"></i>
                                                    </div>
                                                </span>
                                            </a>


                                            <a data-toggle="tooltip" data-placement="top" title="Modificar" href="<?= URL_ADMIN ?>/index.php?op=landing&accion=modificar&cod=<?= $data_['data']["cod"] ?>">
                                                <span class=" badge badge-light-warning">
                                                    <div class="fonticon-wrap">
                                                        <i class="bx bx-cog fs-20" style="color:#666;"></i>
                                                    </div>
                                                </span>
                                            </a>

                                            <a data-toggle="tooltip" data-placement="top" title="Eliminar" href="<?= URL_ADMIN ?>/index.php?op=landing&accion=ver&borrar=<?= $data_['data']["cod"] ?>">
                                                <span class="badge badge-light-danger">
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
        </section>
    </div>
</div>
<?php
if (isset($_GET["borrar"])) {
    $cod = $funciones->antihack_mysqli(isset($_GET["borrar"]) ? $_GET["borrar"] : '');
    $landing->set("cod", $cod);
    $landing->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=landing");
}
?>