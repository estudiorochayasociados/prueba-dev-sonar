<?php
require_once "Config/Autoload.php";
Config\Autoload::run();

use JasonGrimes\Paginator;

$template = new Clases\TemplateSite();
$f = new Clases\PublicFunction();
$contenidos = new Clases\Contenidos();
$config = new Clases\Config();
$enviar = new Clases\Email();
$template->set("title", "Inicio");
$template->themeInit();
#Se carga la configuración de contacto
// $contactData = $config->viewContact();

#Se carga la configuración de email
// $emailData = $config->viewEmail();
// $data = [
//     "filter" => ['area = "recusos"'],
//     "idioma" => $_SESSION['lang'],
// ];
// $contenidoContacto = $contenidos->list($data,$_SESSION['lang']);
#Información de cabecera
// $template->set("title", "Contacto | " . TITULO);
// $template->set("description", "Envianos tus dudas y nosotros te asesoramos");
// $template->set("keywords", "");
// $template->themeInit();

$data = [
    "filter" => ["area = 'recursos'"],
    "images" => true,
    "idioma" => $_SESSION['lang'],
];
$recursosContacto = $contenidos->list($data, $_SESSION["lang"], false);
!empty($recursosContacto) ? $recursosContacto  : $f->headerMove(URL);

!empty($recursosContacto) ? $recursosContacto  : $f->headerMove(URL);

#Opciones del paginador
$itemsPerPage = 6;
$totalItems = count($recursosContacto);
$currentPage = !empty($_GET["pagina"]) ? $f->antihack_mysqli($_GET["pagina"]) : 1;
$urlPattern = preg_replace("/\/pagina\/(\d+)/i", "", CANONICAL) . '/pagina/(:num)';
$urlPattern = str_replace("novedades//", "novedades/", $urlPattern);
$paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
$paginator->setMaxPagesToShow(3);
$paginator->setPreviousText("");
$paginator->setNextText("");


?>
<nav class="breadcrumb-section theme4 padding-custom pt-10 pb-10">

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-0 pb-3 text-center">
                    <h2 class="title pb-2 text-dark text-capitalize ">
                        <?= $recursosContacto["newes"]["data"]["titulo"] ?>
                    </h2>
                </div>
            </div>
            <div class="col-12">
                <ol class="breadcrumb bg-transparent m-0 p-0 align-items-center justify-content-center">
                    <li class="breadcrumb-item">
                        <a href="<?= URL ?>"><?= $recursosContacto["home"]["data"]["titulo"] ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= $recursosContacto["newes"]["data"]["titulo"] ?>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</nav>

<!-- end page-header -->
<section class="contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-12 wow fadeIn">
                <div class="section-title">
                    <h2><?= $recursosContacto["our_company"]["data"]["titulo"] ?></h2>
                </div>
            </div>
            <div>
                <img src="<?= $recursosContacto["our_company"]['images'][0]["url"] ?>" class="mx-auto d-block" alt="">
            </div>
            <div class="pt-40px">
                <p class="text-dark"><?= $recursosContacto["our_company"]["data"]["contenido"] ?></p>
            </div>
            <a href="portfolio">
                <i class="icon-arrow-right"></i>
                <strong><span> <?= $_SESSION["lang-txt"]["general"]["ver_mas"] ?></span></strong>
                </a>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<?php $template->themeEnd() ?>