<?php
require_once "Config/Autoload.php";
Config\Autoload::run();

$template = new Clases\TemplateSite();
$f = new Clases\PublicFunction();
$producto = new Clases\Productos();
$categoria = new Clases\Categorias();
$subcategoria = new Clases\Subcategorias();
$banner = new Clases\Banners();
#Variables GET
$sesionActiva = isset($_SESSION['usuarios']['cod']) ? true :  false;

$tituloGet = isset($_GET["titulo"]) ? $f->antihack_mysqli(str_replace("-", " ", $_GET["titulo"])) : '';
$categoriaGet = isset($_GET["categoria"]) ? $f->antihack_mysqli(str_replace("-", " ", $_GET["categoria"])) : '';
$subcategoriaGet = isset($_GET["subcategoria"]) ? $f->antihack_mysqli(str_replace("-", " ", $_GET["subcategoria"])) : '';
$favoritos = ($tituloGet == 'favoritos') ? true : false;

#Información de cabecera
$template->set("title", "Tienda Online | " . TITULO);
$template->set("description", "");
$template->set("keywords", "");
$template->themeInit(); ?>
<nav class="breadcrumb-section theme1 padding-custom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2 class="title pb-4 text-dark text-capitalize">
                        Favoritos
                    </h2>
                </div>
            </div>
            <div class="col-12">
                <ol class="breadcrumb bg-transparent m-0 p-0 align-items-center justify-content-center">
                    <li class="breadcrumb-item"><a href="<?= URL ?>">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Favoritos
                    </li>
                </ol>
            </div>
        </div>
    </div>
</nav>
<?php
if ($sesionActiva) { ?>
    <div class="container">
        <div class="shop-area mt-50 pb-90">
            <div class="row flex-row-reverse">
                <div class="col-lg-12">
                    <div class="portfolio-standard mt-0">
                        <div class="container">
                            <div class="row">
                                <div class="products-section shop mt-0">
                                    <div class="row grid-favorites" data-url="<?= URL ?>" data-favorites="true"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                    <button id="grid-products-btn" class="btn btn__secondary loadMoreportfolio" onclick="loadMore()">
                                        CARGAR MÁS
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="alert alert-warning mt-30 mb-250" role="alert">¡Para tener productos favoritos debes estar registrado! <a href="<?= URL ?>/usuarios?link=<?= CANONICAL ?>"> ¡Click aqui!</a></div>
<?php } ?>
</div>
<script>
    function checkRefresh(id) {
        if ($("#" + id).prop('checked')) {
            $("#" + id).prop("checked", false);
        } else {
            $("#" + id).prop("checked", true);
        }
        $("#" + id).trigger("change");
    }
</script>
<?php
$template->themeEnd();
?>
