<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$f = new Clases\PublicFunction();
$carrito = new Clases\Carrito();
$producto = new Clases\Productos();
$atributo = new Clases\Atributos();
$subatributo = new Clases\Subatributos();
$combinacion = new Clases\Combinaciones();
$detalleCombinacion = new Clases\DetalleCombinaciones();
$checkout = new Clases\Checkout();

$product = isset($_POST['product']) ? $f->antihack_mysqli($_POST['product']) : ''; //TODO POST
$amount = intval(isset($_POST['amount']) ? $f->antihack_mysqli($_POST['amount']) : $f->antihack_mysqli($_POST['stock'])); //TODO POST

$product = trim(str_replace(" ", "", $product));

$productoData = $producto->list(["filter" => ["productos.cod = " . "'$product'"]],$_SESSION['lang'],true);

if (empty($productoData)) {
    echo json_encode(["status" => false, "type" => "error", "message" => "Ocurrió un error, recargar la página."]);
    die();
}
$opciones = $error = '';
$carrito->deleteOnCheck("Envio-Seleccion");
$carrito->deleteOnCheck("Metodo-Pago");
$carrito->set("id", $productoData['data']['cod']);
$carrito->set("cantidad", $amount);
$carrito->set("titulo", $productoData['data']['titulo']);
$carrito->set("stock", $productoData['data']['stock']);
$carrito->set("peso", number_format($productoData['data']['peso'], 2, ".", ""));
$carrito->set("opciones", $opciones);
$carrito->set("precio", $productoData['data']['precio_final']);
//SI VIENE ATRIBUTO
if (!empty($_POST['atribute'])) {
    $opcion = '| ';
    $atri;
    foreach ($_POST['atribute'] as $key => $atrib) {
        $atributo->set("cod", $key);
        $titulo = $atributo->view()['atribute']['value'];
        $subatributo->set("cod", $atrib);
        $sub = $subatributo->view()['data']['value'];
        $opcion .= "<strong>$titulo: </strong>$sub | ";
        $atri[] = array($titulo => $sub);
    }
    $opciones = array("texto" => $opcion, "subatributos" => $atri);
    $carrito->set("opciones", $opciones);
}
//SI TIENE COMBINACION
if (!empty($_POST['combination'])) {
    $resultValidate = $combinacion->check($_POST['atribute'], $product);
    if ($resultValidate['result'] === 1) {
        $detalleCombinacion->set("codCombinacion", $resultValidate['combination']);
        $detalleData = $detalleCombinacion->view();
        if (!empty($detalleData)) {
            $carrito->set("precio", $detalleData['precio']);
            if (!empty($_SESSION['usuarios'])) {
                if ($_SESSION['usuarios']['invitado'] != 1 || $_SESSION["usuarios"]["minorista"] == 1) {
                    $carrito->set("precio", $detalleData['precio']);
                } else {
                    if (!empty($detalleData['mayorista'])) {
                        $carrito->set("precio", $detalleData['mayorista']);
                    }
                }
            }
            $opciones = array("texto" => $opcion, "combinacion" => $detalleData);
            $carrito->set("stock", $detalleData['stock']);
            $carrito->set("peso", number_format($productoData['data']['peso'], 2, ".", ""));
            $carrito->set("opciones", $opciones);
        } else {
            $ERROR = 'Ocurrió un error, intente nuevamente.';
        }
    } else {
        $ERROR = 'LO SENTIMOS NO HAY STOCK CON ESAS ESPECIFICACIONES.';
    }
}
if (!empty($ERROR)) {
    $result = array("status" => false, "message" => $ERROR);
    echo json_encode($result);
} else {
    if ($amount <= $productoData['data']['stock']) {
        if ($carrito->add()) {
            $checkout->destroy();
            $_SESSION['latest'] = $productoData['data']['titulo'];
            $result = array("status" => true, "cod_producto" => $productoData['data']['cod'], "combinacion " => isset($detalleData) ? json_encode($detalleData) : '');
            echo json_encode($result);
        } else {
            $result = array("status" => false, "message" => "LO SENTIMOS NO CONTAMOS CON ESA CANTIDAD EN STOCK, COMPRUEBE SI YA POSEE ESTE PRODUCTO EN SU CARRITO.");
            echo json_encode($result);
        }
    } else {
        $result = array("status" => false, "message" => "LO SENTIMOS NO CONTAMOS CON ESA CANTIDAD EN STOCK.");
        echo json_encode($result);
    }
}
