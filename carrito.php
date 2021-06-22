<?php
require_once "Config/Autoload.php";
Config\Autoload::run();

$template = new Clases\TemplateSite();
$f = new Clases\PublicFunction();
$carrito = new Clases\Carrito();
$usuario = new Clases\Usuarios();
$descuento = new Clases\Descuentos();
$checkout = new Clases\Checkout();
$config = new Clases\Config();
$combi = new Clases\Combinaciones();

#Variables GET
$remover = $f->antihack_mysqli(isset($_GET["remover"]));

#Se carga la sesión del usuario
$usuarioData = $usuario->viewSession();

#List de descuentos
$descuentos = $descuento->list("", "", "");

#Se refrescan los descuentos por si se agrego algún producto nuevo
$descuento->refreshCartDescuento($carrito->return(), $usuarioData);

#Se cargan los productos del carrito
$carro = $carrito->return();
#Si existe la variable GET remover, entonces se elimina ese item del carrito
if (!empty($remover)) {
    $carrito->delete($_GET["remover"]);
    $f->headerMove(URL . "/carrito");
}
// echo "<pre>";
// var_dump($_SESSION['carrito']);
// echo "</pre>";

#Información de cabecera
$template->set("title", "Carrito de compra | " . TITULO);
$template->set("description", "Mirá tu compra y selecciona las formas de pagos y envios");
$template->set("keywords", "");

$template->themeInit();
?>
<nav class="breadcrumb-section theme1 bg-lighten2 padding-custom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2 class="title pb-4 text-dark text-capitalize">
                        Carrito
                    </h2>
                </div>
            </div>
            <div class="col-12">
                <ol class="breadcrumb bg-transparent m-0 p-0 align-items-center justify-content-center">
                    <li class="breadcrumb-item"><a href="<?= URL ?>">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Carrito
                    </li>
                </ol>
            </div>
        </div>
    </div>
</nav>
<div id="content" class="site-content mt-50 mb-50" tabindex="-1">
    <section class="whish-list-section theme1 pt-80 pb-80">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-10">
                    <h3 class="title mb-30 pb-25 text-capitalize">Tu Compra</h3>
                    <div class="table-responsive hidden-md-down">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-left" scope="col">Titulo</th>
                                    <th class="text-left" scope="col">Cantidad</th>
                                    <th class="text-left" scope="col">Precio</th>
                                    <th class="text-left" scope="col"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <cart></cart>
            </div>
            <div class="row mt-30">
                <div class="col-md-12">
                    <?php
                    if ($descuentos) {
                        if (isset($_POST["btn_codigo"])) {
                            $codigoDescuento = isset($_POST["codigoDescuento"]) ? $f->antihack_mysqli($_POST["codigoDescuento"]) : '';
                            $descuento->set("cod", $codigoDescuento);

                            $response = $descuento->addCartDescuento($carro, $usuarioData);
                            if ($response['status']['applied']) {
                                $f->headerMove(URL . "/carrito");
                            } else {
                                echo "<div class='alert alert-danger'>" . $response['status']['error']['errorMsg'] . "</div>";
                            }
                        }
                    }
                    ?>
                    <hr>
                    <form method="post" class="row">
                        <div class="col-md-6 text-center">
                            <p><b>¿Tenés algún código de descuento para tus compras?</b></p>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="codigoDescuento" class="form-control" placeholder="CÓDIGO DE DESCUENTO">
                            <br class="d-md-none">
                        </div>
                        <div class="col-md-2">
                            <input style="width: 100%" type="submit" value="USAR CÓDIGO" name="btn_codigo" class="btn btn-primary check-out-btn" />
                        </div>
                    </form>
                    <hr>
                    <?php
                    if (!empty(floatval($carrito->totalPrice()))) {
                        $type = !empty($_SESSION['usuarios']) ? "USER" : "GUEST";
                        $cod_user = ($type == "USER") ?  $_SESSION['usuarios']['cod'] : "";
                        if ($type == "USER") {
                            $link = $checkout->checkSkip($_SESSION['usuarios']['minorista']);
                        } else {
                            $link = "login";
                        }
                        $checkout->initial($type, $cod_user);
                    ?>
                        <a class="btn btn-primary check-out-btn" style="width: 100%;" href="<?= URL ?>/<?= $link ?>">
                            <i class="fa fa-check-circle"></i> <?= $_SESSION["lang-txt"]["carrito"]["finalizar_compra"] ?>
                        </a>
                    <?php
                    }
                    ?>
                    <hr>
                </div>
            </div>
        </div>
    </section>
</div>






<?php
$template->themeEnd();

if (!empty($_SESSION['latest'])) {
?>
    <script>
        success('<?= $_SESSION['latest'] ?>');
    </script>
<?php
    $_SESSION['latest'] = '';
}

if (!empty($error)) {
?>
    <script>
        $(document).ready(function() {
            alertSide('<?= $error ?>');
        });
    </script>
<?php
}
?>