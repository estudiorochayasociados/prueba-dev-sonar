<?php
include "../inc.php";

$config = new Clases\Config();
$atributo = new Clases\Atributos();
$subatributo = new Clases\Subatributos();

$attr = isset($_GET["attr"]) ? $_GET["attr"] : '';
$subattr = isset($_GET["subattr"]) ? $_GET["subattr"] : '';

if ($attr != '') {
    $atributo->set("cod", $attr);
    $atributo->delete();
}


if ($subattr != '') {
    $subatributo->set("cod", $subattr);
    $subatributo->delete();
}

