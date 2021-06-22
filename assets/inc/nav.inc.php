<?php
$f = new Clases\PublicFunction();
$config = new Clases\Config();
$usuarios = new Clases\Usuarios();
$menu = new Clases\Menu();
$carrito = new Clases\Carrito();
$contenidos = new Clases\Contenidos();
$idiomas = new Clases\Idiomas();

$listLang = $idiomas->list("", "", "");
#Se carga la sesión del usuario
$usuario = $usuarios->viewSession();

#Se cargan los productos del carrito
$carro = $carrito->return();

#Se carga la configuración de contacto
$contactData = $config->viewContact();
$socialData = $config->viewSocial();

$sesionActiva = isset($_SESSION['usuarios']['cod']) ? true :  false;

$descripcion = $contenidos->list(["filter" => ["cod = 'description'"]], $_SESSION['lang'], true);

#Captcha
$captchaData = $config->viewCaptcha();

#Si existe la sesión y no es invitado, entonces se habilita el botón de mi cuenta en la nav
$habilitado = (isset($usuario["invitado"]) && $usuario["invitado"] == 0) ?  true : false;
$telefono = isset($contactData['data']['whatsapp']) && $contactData['data']['whatsapp'] != "-" ? $contactData['data']['whatsapp'] : $contactData['data']['telefono'];
?>
<div class="search-box">
        <div class="close-btn"> <span></span> <span></span> </div>
        <!-- end close-btn -->
        <form>
            <input type="search" placeholder="<?= $_SESSION['lang-txt']['productos']['buscar'] ?>">
            <h6> <?= $_SESSION["lang-txt"]["productos"]["buscar_desc"] ?> </h6>
        </form>
    </div>
    <!-- end search-box -->
    <aside class="sandwich-menu">
        <div class="logo"> <img src="<?= URL ?>/assets/images/logo-blanco.png" alt="Image"> </div>
        <!-- end logo -->
        <?= $menu->build_nav() ?>
        <!-- end nav-menu -->
        <?= $descripcion['data']['contenido'] ?>
        <address>
        <p> <?= $contactData['data']['domicilio'] ?> <br>
         <?= $contactData['data']['localidad'], ' - ', $contactData['data']['provincia'], ' - ', $contactData['data']['pais'] ?> </p>
        <p> 
            <?= $telefono ?> 
            <br>
            <?= $_SESSION["lang-txt"]["usuarios"]["email"] ?> <a href="#"> <?= $contactData['data']['email'] ?> </a>
        </p>
        </address>
        <ul class="social-media">
            <?php
            foreach ($socialData['data'] as $key => $value) {
                if (!$value) continue;
                echo  "<li><a class='fs-12' href='" . $value . "' target='_blank'><span class='fa fa-2x fa-" . $key . "'></span></a></li>";
            }
            ?>
        </ul>
        <!-- end social-media -->
         <span class="copyright"><?= $_SESSION["lang-txt"]["general"]["derechos_reservados"] ?> <a href="<?= URL ?>" target="_blank" style="color: orange"><?= TITULO ?></a></span> 
    </aside>
    <!-- end sandwich-menu -->
    <header class="header">
        <div class="topbar">
            <div class="container">
                <div class="tagline"> Work Hard <u>Play Hard</u></div>
                <!-- end tagline -->
                <ul class="social-media">
                <?php
                foreach ($socialData['data'] as $key => $value) {
                    if (!$value) continue;
                    echo  "<li><a class='fs-12' href='" . $value . "' target='_blank'><span class='fa fa-2x fa-" . $key . "'></span></a></li>";
                }
                ?>
                </ul>
                <!-- end social-media -->
                <div class="phone"><img src=" <?= URL ?> /assets/theme/images/icon-phone.png" alt="Image"> <span><b>AR</b> <?= $telefono ?> </span></div>
                <!-- end phone -->
            </div>
            <!-- end container -->
        </div>
        <!-- end topbar -->
        <nav class="navbar">
            <div class="container">
                <div class="logo">
                    <a href="#"> <img src="<?= URL ?>/assets/images/logo.png" alt="Image"> </a>
                </div>
                <!-- end logo -->
                <?= $menu->build_nav() ?>
                <!-- end nav-menu -->
                <ul class="language">
                    <?php foreach ($listLang as $idioma_) {  ?>
                        <li class="<?= ($idioma_['data']['cod'] == $_SESSION['lang']) ? "active" : "" ?>">
                            <a href="#" onclick="changeLang('<?= URL ?>','<?= $idioma_['data']['cod'] ?>')">
                                <img width="25" src="<?= URL_ADMIN ?>/img/idiomas/<?= $idioma_["data"]["cod"] ?>.png" alt="<?= $idioma_["data"]["titulo"] ?>" />
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <!-- end language -->
                <div class="search-btn"> <i class="fa fa-search"></i> </div>
                <!-- end search-btn -->
                <div class="sandwich-btn"> <i class="fa fa-lg fa-bars"></i> <span></span> </div>
                <!-- end sandwich-btn -->
                <div class="bottom-bar"></div>
                <!-- end bottom-bar -->
            </div>
            <!-- end container -->
        </nav>
        <!-- end navbar -->
    </header>
<script>
    $(document).ready(() => {
        getDataFavorites();
    });
</script>