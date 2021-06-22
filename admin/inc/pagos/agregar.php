<?php
$pagos = new Clases\Pagos();
$config = new Clases\Config();
$estadoPedido = new Clases\EstadosPedidos();
$estadoData = $estadoPedido->list("", "", "");
$payments = $config->listPayment();
if (isset($_POST["agregar"])) {
    $count = 0;
    $cod = substr(md5(uniqid(rand())), 0, 10);
    $pagos->set("cod", $cod);
    $pagos->set("titulo", isset($_POST["titulo"]) ? $funciones->antihack_mysqli($_POST["titulo"]) : '');
    $pagos->set("leyenda", isset($_POST["leyenda"]) ? $funciones->antihack_mysqli($_POST["leyenda"]) : '');
    $pagos->set("estado", isset($_POST["estado"]) ? $funciones->antihack_mysqli($_POST["estado"]) : '');
    $pagos->set("tipo", isset($_POST["tipo"]) ? $funciones->antihack_mysqli($_POST["tipo"]) : '');
    $aumento = isset($_POST["aumento"]) ? $funciones->antihack_mysqli($_POST["aumento"]) : '';
    switch ($aumento) {
        case 0:
            $pagos->set("aumento", '');
            $pagos->set("disminuir", '');
            break;
        default:
            if ($aumento > 0) {
                $pagos->set("aumento", $aumento);
                $pagos->set("disminuir", "");
            } else {
                $pagos->set("disminuir", abs($aumento));
                $pagos->set("aumento", "");
            }
            break;
    }
    $pagos->set("defecto", isset($_POST["defecto"]) ? $funciones->antihack_mysqli($_POST["defecto"]) : '');
    $pagos->minimo = !empty($_POST["minimo"]) ? $funciones->antihack_mysqli($_POST["minimo"]) : 0;
    $pagos->set("tipo_usuario", isset($_POST["tipo_usuario"]) ? $funciones->antihack_mysqli($_POST["tipo_usuario"]) : '');
    $pagos->add();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=pagos");
}
?>
<div class="mt-20 ">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-uppercase text-center">
                Pagos
            </h4>
            <hr style="border-style: dashed;">
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="post" class="row">
                    <label class="col-md-9">Método de pago:<br />
                        <input type="text" name="titulo" required>
                    </label>
                    <label class="col-md-3">Compra Minima:<br />
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="float" class="form-control" name="minimo">
                        </div>
                    </label>
                    <label class="col-md-12">Descripción del método de pago:<br />
                        <textarea name="leyenda"></textarea>
                    </label>
                    <label class="col-md-2">
                        Estado
                        <select name="estado" class="form-control" required>
                            <option value="1">Activo</option>
                            <option value="0">Desactivado</option>
                        </select>
                    </label>
                    <label class="col-md-3">
                        Tipo de pago online:
                        <select name="tipo" class="form-control">
                            <option value="" disabled selected>--- Sin elegir ---</option>
                            <?php
                            if (!empty($payments)) {
                                foreach ($payments as $payment) {
                            ?>
                                    <option value="<?= $payment['data']['id']; ?>"><?= strtoupper($payment['data']['empresa']); ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </label>
                    <label class="col-md-2">
                        Defecto:
                        <select name="defecto" class="form-control" required>
                            <?php foreach ($estadoData as $estado) { ?>
                                <option value="<?= $estado['data']['id'] ?>"><?= $estado['data']['titulo'] ?></option>
                            <?php } ?>
                        </select>
                    </label>
                    <label class="col-md-2">
                        Tipo Usuario:
                        <select name="tipo_usuario" class="form-control" required>
                            <option value="0">Ambos</option>
                            <option value="1">Minorista</option>
                            <option value="2">Mayorista</option>
                        </select>
                    </label>
                    <label class="col-md-3">
                        Aumento o Descuento (%)<br />
                        <input data-suffix="%" value="0" min="-100" max="100" type="number" name="aumento" onkeydown="return (event.keyCode!=13);" />
                    </label>
                    <div class="col-md-12 mt-20">
                        <input type="submit" class="btn btn-primary btn-block" name="agregar" value="Crear Pago" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("input[type='number']").inputSpinner()
</script>