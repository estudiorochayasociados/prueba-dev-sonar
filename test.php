<?php
require_once "Config/Autoload.php";
Config\Autoload::run();

$productos = new Clases\Productos();
$atributo = new Clases\Atributos();
$subatributo = new Clases\Subatributos();
$data = [
    "filter" => ["productos.variable1 != ''"],
];
$productosData  = $productos->list($data, $_SESSION['lang']);

foreach ($productosData as $productItem) {
    $atributoVal = explode("|", $productItem['data']['variable1']);
    if (isset($atributoVal) && !empty($atributoVal)) {
        foreach ($atributoVal as $atributoItem) {
            $attr = explode(":", $atributoItem);
            if (isset($attr) && !empty($attr)) {
                //se crea el atributo
                $codAtributo = substr(md5(uniqid(rand())), 0, 10);
                $atributo->set("productoCod", $productItem["data"]["cod"]);
                $atributo->set("cod", $codAtributo);
                $atributo->set("value", $attr[0]);
                $addAtributo = $atributo->add();

                //se crea el sub atributo
                $subAtributoVal = explode("_", $attr[1]);
                if (isset($subAtributoVal) && !empty($subAtributoVal)) {
                    foreach ($subAtributoVal as $subAttr) {
                        $codSubatributo = substr(md5(uniqid(rand())), 0, 10);
                        $subatributo->set("cod", $codSubatributo);
                        $subatributo->set("codAtributo", $codAtributo);
                        $subatributo->set("value", $subAttr);
                        $subatributo->add();
                    }
                }
            }
        }
    }
}
