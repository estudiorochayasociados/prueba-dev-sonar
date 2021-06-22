<?php
require_once dirname(__DIR__, 3) . "/Config/Autoload.php";
Config\Autoload::run();
$producto = new Clases\Productos();
$categoria = new Clases\Categorias();
$f = new Clases\PublicFunction();
$idiomaGet = isset($_GET["idioma"]) ? $f->antihack_mysqli($_GET["idioma"]) : $_SESSION['lang'];
$filter = [];
$busqueda = isset($_GET['busqueda']) ?  $f->antihack_mysqli($_GET['busqueda']) : '';
$start = isset($_GET['start']) ?  $f->antihack_mysqli($_GET['start']) : '0';
$limit = isset($_GET['limit']) ?  $f->antihack_mysqli($_GET['limit']) : '24';
if (!empty($busqueda)) {
    $filter[] = "productos.titulo LIKE '%$busqueda%' OR `productos`.`cod_producto` = '$busqueda'";
}
if (empty($filter)) $filter = '';


$categoriasData = $categoria->list(["area = 'productos'"], "titulo ASC", "", $idiomaGet);
$data = [
    "filter" => $filter,
    "admin" => true,
    "category" => true,
    "subcategory" => true,
    "limit" => $start . "," . $limit,
];

$productos = $producto->list($data, $idiomaGet);
?>

<?php
if (!empty($productos)) {
    $result = ["product" => $productos, "category" => $categoriasData];
     echo json_encode($result,JSON_PRETTY_PRINT);
}
