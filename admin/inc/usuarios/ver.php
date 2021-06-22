<?php
$usuario = new Clases\Usuarios();
$pedido = isset($_GET["pedido"]) ? $funciones->antihack_mysqli($_GET["pedido"]) : '0';
?>
<div class="content-wrapper">
    <div class="content-body">
        <section class="users-list-wrapper">
            <div class="users-list-table">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="mt-20 pull-left">Usuarios</h4>
                        <div class="dropdown pull-right">
                            <div class="btn-group dropleft mb-1">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="<?= URL_ADMIN ?>/index.php?op=usuarios&accion=agregar<?= ($pedido == 1) ? '&pedido=1' : '' ?>">
                                        AGREGAR USUARIOS
                                    </a>
                                    <a class="dropdown-item" target="_blank" href="<?= URL_ADMIN ?>/index.php?op=excel&accion=excel">
                                        IMPORTAR USUARIOS
                                    </a>
                                    <a class="dropdown-item" target="_blank" href="<?= URL_ADMIN ?>/index.php?op=excel&accion=excel">
                                        EXPORTAR USUARIOS
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr />
                    </div>
                </div>
            </div>
            <div>
                <div class="row ">
                    <div class="col-md-12 ">
                        <fieldset class="form-group position-relative has-icon-left mb-2">
                            <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
                            <div class="form-control-position">
                                <i class="bx bx-search"></i>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="table-responsive">

                    <?php
                    if ($pedido == 1) {
                    ?>
                        <div class="alert alert-success" role="alert">
                            Seleccion un usuario para comenzar a armar el pedido o agrega un usuario nuevo.
                        </div>
                    <?php
                    }
                    ?>

                    <table id="users-list-datatable" class="table">
                        <thead>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Tipo</th>
                            <th>Ajustes</th>
                        </thead>
                        <tbody>
                            <?php
                            $filter = array();
                            $usuariosData = $usuario->list('', '', '');
                            if (is_array($usuariosData)) {
                                foreach ($usuariosData as $data) {
                            ?>
                                    <tr>
                                        <td><?= mb_strtoupper($data['data']["nombre"]) . " " . mb_strtoupper($data['data']["apellido"]) ?></td>

                                        <td><?= mb_strtolower($data['data']["email"]) ?></td>
                                        <td>
                                            <?php
                                            if ($data['data']["minorista"] == 1) {
                                                echo "MINORISTA";
                                            } else {
                                                echo "MAYORISTA";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($data['data']["estado"] == 1) {
                                            ?>
                                                <a data-toggle="tooltip" data-placement="top" title="Activo" href="<?= URL_ADMIN . '/index.php?op=usuarios&cod=' . $data['data']['cod'] . '&active=0' ?>">
                                                    <span class=" badge badge-light-primary">
                                                        <div class="fonticon-wrap">
                                                            <i class="bx bx-user-check fs-20"></i>
                                                        </div>
                                                    </span>
                                                </a>
                                            <?php
                                            } else {
                                            ?>
                                                <a data-toggle="tooltip" data-placement="top" title="No activo" href="<?= URL_ADMIN . '/index.php?op=usuarios&cod=' . $data['data']['cod'] . '&active=1' ?>">
                                                    <span class=" badge badge-light-danger">
                                                        <div class="fonticon-wrap">
                                                            <i class="bx bx-user-x fs-20"></i>
                                                        </div>
                                                    </span>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                            <a data-toggle="tooltip" data-placement="top" title="Ver Pedidos" href="<?= URL_ADMIN ?>/index.php?op=pedidos&accion=ver&usuario=<?= $data['data']["cod"] ?>">
                                                <span class=" badge badge-light-warning">
                                                    <div class="fonticon-wrap">
                                                        <i class="bx bx-list-ol fs-20"></i>
                                                    </div>
                                                </span>
                                            </a>

                                            <a data-toggle="tooltip" data-placement="top" title="Agregar Pedido" href="<?= URL_ADMIN ?>/index.php?op=pedidos&accion=agregar&usuario=<?= $data['data']["cod"] ?>">
                                                <span class=" badge badge-light-success">
                                                    <div class="fonticon-wrap">
                                                        <i class="bx bx-plus fs-20"></i>
                                                    </div>
                                                </span>
                                            </a>

                                            <a data-toggle="tooltip" data-placement="top" title="Modificar" href="<?= URL_ADMIN ?>/index.php?op=usuarios&accion=modificar&cod=<?= $data['data']["cod"] ?>">
                                                <span class=" badge badge-light-secondary">
                                                    <div class="fonticon-wrap">
                                                        <i class="bx bx-cog fs-20"></i>
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
    $cod = isset($_GET["borrar"]) ? $funciones->antihack_mysqli($_GET["borrar"]) : '';
    $usuario->set("cod", $cod);
    $usuario->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=usuarios");
}
if (isset($_GET["active"])) {
    $estado = isset($_GET["active"]) ? $funciones->antihack_mysqli($_GET["active"]) : '';
    $usuario->set("cod", isset($_GET["cod"]) ? $funciones->antihack_mysqli($_GET["cod"]) : '');
    $usuario->editEstado("estado", $_GET["active"]);
    $funciones->headerMove(URL_ADMIN . "/index.php?op=usuarios");
}
?>