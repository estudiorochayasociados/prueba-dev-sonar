<?php
$config = new Clases\Config();
$contenidos = new Clases\Contenidos();
$area = new Clases\Area();
#Se carga la configuración de email
$contactData = $config->viewContact();
$socialData = $config->viewSocial();
$telefono = isset($contactData['data']['whatsapp']) && $contactData['data']['whatsapp'] != "-" ? $contactData['data']['whatsapp'] : $contactData['data']['telefono'];

$footer =  $contenidos->list(["filter" => ["cod = 'footer-1'"]], $_SESSION["lang"], true);
$data = [
    "filter" => ["area = 'recursos'", "categoria = 'links'"],
    "images" => true,
    "idioma" => $_SESSION['lang'],
];
$contenidodata = $contenidos->list($data, $_SESSION['lang']);
$recursosdata = $contenidos->list(["filter" => ["cod IN ('adress','working','supp','inf')"]], $_SESSION["lang"]);
//$linksData = $area->list(["categori = 'links' "],'', '',$_SESSION["lang"]);
//echo '<pre>';
//var_dump($linksData);
//echo '</pre>';
?>

<footer class="footer">
    <div class="contact-wrapper">
        <div class="container">
            <div class="content-box wow fadeIn"><i class="fa fa-address-book-o" aria-hidden="true"></i>
                <h3><?= $recursosdata["adress"]["data"]["titulo"] ?></h3>
                <?= $recursosdata["adress"]["data"]["contenido"] ?>
            </div>
            <!-- end content-box -->
            <div class="content-box wow fadeIn"> <i class="fa fa-hourglass" aria-hidden="true"></i>
                <h3><?= $recursosdata["working"]["data"]["titulo"] ?></h3>
                <?= $recursosdata["working"]["data"]["contenido"] ?>
            </div>
            <!-- end content-box -->
            <div class="content-box wow fadeIn"> <i class="fa fa-heartbeat" aria-hidden="true"></i>
                <h3><?= $recursosdata["supp"]["data"]["titulo"] ?></h3>
                <?= $recursosdata["supp"]["data"]["contenido"] ?><a href="#">call</a> or <a href="#">e-mail</a> us anytime
            </div>
            <!-- end content-box -->
        </div>
        <!-- end container -->
    </div>
    <!-- end contact-wrapper -->
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 wow fadeIn"> <i class="fa fa-database fa-2x text-success" aria-hidden="true"></i>
                    <?= $recursosdata["inf"]["data"]["contenido"] ?>
                </div>
                <!-- end col-4 -->
                <div class="col-lg-2 col-md-6 wow fadeIn">
                    <ul class="footer-menu">
                       
                            <div>
                                <ul>
                                    <li><a href="c/servicios"><?= $contenidodata['consultation']['data']['titulo'] ?></a></li>
                                    <li><a href="portfolio"><?= $contenidodata['businesss']['data']['titulo'] ?></a></li>
                                    <li><a href="contacto"><?= $contenidodata['contact']['data']['titulo'] ?></a></li>
                                    <li><a href="empresa"><?= $contenidodata['newes']['data']['titulo'] ?></a></li>
                                    
                                </ul>
                            </div>
                        

                       
                </div>


                <!-- end col-2 -->
                <div class="col-lg-4 wow fadeIn position-relative-left">
                    <div class="contact-box">
                        <h5><?= $_SESSION["lang-txt"]["usuarios"]["telefono"] ?></h5>
                        <h3> <?= $telefono ?> </h3>
                        <p> <?= $_SESSION["lang-txt"]["usuarios"]["email"] ?> <a href="#"><?= $contactData['data']["email"] ?></a></p>
                        <ul>
                            <?php
                            foreach ($socialData['data'] as $key => $value) {
                                if (!$value) continue;
                                echo  "<li><a class='fs-12' href='" . $value . "' target='_blank'><span class='fa fa-1g fa-" . $key . "'></span></a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                    <!-- end contact-box -->
                </div>
                <!-- end col-4 -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end content-wrapper -->
    <div class="sub-footer wow fadeIn">
        <div class="container"> <span class="copyright"><?= $_SESSION["lang-txt"]["general"]["derechos_reservados"] ?> <a href="<?= URL ?>" target="_blank" style="color: orange"><?= TITULO ?></a></span> </div>
        <!-- end container -->
    </div>
    <!-- end sub-footer -->
</footer>

<!-- Scripts CMS -->
<script src="<?= URL ?>/assets/js/services/lang.js"></script>
<script src="<?= URL ?>/assets/js/lightbox.js"></script>
<script src="<?= URL ?>/assets/js/bootstrap-notify.min.js"></script>
<script src="<?= URL ?>/assets/js/toastr.min.js"></script>
<script src="<?= URL ?>/assets/js/services/cart.js"></script>
<script src="<?= URL ?>/assets/js/services/services.js"></script>
<script src="<?= URL ?>/assets/js/services/search.js"></script>
<script src="<?= URL ?>/assets/js/services/products.js"></script>
<script src="<?= URL ?>/assets/js/services/user.js"></script>

<!-- Fin Scripts CMS -->
<!-- Scripts Template -->
<script src="<?= URL ?>/assets/theme/js/jquery.min.js"></script>
<script src="<?= URL ?>/assets/theme/js/popper.min.js"></script>
<script src="<?= URL ?>/assets/theme/js/bootstrap.min.js"></script>
<script src="<?= URL ?>/assets/theme/js/fancybox.min.js"></script>
<script src="<?= URL ?>/assets/theme/js/odometer.min.js"></script>
<script src="<?= URL ?>/assets/theme/js/timeline.js"></script>
<script src="<?= URL ?>/assets/theme/js/swiper.min.js"></script>
<script src="<?= URL ?>/assets/theme/js/isotope.min.js"></script>
<script src="<?= URL ?>/assets/theme/js/wow.min.js"></script>
<script src="<?= URL ?>/assets/theme/js/imagesloaded.pkgd.min.js"></script>
<script src="<?= URL ?>/assets/theme/js/scripts.js"></script>
<!-- Fin Scripts Template -->
<script>
    $(document).ready(function() {
        refreshCart($('body').attr('data-url'));
        $("price").removeClass("hidden");
        viewCart($('body').attr('data-url'));
    });
</script>