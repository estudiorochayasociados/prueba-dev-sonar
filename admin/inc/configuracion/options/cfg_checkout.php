<?php

use function PHPSTORM_META\type;

$envios = new Clases\Envios();
$pagos = new Clases\Pagos();

$listData = $config->listCheckout();

$enviosData = $envios->list('', '', '');
$pagosData = $pagos->list('', '', '');



if (isset($_POST["agregar-checkout"])) {
    $type = isset($_POST["ckt-tipo"]) ? $funciones->antihack_mysqli($_POST["ckt-tipo"]) : '';
    $config->set("id", isset($_POST["ckt-id"]) ? $funciones->antihack_mysqli($_POST["ckt-id"]) : '');
    $config->set("tipo", $type);
    isset($_POST["ckt-estado"]) ? $config->set("estado", 1) : $config->estado = 0;
    isset($_POST["ckt-mostrarPrecio"]) ? $config->set("mostrar_precio", 1) : $config->mostrar_precio = 0;
    $config->set("envio", isset($_POST["ckt-envio"]) ? $funciones->antihack_mysqli($_POST["ckt-envio"]) : '');
    $config->set("pago", isset($_POST["ckt-pago"]) ? $funciones->antihack_mysqli($_POST["ckt-pago"]) : '');
    $error = $config->addCheckout($type);
    if ($error) {
        $funciones->headerMove(URL_ADMIN . '/index.php?op=configuracion&accion=modificar&tab=checkout-tab');
    } else {
        echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
    }
}
?>
<div>
    <div class="row">
        <?php
        foreach ($listData as $data) { ?>
            <form method="post" class="col-md-12" action="<?= URL_ADMIN ?>/index.php?op=configuracion&accion=modificar&tab=checkout-tab">
                <input type="hidden" name="ckt-id" value="<?= $data['data']['id'] ?>">
                <input type="hidden" name="ckt-tipo" value="<?= $data['data']['tipo'] ?>">
                <div class="card">
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-12">
                                <h3 class="text-center"><?= ucfirst($data['data']['tipo']) ?></h3>
                                <hr style="border-style: dashed;">
                            </div>
                            <div class="col-md-6">
                                <label>Metodo de envio predefinido
                                    <select name="ckt-envio">
                                        <option>-- Elige Metodo de Envio --</option>
                                        <?php foreach ($enviosData as $envio) { ?>
                                            <option <?= ($envio['data']['cod'] == $data['data']['envio']) ? 'selected' : '' ?> value="<?= $envio['data']['cod'] ?>"><?= $envio['data']['titulo'] . " - $" .  $envio['data']['precio'] ?></option>
                                        <?php  } ?>
                                    </select>
                                </label>
                            </div>
                            <div class="col-md-6">
                                <label>Metodo de pago predefinido
                                    <select name="ckt-pago">
                                        <option>-- Elige Metodo de Pago --</option>
                                        <?php foreach ($pagosData as $pago) { ?>
                                            <option <?= ($pago['data']['cod'] == $data['data']['pago']) ? 'selected' : '' ?> value="<?= $pago['data']['cod'] ?>"><?= $pago['data']['titulo']  ?></option>
                                        <?php  } ?>
                                    </select>
                                </label>
                            </div>
                            <div class="col-md-12 mt-10">
                                <div class="custom-control custom-switch">
                                    <li class="d-inline-block">
                                        <fieldset>
                                            <div class="checkbox checkbox-primary">
                                                <input type="checkbox" name="ckt-estado" id="colorCheckbox3-<?= $data['data']['id'] ?>" <?= ($data['data']['estado'] == 1) ? 'checked' : '' ?>>
                                                <label style="width:200px;" for="colorCheckbox3-<?= $data['data']['id'] ?>">Saltar proceso de checkout</label>
                                            </div>
                                        </fieldset>
                                    </li>
                                    <li class="d-inline-block">
                                        <fieldset>
                                            <div class="checkbox checkbox-primary">
                                                <input type="checkbox" name="ckt-mostrarPrecio" id="mostrarPrecio-<?= $data['data']['id'] ?>" <?= ($data['data']['mostrar_precio'] == 1) ? 'checked' : '' ?>>
                                                <label for="mostrarPrecio-<?= $data['data']['id'] ?>">Ocultar precios en detalle de compra</label>
                                            </div>
                                        </fieldset>
                                    </li>
                                </div>
                            </div>
                            <div class="col-md-12 mt-10">
                                <button class="btn btn-primary" name="agregar-checkout">Actualizar Datos</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        <?php
        } ?>
    </div>
</div>