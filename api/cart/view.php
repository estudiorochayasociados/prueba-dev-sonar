<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$f = new Clases\PublicFunction();
$carrito = new Clases\Carrito();
$productos = new Clases\Productos();
$carro = $carrito->return();
if (!empty($carro)) {
    foreach ($carro as $key => $item) {
        $cart[$key]['cart'] = $item;
        if ($item['id'] == "Envio-Seleccion" || $item['id'] == "Metodo-Pago") {
            $cart[$key]['products'] = ($item['id'] == "Envio-Seleccion") ? "shipping" : "payment";
        } else {
            $data = [
                "filter" => ["productos.cod = '" . $item['id'] . "'"],
                "admin" => false,
                "category" => false,
                "subcategory" => false,
                "images" => true,
            ];
            $product = ($item['descuento'] == null) ? $productos->list($data, $_SESSION['lang'], true) : 'discount';
            if ($product != 'discount') {
                $cart[$key]['products'] =   ($item["cantidad"] <= $product["data"]["stock"]) ? $product : 'error';
            } else {
                $cart[$key]['products'] =   $product;
            }
        }
    }
    echo json_encode($cart);
} else {
    echo json_encode(false);
}
