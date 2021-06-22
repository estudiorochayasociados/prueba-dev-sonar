<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$f = new Clases\PublicFunction();
$carrito = new Clases\Carrito();
$checkout = new Clases\Checkout();
$envios = new Clases\Envios();
$usuarios = new Clases\Usuarios();
$pedidos = new Clases\Pedidos();
$detalle = new Clases\DetallePedidos();
$productos = new Clases\Productos();

$envio = isset($_POST['envio']) ?  $f->antihack_mysqli($_POST['envio']) : '';
$nombre = isset($_POST['nombre']) ?  $f->antihack_mysqli($_POST['nombre']) : '';
$apellido = isset($_POST['apellido']) ?  $f->antihack_mysqli($_POST['apellido']) : '';
$email = isset($_POST['email']) ?  $f->antihack_mysqli($_POST['email']) : '';
$telefono = isset($_POST['telefono']) ?  $f->antihack_mysqli($_POST['telefono']) : '';
$provincia = isset($_POST['provincia']) ?  $f->antihack_mysqli($_POST['provincia']) : '';
$localidad = isset($_POST['localidad']) ?  $f->antihack_mysqli($_POST['localidad']) : '';
$direccion = isset($_POST['direccion']) ?  $f->antihack_mysqli($_POST['direccion']) : '';
$similar = isset($_POST['similar']) ?  $f->antihack_mysqli($_POST['similar']) : '';

if (!empty($envio)) {
    if (!empty($nombre) && !empty($apellido) && !empty($email) && !empty($telefono) && !empty($provincia) && !empty($localidad) && !empty($direccion)) {

        $envios->set("cod", $envio);
        $envioData = $envios->view();

        if (!empty($envioData)) {

            $data = array(
                "envio" => $envio,
                "nombre" => $nombre,
                "apellido" => $apellido,
                "email" => $email,
                "telefono" => $telefono,
                "provincia" => $provincia,
                "localidad" => $localidad,
                "direccion" => $direccion,
                "similar" => $similar,
            );

            if ($checkout->stage1($data)) {

                $carrito->deleteOnCheck("Envio-Seleccion");
                $carrito->deleteOnCheck("Metodo-Pago");

                if ($envioData['data']['limite']) {
                    if ($carrito->precioSinMetodoDePago() >= $envioData['data']['limite']) {
                        $envioData['data']["titulo"] = $envioData['data']["titulo"] . "¡GRATIS COMPRA SUPERIOR A $" . $envioData['data']['limite'] . "!";
                        $envioData['data']["precio"] = 0;
                    }
                }
                $carrito->set("id", "Envio-Seleccion");
                $carrito->set("cantidad", 1);
                $carrito->set("titulo", $envioData['data']["titulo"]);
                $carrito->set("precio", $envioData['data']["precio"]);
                $carrito->add();

                //Por si eligio invitado, ver de guardarlo en la base o updatearlo+}
                if ($_SESSION['stages']['type'] == 'GUEST') {
                    $usuarios->set("nombre", $nombre);
                    $usuarios->set("apellido", $apellido);
                    $usuarios->set("doc", '');
                    $usuarios->set("email", $email);
                    $usuarios->set("password", '');
                    $usuarios->set("direccion", $direccion);
                    $usuarios->set("localidad", $localidad);
                    $usuarios->set("provincia", $provincia);
                    $usuarios->set("telefono", $telefono);
                    $usuarios->set("invitado", 1);
                    $usuarios->set("fecha", date("Y-m-d"));
                    $usuarios->set("estado", 1);
                    $usuarios->set("minorista", 1);

                    $emailData = $usuarios->validate();
                    if ($emailData['status']) {
                        $cod = $emailData['data']['cod'];
                    } else {
                        $cod = substr(md5(uniqid(rand())), 0, 10);
                    }

                    $usuarios->set("cod", $cod);

                    if ($emailData['status']) {
                        $usuarios->guestSession();
                        $checkout->user($cod, 'GUEST');
                        $response = array("status" => true);
                        echo json_encode($response);
                    } else {
                        $usuarios->firstGuestSession();
                        $checkout->user($cod, 'GUEST');
                        $response = array("status" => true);
                        echo json_encode($response);
                    }
                } else {
                    $response = array("status" => true);
                    echo json_encode($response);
                }


                $_SESSION["usuarios"] = $usuarios->viewSession();
                $precio = $carrito->totalPrice();


                $carro = $carrito->return();
                $timezone = -3;
                $fecha = gmdate("Y-m-j H:i:s", time() + 3600 * ($timezone + date("I")));
                $pedidos->set("cod", $_SESSION['last_cod_pedido']);
                $pedidoCompleto = $pedidos->view();
                if (empty($pedidoCompleto["data"])) {
                    #Agrega al pedido
                    $pedidos->set("cod", $_SESSION['last_cod_pedido']);
                    $pedidos->set("total", $precio);
                    $pedidos->estado =  1; // CARRITO NO CERRADO
                    $pedidos->set("pago", "");
                    $pedidos->set("usuario", $_SESSION['usuarios']['cod']);
                    $pedidos->set("fecha", $fecha);
                    $pedidos->set("detalle", "");
                    $pedidos->set("visto", "");
                    $pedidos->add();
                    foreach ($carro as $carroItem) {
                        #Agrega el detalle
                        ////////validacion y baja de stock segun  la config
                        ////////validacion y baja de stock segun  la config
                        $detalle->set("cod", $_SESSION['last_cod_pedido']);
                        $detalle->set("producto", isset($carroItem["opciones"]["texto"]) ? $carroItem["titulo"] . " " . $carroItem["opciones"]["texto"] : $carroItem["titulo"]);
                        $detalle->set("cantidad", $carroItem["cantidad"]);
                        $detalle->set("precio", $carroItem["precio"]);
                        $detalle->set("tipo", ($carroItem['id'] == "Envio-Seleccion") ?  "ME"  :  "PR");
                        $detalle->set("descuento", serialize($carroItem["descuento"]));
                        $detalle->set("cod_producto",  $carroItem["id"]);
                        $detalle->set("cod_combinacion",  isset($carroItem["opciones"]["combinacion"]["cod_combinacion"]) ? $carroItem["opciones"]["combinacion"]["cod_combinacion"] : '');
                        $detalle->add();
                        // if($detalle->add()){
                        //    $productos->reduceStock($carroItem["id"],$carroItem["cantidad"]);
                        // }
                    }
                } else {
                    foreach ($carro as $carroItem) {
                        #Edita el detalle
                        if ($carroItem['id'] == "Envio-Seleccion") {
                            $detalle->set("cod", $_SESSION['last_cod_pedido']);
                            $detalle->set("tipo", 'ME');
                            $detalle->editSingleShipping("producto", isset($carroItem["opciones"]["texto"]) ? $carroItem["titulo"] . " " . $carroItem["opciones"]["texto"] : $carroItem["titulo"]);
                            $detalle->editSingleShipping("cantidad", $carroItem["cantidad"]);
                            $detalle->editSingleShipping("precio", $carroItem["precio"]);
                            $detalle->editSingleShipping("tipo", "ME");
                            $detalle->editSingleShipping("descuento", serialize($carroItem["descuento"]));
                        }
                    }
                }
            } else {
                $response = array("status" => false, "type" => "error", "message" => "[101] Ocurrió un error, recargar la página.");
                echo json_encode($response);
            }
        } else {
            $response = array("status" => false, "type" => "error", "message" => "[102] Ocurrió un error, recargar la página.");
            echo json_encode($response);
        }
    } else {
        $message = 'Completar los siguientes campos correctamente:<br>';
        if (empty($nombre)) {
            $message .= '- Nombre<br>';
        }
        if (empty($apellido)) {
            $message .= '- Apellido<br>';
        }
        if (empty($email)) {
            $message .= '- Email<br>';
        }
        if (empty($telefono)) {
            $message .= '- Telefono<br>';
        }
        if (empty($provincia)) {
            $message .= '- Provincia<br>';
        }
        if (empty($localidad)) {
            $message .= '- Localidad<br>';
        }
        if (empty($direccion)) {
            $message .= '- Direccion<br>';
        }

        $response = array("status" => false, "type" => "error", "message" => $message);
        echo json_encode($response);
    }
} else {
    $response = array("status" => false, "type" => "error", "message" => 'Seleccionar un tipo de envío.');
    echo json_encode($response);
}
