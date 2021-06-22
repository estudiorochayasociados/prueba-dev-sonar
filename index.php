<?php
require_once "Config/Autoload.php";
Config\Autoload::run();

$template = new Clases\TemplateSite();
$f = new Clases\PublicFunction();
$banners = new Clases\Banners();
$productos = new Clases\Productos();
$contenidos = new Clases\Contenidos();

$sliderDesktop = $banners->list(["categoria = 'slider-inicio'"], '', '', $_SESSION["lang"]);
$bannerMarcas = $banners->list(["categoria = 'marcas'"], '', '');



$banner_inicio = $banners->list(["categoria = '4786cc053d'"], '', '');
$servicios_categorias = $contenidos->list(["area = 'servicios'"], '', '');
$proyectos = $contenidos->list(["area = 'proyectos'"], '', '', 'true', '', 6, '');
$miembros = $contenidos->list(["area = 'miembros'"], '', '', 'true', '', 5, '');
$novedades = $contenidos->list(["area = 'novedades'"], '', '', 'true', '', 3, '');




$contenidosIndex = $contenidos->list(["filter" => ["cod IN ('banner-inicio','pie-inicio')"]], $_SESSION["lang"]);

$data = [
    "category" => true,
    "subcategory" => true,
    "images" => true,
    "order" => "RAND()",
    "limit" => 12,

];
$productosData  = $productos->list($data, $_SESSION['lang']);

$fav = (isset($_SESSION['usuarios']) && !empty($_SESSION['usuarios'])) ? true : false;

#Información de cabecera
$template->set("title", TITULO);
$template->set("description", "");
$template->set("keywords", "");
$template->themeInit();
?>
    <!-- end header -->
    <section class="slider">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($banner_inicio as $banners) { ?>
                <div class="swiper-slide">
                    <div class="slide-inner bg-image" data-background="<?= URL . "/" . $banners['image']['ruta'] ?>" data-text="<?= $banners['data']['subtitulo'] ?><span><?= $banners['data']['titulo'] ?></span>">
                        <div class="container">
                            <h6 data-swiper-parallax="100"><?= $banners['data']['subtitulo'] ?></h6>
                            <h2 data-swiper-parallax="200"><span>.</span><?= $banners['data']['titulo'] ?></h2>
                            <p data-swiper-parallax="300"><?= $banners['data']['link'] ?></p>
                            <div class="clearfix"></div>
                            <a href="#" data-swiper-parallax="200">Discover More<span></span></a>
                        </div>
                        <!-- end container -->
                    </div>
                    <!-- end slide-inner -->
                </div>
            <?php } ?>
            <!-- end swiper-slide -->
        </div>
        <!-- end swiper-wrapper -->
        <div class="swiper-custom-pagination"></div>
        <!-- end swiper-custom-pagination -->
    </div>
    <!-- end swiper-container -->
</section>
<!-- end slider -->

<section class="featured-services">
    <div class="content-wrapper">
        <div class="container my-5">
            <div class="content-box wow fadeIn">
                <?= $recursos['inicio_pie']['data']['contenido'] ?>
            </div>
            <!-- end content-box -->
        </div>
        <!-- end container -->
    </div>
    <!-- end content-wrapper -->
    <div class="logos fadeIn">
        <div class="container">
            <ul>
                <?php foreach ($recursos['logos_marcas']['data']['imagenes_rutas'] as  $logo) {  ?>
                    <li class="scale-down"><img src="<?= URL . '/' . $logo ?>" alt="Image"></li>
                <?php } ?>
            </ul>
        </div>
        <!-- end container -->
    </div>
    <!-- end logos -->
</section>
<!-- end featured-services -->

<section class="image-content-box">
    <div class="container">
        <div class="row">
            <div class="col-12 wow fadeIn">
                <div class="section-title">
                    <h2><?= $recursos['titulo_desarrollo']['data']['titulo'] ?></h2>
                    <h6 class="max-width"><?= $recursos['titulo_desarrollo']['data']['subtitulo'] ?></h6>
                </div>
                <!-- end section-title -->
            </div>
            <!-- end col-12 -->
            <div class="col-12">
                <div class="content-box wow fadeIn">
                    <p><?= $recursos['titulo_desarrollo']['data']['contenido'] ?></p>
                </div>
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<!-- end image-content-box -->

<section class="side-image-content moved-space" id="counter">
    <div class="sides bg-image wow fadeIn" data-background="<?= $recursos['introduccion']['data']['imagenes_rutas'][0] ?>">
        <div class="video">
            <video src="<?= $recursos['introduccion']['data']['link'] ?>" loop autoplay muted></video>
        </div>
        <!-- end video -->
        <a href="<?= $recursos['introduccion']['data']['link'] ?>" class="play-btn" data-fancybox>
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 104 104" enable-background="new 0 0 104 104" xml:space="preserve">
                <path fill="none" stroke="#FFFFFF" stroke-width="5" stroke-miterlimit="10" d="M26,35h52L52,81L26,35z" />
                <circle class="video-play-circle" fill="none" stroke="#fff" stroke-width="5" stroke-miterlimit="10" cx="52" cy="52" r="50" />
            </svg>
            <span class="video-play-outline"></span> </a>
    </div>
    <!-- end sides -->
    <div class="sides bg-color wow fadeIn" data-background="#405089">
        <div class="inner">
            <?= $recursos['introduccion']['data']['contenido']; ?>
        </div>
        <!-- end inner -->
    </div>
    <!-- end sides -->
</section>
<!-- end side-image-content -->

<section class="icon-content-box">
    <div class="container">
        <div class="row">
            <div class="col-12 wow fadeIn">
                <div class="section-title">
                    <h2><?= $recursos['servicios_titulo']['data']['titulo'] ?></h2>
                    <h6><?= $recursos['servicios_titulo']['data']['contenido'] ?></h6>
                </div>
                <!-- end section-title -->
            </div>
            <!-- end col-12 -->

            <div class="col-12">
                <?php foreach ($servicios_categorias as $key => $servicios_categorias_item) { ?>
                    <div class="content-box wow fadeIn">
                        <div class="flip-box" data-flip-direction="horizontal-to-left" data-h_text_align="left" data-v_text_align="center">
                            <div class="flip-box-front" data-bg-overlay="true" data-text-color="light">
                                <div class="inner">
                                    <h4><?= $servicios_categorias_item['data']['titulo'] ?></h4>
                                    <figure> <img src="<?= URL . '/' . $servicios_categorias_item['image']['ruta'] ?>" alt="Image"> </figure>
                                </div>
                                <!-- end inner -->
                            </div>
                            <!-- end flip-box-front -->
                            <div class="flip-box-back">
                                <div class="inner">
                                    <h4><?= $servicios_categorias_item['data']['titulo'] ?></h4>
                                    <p><?= $servicios_categorias_item['data']['descripcion'] ?></p>
                                    <a href="<?= URL . "/c/" . $servicios_categorias_item['data']['area'] . '/' . $servicios_categorias_item['data']['cod'] ?>"><span>Ver Mas</span></a>
                                </div>
                                <!-- end inner -->
                            </div>
                            <!-- end end flip-box-back -->
                        </div>
                        <!-- end flip-box -->
                    </div>
                    <!-- end content-box -->
                <?php } ?>
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<!-- end servicios -->

<section class="image-content-over-box">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="section-title wow fadeIn">
                    <h2><?= $recursos['proyectos_titulo']['data']['titulo'] ?></h2>
                    <h6><?= $recursos['proyectos_titulo']['data']['contenido'] ?></h6>
                </div>
                <!-- end section-title -->
            </div>
            <!-- end col-3 -->
            <div class="col-lg-8">
                <div class="swiper-carousel wow fadeIn">
                    <div class="swiper-wrapper">
                        <?php foreach ($proyectos as $proyectos_item) {  ?>
                            <div class="swiper-slide">
                                <a href="<?= URL . '/c/' . $proyectos_item['data']['area'] . '/' . $f->normalizar_link($proyectos_item['data']['titulo']) . '/' . $proyectos_item['data']['cod'] ?>">
                                    <figure> <img src="<?= URL . '/' . $proyectos_item['data']['imagenes_rutas'][0] ?>" alt="imagen">
                                        <figcaption>
                                            <h4><?= $proyectos_item['data']['titulo'] ?></h4>
                                            <small><?= $proyectos_item['data']['subtitulo'] ?></small>
                                        </figcaption>
                                    </figure>
                                </a>
                            </div>
                            <!-- end swiper-slide -->
                        <?php } ?>
                    </div>
                    <!--end swiper-wrapper -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <!-- end swiper-carousel -->
                <a href="<?= URL . "/c/" . $proyectos[0]['data']['area']  ?>" Class="btn"><span>Ver Mas</span></a>
            </div>
            <!-- end col-6 -->
        </div>
    </div>
    <!-- end container -->
</section>
<!-- end proyectos -->

<section class="team-members">
    <div class="container">
        <div class="row">
            <div class="col-12 wow fadeIn">
                <div class="section-title">
                    <h2><?= $recursos['miembros_del_equipo']['data']['titulo'] ?></h2>
                    <h6><?= $recursos['miembros_del_equipo']['data']['contenido'] ?></h6>
                </div>
                <!-- end section-title -->
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
    <div class="content-wrapper">
        <?php foreach ($miembros as $key => $miembros_item) {
            $redes = explode(';', $miembros_item['data']['link']);

            #redes
            $facebook = '';
            $instagram = '';
            $twitter = '';
            $linkedin = '';
            $google_plus = '';
            $youtube = '';

            if (!empty($redes)) {
                foreach ($redes as $redItem) {

                    if (explode(',', $redItem)[0] == 'facebook') {
                        $facebook = "<li><a href='" . explode(',', $redItem)[1] . "' target='_blank'><i class='fa fa-facebook'></i></a></li>";
                    }
                    if (explode(',', $redItem)[0] == 'instagram') {
                        $instagram = "<li><a href='" . explode(',', $redItem)[1] . "' target='_blank'><i class='fa fa-instagram'></i></a></li>";
                    }
                    if (explode(',', $redItem)[0] == 'twitter') {
                        $twitter = "<li><a href='" . explode(',', $redItem)[1] . "' target='_blank'><i class='fa fa-twitter'></i></a></li>";
                    }
                    if (explode(',', $redItem)[0] == 'linkedin') {
                        $linkedin = "<li><a href='" . explode(',', $redItem)[1] . "' target='_blank'><i class='fa fa-linkedin'></i></a></li>";
                    }
                    if (explode(',', $redItem)[0] == 'google_plus') {
                        $google_plus = "<li><a href='" . explode(',', $redItem)[1] . "' target='_blank'><i class='fa fa-google_plus'></i></a></li>";
                    }
                    if (explode(',', $redItem)[0] == 'youtube') {
                        $youtube = "<li><a href='" . explode(',', $redItem)[1] . "' target='_blank'><i class='fa fa-youtube-play></i></a></li>";
                    }
                }
            }
        ?>
            <figure class="member wow fadeIn d-block w-100"> <img src="<?= URL . '/' . $miembros_item['data']['imagenes_rutas'][0] ?>" alt="Image" class="fist-image"> <img src="<?= URL . '/' . $miembros_item['data']['imagenes_rutas'][1] ?>" alt="Image" class="second-image">
                <figcaption>
                    <h5><?= $miembros_item['data']['titulo'] ?></h5>
                    <small> <?= $miembros_item['data']['subtitulo'] ?></small>
                    <ul>
                        <?= $facebook ?>
                        <?= $instagram ?>
                        <?= $twitter ?>
                        <?= $linkedin ?>
                        <?= $google_plus ?>
                        <?= $youtube ?>
                    </ul>
                </figcaption>
            </figure>
            <!-- end member -->
        <?php } ?>
    </div>
    <!-- end content-wrapper -->
</section>
<!-- end team-members -->

<section class="latest-news">

    <?php $link = URL . "/c/" . $novedades[0]['data']['area']  ?>
    <div class="container">
        <div class="row">
            <div class="col-12 wow fadeIn">
                <div class="section-title">
                    <h2><?= $recursos['novedades_titulo']['data']['titulo'] ?></h2>
                    <h6><?= $recursos['novedades_titulo']['data']['subtitulo'] ?></h6>
                </div>
                <!-- end section-title -->
            </div>
            <!-- end col-12 -->
            <div class="col-12">
                <?php foreach ($novedades as $novedad) { ?>
                    <div class="content-box wow fadeIn"> <span><?= $novedad['data']['subtitulo'] ?></span>
                        <h4><?= $novedad['data']['titulo'] ?></h4>
                        <small><?= $novedad['data']['fecha'] ?></small>
                        <p><?= substr($novedad['data']['contenido'], 0, 150) ?> ...</p>
                        <a href='<?= URL . "/c/" . $novedad['data']['area'] . '/' . $f->normalizar_link($novedad['data']['titulo']) . '/' . $novedad['data']['cod'] ?>'><i class="fa fa-arrow-right fa-lg" aria-hidden="true"></i></a>
                    </div>
                <?php } ?>
                <!-- end content-box -->
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row -->
        <a href="<?= URL . "/c/" . $novedades[0]['data']['area']  ?>" Class="btn"><span>Ver Mas</span></a>
    </div>
    <!-- end container -->
</section>
<!-- end latest-news -->

<section class="info-box">
    <div class="container wow fadeIn">
        <h3><?= $recursos['info_box']['data']['titulo'] ?></h3>
        <h6><?= $recursos['info_box']['data']['subtitulo'] ?></h6>
        <p><?= $recursos['info_box']['data']['contenido'] ?></p>
        <img src="<?= URL . '/' . $recursos['info_box']['data']['imagenes_rutas'][0] ?>" alt="Image">
    </div>
</section>
<!-- end info-box -->

<section class="request-form">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 wow fadeIn">
                <div class="section-title light">
                    <h2><?= $recursos['contacto']['data']['titulo'] ?></h2>
                    <h6><?= $recursos['contacto']['data']['contenido'] ?></h6>
                </div>
                <!-- end section-title -->
            </div>
            <!-- end col-5 -->
            <div class="col-lg-7 wow fadeIn">
                <form id="clientData" class="row inner" onsubmit="getClientData('<?= URL ?>')">
                    <div class="form-group col-md-6">
                        <label>Nombre</label>
                        <input name="nombre" type="text">
                    </div>
                    <!-- end form-group -->
                    <div class="form-group col-md-6">
                        <label>Apellido</label>
                        <input name="apellido" type="text">
                    </div>
                    <!-- end form-group -->
                    <div class="form-group col-md-6">
                        <label>Numero de telefono</label>
                        <input name="telefono" type="text">
                    </div>
                    <!-- end form-group -->
                    <div class="form-group col-md-6">
                        <label>Correo</label>
                        <input name="correo" type="email">
                    </div>
                    <!-- end form-group -->
                    <div class="form-group col-md-12">
                        <label>Nombre de la empresa</label>
                        <input name="nombreEmpresa" type="text">
                    </div>
                    <!-- end form-group -->
                    <div class="form-group col-md-12">
                        <label>Contanos brevemente de qué se trata tu empresa o comercio:</label>
                        <input name="data" type="text">
                    </div>
                    <!-- end form-group -->
                    <div class="form-group col-md-4">
                        <label>&nbsp;</label>
                        <input id="agregar" name="agregar" type="submit" value="ENVIAR">
                    </div>
                    <!-- end form-group -->
                </form>
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<!-- end consultation-form -->
<?php $template->themeEnd() ?>