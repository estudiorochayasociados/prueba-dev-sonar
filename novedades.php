<?php

use Clases\Imagenes;
use JasonGrimes\Paginator;

require_once "Config/Autoload.php";
Config\Autoload::run();

$template = new Clases\TemplateSite();
$f = new Clases\PublicFunction();
$contenido = new Clases\Contenidos();
$banner = new Clases\Banners();
$imagen = new Clases\Imagenes();
#List de novedads
// $novedadesData = $contenido->list(["area = 'novedad'"], "", "", true);

#Si se encontro el contenido se almacena y sino se redirecciona al inicio
// !empty($novedadesData) ? $novedadesData  : $f->headerMove(URL);

#Opciones del paginador
$itemsPerPage = 6;
$totalItems = count($novedadesData);
$currentPage = !empty($_GET["pagina"]) ? $f->antihack_mysqli($_GET["pagina"]) : 1;
$urlPattern = preg_replace("/\/pagina\/(\d+)/i", "", CANONICAL) . '/pagina/(:num)';
$urlPattern = str_replace("novedades//", "novedades/", $urlPattern);
$paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
$paginator->setMaxPagesToShow(3);
$paginator->setPreviousText("");
$paginator->setNextText("");

#Con las opciones del paginador se limita la cantidad de novedades a mostrar en cada página
$novedadesData = array_slice($novedadesData, (($currentPage - 1) * $itemsPerPage), $itemsPerPage);

#Información de cabecera
$template->set("title", "Novedades" . " | " . TITULO);
$template->set("description", "");
$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->themeInit();
?>
<nav class="breadcrumb-section theme4 padding-custom pt-10 pb-10">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2 class="title pb-2 text-dark text-capitalize">
                        Novedades
                    </h2>
                </div>
            </div>
            <div class="col-12">
                <ol class="breadcrumb bg-transparent m-0 p-0 align-items-center justify-content-center">
                    <li class="breadcrumb-item"><a href="<?= URL ?>">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Novedades
                    </li>
                </ol>
            </div>
        </div>
    </div>
</nav>
<section class="portfolio-grid">
    <div class="container">
        <div class="row">
            <?php foreach ($novedadesData as $novedad) {

            ?>
                <div class="col-sm-6 col-md-6 col-lg-4">
                    <div class="portfolio-item">
                        <div class="portfolio-item__img">
                            <a class="popup-gallery-item" href="<?= URL . "/" . $novedad['data']['imagenes_rutas'][0] ?>">
                                <img style="object-fit: contain;width:350px;height:350px" src="<?= URL . "/" . $novedad['data']['imagenes_rutas'][0] ?>" alt="<?= $novedad['data']['titulo'] ?>">
                            </a>
                        </div>
                        <div class="portfolio-item__content">
                            <h4 class="portfolio-item__title"><a href="<?= URL . "/c/area/" . $novedad['data']['area'] . "/titulo/" . $f->normalizar_link($novedad['data']['titulo']) . "/id/" . $novedad['data']['id'] ?>"><?= $novedad['data']['titulo'] ?></a></h4>
                            <a href="<?= URL . "/c/area/" . $novedad['data']['area'] . "/titulo/" . $f->normalizar_link($novedad['data']['titulo']) . "/id/" . $novedad['data']['id'] ?>">
                                <?= $novedad['data']['description'] ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<div class="row">
    <div class="offset-md-4"></div>
    <div class="col-md-4">
        <ul>
            <?= $paginator ?>
        </ul>
    </div>
</div>
<?php
$template->themeEnd();
?>