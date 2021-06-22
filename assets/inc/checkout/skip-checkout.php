<?php
$f = new Clases\PublicFunction();
$config = new Clases\Config();

if ($_SESSION["usuarios"]["minorista"] == 1) {
    $checkoutData = $config->viewCheckout("minorista");
} else {
    $checkoutData = $config->viewCheckout("mayorista");
}

$data = [
    "envio" => $checkoutData['data']['envio'],
    "cod" =>  $checkoutData['data']['pago'],
    "nombre" => $_SESSION["usuarios"]["nombre"],
    "apellido" => $_SESSION["usuarios"]["apellido"],
    "dni" => !empty($_SESSION["usuarios"]["doc"]) ? $_SESSION["usuarios"]["doc"] : 'Sin datos',
    "email" => $_SESSION["usuarios"]["email"],
    "telefono" => $_SESSION["usuarios"]["telefono"],
    "provincia" => $_SESSION["usuarios"]["provincia"],
    "localidad" => $_SESSION["usuarios"]["localidad"],
    "direccion" => $_SESSION["usuarios"]["direccion"],
    "facturar" => 1
];
?>
<script src="<?= URL ?>/assets/js/services/checkout.js"></script>
<script>
    stage1('<?= json_encode($data) ?>' , '<?= URL ?>');
</script>