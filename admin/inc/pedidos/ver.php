<?php
$pedidos = new Clases\Pedidos();
$funciones = new Clases\PublicFunction();
$usuarios = new Clases\Usuarios();
$estadosPedidos  = new Clases\EstadosPedidos();


$estadoFiltro = isset($_GET["estadoFiltro"]) ? $funciones->antihack_mysqli($_GET["estadoFiltro"]) : '';
$from = isset($_GET["from"]) ? $funciones->antihack_mysqli($_GET["from"]) : '';
$to = isset($_GET["to"]) ? $funciones->antihack_mysqli($_GET["to"]) : '';

$estadoPedido = $estadosPedidos->listByEstado();


if ($estadoFiltro != '') {
    foreach ($estadoPedido[$estadoFiltro]['data'] as $key__ => $filterEstado) {
        $filter['status'][$key__] = "estado = '" . $filterEstado['id'] . "'";
    }
}
if (!empty($from)) {
    $to_ = !empty($to) ? "'" . $to . "'" : "NOW()";
    $filter['date'] = ["fecha BETWEEN '" . $from . "' AND " . $to_];
}
$pedidosData = $pedidos->list(isset($filter) ? $filter : '', '', '');
if ($estadoFiltro != '') $filter = '';
$totalByStatus = $pedidos->getTotalByStatus(isset($filter) ? $filter : ''); // Cantidad total y monto de pedidos por area

$promedio = 0;
if ($totalByStatus["statusTotal"][2]["data"]["cantidad"] != 0) {
    $promedio = $totalByStatus["statusTotal"][2]["data"]["total"] / $totalByStatus["statusTotal"][2]["data"]["cantidad"];
}
?>
<div class="mt-20">
    <section id="widgets-Statistics">
        <div class="row">
            <div class="col-12 mt-1 mb-2">
                <h4 class="mt-20 pull-left">Pedidos</h4><a class="btn btn-success pull-right text-uppercase mt-15 " href="<?= URL_ADMIN ?>/index.php?op=pedidos&accion=agregar">AGREGAR PEDIDOS </a>
                <form method="get" class="pull-right mt-15" id="orderForm" name="orderForm" action="<?= CANONICAL ?>"><input type="hidden" name="op" value="pedidos" /><input type="hidden" name="accion" value="ver" />
                    <div class="col-auto pull-right"><button type="submit" class="btn btn-info">BUSCAR</button></div>
                    <div class="col-auto pull-right"><input type="date" name="to" value="<?= !empty($to) ? $to : '' ?>"></div>
                    <div class="col-auto pull-right">
                        <h6 class="mt-10">hasta</h6>
                    </div>
                    <div class="col-auto pull-right"><input type="date" name="from" value="<?= !empty($from) ? $from : '' ?>" required></div>
                </form>
                <div class="clearfix"></div>
                <hr />
            </div>
        </div>
        <div class="row"><?php $tooltipData = $pedidos->tooltipData($totalByStatus['status']) ?>
            <?php foreach ($totalByStatus['statusTotal'] as $key_ => $statusData) {
                $link = URL_ADMIN . "/index.php?op=pedidos&accion=ver&estadoFiltro=" . $key_;
                switch ($key_) {
                    case 0:
                        $statusStyle = ["Carrito no cerrado", "bx-truck", "primary"];
                        if (isset($tooltipData[$key_])) {
                            $tooltipData_ = $tooltipData[$key_];
                        }
                        break;
                    case 1:
                        $statusStyle = ["Pendiente", "bxs-hourglass", "warning"];
                        if (isset($tooltipData[$key_])) {
                            $tooltipData_ = $tooltipData[$key_];
                        }
                        break;
                    case 2:
                        $statusStyle = ["Aprobado", "bx-money", "success"];
                        if (isset($tooltipData[$key_])) {
                            $tooltipData_ = $tooltipData[$key_];
                        }
                        break;
                    case 3:
                        $statusStyle = ["Pago no concretado", "bx-dislike", "danger"];
                        if (isset($tooltipData[$key_])) {
                            $tooltipData_ = $tooltipData[$key_];
                        }
                        break;
                }
            ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card text-center">
                        <div class="card-content">
                            <div class="card-body btn  tooltip-light" style="" type="button" data-toggle="tooltip" data-placement="bottom" data-html="true" title="<?= $pedidos->getTooltip($tooltipData_) ?>" onclick="document.location.href='<?= (CANONICAL == $link) ?  URL_ADMIN . '/index.php?op=pedidos&accion=ver' : $link ?>'">
                                <div class="badge-circle badge-circle-lg  mx-auto my-1  <?= $estadoFiltro != '' ? ($estadoFiltro == $key_ ? 'badge-circle-light-' . $statusStyle[2] : 'badge-circle-light-secondary') : 'badge-circle-light-' . $statusStyle[2] ?>"><i class="fs-26 bx <?= $statusStyle[1] ?> fs-30 "></i></div>
                                <p class="text-muted mb-0 line-ellipsis"><?= $statusStyle[0] ?>(<?= isset($statusData['data']['cantidad']) ? $statusData['data']['cantidad'] : 0 ?>)</p>
                                <h3 class="mb-0">$<?= isset($statusData['data']['total']) ? number_format($statusData['data']['total'], 2, ",", ".") : 0 ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <span class="badge badge-success fs-13 text-uppercase  pull-right" style="margin-right:40px"> Promedio de carritos aprobados: $<?= number_format($promedio, "2", ",", ".") ?></span>
        </div>
    </section>
    <hr><?php foreach ($pedidosData as $key => $value) {
            $precioTotal = 0;
            $fecha = strftime("%d/%m/%Y - %H:%M", strtotime($value['data']['fecha']));
            $code = $value['data']['cod'];
            $flag = $value['data']['visto'];
        ?><div class="accordion collapse-icon accordion-icon-rotate" id="accordionWrapa2<?= $value['data']['id'] ?>">
            <div class="card collapse-header">
                <div onclick="check('<?= URL ?>','<?= $code ?>','<?= $flag ?>')" id="heading5<?= $value['data']['id'] ?>" class="card-header" data-toggle="collapse" data-target="#accordion5<?= $value['data']['id'] ?>" aria-expanded="false" aria-controls="accordion5<?= $value['data']['id'] ?>" role="tablist">
                    <span class="collapse-title">
                        <i id='viewed<?= $code ?>' class="icon-pedido fa fa-eye  <?= ($value['data']['visto'] == 1) ? '' : 'hidden' ?>" aria-hidden="true"></i>
                        <i id='notOpen<?= $code ?>' class="icon-pedido fa fa-eye-slash  <?= ($value['data']['visto'] == 1) ? 'hidden' : '' ?>" aria-hidden="true"></i>

                        <span class="ml-40 align-middle"><b>Pedido: </b><?= $value['data']["cod"] ?></span>
                        <?php if (isset($value['data']["pago"])) { ?>
                            <span class=" align-middle hidden-xs hidden-sm"> <b style="margin-left:4px"> Pago: </b><?= $value['data']["pago"] ?></span>
                        <?php } ?>
                        <span class="align-middle hidden-xs hidden-sm"> <b style="margin-left:4px"> Fecha: </b><?= $fecha ?></span>
                        <span class="align-middle hidden-xs hidden-sm"> <b style="margin-left:4px"> Nombre: </b><?= $value['user']['data']['nombre'] . ' ' . $value['user']['data']['apellido'] ?></span>

                        <?= $estadosPedidos->getStateBadge($value['data']['estado']); ?>
                    </span>
                </div>
                <div id="accordion5<?= $value['data']['id'] ?>" role="tabpanel" data-parent="#accordionWrapa2<?= $value['data']['id'] ?>" aria-labelledby="heading5<?= $value['data']['id'] ?>" class="collapse">
                    <div class="card-content">
                        <div class="card-body">
                            <div id="print-<?= $value['data']['id'] ?>" style="padding:10px;background:#fff" class="p-10"><img src="<?= LOGO ?>" width="250" class="mt-15 " />
                                <hr />
                                <div class="row">
                                    <div class="col-md-7 col-sm-12">
                                        <table class="table table-striped table-sm table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Producto </th>
                                                    <th>Cantidad </th>
                                                    <th class="hidden-xs hidden-sm">Precio </th>
                                                    <th>Precio Final </th>
                                                </tr>
                                            </thead>
                                            <tbody><?php
                                                    foreach ($value['detail'] as $key2 => $value2) :
                                                        $descuento = unserialize($value2["descuento"]);
                                                    ?><?php if ($value2['cod'] == $value['data']["cod"]) : ?><tr>
                                                    <td>
                                                        <?= $value2["producto"] ?><?php if (isset($descuento["cod"])) { ?><b class="descuento-monto"><?= $descuento["monto"]; ?></b>
                                                    <?php } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($value2["precio"] > 0) {
                                                                echo $value2["cantidad"];
                                                            } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($value2["precio"] > 0) {
                                                                echo '$' . $value2["precio"];
                                                                if (isset($descuento["cod"])) {
                                                                    echo '<b class="descuento-precio">  ' . $descuento["precio-antiguo"] . '</b>';
                                                                }
                                                            } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($value2["precio"] > 0 || $value2["precio"] < 0) {
                                                                echo '$' . $value2["precio"] * $value2["cantidad"];
                                                            } elseif ($value2["precio"] == 0) {
                                                                echo 'Sin recargo';
                                                            } ?>
                                                    </td>
                                                    <?php $precioTotal = $precioTotal + ($value2["precio"] * $value2["cantidad"]); ?>
                                                </tr>
                                                <?php endif; ?><?php endforeach; ?>
                                                <tr>
                                                    <td><b>TOTAL DE LA COMPRA</b></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><b>$<?= $precioTotal ?></b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-5 col-sm-12">
                                        <table class="table table-striped table-sm table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Usuario</th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <td>Nombre</td>
                                                    <td width="100%"><?= $value['user']['data']['nombre'] . ' ' . $value['user']['data']['apellido'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Dirección</td>
                                                    <td width="100%"><?= $value['user']['data']['direccion'] . ' - ' . $value['user']['data']['localidad'] . ' - ' . $value['user']['data']['provincia'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Teléfono</td>
                                                    <td width="100%"><?= $value['user']['data']['telefono'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Email</td>
                                                    <td width="100%"><?= $value['user']['data']['email'] ?></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="alert alert-dark"><b>OBSERVACIONES</b>
                                <br/> <br/>
                                    <b>FORMA DE PAGO: </b><?= isset($value['data']["pago"]) ? $value['data']["pago"]  : 'No especificada' ?>
                                    <?php
                                    if (!empty($value['data']['detalle'])) {
                                        $detalle = json_decode($value['data']['detalle'], true);
                                        if (!empty($detalle['leyenda'])) {
                                            echo "<b class='ml-20'>DESCRIPCIÓN DEL PAGO: </b>" . $detalle['leyenda'] . "<br/>";
                                        }
                                        if (!empty($detalle['descuento'])) {
                                            echo "<b class='ml-20'>SE UTILIZÓ EL CÓDIGO DE DESCUENTO: </b>" . $detalle['descuento'];
                                        }
                                        if (!empty($detalle['link'])) {
                                            echo "<b class='ml-20'>URL PARA PAGAR: </b><a href='" . $detalle['link'] . "' target='_blank'>CLICK AQUÍ</a>";
                                        }
                                    ?>
                                        <div class="clearfix"></div>
                                        <hr>
                                        <div class="row mb-15">
                                            <div class="col-md-6" style="width: 50%;"><b>INFORMACIÓN DE ENVIO</b><br><?= $pedidos->getInfoPedido($detalle, 'envio'); ?></div>
                                            <div class="col-md-6" style="width: 50%"><b>INFORMACIÓN DE FACTURACIÓN</b><br><?= $pedidos->getInfoPedido($detalle, 'pago'); ?>
                                                <?php if ($detalle['pago']['factura']) {
                                                    echo "<p class='mb-0 fs-13'><b>Factura A al CUIT: </b>" . $detalle['pago']['dni'] . "</p>";
                                                } ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php if (isset($url)) { ?>
                                    <hr />
                                    <?php if (!empty($value['user']['data']['celular'])) { ?>
                                        <a href="https://wa.me/<?= $value['user']['data']['celular'] ?>?text=<?= $url ?>" target="_blank" class="btn" style="background-color: lawngreen;"><i class="fa fa-phone"></i>Compartir por whatsapp </a>
                                    <?php } else { ?>
                                        <button class="btn" style="background-color: lawngreen;" title="El usuario no posee numero de celular" disabled><i class="fa fa-phone"></i>Compartir por whatsapp </button>
                                    <?php } ?>
                                <?php } ?>
                                <div class="hiddenPrint">
                                    <hr />

                                    <b class="mt-10 mr-10 ">CAMBIAR ESTADO: </b>
                                    <div class="row ">
                                        <?php
                                        foreach ($estadoPedido as $key => $estado) {
                                            switch ($key) {
                                                case 0:
                                                    $btnName = "Carrito no cerrado";
                                                    $btnColor = "btn-dark";
                                                    break;
                                                case 1:
                                                    $btnName = "Pendiente";
                                                    $btnColor = "btn-warning";
                                                    break;
                                                case 2:
                                                    $btnName = "Aprobado";
                                                    $btnColor = "btn-success";
                                                    break;
                                                case 3:
                                                    $btnName = "Rechazado";
                                                    $btnColor = "btn-danger";
                                                    break;
                                            }
                                        ?>
                                            <div class="btn-group dropup mr-1 mb-1"><button type="button" class="btn <?= $btnColor ?> dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="<?= $value['data']['cod'] . "state"; ?>"><?= $btnName ?></button>
                                                <div class="dropdown-menu" aria-labelledby="<?= $value['data']['cod'] . "state"; ?>">
                                                    <?php
                                                    foreach ($estado['data'] as $estadoItem) { ?>
                                                        <a id="<?= $estadoItem['id'] . "state"; ?>" onclick="editAndSendStatus('<?= URL ?>','<?= $value['data']['cod'] ?>','<?= $estadoItem['id'] ?>','<?= $estadoItem['enviar'] ?>')" class="dropdown-item"><?= $estadoItem['titulo'] ?></a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <b class="mt-10 mr-10 ">MÁS OPCIONES: </b>
                                    <div class="row ">
                                        <button class="btn btn-primary pull-left" onclick="printContent('print-<?= $value['data']['id'] ?>')">
                                            <i class="fa fa-print"></i>IMPRIMIR </button>
                                        <a href="<?= CANONICAL ?>&borrar=<?= $value['data']['cod'] ?>" class="btn btn-danger deleteConfirm pull-left ml-10">ELIMINAR PEDIDO</a>
                                        <!-- The text field -->
                                        <button class="btn btn-warning pull-left ml-10" onclick="copyLink('<?= $value['data']['cod'] ?>')">Copiar Link Carrito Pre Armado</button>
                                        <div class="col-md-4">

                                            <input class="pull-right" type="text" value="<?= URL ?>/pedido/<?= $value['data']["cod"] ?>" id="linkCopy-<?= $value['data']["cod"] ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modalS" class="modal fade mt-120" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="textS" class="text-center"></div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<?php
if (!empty($_GET["borrar"])) {
    $pedidos->set("cod", isset($_GET["borrar"]) ? $funciones->antihack_mysqli($_GET["borrar"]) : '');
    $pedidos->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=pedidos");
}
?>


<script>
    function copyLink(id) {
        var copyText = document.getElementById("linkCopy-" + id);
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        successMessage("Link de carrito pre armado: " + copyText.value);
    }
</script>