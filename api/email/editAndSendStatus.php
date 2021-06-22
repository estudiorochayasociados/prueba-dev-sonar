<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();
$enviar = new Clases\Email();
$pedido = new Clases\Pedidos();
$config = new Clases\Config();
$estadosPedidos  =  new Clases\EstadosPedidos();

$emailData = $config->viewEmail();
$codPedido = isset($_POST['codPedido']) ? $funciones->antihack_mysqli($_POST['codPedido']) : '';
$subEstadoPedidoCod = isset($_POST['estadoPedido']) ? $funciones->antihack_mysqli($_POST['estadoPedido']) : '';
$enviarMail = isset($_POST['enviar']) ? $funciones->antihack_mysqli($_POST['enviar']) : '';
$estado = $estadosPedidos->view($subEstadoPedidoCod);
$mensajeCompraUsuario = '';
$carroTotal = 0;

if (!empty($codPedido)) {
    $pedido->set("cod", $codPedido);
    $pedido->editSingle("estado", $subEstadoPedidoCod);
    if ($enviarMail == 1) {
        $pedidoData = $pedido->view();
        $detalle = json_decode($pedidoData['data']['detalle'], true);
        #SE GENERA LA INFORMACION DEL PEDIDO
        $envioData = $pedido->getInfoPedido($detalle, 'envio');
        $pagoData = $pedido->getInfoPedido($detalle, 'pago');
        #END GENERAR INFO PEDIDO

        if (!empty($pedidoData['data'])) {

            #SE GENERA LA TABLA DEL CARRITO
            $mensaje_carro = '<table border="1" style="text-align:left;width:100%;font-size:13px !important">';
            $mensaje_carro .= "<thead><th>Nombre producto</th><th>Cantidad</th><th>Precio</th><th>Total</th></thead>";
            foreach ($pedidoData['detail'] as $detail) {
                $unserialized = unserialize($detail['variable2']);
                if (!empty($unserialized) && isset($unserialized['cod'])) {
                    $descuentoMonto = $unserialized["monto"];
                    $descuentoPrecio = $unserialized["precio-antiguo"];
                } else {
                    $descuentoMonto = '';
                    $descuentoPrecio = '';
                }
                $opciones = '';
                if (!empty($detail['variable3'])) {
                    $opciones = "<br>" . $detail['variable3'];
                }
                $carroTotal += $detail['cantidad'] * $detail['precio'];
                $mensaje_carro .= "<tr>";
                $mensaje_carro .= "<td>" . $detail['producto'] . " <b>" . $descuentoMonto . "</b>" . $opciones . "</td>";
                $mensaje_carro .= "<td>" . $detail["cantidad"] . "</td>";
                if ($detail['precio'] != 0) {
                    $mensaje_carro .= "<td>$" . $detail['precio'] . " <span style='text-decoration: line-through'>" . $descuentoPrecio . "</span></td>";
                } else {
                    $mensaje_carro .= "<td></td>";
                }
                $mensaje_carro .= "<td>$" . $detail['cantidad'] * $detail['precio'] . "</td>";

                $mensaje_carro .= "</tr>";
            }
            $mensaje_carro .= '<tr><td></td><td></td><td></td><td>$' . $carroTotal . '</td></tr>';
            $mensaje_carro .= '</table>';
            #END TABLA CARRITO


            $cuerpoMail = $estado['data']['mensaje'];
            $cuerpoMail = str_replace('(usuario)', ucfirst($pedidoData['user']['data']["nombre"]), $cuerpoMail);

            $mensajeCompraUsuario .= $cuerpoMail;
            $mensajeCompraUsuario .= "<h3>Pedido realizado:</h3>";
            $mensajeCompraUsuario .= $mensaje_carro;

            if ($detalle['pago']['factura']) {
                $mensajeCompraUsuario .= '<p style="float:left><b>Factura A al CUIT: </b>' . $detalle['pago']['dni'] . '</p>';
            }

            $mensajeCompraUsuario .= '<h6 style="width:100%;float:left">MÉTODO DE PAGO ELEGIDO: ' . mb_strtoupper($pedidoData['data']["tipo"]) . '</h6>';
            if (isset($detalle['link']) && $estado['data']['estado'] != '2') {
                $mensajeCompraUsuario .= '<6>LINK DE PAGO: <a href="' . $detalle['link'] . '"> CLICK AQUÍ </a></6>';
            }

            $mensajeCompraUsuario .= '<br/><hr/>';
            $mensajeCompraUsuario .= '<div style="width:50%;float:left;margin-bottom:50px">';
            $mensajeCompraUsuario .= '<h3>Información de envio:</h3>';
            $mensajeCompraUsuario .= $envioData;
            $mensajeCompraUsuario .= '</div>';
            $mensajeCompraUsuario .= '<div style="width:50%;float:right;margin-bottom:50px">';
            $mensajeCompraUsuario .= '<h3>Información de pago:</h3>';
            $mensajeCompraUsuario .= $pagoData;
            $mensajeCompraUsuario .= '</div>';

            if ($estado['data']['enviar'] == 1) {
                $asunto = $estado['data']['asunto'];
                $enviar->set("asunto", $asunto);
                $enviar->set("receptor", $pedidoData['user']['data']["email"]);
                $enviar->set("emisor", $emailData['data']['remitente']);
                $enviar->set("mensaje", $mensajeCompraUsuario);
                if ($enviar->emailEnviar()) {
                    $result = array("status" => true, "message" => "EMAIL ENVIADO EXITOSAMENTE");
                } else {
                    $result = array("status" => false, "message" => "OCURRIO UN ERROR");
                }
                echo json_encode($result);
            }
        }
    } else {
        $result = array("status" => true, "message" => "ESTADO CAMBIADO EXITOSAMENTE");
        echo json_encode($result);
    }
}
