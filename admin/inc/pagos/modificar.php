<?php
$pagos = new Clases\Pagos();
$config = new Clases\Config();
$estadoPedido = new Clases\EstadosPedidos();

$cod = isset($_GET["cod"]) ? $funciones->antihack_mysqli($_GET["cod"]) : '';
$estadoData = $estadoPedido->list("", "", "");
$pagos->set("cod", $cod);
$pagos_ = $pagos->view();
$payments = $config->listPayment();

if (isset($_POST["agregar"])) {
    $pagos->set("cod", $pagos_['data']["cod"]);
    $pagos->set("titulo", isset($_POST["titulo"]) ?  $funciones->antihack_mysqli($_POST["titulo"]) : '');
    $pagos->set("leyenda", isset($_POST["leyenda"]) ?  $funciones->antihack_mysqli($_POST["leyenda"]) : '');
    $pagos->set("estado", isset($_POST["estado"]) ?  $funciones->antihack_mysqli($_POST["estado"]) : '');
    $pagos->set("tipo", isset($_POST["tipo"]) ?  $funciones->antihack_mysqli($_POST["tipo"]) : '');
    $aumento = isset($_POST["aumento"]) ?  $funciones->antihack_mysqli($_POST["aumento"]) : '';
    switch ($aumento) {
        case 0:
            $pagos->set("aumento", "");
            $pagos->set("disminuir", "");
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
    $pagos->set("defecto", isset($_POST["defecto"]) ?  $funciones->antihack_mysqli($_POST["defecto"]) : '');
    $pagos->minimo = !empty($_POST["minimo"]) ? $_POST["minimo"] : 0;
    $pagos->set("tipo_usuario", isset($_POST["tipo_usuario"]) ? $funciones->antihack_mysqli($_POST["tipo_usuario"]) : '');
    $pagos->edit();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=pagos");
}
?>
<div class="mt-20 card">
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
                        <input type="text" name="titulo" value="<?= $pagos_['data']["titulo"] ? $pagos_['data']["titulo"] : '' ?>" required>
                    </label>
                    <label class="col-md-3">Compra Minima:<br />
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="float" class="form-control" name="minimo" value="<?= $pagos_['data']["minimo"] ? $pagos_['data']["minimo"] : '' ?>">
                        </div>
                    </label>

                    <label class="col-md-12">Descripción del método de pago:<br />
                        <textarea name="leyenda"><?= $pagos_['data']["leyenda"] ? $pagos_['data']["leyenda"] : '' ?></textarea>
                    </label>
                    <label class="col-md-2">
                        Estado
                        <select name="estado" class="form-control" required>
                            <option value="1" <?php if ($pagos_['data']['estado'] == 1) {
                                                    echo "selected";
                                                } ?>>
                                Activo
                            </option>
                            <option value="0" <?php if ($pagos_['data']['estado'] == 0) {
                                                    echo "selected";
                                                } ?>>
                                Desactivado
                            </option>
                        </select>
                    </label>
                    <label class="col-md-3">
                        Tipo de pago online:
                        <select name="tipo" class="form-control">
                            <option value="" <?php if ($pagos_['data']['tipo'] == '') {
                                                    echo "selected";
                                                } ?>>
                                --- Sin elegir ---
                            </option>
                            <?php
                            if (!empty($payments)) {
                                foreach ($payments as $payment) {
                            ?>
                                    <option value="<?= $payment['data']['id']; ?>" <?php if ($pagos_['data']['tipo'] == $payment['data']['id']) {
                                                                                        echo "selected";
                                                                                    } ?>>
                                        <?= $payment['data']['empresa']; ?>
                                    </option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                    </label>

                    <label class="col-md-2">
                        Defecto:
                        <select name="defecto" class="form-control" required>
                            <?php foreach ($estadoData as $estado) {
                                $select = $pagos_['data']['defecto'] == $estado['data']['id'] ? 'selected' : '';
                            ?>
                                <option value="<?= $estado['data']['id'] ?>" <?= $select ?>><?= strtoupper($estado['data']['titulo']) ?></option>
                            <?php
                            } ?>
                        </select>
                    </label>
                    <label class="col-md-2">Tipo Usuario:<br />
                        <select name="tipo_usuario" required>
                            <option value="0" <?php if ($pagos_['data']['tipo_usuario'] == 0) {
                                                    echo "selected";
                                                } ?>>Ambos
                            </option>
                            <option value="1" <?php if ($pagos_['data']['tipo_usuario'] == 1) {
                                                    echo "selected";
                                                } ?>>Minorista
                            </option>
                            <option value="2" <?php if ($pagos_['data']['tipo_usuario'] == 2) {
                                                    echo "selected";
                                                } ?>>Mayorista
                            </option>
                        </select>
                    </label>
                    <?php
                    if ($pagos_['data']['aumento'] != NULL) {
                        $aumento = $pagos_['data']['aumento'];
                    } else {
                        if ($pagos_['data']['disminuir'] != NULL) {
                            $aumento = -$pagos_['data']['disminuir'];
                        } else {
                            $aumento = 0;
                        }
                    }
                    ?>
                    <label class="col-md-3">
                        Aumento o Descuento (%)<br />
                        <input data-suffix="%" value="<?= $aumento ?>" min="-100" max="100" type="number" name="aumento" onkeydown="return (event.keyCode!=13);" />
                    </label>
                    <div class="col-md-12 mt-20">
                        <input type="submit" class="btn btn-primary btn-block" name="agregar" value="Modificar Pago" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("input[type='number']").inputSpinner()
</script>