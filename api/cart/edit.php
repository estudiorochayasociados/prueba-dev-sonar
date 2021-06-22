<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$f = new Clases\PublicFunction();
$carrito = new Clases\Carrito();


$key = isset($_POST['key']) ? $f->antihack_mysqli($_POST['key']) : '';
$cantidad = isset($_POST['cantidad']) ? $f->antihack_mysqli($_POST['cantidad']) : '';
$carrito->set("cantidad", $cantidad);
$carrito->edit($key);
$carrito->deleteOnCheck("Envio-Seleccion");
$carrito->deleteOnCheck("Metodo-Pago");
$cart = $carrito->return();
$lastArray = $cart[(count($cart) - 1)];
if ($lastArray['descuento'] != null) {
    $usuario = new Clases\Usuarios();
    $descuento = new Clases\Descuentos();
    $usuarioData = $usuario->viewSession();
    $descuento->refreshCartDescuento($cart, $usuarioData);
}
$discount = $carrito->checkDescuento();
$finalPrice = $carrito->totalPrice();
$total = $carrito->totalPriceWithoutDiscount();
echo json_encode(['total' => $total,'finalPrice' => $finalPrice, 'discount' => ['cart' => $discount]]);
