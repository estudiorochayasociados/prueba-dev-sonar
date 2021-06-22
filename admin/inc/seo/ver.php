<?php
$seo = new Clases\Seo();
$urls = $seo->list('', '', '');
?>



<div class="content-wrapper">
    <div class="content-body">
        <section class="users-list-wrapper">
            <div class="users-list-table">

                <h4 class="mt-20 pull-left">SEO</h4>
                <a class="btn btn-success pull-right text-uppercase mt-15 " href="<?= URL_ADMIN ?>/index.php?op=seo&accion=agregar">
                    AGREGAR URL
                </a>
                <div class="clearfix"></div>
                <hr />
                <div class="table-responsive">
                    <table id="users-list-datatable" class="table">
                        <thead>
                            <th>
                                URL
                            </th>
                            <th>
                                Ajustes
                            </th>
                        </thead>
                        <tbody>
                            <?php
                            if (is_array($urls)) {
                                foreach ($urls as $url) { ?>
                                    <tr>
                                        <td>
                                            <?= strtoupper($url['data']["url"]) ?>
                                        </td>
                                        <td>

                                            <?php if (in_array(1, $_SESSION["admin"]["rol"])) { ?>
                                                <a class="deleteConfirm" data-toggle="tooltip" data-placement="top" title="Eliminar" href="<?= URL_ADMIN ?>/index.php?op=seo&accion=ver&borrar=<?= $url['data']["cod"] ?>">
                                                    <span class=" badge badge-light-danger">
                                                        <div class="fonticon-wrap">
                                                            <i class="bx bx-trash fs-20" style="color:#666;"></i>
                                                        </div>
                                                    </span>
                                                </a>
                                            <?php  } ?>
                                            <a class="ml-20" data-toggle="tooltip" data-placement="top" title="Modificar" href="<?= URL_ADMIN ?>/index.php?op=seo&accion=modificar&cod=<?= $url['data']["cod"] ?>">
                                                <span class=" badge badge-light-secondary">
                                                    <div class="fonticon-wrap">
                                                        <i class="bx bx-cog fs-20" style="color:#666;"></i>
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
    $seo->set("cod", $cod);
    $seo->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=seo");
}
?>