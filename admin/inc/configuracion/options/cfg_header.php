<?php
if (isset($_POST["agregar-config"])) {
    $config->set("content_header", isset($_POST["cnf-header"]) ? $funciones->antihack_mysqli($_POST["cnf-header"]) : '');
    $error = $config->addConfigHeader();
    if ($error) {
        $funciones->headerMove(URL_ADMIN . '/index.php?op=configuracion&accion=modificar&tab=config-header');
    } else {
        echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
    }
}
?>
<div class="card-body ">
    <form method="post" action="<?= URL_ADMIN ?>/index.php?op=configuracion&accion=modificar&tab=config-header">
        <div class="row">
            <label class="col-md-12">
                CONFIG HEADER:<br />
                <textarea class="form-control" name="cnf-header" rows="20"><?= $configHeader["data"]["content_header"] ?></textarea>
            </label>
            <div class="col-md-12 mt-10">
                <button class="btn btn-primary btn-block" type="submit" name="agregar-config">Guardar cambios</button>
            </div>
        </div>
    </form>
</div> 