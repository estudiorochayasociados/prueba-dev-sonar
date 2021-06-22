<?php
require_once "Config/Autoload.php";
Config\Autoload::run();

$template = new Clases\TemplateSite();
$f = new Clases\PublicFunction();
$landing = new Clases\Landing();
$config = new Clases\Config();

#Variables GET
$cod = isset($_GET["cod"]) ? $f->antihack_mysqli( $_GET["cod"]) : '';

#View de la landing actual
$landing->set("cod", $cod);
$landingData = $landing->view();

#Se carga la configuración de contacto
$dataContact = $config->viewContact();

#Fecha normalizada de la landing actual
$fecha = strftime("%u de %B de %Y", strtotime($landingData['data']['fecha']));

#Switch que cambia el titulo y el boton según la categoría
switch ($landingData['category']['data']['titulo']) {
    case "Informacion":
        $titulo_form = "Solicitá más información";
        $boton_form = "¡Pedir más info!";
        break;
    case "Compra":
        $titulo_form = "Llená el formulario y comprá online";
        $boton_form = "¡Comprar!";
        break;
    case "Sorteo":
        $titulo_form = "Participá del sorteo";
        $boton_form = "¡Participar!";
        break;
    case "Evento":
        $titulo_form = "Inscribíte al evento";
        $boton_form = "¡Inscribirme!";
        break;
    default:
        $titulo_form = "Completar el formulario";
        $boton_form = "¡Enviar mis datos!";
        break;
}

#Información de cabecera
$template->set("title", ucfirst(mb_strtolower($landingData['data']['titulo'])) . ' | ' . TITULO);
$template->themeInit();
?>
<!-- start page-title -->
<section class="page-title">
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <h2><?= $landingData['data']['titulo'] ?></h2>
                <ol class="breadcrumb">
                    <li><a href="<?= URL ?>">Inicio</a></li>
                    <li><?= $landingData['data']['titulo'] ?></li>
                </ol>
            </div>
        </div> <!-- end row -->
    </div> <!-- end container -->
</section>
<!-- end page-title -->

<div id="content" class="site-content mt-50 mb-50" tabindex="-1">
    <div class="container">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <article class="has-post-thumbnail hentry col-md-8">
                    <div class="product-images-wrapper">
                        <?php
                        if (!empty($landingData['images'])) {
                        ?>
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <?php
                                    foreach ($landingData['images'] as $key => $img) {
                                    ?>
                                        <div class="carousel-item <?php if ($key == 0) {
                                                                        echo "active";
                                                                    } ?>">
                                            <div style="height:500px;background:url(<?= URL ?>/<?= $img['ruta'] ?>)center/cover;"></div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <?php
                                if (@count($landingData['images']) > 1) {
                                ?>
                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                <?php
                                }
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div><!-- /.product-images-wrapper -->
                    <hr />
                    <header class="entry-header">
                        <div class="entry-meta">
                            <span class="posted-on"><a href="#" rel="bookmark"><i class="fa fa-calendar" aria-hidden="true"></i> <?= $fecha ?></a></span>
                        </div>
                        <h2 class="entry-title" itemprop="name headline"><?= $landingData['data']['titulo']; ?></h2>
                    </header><!-- .entry-header -->
                    <hr />
                    <p class="fs-20">
                        <?= $landingData['data']['desarrollo']; ?>
                    </p>
                </article>
                <div class="blogs-page col-md-4 ">
                    <div>
                        <h3><?= $titulo_form ?></h3>
                        <hr />
                        <form method="post" class="row" id="Formulario de Contacto" action="<?= URL ?>/gracias">
                            <label class="col-xs-12 col-sm-12 col-md-6">
                                Nombre <span style="color:red">(*)</span>:<br />
                                <input type="text" name="nombre" class="form-control" required />
                            </label>
                            <label class="col-xs-12 col-sm-12 col-md-6">
                                Apellido <span style="color:red">(*)</span>:<br />
                                <input type="text" name="apellido" class="form-control" required />
                            </label>
                            <label class="col-xs-12 col-sm-12 col-md-12">
                                Landing:<br />
                                <input type="text" readonly name="landing" class="form-control" value="<?= $landingData['data']["titulo"] ?>" />
                            </label>
                            <label class="col-xs-12 col-sm-12 col-md-12">
                                Teléfono:<br />
                                <input type="text" name="telefono" class="form-control" />
                            </label>
                            <label class="col-xs-12 col-sm-12 col-md-12">
                                Email <span style="color:red">(*)</span>:<br />
                                <input type="email" name="email" class="form-control" required />
                            </label>
                            <label class="col-xs-12 col-sm-12 col-md-12">
                                Mensaje:<br />
                                <textarea name="mensaje" class="form-control"></textarea>
                            </label>
                            <label class="col-xs-12 col-sm-12  col-md-12">
                                <input type="submit" name="enviar" class="btn btn-block btn-success" value="<?= $boton_form ?>" />
                            </label>
                        </form>
                        <hr />
                    </div>
                    <div class="mt-40 text-center">
                        <h5><b>Comunicate también por:</b></h5>
                        <div>
                            <a target="_blank" href="https://api.whatsapp.com/send?phone=549<?= $dataContact['data']['whatsapp'] ?>" class="btn btn-block btn-success fs-18">
                                <i class="ifoot fa fa-whatsapp" aria-hidden="true"></i> WhatsApp
                            </a>
                            <a target="_blank" href="tel:<?= $dataContact['data']['telefono'] ?>" class="btn btn-block btn-info fs-19">
                                <i class="ifoot fa fa-phone" aria-hidden="true"></i> <?= $dataContact['data']['telefono'] ?>
                            </a>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
</div>

<?php $template->themeEnd(); ?>





