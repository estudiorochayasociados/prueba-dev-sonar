<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$f = new Clases\PublicFunction();
$producto = new Clases\Productos();
$producto_relacionados = new Clases\ProductosRelacionados();
$combinacion = new Clases\Combinaciones();

$cod_producto = isset($_POST['cod_producto']) ? $f->antihack_mysqli($_POST['cod_producto']) : '';

$producto_relacionados_ = $producto_relacionados->list(["productos_cod LIKE '%$cod_producto%'"], "", "");
echo 'a';//no borrar
if ($producto_relacionados_) {
    foreach ($producto_relacionados_ as $producto_relacionados__) {
        if ($producto_relacionados__ !=  $cod_producto) {
            $realtedItem = $producto->view($producto_relacionados__, "", "", "", true);
            if (!empty($realtedItem) && $realtedItem['data']['stock'] > 0 && $realtedItem['data']['precio'] > 0 && $realtedItem['data']['mostrar_web'] == 1) {
                $combinacion->set("codProducto", $producto_relacionados__);
                $combinacionData = $combinacion->listByProductCod();
                $link = URL . '/producto/' . $f->normalizar_link($realtedItem["data"]["titulo"]) . '/' . $realtedItem["data"]["cod"];
                if (!$combinacionData) { ?>
                    <div class="col-md-3 col-xs-6 mb-15">
                        <div onclick='window.location.assign("<?= $link ?>")' style="width:100%;height:100px;background:url('<?= $realtedItem['images'][0]['url'] ?>') no-repeat center center/contain"></div>
                        <h4 class="text-center fs-14" style="min-height: 50px;"><span><?= strtoupper($realtedItem['data']['titulo']) ?></span></h4>
                        <price class="hidden">
                            <span class="bold fs-13">
                                <?php if ($realtedItem["data"]["precio_descuento"]) { ?>
                                    <strike class="text-danger">$<?= $realtedItem["data"]["precio"] ?></strike>
                                <?php } ?>
                            </span>
                            <span class="bold fs-13">
                                <label style="color:green"><?= ($realtedItem["data"]["precio_final"] != 0) ? "$" . $realtedItem["data"]["precio_final"] : '' ?></label>
                            </span>
                        </price>
                        <a onclick="addToCart('','<?= $realtedItem['data']['cod'] ?>','<?= URL ?>',true,1)" class="btn text-center btn-block btn-success">
                            SI
                        </a>
                    </div>
<?php
                }
            }
        }
    }
} ?>