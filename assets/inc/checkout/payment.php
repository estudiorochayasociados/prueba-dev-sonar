<?php
$carrito = new Clases\Carrito();
$pagos = new Clases\Pagos();
$tipoUsuario = ($_SESSION['stages']['type'] == 'GUEST' || $_SESSION['usuarios']['minorista'] == 1) ? 1 : 2; // 1 Minorista - 2 Mayorista
if (isset($_SESSION['stages'])) {
    if ($_SESSION['stages']['status'] == 'OPEN' && !empty($_SESSION['stages']['stage-2']) && !empty($_SESSION['stages']['user_cod'])) {
?>
        <div class="">
            <form id="payment-f" method="post" data-url="<?= URL ?>" data-cod="<?= $_SESSION['last_cod_pedido'] ?>" onsubmit="addPayment()">
                <div class="form-register-title">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="formPago" class="alert alert-info">
                                <p class="text-uppercase bold fs-25 mt-20 mb-20 text-center">Seleccione el medio de pago que desea utilizar. </p>
                                <ul>
                                    <?php
                                    $listPagos = $pagos->list(["estado = 1", "(tipo_usuario = $tipoUsuario OR tipo_usuario = 0)", "(" . $carrito->precioSinMetodoDePago() . " > minimo OR minimo = 0)"], "", "");
                                    foreach ($listPagos as $key => $pago) {
                                        $precio_total = $pagos->checkPriceOnPayments($pago, $carrito->precioSinMetodoDePago());
                                    ?>
                                        <label class="list-style-none mb-15">
                                            <input type="radio" <?= ((count($listPagos) < 2)  ? "checked" : '') ?> name="cod" value="<?= $pago['data']['cod'] ?>" id="r-<?= $key ?>" required>
                                            <label class="mb-0 ml-10 fs-20 text-uppercase namePayment" for="r-<?= $key ?>"><?= $pago['data']['titulo'] . "  | <price class='hidden'>$" . $precio_total ?></price></label>
                                            <p><?= !empty($pago['data']['leyenda']) ? $pago['data']['leyenda'] : ''; ?> </p>
                                        </label>
                                        <br />
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="btn-payment-d" class="col-md-12 col-xs-12 mt-10 mb-50">
                            <a href="<?= URL ?>/checkout/billing" style="line-height: 46px"><i class="fa fa-chevron-left"></i> VOLVER</a>
                            <button class="btn btn-success pull-right text-uppercase fs-20" type="submit" id="btn-payment-1">
                                FINALIZAR COMPRA <i class="fa fa-check-circle"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
<?php
    } else {
        if ($_SESSION['stages']['status'] == 'CLOSED') {
            $f->headerMove(URL . '/checkout/detail');
        } else {
            if (empty($_SESSION['stages']['user_cod'])) {
                $f->headerMove(URL . '/login');
            } else {
                $f->headerMove(URL . '/checkout/billing');
            }
        }
    }
} else {
    $f->headerMove(URL . '/carrito');
}
?>
<div id="modalS" class="modal fade mt-120" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div id="textS" class="text-center">
                </div>
            </div>
        </div>
    </div>
</div>