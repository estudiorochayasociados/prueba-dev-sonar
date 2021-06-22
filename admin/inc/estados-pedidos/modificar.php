<?php
$estados = new Clases\EstadosPedidos();
$id = isset($_GET["id"]) ? $funciones->antihack_mysqli($_GET["id"]) : '';
$estado = $estados->view($id);

if (isset($_POST["agregar"])) {
    $estados->set("id", $id);
    if (isset($_POST["estado"]) && $_POST["estado"] != 0) {
        $estados->set("estado", $funciones->antihack_mysqli($_POST["estado"]));
    } else {
        $estados->estado = 0;
    }
    $estados->set("titulo", isset($_POST["titulo"]) ? $funciones->antihack_mysqli($_POST["titulo"]) : '');
    $estados->set("asunto", isset($_POST["asunto"]) ? $funciones->antihack_mysqli($_POST["asunto"]) : '');
    $estados->set("mensaje", isset($_POST["mensaje"]) ? $funciones->antihack_mysqli($_POST["mensaje"]) : '');
    isset($_POST["enviar"]) ? $estados->set("enviar", 1) : $estados->enviar = 0;
    $estados->set("tipo_usuario", isset($_POST["tipo_usuario"]) ? $funciones->antihack_mysqli($_POST["tipo_usuario"]) : "'0'");
    isset($_GET["id"]) ? $estados->edit() : $estados->add();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=estados-pedidos");
}
?>

<div class="mt-20 ">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-uppercase text-center">
                <?= isset($_GET["id"]) ? "Modificar" : "Agregar" ?> Estados
            </h4>
            <hr style="border-style: dashed;">
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="post" class="row" enctype="multipart/form-data">
                    <label class="col-md-6">
                        Título:<br />
                        <input type="text" value="<?= isset($estado['data']["titulo"]) ? $estado['data']["titulo"] : '' ?>" name="titulo" required>
                    </label>
                    <label class="col-md-3">Estado:<br />
                        <select name="estado" required>
                            <option value="1" <?php if ((isset($estado['data']["estado"]) && $estado['data']['estado'] == 1) || empty($estado['data'])) {
                                                    echo "selected";
                                                } ?>>Pendiente
                            </option>
                            <option value="2" <?php if (isset($estado['data']["estado"]) && $estado['data']['estado'] == 2) {
                                                    echo "selected";
                                                } ?>>Aprobado
                            </option>
                            <option value="3" <?php if (isset($estado['data']["estado"]) && $estado['data']['estado'] == 3) {
                                                    echo "selected";
                                                } ?>>Rechazado
                            </option>
                        </select>
                    </label>

                    <label class="col-md-2">
                        <div class="custom-control custom-switch custom-switch-glow mt-20">
                            <span class="invoice-terms-title"> Enviar Email</span>
                            <input name="enviar" type="checkbox" id="enviar" class="custom-control-input" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" value="1" <?= (isset($estado['data']["enviar"]) && $estado['data']["enviar"] == 1) ? "checked" : "" ?>>
                            <label class="custom-control-label" for="enviar">
                            </label>
                        </div>
                    </label>
                    <label class="col-md-12" style="padding: 0px">
                        <div class="collapse" id="collapseExample">
                            <div class="card card-body" style="padding: 0px">
                               
                                <label class="col-md-12 mt-20">
                                    <h6>Se enviara el siguiente email cuando el pedido entre en este estado.</h6>
                                </label>
                                <label class="col-md-12 mt-10">
                                    Asunto:<br />
                                    <input type="text" name="asunto" value="<?= isset($estado['data']["asunto"]) ? $estado['data']["asunto"] : '' ?>">
                                </label>
                                <label class="col-md-12 mt-10">
                                    Mensaje:<br />
                                    <textarea name="mensaje" class="ckeditorTextarea" required><?= isset($estado['data']["mensaje"]) ? $estado['data']["mensaje"] : '' ?></textarea>
                                </label>
                            </div>
                        </div>
                    </label>
                    <div class="col-md-12 mt-20">
                        <input type="submit" class="btn btn-primary btn-block" name="agregar" value="<?= isset($_GET["id"]) ? "Modificar" : "Agregar" ?> Estado" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>