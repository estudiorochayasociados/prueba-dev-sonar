<?php
require_once "Config/Autoload.php";
Config\Autoload::run();

$template = new Clases\TemplateSite();
$f = new Clases\PublicFunction();
$contenidos = new Clases\Contenidos();

$filter = [];
foreach ($_GET as $key => $get_) {
    $get_ = $f->antihack_mysqli($get_);
    isset($_GET[$key]) ?  $filter[] = "$key = '" . $get_ . "'" : '';
}
$data = [
    "filter" => $filter,
    "images" => true,
    "gallery" => true
];

$area_cod = $_GET["area"];

#List de contenidos (al ser único el título, solo trae un resultado)
$contenidoData = $contenidos->list($data, $_SESSION["lang"], false);
#Si se encontro el contenido se almacena y sino se redirecciona al inicio
 
if (empty($contenidoData)) $f->headerMove(URL);
#Información de cabecera
$template->set("title", $contenidoData[array_key_first($contenidoData)]['data']['area'] . " | " . TITULO);
$template->set("description", "");
$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->themeInit();
?>
<nav class="breadcrumb-section theme4 padding-custom pt-10 pb-10">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-0 pb-3 text-center">
                    <h2 class="title pb-2 text-dark text-capitalize">
                        <?= $contenidoData[array_key_first($contenidoData)]['data']['area'] ?>
                    </h2>
                </div>
            </div>
            <div class="col-12">
                <ol class="breadcrumb bg-transparent m-0 p-0 align-items-center justify-content-center">
                    <li class="breadcrumb-item"><a href="<?= URL ?>">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= $contenidoData[array_key_first($contenidoData)]['data']['area'] ?>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</nav>

<section class="blog-section py-50">
    <div class="container">
        <div class="row">
            <?php
            foreach ($contenidoData as $contentItem) {
                $date = date_create($contentItem["data"]["fecha"]);
                $link = URL . "/c/" . $contentItem['data']['area'] . "/" . $f->normalizar_link($contentItem['data']['titulo']) . "/" . $contentItem['data']['cod'];
            ?>
                <div class="col-12 col-md-6 col-lg-4 col-xl-4 mb-30">
                    <div class="single-blog text-left">
                        <a class="blog-thumb mb-20 zoom-in d-block overflow-hidden" href="<?= $link ?>">
                            <img style="object-fit:contain;width:350px;height:350px" src="<?= $contentItem['images'][0]["url"] ?>" alt="blog-thumb-naile" />
                        </a>
                        <div class="blog-post-content">

                            <?php   if($area_cod != "servicios") {  ?>
                                <p class="sub-title">
                                    <?= date_format($date, "d/m/Y") ?>
                                </p>
                            <?php   }   ?>
                            
                            <h3 class="title mb-15 mt-15">
                                <a href="<?= $link ?>"><?= $contentItem['data']['titulo'] ?></a>
                            </h3>
                            <p class="text">
                                <?= $contentItem['data']['description'] ?>
                            </p>
                            
                            <?php   if($area_cod != "servicios") {  ?>
                                <a class="read-more" href="<?= $link ?>"><?= $_SESSION["lang-txt"]["general"]["ver_mas"] ?></a>
                            <?php   }   ?>
                            
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php
$template->themeEnd();
?>