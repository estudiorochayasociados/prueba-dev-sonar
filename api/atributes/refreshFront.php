<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();
$producto = new Clases\Productos();
$atributo = new Clases\Atributos();
$subatributo = new Clases\Subatributos();
$combinacion = new Clases\Combinaciones();
$detalleCombinacion = new Clases\DetalleCombinaciones();
$product = isset($_POST['product']) ? $funciones->antihack_mysqli($_POST['product']) : '';
$amountAtributes = isset($_POST['amount-atributes']) ? $funciones->antihack_mysqli($_POST['amount-atributes']) : '';
$combination = false;
if ($amountAtributes == count($_POST['atribute'])) {
    if (!empty($product)) {
        $ERROR = '';
        $productoData = $producto->list(["filter" => ["productos.cod=" . $product]], $_SESSION['lang'], true);
        $precio = $productoData["data"]["precio_final"];
        $stock = $productoData["data"]["stock"];
        var_dump($productoData);
        if (!empty($productoData['data'])) {
            if (!empty($_POST['combination'])) {
                $resultValidate = $combinacion->check($_POST['atribute'], $product);
                if ($resultValidate['result'] === 1) {
                    $combination = true;
                    $detalleCombinacion->set("codCombinacion", $resultValidate['combination']);
                    $detalleData = $detalleCombinacion->view();
                    if (!empty($detalleData)) {
                        $precio = $detalleData['precio'];
                        $stock = ($detalleData['stock'] != 0) ? $detalleData['stock'] : "0";
                        if (!empty($_SESSION['usuarios'])) {

                            if ($_SESSION['usuarios']['invitado'] != 1 || $_SESSION["usuarios"]["minorista"] == 1) {

                                $precio = $detalleData['precio'];
                                $stock = ($detalleData['stock'] != 0) ? $detalleData['stock'] : "0";
                            } else {
                                if (!empty($detalleData['mayorista'])) {
                                    $precio = $detalleData['mayorista'];
                                    $stock = ($detalleData['stock'] != 0) ? $detalleData['stock'] : "0";
                                }
                            }
                        }
                    } else {
                        $ERROR = 'Ocurrió un error, intente nuevamente.';
                    }
                }
            }
            if (!empty($ERROR)) {
                $result = array("status" => false, "message" => $ERROR);
                echo json_encode($result);
            } else {
                $result = array("status" => true, "price" => $precio, "stock" => $stock, "combination" => $combination);
                echo json_encode($result);
            }
        } else {
            $result = array("status" => false, "message" => "Ocurrió un error, recargar la página.");
            echo json_encode($result);
        }
    } else {
        $result = array("status" => false, "message" => "Ocurrió un error, recargar la página.");
        echo json_encode($result);
    }
}
