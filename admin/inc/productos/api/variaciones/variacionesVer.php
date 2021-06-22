<?php
include "../inc.php";

$combinacion = new Clases\Combinaciones();
$cod = isset($_GET["cod"]) ? $_GET["cod"] : '';
$combinacion->set("codProducto", $cod);
$combinacionData = $combinacion->listByProductCod();
echo json_encode($combinacionData);