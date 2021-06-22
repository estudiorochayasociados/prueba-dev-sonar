<?php
$banner = new Clases\Banners();
$idiomas = new Clases\Idiomas();

$filter = '';
$idiomaGet = isset($_GET["idioma"]) ? $funciones->antihack_mysqli($_GET["idioma"]) : $_SESSION['lang'];
$banners = $banner->list([], '', '', $idiomaGet);
?>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <h4 class="mt-20 pull-left">Banners</h4>
                        <a class="btn btn-success pull-right text-uppercase mt-15 " href="<?= URL_ADMIN ?>/index.php?op=banners&accion=agregar&idioma=<?= $idiomaGet ?>">
                            AGREGAR BANNER
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
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Título</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Subtitulo</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Link</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Categoria</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Ajustes</th>
                                                </tr>
                                            </thead>
                                            <ul class="nav nav-tabs">
                                                <?php
                                                foreach ($idiomas->list("", "id ASC", "") as $key => $idioma_) {
                                                    $url =  URL_ADMIN . "/index.php?op=banners&accion=ver&idioma=" . $idioma_["data"]["cod"];
                                                ?>
                                                    <a class="nav-link <?= CANONICAL == $url ? "active" : '' ?> " href="<?= $url ?>"><?= mb_strtoupper($idioma_["data"]["titulo"]) ?></a>
                                                <?php } ?>
                                            </ul>
                                            <tbody>
                                                <?php
                                                if (is_array($banners)) {
                                                    foreach ($banners as $key => $data) {
                                                        ($key == 0) ? $idiomaCheck = $data['data']['idioma'] : '';
                                                        echo (isset($idiomaCheck) && $idiomaCheck != $data['data']['idioma']) ? "<tr><td></td><td></td><td></td><td></td><td></td></tr>" : '';
                                                        $idiomaCheck = $data['data']['idioma'];
                                                ?>
                                                        <tr role="row" class="odd">

                                                            <td style="padding: 0.5rem 0.5rem;">
                                                                <img class="" src="<?= URL_ADMIN ?>/img/idiomas/<?= $data['data']["idioma"] ?>.png" width="35" />
                                                            </td>
                                                            <td style="padding: 0.5rem 0.5rem;width:800px">
                                                                <?php if (isset($data['data']["titulo"])) { ?>
                                                                    <?= strtoupper($data['data']["titulo"]) ?>
                                                                    <span class=" <?= $data['data']["titulo_on"] == 1 ? "badge badge-light-success"  : "badge badge-light-danger" ?>">
                                                                        <?=
                                                                        $data['data']["titulo_on"] == 1 ? $titleStatus = "on" :  $titleStatus = "off";
                                                                        ?>
                                                                    </span>
                                                                <?php } ?>
                                                            </td>
                                                            <td style="width:50px">
                                                                <?php if (isset($data['data']["subtitulo"])) { ?>
                                                                    <span class=" <?= $data['data']["subtitulo_on"] == 1 ? "badge badge-light-success" : "badge badge-light-danger" ?>">
                                                                        <?=
                                                                        $data['data']["subtitulo_on"] == 1 ? $subtitleStatus = "on" :  $subtitleStatus = "off";
                                                                        ?>
                                                                    </span>
                                                                <?php } ?>
                                                            </td>
                                                            <td style="width:50px">
                                                                <?php if (isset($data['data']["link"])) { ?>
                                                                    <span class=" <?= $data['data']["link_on"] == 1 ? "badge badge-light-success" : "badge badge-light-danger" ?>">
                                                                        <?=
                                                                        $data['data']["link_on"] == 1 ? $linkStatus = "on" :  $linkStatus = "off";
                                                                        ?>
                                                                    </span>
                                                                <?php } ?>
                                                            </td>

                                                            <td style="padding: 0.5rem 0.5rem;width:200px">
                                                                <?= $data['category']['titulo'] ?>
                                                            </td>
                                                            <td style="padding: 0.5rem 0.5rem;">
                                                                <a data-toggle="tooltip" data-placement="top" title="Modificar" href="<?= URL_ADMIN ?>/index.php?op=banners&accion=modificar&cod=<?= $data['data']["cod"] ?>&idioma=<?= $idiomaGet ?>">
                                                                    <span class=" badge badge-light-secondary">
                                                                        <div class="fonticon-wrap">
                                                                            <i class="bx bx-cog fs-20" style="color:#666;"></i>
                                                                        </div>
                                                                    </span>
                                                                </a>
                                                                <a class="deleteConfirm" data-toggle="tooltip" data-placement="top" title="Eliminar" href="<?= URL_ADMIN ?>/index.php?op=banners&accion=ver&borrar=<?= $data['data']["cod"] ?>&idioma=<?= $idiomaGet ?>">
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
    $banner->set("cod", $cod);
    $banner->set("idioma", $idiomaGet);
    $banner->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=banners&accion=ver&idioma=" . $idiomaGet);
}
?>