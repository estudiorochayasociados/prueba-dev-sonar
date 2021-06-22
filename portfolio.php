<?php
require_once "Config/Autoload.php";
Config\Autoload::run();


use JasonGrimes\Paginator;

$template = new Clases\TemplateSite();
$contenidos = new Clases\Contenidos();
$f = new Clases\PublicFunction();
$banner = new Clases\Banners();
$idiomas = new Clases\Idiomas();
$categoris = new Clases\Categorias();

$data2 = [
    "filter" => ["area = 'recursos'"],
    "images" => true,
    "idioma" => $_SESSION['lang'],
];
$recursosPortfolio = $contenidos->list($data2, $_SESSION["lang"]);
// $imagenesPortfolio = $contenidos->list(["filter" => ["cod IN ('49f0ab78bf','2e54bb3c48','1f89359b50','2e8f60e7a4')"]], $_SESSION["lang"]);


$data = [
    "filter" => ["area = 'portofolio'"],
    "images" => true,
    "idioma" => $_SESSION['lang'],
];
#List de contenidos (al ser único el título, solo trae un resultado)
$contenidoData = $contenidos->list($data, $_SESSION["lang"]);
#Si se encontro el contenido se almacena y sino se redirecciona al inicio

!empty($contenidoData) ? $contenidoData  : $f->headerMove(URL);

$filtro_publicidad =[
    "filter" => ["area = 'portofolio'", "categoria = 'publ1cidad'"],
];
$filtro_publicidad = $contenidos->list($data, $_SESSION["lang"]);
!empty($filtro_publicidad) ? $filtro_publicidad  : $f->headerMove(URL);

#Opciones del paginador
$itemsPerPage = 6;
$totalItems = count($contenidoData);
$currentPage = !empty($_GET["pagina"]) ? $f->antihack_mysqli($_GET["pagina"]) : 1;
$urlPattern = preg_replace("/\/pagina\/(\d+)/i", "", CANONICAL) . '/pagina/(:num)';
$urlPattern = str_replace("novedades//", "novedades/", $urlPattern);
$paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
$paginator->setMaxPagesToShow(3);
$paginator->setPreviousText("");
$paginator->setNextText("");

#Con las opciones del paginador se limita la cantidad de novedades a mostrar en cada página
$contenidoData = array_slice($contenidoData, (($currentPage - 1) * $itemsPerPage), $itemsPerPage);


#Información de cabecera
$template->set("title", $contenidoData[array_key_first($contenidoData)]['data']['area'] . " | " . TITULO);
$template->set("description", "");
$template->set("keywords", "");
$template->set("imagen", isset($bannerData['image']['ruta']) ? URL . '/' . $bannerData['image']['ruta'] : LOGO);

$template->themeInit();

?>
<nav class="breadcrumb-section theme4 padding-custom pt-10 pb-10">

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-0 pb-3 text-center">
                    <h2 class="title pb-2 text-dark text-capitalize">
                        <?= $recursosPortfolio["showcase"]["data"]["titulo"] ?>
                    </h2>
                </div>
            </div>
            <div class="col-12">
                <ol class="breadcrumb bg-transparent m-0 p-0 align-items-center justify-content-center">
                    <li class="breadcrumb-item">
                        <a href="<?= URL ?>"><?= $recursosPortfolio["home"]["data"]["titulo"] ?></a>
                        <a href="<?= URL ?>">/ <?= $recursosPortfolio["newes"]["data"]["titulo"] ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= $recursosPortfolio["showcase"]["data"]["titulo"] ?>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</nav>


<section class="showcases">
    <div class="container">
        <div class="row">
            <div class="col-12 wow fadeIn">
                <div class="section-title">
                    <h2><?= $recursosPortfolio["portf"]["data"]["titulo"] ?></h2>
                    <?= $recursosPortfolio["portf"]["data"]["contenido"] ?>
                </div>
                <!-- end section-title -->
</section>

<aside class="sidebar pull-left">
    <ul class="list-group">
        <li class="list-group-item"><a href="#"><?= $recursosPortfolio["all"]["data"]["titulo"] ?></a></li>
        <li class="list-group-item"><a href="audiovisual"><?= $recursosPortfolio["business"]["data"]["titulo"] ?></a></li>
        <li class="list-group-item"><a href="javascript:void(0);" data-filter=".web"><?= $recursosPortfolio["dev"]["data"]["titulo"] ?></a></li>
        <li class="list-group-item"><a href="javascript:void(0);" data-filter=".three"><?= $recursosPortfolio["strategy"]["data"]["titulo"] ?></a></li>
        <li class="list-group-item"><a href="javascript:void(0);" data-filter=".publicidad"><?= $recursosPortfolio["training"]["data"]["titulo"] ?></a></li>
    </ul>
</aside>
</div>
<!-- end col-12 -->
<div class="row">
    <?php
    foreach ($contenidoData as $contentItem) {
        // echo '<pre>';
        // var_dump($contentItem);
        // echo '</pre>'
    ?>
        <div class="col-sm-12 col-md-8 col-lg-4">
            <div class="service-item">
                <div class="service-item__content">
                    <div class="service-item__icon position-relative">
                        <img src="<?= URL . "/" . $contentItem['data']['imagenes_rutas'] ?>" alt="<?= $contentItem['data']['titulo'] ?>">
                    </div>

                    <h3><?= $contentItem['data']['titulo'] ?></h3>


                    <div>
                        <h5> <?= $contentItem['data']['description'] ?></h5>
                    </div>
                    <div class="container">
                        <a href="<?= URL . "/c/" . $contentItem['data']['area'] . "/" . $f->normalizar_link($contentItem['data']['titulo']) . "/" . $contentItem['data']['cod']; ?>" class="btn btn__secondary" style="position: static ;top: 100%;">
                            <i class="icon-arrow-right"></i>
                            <strong><span> <?= $_SESSION["lang-txt"]["general"]["ver_mas"] ?></span></strong>
                    </div>
                    </a>
                </div>
            </div>
        </div><!-- /.col-lg-4 -->
    <?php } ?>
</div>
</div>
<!-- end col-12 -->
</div>



<!-- end showcases -->
<div class="row">
    <div class="offset-md-4"></div>
    <div class="col-md-4">
        <ul>
            <?= $paginator ?>
        </ul>
    </div>
</div>
<?php $template->themeEnd() ?>