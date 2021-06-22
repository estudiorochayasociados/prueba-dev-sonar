<?php
include "../inc.php";

$config = new Clases\Config();
$atributo = new Clases\Atributos();
$subatributo = new Clases\Subatributos();

$cod = isset($_GET["cod"]) ? $_GET["cod"] : '';

$atributo->set("productoCod",$cod);
echo json_encode($atributo->list());