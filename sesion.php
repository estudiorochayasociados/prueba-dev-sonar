<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
$template = new Clases\TemplateSite();
$f = new Clases\PublicFunction();
$checkout = new Clases\Checkout();
$carrito = new Clases\Carrito();
$usuario = new Clases\Usuarios();

#Variables GET
$op = isset($_GET["op"]) ? $f->antihack_mysqli($_GET["op"]) : '';
$logout = isset($_GET["logout"]) ? true : false;

#Se carga la sesión del usuario
$usuarioSesion = $usuario->viewSession();

#Si no existe una sesión se redirige a usuarios
empty($usuarioSesion) ? $f->headerMove(URL . '/usuarios') : null;

#Si existe una sesión, pero es invitado, se sale de la cuenta y se redirige a usuarios
if ($usuarioSesion['invitado'] == 1) {
    $usuario->logout();
    $f->headerMove(URL . '/usuarios');
}

#Si se encuentra la variable Get logout, se elimina el checkout y la sesión y se redirige a usuarios
if ($logout) {
    $checkout->destroy();
    $usuario->logout();
    $f->headerMove(URL . '/usuarios');
}

#Se busca pedidos y cuenta en la URL para ponerle el atributo active al boton
$pedidos = $f->antihack_mysqli(strpos($_SERVER['REQUEST_URI'], "pedidos"));
$cuenta = $f->antihack_mysqli(strpos($_SERVER['REQUEST_URI'], "cuenta"));
$favoritos = $f->antihack_mysqli(strpos($_SERVER['REQUEST_URI'], "favoritos"));
if ($pedidos == "" && $cuenta == "" && $favoritos == "") {
    $pedidos = "ok";
}

#Información de cabecera
$template->set("title", $_SESSION["lang-txt"]["sesion"]["title"] . " | " . TITULO);
$template->themeInit();
?>

<div id="content" class="site-content mt-50 mb-50" tabindex="-1">

    <!--My Account section start-->
    <div class="my-account-section section  pb-100 pb-lg-80 pb-md-70 pb-sm-60 pb-xs-50">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="<?= URL ?>/productos" class="blanco pt-15 text-uppercase fs-18 btn btn-primary btn-lg d-block mb-15">
                                <i class="fa blanco fa-shopping-cart mb-10 d-block"></i>
                                <?= $_SESSION["lang-txt"]["sesion"]["ir_comprar"] ?>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= URL ?>/favoritos" class="blanco pt-15 text-uppercase fs-18 btn btn-primary btn-lg d-block mb-15 <?= $favoritos ? 'active' : '' ?>">
                                <i class="fa blanco fa-heart mb-10 d-block"></i>
                                <?= $_SESSION["lang-txt"]["sesion"]["mis_favoritos"] ?>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?= URL ?>/sesion/pedidos" class="blanco pt-15 text-uppercase fs-18 btn btn-primary btn-lg d-block mb-15 <?= $pedidos ? 'active' : '' ?>">
                                <i class="fa blanco fa-list mb-10 d-block"></i>
                                <?= $_SESSION["lang-txt"]["sesion"]["mis_compras"] ?>
                            </a>
                        </div>

                        <div class="col-md-3">
                            <a href="<?= URL ?>/sesion/cuenta" class="blanco pt-15 text-uppercase fs-18 btn btn-primary btn-lg d-block mb-15 <?= $cuenta ? 'active' : '' ?>">
                                <i class="fa blanco fa-edit mb-10 d-block"></i>
                                <?= $_SESSION["lang-txt"]["sesion"]["mis_datos"] ?>
                            </a>
                        </div>
                        <!-- <div class="col-md-3">
                                <a href="<?= URL ?>/sesion?logout" class="blanco pt-15 text-uppercase fs-20 btn btn-default btn-lg btn-block mb-15">
                                    <i class="fa blanco fa-sign-out mt-10"></i>
                                    <?= $_SESSION["lang-txt"]["sesion"]["salir"] ?>
                                </a>
                            </div> -->
                    </div>
                </div>
                <div class="col-lg-12 float-md-right mt-40">
                    <div class="categories_product_area">
                        <div class="row">
                            <?php
                            $op = isset($_GET["op"]) ? $_GET["op"] : 'pedidos';
                            if ($op != '') {
                                include("assets/inc/sesion/" . $op . ".php");
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--My Account section end-->
    <!-- panel-user -->

</div>
<?php $template->themeEnd(); ?>