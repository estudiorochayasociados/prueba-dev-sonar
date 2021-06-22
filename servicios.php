<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
use JasonGrimes\Paginator;

$template = new Clases\TemplateSite();
$f = new Clases\PublicFunction();
$contenidos = new Clases\Contenidos();
$idiomas = new Clases\Idiomas();

$data = [
    "filter" => ["area = 'servicios'"],
    "images" => true
];

$serviciosData = $contenidos->list($data, $_SESSION["lang"], false);

#Si se encontro el contenido se almacena y sino se redirecciona al inicio
!empty($serviciosData) ? $serviciosData  : $f->headerMove(URL);

#Información de cabecera
$template->set("title", "Servicios" . " | " . TITULO);
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
                        Servicios
                    </h2>
                </div>
            </div>
            <div class="col-12">
                <ol class="breadcrumb bg-transparent m-0 p-0 align-items-center justify-content-center">
                    <li class="breadcrumb-item">
                        <a href="<?= URL ?>">Inicio</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Servicios
                    </li>
                </ol>
            </div>
        </div>
    </div>
</nav>

<section class="services-layout1 pb-90">
    <div class="container">
        <div class="row">
            <?php 
            if(isset($_GET['cod'])){
                $cod = $_GET['cod'];
                $data = [
                    "filter" => ["area = 'servicios' cod = '$cod'"],
                    "images" => true,
                ];
            ?>
            <?php }
            foreach ($serviciosData as $servicio) { 
            ?>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="service-item">
                        <div class="service-item__content" id="<?=$servicio['data']['cod']?>">
                            <div class="service-item__icon">
                                <img src="<?= URL . "/" . $servicio['data']['imagenes_rutas'][0] ?>" alt="">
                            </div><!-- /.service-item__icon -->
                            <h4 class="service-item__title"><?= $servicio['data']['titulo'] ?></h4>

                            <div class="container">
                                <?= $servicio['data']['description'] ?>
                            </div>
                        </div>
                    </div><!-- /.service-item -->
                </div><!-- /.col-lg-4 -->
            <?php } ?>
        </div><!-- /.row -->
    </div><!-- /.container -->
</section><!-- /.Services Layout 1 -->

<script>
    $(function() {

        $(document).on('click', '.service-item__icon', '.service-item__title', function() {
            let element = $(this)[0].parentElement.attr('id');
        })
    })
</script>

<?php
$template->themeEnd();
?>