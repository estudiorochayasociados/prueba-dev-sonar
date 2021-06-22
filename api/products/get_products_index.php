<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$f = new Clases\PublicFunction();
$producto = new Clases\Productos();
$categoria = new Clases\Categorias();
$combinacion = new Clases\Combinaciones();
$subcategoria = new Clases\Subcategorias();

$order = '';
$start = 0;
$limit = 12;
$filter[] = 'productos.mostrar_web = 1';

$productosData = $producto->list($filter, false, true, true, true, $order, $start . "," . $limit);

$user = (!empty($_SESSION['usuarios']['cod'])) ? $_SESSION['usuarios']['cod'] : '';

if (!empty($productosData)) {
    echo json_encode(["products" => $productosData, "user" => $user]);
}
