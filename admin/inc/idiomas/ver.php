<?php
$idiomas = new Clases\Idiomas();
?>
<div class="content-wrapper">
    <div class="content-body">
        <section class="users-list-wrapper">
            <div class="users-list-table">
                <h4 class="mt-20 pull-left">Idiomas</h4>
                <div class="pull-right">
                    <a href="<?= URL_ADMIN ?>/index.php?op=idiomas&accion=agregar" class="btn btn-secondary">
                        AGREGAR IDIOMAS
                    </a>
                </div>
                <div class="clearfix"></div>
                <hr />
                <table id="users-list-datatable" class="table">
                    <thead>
                        <th></th>
                        <th width="600px">
                            Título
                        </th>
                        <th>
                            Predeterminado
                        </th>
                        <th></th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($idiomas->list('', '', '') as $idioma) { ?>
                            <tr>
                                <td><img src="<?= URL_ADMIN ?>/img/idiomas/<?= $idioma["data"]["cod"] ?>.png" width="40" /></td>
                                <td>
                                    <?= mb_strtoupper($idioma['data']["titulo"]) ?>
                                </td>
                                <td class="motrar_web" width="80" class="text-center">
                                    <div class="custom-control custom-switch custom-switch-glow ml-10">
                                        <input name="radio" type="radio" id="default-<?= $idioma['data']["cod"] ?>" class="custom-control-input" <?= $idioma['data']['default'] == 1 ? 'checked' : '' ?> value="1" onchange="changeLabel('<?= $idioma['data']['cod'] ?>','<?= URL ?>')">
                                        <label class="custom-control-label" for="default-<?= $idioma['data']["cod"] ?>"></label>
                                    </div>
                                </td>
                                <td>
                                    <a data-toggle="tooltip" data-placement="top" title="Modificar" href="<?= URL_ADMIN ?>/index.php?op=idiomas&accion=modificar&cod=<?= $idioma["data"]["cod"] ?>">
                                        <span class=" badge badge-light-secondary">
                                            <div class="fonticon-wrap">
                                                <i class="bx bx-cog fs-20"></i>
                                            </div>
                                        </span>
                                    </a>
                                    <a class="deleteConfirm" data-toggle="tooltip" data-placement="top" title="Eliminar" href="<?= URL_ADMIN ?>/index.php?op=idiomas&accion=ver&borrar=<?= $idioma["data"]["cod"] ?>">
                                        <span class=" badge badge-light-danger">
                                            <div class="fonticon-wrap">
                                                <i class="bx bx-trash fs-20"></i>
                                            </div>
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        <?php
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
    $cod = isset($_GET["borrar"]) ?  $funciones->antihack_mysqli($_GET["borrar"]) : '';
    $idiomas->set("cod", $cod);
    $idiomas->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=idiomas");
}

?>