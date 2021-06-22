<?php
$envios = new Clases\Envios();
if (isset($_POST["agregar"])) {
    $count = 0;
    $cod = substr(md5(uniqid(rand())), 0, 10);
    $envios->set("cod", $cod);
    $envios->set("titulo", isset($_POST["titulo"]) ? $funciones->antihack_mysqli($_POST["titulo"]) : '');
    $envios->set("peso", isset($_POST["peso"]) ? $funciones->antihack_mysqli($_POST["peso"]) : '');
    $envios->set("precio", isset($_POST["precio"]) ? $funciones->antihack_mysqli($_POST["precio"]) : '');
    $envios->set("estado", isset($_POST["estado"]) ? $funciones->antihack_mysqli($_POST["estado"]) : '');
    $envios->set("limite", isset($_POST["limite"]) ? $funciones->antihack_mysqli($_POST["limite"]) : '');
    $envios->set("tipo_usuario", isset($_POST["tipo_usuario"]) ? $funciones->antihack_mysqli($_POST["tipo_usuario"]) : "'0'");

    $envios->add();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=envios");
}
?>
<div class="mt-20 ">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-uppercase text-center">
                Envios
            </h4>
            <hr style="border-style: dashed;">
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="post" class="row">
                    <label class="col-md-4">Título:<br />
                        <input type="text" name="titulo" required>
                    </label>
                    <label class="col-md-2">Peso:<br />
                        <input value="0" min="0" name="peso" type="text" required />
                    </label>
                    <label class="col-md-3">Precio:<br />
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="float" class="form-control" min="0" name="precio" required>
                        </div>
                    </label>
                    <label class="col-md-2">Limite:<br />
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="float" class="form-control" name="limite">
                        </div>
                    </label>
                    <label class="col-md-3">Estado:<br />
                        <select name="estado" required>
                            <option value="1">Activado</option>
                            <option value="0">Desactivado</option>
                        </select>
                    </label>
                    <label class="col-md-3">Tipo de Usuarios:<br />
                        <select name="tipo_usuario" required>
                            <option value="0" selected>Ambos</option>
                            <option value="1">Minorista</option>
                            <option value="2">Mayorista</option>
                        </select>
                    </label>
                    <div class="col-md-12 mt-20">
                        <input type="submit" class="btn btn-primary btn-block" name="agregar" value="Crear Envio" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $("#pes").inputSpinner()
</script>