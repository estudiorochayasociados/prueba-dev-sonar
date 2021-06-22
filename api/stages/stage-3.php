<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$f = new Clases\PublicFunction();
$carrito = new Clases\Carrito();
$pagos = new Clases\Pagos();
$checkout = new Clases\Checkout();
$pedidos = new Clases\Pedidos();
$detalle = new Clases\DetallePedidos();
$cod = isset($_POST['cod']) ? $f->antihack_mysqli($_POST['cod']) : '';
if (!empty($cod)) {
    $pagos->set("cod", $cod);
    $pagosData = $pagos->view();
    if (!empty($pagosData['data'])) {
        $carrito->checkKeyOnCart("Metodo-Pago");
        $carrito->changePriceByPayment($pagosData);
        $precio = $carrito->totalPrice();
        $data = array("cod" => $cod);
        if ($checkout->stage3('', $data)) {
            $detalleCompleto = array(
                'leyenda' => '',
                'descuento' => '',
                'envio' => array(
                    'tipo' => '',
                    'nombre' => '',
                    'apellido' => '',
                    'email' => '',
                    'provincia' => '',
                    'localidad' => '',
                    'direccion' => '',
                    'telefono' => '',
                    'similar' => false
                ),
                'pago' => array(
                    'nombre' => '',
                    'apellido' => '',
                    'email' => '',
                    'dni' => '',
                    'provincia' => '',
                    'localidad' => '',
                    'direccion' => '',
                    'telefono' => '',
                    'factura' => false
                )
            );
            if (!empty($pagosData['data']['leyenda'])) {
                $detalleCompleto['leyenda'] = $pagosData['data']['leyenda'];
            }
            $detalleCompleto['envio']['tipo'] = $_SESSION['carrito'][$carrito->checkKeyOnCart("Envio-Seleccion")]['titulo'];
            $detalleCompleto['envio']['nombre'] = $_SESSION['stages']['stage-1']['data']['nombre'];
            $detalleCompleto['envio']['apellido'] = $_SESSION['stages']['stage-1']['data']['apellido'];
            $detalleCompleto['envio']['email'] = $_SESSION['stages']['stage-1']['data']['email'];
            $detalleCompleto['envio']['provincia'] = $_SESSION['stages']['stage-1']['data']['provincia'];
            $detalleCompleto['envio']['localidad'] = $_SESSION['stages']['stage-1']['data']['localidad'];
            $detalleCompleto['envio']['direccion'] = $_SESSION['stages']['stage-1']['data']['calle'];
            $detalleCompleto['envio']['telefono'] = $_SESSION['stages']['stage-1']['data']['telefono'];
            if (!empty($_SESSION['stages']['stage-1']['data']['similar'])) {
                $detalleCompleto['envio']['similar'] = true;
            }

            $detalleCompleto['pago']['nombre'] = $_SESSION['stages']['stage-2']['data']['nombre'];
            $detalleCompleto['pago']['apellido'] = $_SESSION['stages']['stage-2']['data']['apellido'];
            $detalleCompleto['pago']['email'] = $_SESSION['stages']['stage-2']['data']['email'];
            $detalleCompleto['pago']['dni'] = $_SESSION['stages']['stage-2']['data']['dni'];
            $detalleCompleto['pago']['provincia'] = $_SESSION['stages']['stage-2']['data']['provincia'];
            $detalleCompleto['pago']['localidad'] = $_SESSION['stages']['stage-2']['data']['localidad'];
            $detalleCompleto['pago']['direccion'] = $_SESSION['stages']['stage-2']['data']['calle'];
            $detalleCompleto['pago']['telefono'] = $_SESSION['stages']['stage-2']['data']['telefono'];
            if (!empty($_SESSION['stages']['stage-2']['data']['factura'])) {
                $detalleCompleto['pago']['factura'] = true;
            }
            $detalleCompletoJSON = json_encode($detalleCompleto, JSON_UNESCAPED_UNICODE);

            $timezone = -3;
            $fecha = gmdate("Y-m-j H:i:s", time() + 3600 * ($timezone + date("I")));
            $pedidos->set("cod", $_SESSION['last_cod_pedido']);
            $pedidos->editSingle("estado", $pagosData['data']['defecto']);
            $pedidos->editSingle("pago", $pagosData['data']["titulo"]);
            $pedidos->editSingle("fecha", $fecha);
            $pedidos->editSingle("detalle", $detalleCompletoJSON);
            $pedidos->editSingle("total", $precio);
            $carro = $carrito->return();

            foreach ($carro as $key => $carroItem) {
                if ($carroItem['id'] == "Metodo-Pago") {
                    $detalle->set("cod", $_SESSION['last_cod_pedido']);
                    $detalle->set("producto", $carroItem["titulo"]);
                    $detalle->set("cantidad", $carroItem["cantidad"]);
                    $detalle->set("precio", $carroItem["precio"]);
                    $detalle->set("tipo", "MP");
                    $detalle->set("descuento", serialize($carroItem["descuento"]));
                    $detalle->set("cod_producto",  $carroItem["id"]);
                    $detalle->set("cod_combinacion",  '');
                    $detalle->add();
                }
            }
            $checkPedido = $pedidos->view();
            if (!empty($checkPedido['data'])) {
                if (!empty($pagosData['data']['tipo'])) {
                    switch ($pagosData['data']['tipo']) {
                        case 1:
                            $response = array("status" => true, "type" => "API", "url" => URL . '/api/payments/mp.php');
                            echo json_encode($response);
                            break;
                        default:
                            $response = array("status" => false, "message" => "[301] Ocurrió un error, recargar la página.");
                            echo json_encode($response);
                            break;
                    }
                } else {
                    $checkout->close();
                    $response = array("status" => true, "url" => URL . '/checkout/detail');
                    echo json_encode($response);
                }
            } else {
                $response = array("status" => false, "message" => "[302] Ocurrió un error, recargar la página.");
                echo json_encode($response);
            }
        } else {
            $response = array("status" => false, "message" => "[303] Ocurrió un error, recargar la página.");
            echo json_encode($response);
        }
    } else {
        $response = array("status" => false, "message" => "[304] Ocurrió un error, recargar la página.");
        echo json_encode($response);
    }
} else {
    $response = array("status" => false, "message" => "[305] Ocurrió un error, recargar la página.");
    echo json_encode($response);
}
