<?php
$config = new Clases\Config();
$funcion = new Clases\PublicFunction();
$tab = isset($_GET["tab"]) ? $funciones->antihack_mysqli($_GET["tab"]) : '';
$emailData = $config->viewEmail();
$marketingData = $config->viewMarketing();
$contactoData = $config->viewContact();
$socialData = $config->viewSocial();
$mercadoLibreData = $config->viewMercadoLibre();
$andreaniData = $config->viewAndreani();
$captchaData = $config->viewCaptcha();
$configHeader = $config->viewConfigHeader();
$exportadorMeliData = $config->viewExportadorMeli();


//Metodos de pagos
$config->set("id", 1);
$pagosData1 = $config->viewPayment();
$config->set("id", 2);
$pagosData2 = $config->viewPayment();
$config->set("id", 3);
$pagosData3 = $config->viewPayment();
$config->set("id", 4);
$pagosData4 = $config->viewPayment();

?>
<section id="tabs" class="project-tab text-capitalize mb-20 mt-40">
    <h2 class="text-uppercase fs-20">Contenidos y Configuraciones</h2>
    <hr />
    <div class="sidebar-left">
        <div class="sidebar">
            <div class="todo-sidebar d-flex">
                <div class="todo-app-menu">
                    <div class="sidebar-menu-list">
                        <div class="list-group">
                            <a class="list-group-item border-0" id="marketing-tab" data-toggle="tab" href="#marketing-home" role="tab" aria-controls="nav-profile" aria-selected="false">
                                <span class="fonticon-wrap">
                                    <i class="livicon-evo" data-options="name:pie-chart.svg; size: 30px; style:lines; strokeColor:#666;"></i>
                                    Marketing
                                </span>
                            </a>
                            <a class="list-group-item border-0" id="contact-tab" data-toggle="tab" href="#contact-home" role="tab" aria-controls="nav-contact" aria-selected="false">
                                <span class="fonticon-wrap">
                                    <i class="livicon-evo" data-options="name:building.svg; size: 30px; style:lines; strokeColor:#666;"></i>
                                    Datos Empresa
                                </span>
                            </a>
                            <a class="list-group-item border-0" id="social-tab" data-toggle="tab" href="#social-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                <span class="fonticon-wrap">
                                    <i class="livicon-evo" data-options="name:smartphone.svg; size: 30px; style:lines; strokeColor:#666;"></i>
                                    Redes Sociales
                                </span>
                            </a>
  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content" id="nav-tabContent">

        <!-- DATOS DE MARKETING -->
        <div class="tab-pane fade" id="marketing-home" role="tabpanel" aria-labelledby="nav-profile-tab">
            <?php include("options/cfg_marketing.php"); ?>
        </div>

        <!-- DATOS DE CONTACTO -->
        <div class="tab-pane fade" id="contact-home" role="tabpanel" aria-labelledby="nav-contact-tab">
            <?php include("options/cfg_contact.php"); ?>
        </div>

        <!-- DATOS DE REDES SOCIALES -->
        <div class="tab-pane fade" id="social-home" role="tabpanel" aria-labelledby="nav-contact-tab">
            <?php include("options/cfg_socialMedia.php"); ?>
        </div>

    
    </div>
</section>

<div style="width:100%;height:50px;clear:both" class="d-block clearfix"></div>

<section id="tabs" class="project-tab text-capitalize  mb-150 pb-150">
    <h2 class="text-uppercase fs-20">Configuraciones técnicas</h2>
    <hr />
    <div class="sidebar-left">
        <div class="sidebar">
            <div class="todo-sidebar d-flex">
                <div class="todo-app-menu">
                    <div class="sidebar-menu-list">
                        <div class="list-group">
                            <a class="list-group-item border-0 " id="email-tab" data-toggle="tab" href="#email-home" role="tab" aria-controls="nav-home" aria-selected="true">
                                <span class="fonticon-wrap">
                                    <i class="livicon-evo" data-options="name:gear.svg; size: 30px; style:lines; strokeColor:#666;"></i>
                                    Configuración Email
                                </span>
                            </a>
                            <a class="list-group-item border-0" id="api-tab" data-toggle="tab" href="#api-home" role="tab" aria-controls="nav-profile" aria-selected="false">
                                <span class="fonticon-wrap">
                                    <i class="livicon-evo" data-options="name:hand-bottom.svg; size: 30px; style:lines; strokeColor:#666;"></i>
                                    Api
                                </span>
                            </a>
                            <a class="list-group-item border-0" id="pagos-tab" data-toggle="tab" href="#pagos-home" role="tab" aria-controls="nav-contact" aria-selected="false">
                                <span class="fonticon-wrap">
                                    <i class="livicon-evo" data-options="name:credit-card-in.svg; size: 30px; style:lines; strokeColor:#666;"></i>
                                    Pagos
                                </span>
                            </a>
                            <a class="list-group-item border-0" id="checkout-tab" data-toggle="tab" href="#checkout-home" role="tab" aria-controls="nav-contact" aria-selected="false">
                                <span class="fonticon-wrap">
                                    <i class="livicon-evo" data-options="name:map.svg; size: 30px; style:lines; strokeColor:#666;"></i>
                                    Checkout
                                </span>
                            </a>
                            <a class="list-group-item border-0" id="captcha-tab" data-toggle="tab" href="#captcha-home" role="tab" aria-controls="nav-contact" aria-selected="false">
                                <span class="fonticon-wrap">
                                    <i class="livicon-evo" data-options="name:step-one-fifth.svg; size: 30px; style:lines; strokeColor:#666;"></i>
                                    Captcha
                                </span>
                            </a>
                            <a class="list-group-item border-0" id="cnf-tab" data-toggle="tab" href="#config-header" role="tab" aria-controls="nav-contact" aria-selected="false">
                                <span class="fonticon-wrap">
                                    <i class="livicon-evo" data-options="name:wide-screen.svg; size: 30px; style:lines; strokeColor:#666;"></i>
                                    Header
                                </span>
                            </a>
                            <a class="list-group-item border-0" id="exportadorMeli-tab" data-toggle="tab" href="#exportadorMeli-home" role="tab" aria-controls="nav-profile" aria-selected="false">
                                <span class="fonticon-wrap">
                                    <i class="livicon-evo" data-options="name:file-export.svg; size: 30px; style:lines; strokeColor:#666;"></i>
                                    Exportador Meli
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content" id="nav-tabContent">

        <div class="tab-pane fade" id="email-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <?php include("options/cfg_email.php"); ?>
        </div>
        <!-- DATOS DE API ANDREANI Y MERCADOLIBRE -->
        <div class="tab-pane fade" id="api-home" role="tabpanel" aria-labelledby="nav-contact-tab">
            <?php include("options/cfg_api.php"); ?>
        </div>

        <!-- DATOS DE METODOS DE PAGOS -->
        <div class="tab-pane fade" id="pagos-home" role="tabpanel" aria-labelledby="nav-contact-tab">
            <?php include("options/cfg_payment.php"); ?>
        </div>

        <!-- OPCIONES CHECKOUT -->
        <div class="tab-pane fade" id="checkout-home" role="tabpanel" aria-labelledby="nav-contact-tab">
            <?php include("options/cfg_checkout.php"); ?>
        </div>

        <!-- DATOS DE CAPTCHA -->
        <div class="tab-pane fade" id="captcha-home" role="tabpanel" aria-labelledby="nav-contact-tab">
            <?php include("options/cfg_captcha.php"); ?>
        </div>

        <!-- HARDCODEAR HEADER -->
        <div class="tab-pane fade" id="config-header" role="tabpanel" aria-labelledby="nav-header-tab">
            <?php include("options/cfg_header.php"); ?>
        </div>

        <!-- DATOS DE EXPORTADOR DE MERCADOLIBRE -->
        <div class="tab-pane fade" id="exportadorMeli-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <?php include("options/cfg_exportMeli.php"); ?>
        </div>
    </div>

</section>
<div style="width:100%;height:100px;clear:both" class="d-block clearfix"></div>


<script>
    $(document).ready(function() {
        $('#<?= $tab ?>').click();
    })
</script>