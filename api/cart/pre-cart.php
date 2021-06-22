<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$f = new Clases\PublicFunction();
$pedidos = new Clases\Pedidos();
$combinaciones = new Clases\Combinaciones();

if (isset($_GET['cod'])) {
    $cod = $f->antihack_mysqli($_GET['cod']);
    $pedidos->set("cod", $cod);
    $pedido = $pedidos->view();
    (!isset($pedido['detail'])) ? $f->headerMove(URL) : '';
    foreach ($pedido['detail'] as $detail) {
        if ($detail['tipo'] == "PR") {
            if (!empty($detail['cod_combinacion'])) {
                $combinacion = $combinaciones->detail($detail['cod_combinacion']);
                foreach ($combinacion as $data) {
                    $attr[$data['data']['cod_atributo']] = $data['data']['cod_subatributo'];
                }
                $array[] = ['product' => $detail['cod_producto'], 'amount' => $detail['cantidad'], 'atribute' => $attr, 'combination' => true];
                $attr = false;
                $combinacion = false;
            } else {
                $array[] = ['product' => $detail['cod_producto'], 'amount' => $detail['cantidad'], 'atribute' => '', 'combination' => ''];
            }
        }
    }
    $arrayJson = json_encode($array);
} else {
    $f->headerMove(URL);
}
?>
<script src="<?= URL ?>/assets/theme/assets/js/vendor/jquery-3.5.1.min.js"></script>
<script>
    addCartByLink(<?= $arrayJson ?>, '<?= URL ?>');

     function addCartByLink(cart, url) {
         cart.forEach(async element => {
            var data = {
                product: element.product,
                amount: element.amount,
                atribute: element.atribute,
                combination: element.combination,
            };

            addCart(data, url);
        });
         setTimeout(function() {
            window.location = url + '/carrito';
        }, 5000);
    }

    function addCart(data, url) {
        console.log(data);
        $.ajax({
            url: url + "/api/cart/add.php",
            type: "POST",
            data: data,
            success: function(data) {
                console.log(data);
            }
        })
    };
</script>