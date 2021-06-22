<?php
$pedidos = new Clases\Pedidos();
$usuarios = new Clases\Usuarios();
$f = new Clases\PublicFunction();
$checkout = new Clases\Checkout();
$detalleCombinacion = new Clases\DetalleCombinaciones();
$estadosPedidos = new Clases\EstadosPedidos();
$pedido = new Clases\Pedidos();

if (isset($_SESSION['stages'])) {
    $pedidos->checkMercadoPago();
    $pedidos->set("cod", $_SESSION['last_cod_pedido']);
    $pedido_info = $pedidos->view();
    $carro = $carrito->return();
    if ($_SESSION['stages']['status'] == 'CLOSED') {
?>
        <div class="section pt-50  pb-70 pb-lg-50 pb-md-40 pb-sm-30 pb-xs-20">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="customer-login-register register-pt-0">
                            <form id="payment-f" method="post">
                                <div class="form-register-title">
                                    <h2>COMPRA FINALIZADA</h2>
                                    <h4>PEDIDO N°: <?= $_SESSION['last_cod_pedido'] ?></h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr>
                                            <b>ESTADO:</b> <?= mb_strtoupper($pedido_info['status_text']); ?><br />
                                            <b>MÉTODO DE PAGO:</b> <?= mb_strtoupper($pedido_info['data']["pago"]); ?><br />
                                            <?php
                                            if (!empty($pedido_info['data']['detalle'])) {
                                                $detalle = json_decode($pedido_info['data']['detalle'], true);
                                                if (!empty($detalle['leyenda'])) {
                                                    echo "<b>DESCRIPCIÓN DEL PAGO: </b>" . $detalle['leyenda'] . "<br/>";
                                                }
                                                if (!empty($detalle['descuento'])) {
                                                    echo "<b>SE UTILIZÓ EL CÓDIGO DE DESCUENTO: </b>" . $detalle['descuento'];
                                                }
                                                if (!empty($detalle['link'])) {
                                                    echo "<b>URL PARA PAGAR: </b><a href='" . $detalle['link'] . "' target='_blank'>CLICK AQUÍ</a>";
                                                }
                                            ?>
                                                <div class="row mb-15">
                                                    <div class="col-md-6">
                                                        <hr>
                                                        <b>INFORMACIÓN DE ENVIO</b>
                                                        <hr />
                                                        <?= $pedido->getInfoPedido($detalle, 'envio') ?>
                                                        <?php
                                                        if ($detalle['envio']['similar']) {
                                                            echo "<span class='mb-0 fs-13'><b>Producto similar por faltante: </b> Si</p>";
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <hr>
                                                        <b>INFORMACIÓN DE FACTURACIÓN</b>
                                                        <hr />
                                                        <?= $pedido->getInfoPedido($detalle, 'pago') ?>
                                                        <?php
                                                        if ($detalle['pago']['factura']) {
                                                            echo "<span class='mb-0 fs-13'><b>Factura A al CUIT: </b>" . $detalle['pago']['dni'] . "</p>";
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>

                                        </div>
                                        <div class="col-md-12">
                                            <b>TU COMPRA</b>
                                            <hr>
                                            <?php include("assets/inc/checkout/carrito.php"); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="btn-payment-d" class="col-md-12 col-xs-12 mt-10 mb-50">
                                            <a class="btn btn-success btn-block text-center fs-20" style="line-height: 2.71!important;" href="<?= URL ?>" id="btn-payment-1">
                                                Volver a la página principal
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
        /*
    } else {
        $f->headerMove(URL . '/carrito');
    }
} else {
    $f->headerMove(URL . '/carrito');
}
*/
    }
}
?>