<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$f = new Clases\PublicFunction();
$carrito = new Clases\Carrito();
$checkout = new Clases\Checkout();
$detalle = new Clases\DetallePedidos();

$nombre = isset($_POST['nombre']) ?  $f->antihack_mysqli($_POST['nombre']) : '';
$apellido = isset($_POST['apellido']) ?  $f->antihack_mysqli($_POST['apellido']) : '';
$email = isset($_POST['email']) ?  $f->antihack_mysqli($_POST['email']) : '';
$dni = isset($_POST['dni']) ?  $f->antihack_mysqli($_POST['dni']) : '';
$telefono = isset($_POST['telefono']) ?  $f->antihack_mysqli($_POST['telefono']) : '';
$provincia = isset($_POST['provincia']) ?  $f->antihack_mysqli($_POST['provincia']) : '';
$localidad = isset($_POST['localidad']) ?  $f->antihack_mysqli($_POST['localidad']) : '';
$direccion = isset($_POST['direccion']) ?  $f->antihack_mysqli($_POST['direccion']) : '';
$factura = isset($_POST['factura']) ?  $f->antihack_mysqli($_POST['factura']) : '';

if (!empty($nombre) && !empty($apellido) && !empty($email) && !empty($dni) && !empty($telefono) && !empty($provincia) && !empty($localidad) && !empty($direccion)) {

    $data = array(
        "nombre" => $nombre,
        "apellido" => $apellido,
        "email" => $email,
        "dni" => $dni,
        "telefono" => $telefono,
        "provincia" => $provincia,
        "localidad" => $localidad,
        "direccion" => $direccion,
        "factura" => $factura,
    );

    if ($checkout->stage2($data)) {
        $response = array("status" => true);
        echo json_encode($response);
    } else {
        $response = array("status" => false, "type" => "error", "message" => "[201] Ocurrió un error, recargar la página.");
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
    if (empty($dni)) {
        $message .= '- DNI/CUIT<br>';
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
