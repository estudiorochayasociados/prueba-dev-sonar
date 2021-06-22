<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();

$idioma = new Clases\Idiomas();
$usuario = new Clases\Usuarios();
$f = new Clases\PublicFunction();
$cod = isset($_POST["cod"]) ? $f->antihack_mysqli($_POST["cod"]) : '';

$_SESSION['lang'] = $cod;


if ((isset($_SESSION['usuarios']) && !empty($_SESSION['usuarios']))) {
    $usuario->set("cod",$_SESSION['usuarios']['cod']);
    $usuario->editSingle("idioma", $cod);
}
echo json_encode(["status" => true]);
