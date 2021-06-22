<?php
require_once "Config/Autoload.php";
Config\Autoload::run();

$template = new Clases\TemplateSite();
$f = new Clases\PublicFunction();
$contenidos = new Clases\Contenidos();

$filter = [];

isset($_GET["area"]) ?  $filter[] = "area = '" . $f->antihack_mysqli($_GET["area"]) . "'" : '';
isset($_GET["cod"]) ?  $filter[] = "cod = '" . $f->antihack_mysqli($_GET["cod"]) . "'" : '';


$data = [
    "filter" => $filter,
    "images" => true,
    "category" => true,
    "gallery" => true,
];

#List de contenidos (al ser único el título, solo trae un resultado)
$contenidoData = $contenidos->list($data, $_SESSION["lang"], true);

#Si se encontro el contenido se almacena y sino se redirecciona al inicio
// !empty($contenidoData) ? $contenidoData = $contenidoData[0] : $f->headerMove(URL);
#Información de cabecera
$template->set("title", $contenidoData['data']['titulo'] . " | " . TITULO);
$template->set("description", $contenidoData['data']['description']);
$template->set("keywords", $contenidoData['data']['keywords']);
$template->set("imagen", isset($contenidoData['data']['imagenes_rutas'][0]) ? URL . '/' . $contenidoData['data']['imagenes_rutas'][0] : LOGO);
$template->themeInit();
?>
<nav class="breadcrumb-section theme1 padding-custom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2 class="title pb-4 text-dark text-capitalize">
                        <?= $contenidoData['data']['titulo'] ?>
                    </h2>
                </div>
            </div>
            <div class="col-12">
                <ol class="breadcrumb bg-transparent m-0 p-0 align-items-center justify-content-center">
                    <li class="breadcrumb-item"><a href="<?= URL ?>/c/<?= $contenidoData['data']['area'] ?>"><?= $contenidoData['data']['categoria_titulo'] ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= $contenidoData['data']['titulo'] ?>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</nav>
<section class="blog-section  pb-80 mt-50">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
                <div class="blog-posts">
                    <div class="single-blog-post blog-grid-post">
                        <?php if (isset($contenidoData["images"])) { ?>
                            <div class="blog-post-media">
                                <?php if (count($contenidoData["images"]) > 1) { ?>
                                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php foreach ($contenidoData["images"] as $key => $contentItem) {  ?>
                                                <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
                                                    <img class="d-block w-100" style="object-fit:contain;width:100px;height:600px" src="<?= $contentItem["url"] ?>" alt="<?= $contenidoData['data']['titulo'] ?>">
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                <?php } else { ?>
                                    <div class="blog-image single-blog">
                                        <a><img class="object-fit-none" src="<?= $contenidoData['images'][0]['url'] ?>" alt="<?= $contenidoData['data']['titulo'] ?>" /></a>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <div class="blog-post-content-inner">
                            <h4 class="blog-title"><?= $contenidoData['data']['titulo'] ?></h4>
                            <ul class="blog-page-meta">
                                <li>
                                    <a href="#"><i class="ion-calendar"></i> <?= $contenidoData['data']['fecha'] ?></a>
                                </li>
                            </ul>
                            <?= $contenidoData['data']['contenido'] ?>
                        </div>
                    </div>
                    <!-- single blog post -->
                </div>
                <?php
                if (isset($contenidoData['data']['keywords'])) {
                    $keyowrds = explode(",", $contenidoData['data']['keywords']);
                ?>
                    <div class="blog-single-tags-share d-sm-flex justify-content-between">
                        <div class="blog-single-tags d-flex">
                            <span class="title">Tags: </span>
                            <ul class="tag-list">
                                <?php foreach ($keyowrds as $keyowrdItem) { ?>
                                    <li><a href="#"><?= $keyowrdItem ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php
$template->themeEnd();
?>