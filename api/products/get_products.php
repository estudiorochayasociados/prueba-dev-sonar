<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$f = new Clases\PublicFunction();
$producto = new Clases\Productos();
$categoria = new Clases\Categorias();
$combinacion = new Clases\Combinaciones();
$subcategoria = new Clases\Subcategorias();
$productosRelacionados = new Clases\ProductosRelacionados();

$search = isset($_POST['title']) ?  $f->antihack_mysqli($_POST['title']) : '';
$order = isset($_GET['order']) ?  $f->antihack_mysqli($_GET['order']) : '';
$start = isset($_GET['start']) ?  $f->antihack_mysqli($_GET['start']) : '0';
$limit = isset($_GET['limit']) ?  $f->antihack_mysqli($_GET['limit']) : '24';
$catsFilter = [];
$filter[] = 'productos.mostrar_web = 1';

if (!empty($search)) {
    $search = trim($search);
    $search_array = explode(' ', $search);
    $searchSql = '(';
    foreach ($search_array as $key => $searchData) {
        if ($key == 0) {
            $searchSql .= "productos.cod_producto LIKE '%$searchData%' OR productos.titulo LIKE '%$searchData%'";
        } else {
            $searchSql .= " AND productos.titulo LIKE '%$searchData%'";
        }
    }

    $searchSql .= ')';


    $filter[] = $searchSql;
}


if (!empty($_POST['variable2'])) {
    $tipo_string = '';
    foreach ($_POST['variable2'] as $key => $tipo) {
        if (!empty($tipo)) $tipo_string .= "'" . $f->antihack_mysqli($tipo) . "'";
    }
    $filter[] = "productos.variable2 IN (" . $tipo_string . ")";
}


if (!empty($_POST['categories'])) {
    foreach ($_POST['categories'] as $key => $cat) {
        $cat_ = $f->antihack_mysqli($cat);
        if (!empty($cat_)) $cats[] = "'" . $cat_ . "'";
    }
    $catsImplode = implode(",", $cats);
    $catsFilter[] = "productos.categoria IN (" . $catsImplode . ")";
}

if (!empty($_POST['subcategories'])) {
    foreach ($_POST['subcategories'] as $key => $cat) {
        $subcat_ = $f->antihack_mysqli($cat);
        if (!empty($subcat_)) $subcats[] = "'" . $subcat_ . "'";
    }
    $subcatsImplode = implode(",", $subcats);
    $catsFilter[] = "productos.subcategoria IN (" . $subcatsImplode . ")";
}



count($catsFilter) ? $filter[] = "(" . implode(" AND ", $catsFilter) . ")" : '';

switch ($order) {
    default:
        $order = "productos.stock DESC";
        break;
    case "2":
        $order = "productos.precio ASC";
        break;
    case "3":
        $order = "productos.precio DESC";
        break;
}


if (empty($filter)) $filter = '';

$data = [
    "filter" => $filter,
    "admin" => false,
    "category" => true,
    "subcategory" => true,
    "images" => true,
    "limit" => $start . "," . $limit,
    "order" => $order,
];

$productosData = $producto->list($data, $_SESSION['lang']);
$user = (!empty($_SESSION['usuarios']['cod'])) ? $_SESSION['usuarios']['cod'] : '';

if (!empty($productosData)) {
    echo json_encode(["products" => $productosData, "user" => $user]);
}
