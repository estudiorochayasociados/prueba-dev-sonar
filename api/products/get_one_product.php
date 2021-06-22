<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$f = new Clases\PublicFunction();
$producto = new Clases\Productos();
$combinacion = new Clases\Combinaciones();
$atributo = new Clases\Atributos();
$combinacion = new Clases\Combinaciones();


$cod = isset($_POST['cod']) ?  $f->antihack_mysqli($_POST['cod']) : '';

$productosData = $producto->view($cod, false, true, true, true);

$atributo->set("productoCod", $cod);
$atributosData = $atributo->list();
$combinacion->set("codProducto", $cod);
$combinacionData = $combinacion->listByProductCod();

if (!empty($productosData)) {
    echo json_encode(["product" => $productosData, "attr" => $atributosData,"combination" => $combinacionData]);
}
