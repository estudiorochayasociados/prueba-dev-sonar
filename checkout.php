<?php
require_once "Config/Autoload.php";
Config\Autoload::run();

$template = new Clases\TemplateSite();
$f = new Clases\PublicFunction();
$checkout = new Clases\Checkout();
$carrito = new Clases\Carrito();
$config = new Clases\Config();

#Variables GET
$op = isset($_GET["op"]) ? $_GET["op"] : '';

#Si no se iniciaron los stages (se inician en el carrito) se redirige al carrito
empty($_SESSION['stages']) ? $f->headerMove(URL . '/carrito') : null;

#Si el cod guardado no coincide con el de sesión, se redirige al carrito para que se actualice
($_SESSION['stages']['cod'] != $_SESSION['last_cod_pedido']) ? $f->headerMove(URL . '/carrito') : null;

#El carrito no puede estar vacío mientras está en los stages, sino se redirige al carrito
if (empty($_SESSION['carrito'])) {
    $checkout->destroy();
    $carrito->destroy();
    $f->headerMove(URL . '/carrito');
}

#Variable que almacena el progeso de los stages
$progress = $checkout->progress();

#Información de cabecera
$template->set("title", "Proceso de compra | " . TITULO);
$template->themeInitStages();
?>
<div class="checkout-estudiorocha navCart">
    <div class="login-register-section section pt-20  pb-70 pb-lg-50 pb-md-40 pb-sm-30 pb-xs-20">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-<?= ($op != 'detail') ? 8 : 12 ?>">
                    <ul class="progress-indicator" style="width: 100%">
                        <li class="<?= ($progress["stage-1"]) ? "completed" : ''; ?>">
                            <span class="bubble"></span>
                            <?= ($progress["stage-1"]) ? "<a href='" . URL . "/checkout/shipping'> ENVIO </a>" : 'ENVIO'; ?>
                        </li>

                        <li class="<?= ($progress["stage-1"] && $progress["stage-2"]) ? "completed" : ''; ?>">
                            <span class="bubble"></span>
                            <?= ($progress["stage-1"] && $progress["stage-2"]) ? "<a href='" . URL . "/checkout/billing'> FACTURACIÓN </a>" : 'FACTURACIÓN'; ?>
                        </li>

                        <li class="<?= ($progress["stage-1"] && $progress["stage-2"]) ? "completed" : ''; ?>">
                            <span class="bubble"></span>
                            <?= ($progress["stage-1"] && $progress["stage-2"] && $progress["stage-3"]) ? "<a href='" . URL . "/checkout/payment'> PAGO </a>" : 'PAGO'; ?>
                        </li>

                        <li class="<?= ($progress["stage-1"] && $progress["stage-2"] && $progress["stage-3"]) ? "completed" : ''; ?>">
                            <span class="bubble"></span>
                            <?= ($progress["stage-1"] && $progress["stage-2"] && $progress["stage-3"]) ? "<a href='" . URL . "/checkout/detail'> DETALLE </a>" : 'DETALLE'; ?>
                        </li>
                    </ul>
                    <?php
                    if ($op != '') {
                        if (!empty($progress)) {
                            include("assets/inc/checkout/" . $op . ".php");
                        } else {
                            include("assets/inc/checkout/shipping.php");
                        }
                    } else {
                        $f->headerMove(URL . '/carrito');
                    }
                    ?>
                </div>
                <?php if ($op != 'detail') { ?>
                    <div class="col-md-4 hidden-xs hidden-sm">
                        <ul class="progress-indicator" style="width: 100%">
                            <li class="completed">
                                <span class="bubble"></span>
                                TU COMPRA
                            </li>
                        </ul>
                        <cart></cart>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php
$template->themeEndStages();
?>
<script src="<?= URL ?>/assets/js/services/checkout.js"></script>
<script src="<?= URL ?>/assets/js/services/email.js"></script>

<?php

if ($op == 'detail') {
?>
    <script>
        sendBuyTimer('<?= URL ?>', '<?= $_SESSION['last_cod_pedido'] ?>');
    </script>
<?php
    if ($_SESSION['stages']['status'] == 'CLOSED') {
        $carrito->destroy();
        $checkout->destroy();
        unset($_SESSION["cod_pedido"]);
        if (!empty($_SESSION["usuarios"]['invitado'])) {
            if ($_SESSION["usuarios"]["invitado"] == 1) {
                unset($_SESSION["usuarios"]);
            }
        }
    }
}
?>