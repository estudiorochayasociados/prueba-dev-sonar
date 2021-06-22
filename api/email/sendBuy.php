<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();
$enviar = new Clases\Email();
$pedido = new Clases\Pedidos();
$config = new Clases\Config();
$emailData = $config->viewEmail();
$codPedido = isset($_POST['cod']) ? $funciones->antihack_mysqli($_POST['cod']) : $_SESSION["last_cod_pedido"];

// if (!empty($codPedido)) {
//     $pedido->set("cod", $codPedido);
//     $pedidoData = $pedido->view();
//     if (!empty($pedidoData['data'])) {
//         $detalle = json_decode($pedidoData['data']['detalle'], true);
//         $envioData = $pedido->getInfoPedido($detalle, 'envio');
//         $pagoData = $pedido->getInfoPedido($detalle, 'pago');
//         $carroTotal = 0;
//         $mensaje_carro = '<table border="1" style="text-align:left;width:100%;font-size:13px !important">';
//         $mensaje_carro .= "<thead><th>Nombre producto</th><th>Cantidad</th><th><price class='hidden'>Precio</price></th><th><price class='hidden'>Total</price></th></thead>";
//         foreach ($pedidoData['detail'] as $detail) {
//             $unserialized = unserialize($detail['variable2']);
//             if (!empty($unserialized) && isset($unserialized['cod'])) {
//                 $descuentoCod = $unserialized["cod"];
//                 $descuentoMonto = $unserialized["monto"];
//                 $descuentoPrecio = $unserialized["precio-antiguo"];
//             } else {
//                 $descuentoCod = '';
//                 $descuentoMonto = '';
//                 $descuentoPrecio = '';
//             }
//             $opciones = '';
//             if (!empty($detail['variable3'])) {
//                 $opciones = "<br>" . $detail['variable3'];
//             }
//             $carroTotal += $detail['cantidad'] * $detail['precio'];
//             $mensaje_carro .= "<tr>";
//             $mensaje_carro .= "<td>" . $detail['producto'] . " <b>" . $descuentoMonto . "</b>" . $opciones . "</td>";
//             $mensaje_carro .= "<td>" . $detail["cantidad"] . "</td>";
//             if ($detail['precio'] != 0) {
//                 $mensaje_carro .= "<td><price class='hidden'>$" . $detail['precio'] . " <span style='text-decoration: line-through'>" . $descuentoPrecio . "</span></price></td>";
//             } else {
//                 $mensaje_carro .= "<td></td>";
//             }
//             $mensaje_carro .= "<td><price class='hidden'>$" . $detail['cantidad'] * $detail['precio'] . "</price></td>";
//             $mensaje_carro .= "</tr>";
//         }
//         $mensaje_carro .= '<tr><td></td><td></td><td></td><td><price class="hidden">$' . $carroTotal . '</price></td></tr>';
//         $mensaje_carro .= '</table>';
//         //ADMIN MENSAJE
//         $mensajeCompra = '¡Nueva compra desde la web!<br/>A continuación te dejamos el detalle del pedido.<hr/> <h3>Pedido realizado:</h3>';
//         $mensajeCompra .= $mensaje_carro;

//         if ($detalle['pago']['factura']) {
//             $mensajeCompra .= '<p><b>Factura A al CUIT: </b>' . $detalle['pago']['dni'] . '</p>';
//         }
//         $mensajeCompra .= '<br/><hr/>';
//         $mensajeCompra .= '<h6 style="width:100%;float:left">MÉTODO DE PAGO ELEGIDO: ' . mb_strtoupper($pedidoData['data']["pago"]) . '</h6>';
//         $mensajeCompra .= '<div style="width:50%;float:right">';
//         $mensajeCompra .= '<h3>Información de envio:</h3>';
//         $mensajeCompra .= $envioData;
//         $mensajeCompra .= '<br/><hr/>';
//         $mensajeCompra .= '</div>';

//         $mensajeCompra .= '<div style="width:50%;float:right">';
//         $mensajeCompra .= '<h3>Información de pago:</h3>';
//         $mensajeCompra .= $pagoData;
//         $mensajeCompra .= '</div>';
//         $enviar->set("asunto", "NUEVA COMPRA ONLINE");
//         $enviar->set("receptor", $emailData['data']['remitente']);
//         $enviar->set("emisor", $emailData['data']['remitente']);
//         $enviar->set("mensaje", $mensajeCompra);
//         $enviar->emailEnviar();

//         //USUARIO MENSAJE
//         $mensajeCompraUsuario = '¡Muchas gracias por tu nueva compra!<br/>';
//         $mensajeCompraUsuario .= "En el transcurso de las 24 hs un operador se estará contactando con usted para pactar la entrega y/o pago del pedido. A continuación te dejamos el pedido que nos realizaste.<hr/>";
//         $mensajeCompraUsuario .= "<h3>Pedido realizado:</h3>";
//         $mensajeCompraUsuario .= $mensaje_carro;
        
//         if ($pedidoData['data']["estado"] == 0 || $pedidoData['data']["estado"] == 1 || $pedidoData['data']['estado'] == 2) {
//             $mensajeCompraUsuario .= '<h5 style="width:100%;float:left">MÉTODO DE PAGO ELEGIDO: ' . mb_strtoupper($pedidoData['data']["pago"]) . '</h5>';
//             if ($detalle['pago']['factura']) {
//                 $mensajeCompraUsuario .= '<p><b>Factura A al CUIT: </b>' . $detalle['pago']['dni'] . '</p>';
//             }
//             if (isset($detalle['link'])) {
//                 $mensajeCompraUsuario .= '<h5>LINK DE PAGO: <a href="' . $detalle['link'] . '"> CLICK AQUÍ </a></h5>';
//             }
//         }
//         $$mensajeCompraUsuario .= '<br/><hr/>';
//         $mensajeCompraUsuario .= '<div style="width:50%;float:left;margin-bottom:50px">';
//         $mensajeCompraUsuario .= '<h3>Información de envio:</h3>';
//         $mensajeCompraUsuario .= $envioData;
//         $mensajeCompraUsuario .= '</div>';

//         $mensajeCompraUsuario .= '<div style="width:50%;float:right;margin-bottom:50px">';
//         $mensajeCompraUsuario .= '<h3>Información de pago:</h3>';
//         $mensajeCompraUsuario .= $pagoData;
//         $mensajeCompraUsuario .= '</div>';

//         $enviar->set("asunto", "Muchas gracias por tu nueva compra");
//         $enviar->set("emisor", $emailData['data']['remitente']);
//         $enviar->set("receptor", $pedidoData['user']['data']["email"]);
//         $enviar->set("mensaje", $mensajeCompraUsuario);
//         $enviar->emailEnviar();
//     }
// }
