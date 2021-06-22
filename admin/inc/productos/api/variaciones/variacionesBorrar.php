<?php

include "../inc.php";

$config = new Clases\Config();
$combinaciones = new Clases\Combinaciones();
$detalleCombinaciones = new Clases\DetalleCombinaciones();

$comb = isset($_GET["comb"]) ? $_GET["comb"] : '';

if ($comb != '') {
    $combinaciones->set("cod", $comb);
    $combinaciones->delete();
    $detalleCombinaciones->set("codCombinacion",$comb);
    $detalleCombinaciones->delete();
}

