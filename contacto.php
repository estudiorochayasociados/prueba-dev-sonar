<?php
require_once "Config/Autoload.php";
Config\Autoload::run();

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
$filter = ["area = 'recursos'"];
$data = [
    "filter" => $filter,
    "images" => true,
];
$recursosContacto = $contenidos->list($data, $_SESSION["lang"],);
?>
<nav class="breadcrumb-section theme4 padding-custom pt-10 pb-10">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-0 pb-3 text-center">
                    <h2 class="title pb-2 text-dark text-capitalize">
                        <?= $recursosContacto["contacto"]["data"]["titulo"] ?>
                    </h2>
                </div>
            </div>
            <div class="col-12">
                <ol class="breadcrumb bg-transparent m-0 p-0 align-items-center justify-content-center">
                    <li class="breadcrumb-item">
                        <a href="<?= URL ?>"><?= $recursosContacto["home"]["data"]["titulo"] ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= $recursosContacto["contacto"]["data"]["titulo"] ?>
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
                    <h2><?= $recursosContacto["c35f9746a6"]["data"]["titulo"] ?></h2>
                    <h6><?= $recursosContacto["c35f9746a6"]["data"]["subtitulo"] ?><?= $recursosContacto["c35f9746a6"]["data"]["contenido"] ?></h6>
                </div>
                <!-- end section-title -->
                <div class="map" id="map"></div>
                <!-- end map -->
            </div>
            <!-- end col-6 -->
            <div class="col-lg-7 col-md-12 wow fadeIn">
                <div class="row inner">
                    <div class="col-md-6">

                        <h6><?= $recursosContacto["comunicacion"]["data"]["titulo"] ?></h6>
                        <?= $recursosContacto["comunicacion"]["data"]["contenido"] ?>

                    </div>
                    <!-- end col-6 -->
                </div>
                <!-- end row inner -->
                <form class="row" id="contact" name="contact" method="post">
                    <div class="form-group col-sm-6 col-12">
                        <label><?= $_SESSION["lang-txt"]["usuarios"]["nombre"] ?></label>
                        <input type="text" name="name" id="name" required>
                    </div>
                    <!-- end form-group -->
                    <div class="form-group col-sm-6 col-12">
                        <label><?= $_SESSION["lang-txt"]["usuarios"]["apellido"] ?></label>
                        <input type="text" name="surname" id="surname" required>
                    </div>
                    <!-- end form-group -->
                    <div class="form-group col-sm-6 col-12">
                        <label><?= $_SESSION["lang-txt"]["usuarios"]["email"] ?></label>
                        <input type="text" name="email" id="email" required>
                    </div>
                    <!-- end form-group -->
                    <div class="form-group col-sm-6 col-12">
                        <label><?= $_SESSION["lang-txt"]["usuarios"]["telefono"] ?></label>
                        <input type="text" name="subject" id="subject" required>
                    </div>
                    <!-- end form-group -->
                    <div class="form-group col-12">
                        <label><?= $_SESSION["lang-txt"]["usuarios"]["mensaje"] ?></label>
                        <textarea name="message" id="message" required></textarea>
                    </div>
                    <!-- end form-group -->
                    <div class="form-group col-12">
                        <input id="submit" type="submit" name="enviar">

                    </div>
                    <!-- end form-group -->
                </form>
                <!-- end form -->
                <div class="row">
                    <div class="col-12">
                        <div id="success" class="alert alert-success" role="alert">
                            <?= $_SESSION["lang-txt"]["checkout"]["envio_mensaje_correcto"] ?>
                        </div>
                        <!-- end success -->
                        <div id="error" class="alert alert-danger" role="alert">
                            <?= $_SESSION["lang-txt"]["checkout"]["envio_mensaje_inrrecto"] ?>
                        </div>
                        <!-- end error -->
                    </div>
                    <!-- end col-12 -->
                </div>
                <!-- end row inner -->
            </div>
            <!-- end col-6 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</section>
<?php $template->themeEnd() ?>