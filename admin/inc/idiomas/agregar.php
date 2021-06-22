<?php
$idiomas = new Clases\Idiomas();
if (isset($_POST["editar"])) {
    $idiomas->set("cod", $funciones->antihack_mysqli(isset($_POST["cod"]) ? $_POST["cod"] : ''));
    $idiomas->set("titulo", $funciones->antihack_mysqli(isset($_POST["titulo"]) ? $_POST["titulo"] : ''));
    $idiomas->set("default", $funciones->antihack_mysqli(isset($_POST["default"]) ? $_POST["default"] : ''));
    if ($idiomas->add()) {
        $funciones->headerMove(URL_ADMIN . "/index.php?op=idiomas");
    }
}
?>
<div class="mt-20 card">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-uppercase text-center">
                Idiomas
            </h4>
            <hr style="border-style: dashed;">
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="post" class="row">
                    <input type="hidden" name="default" value="0">
                    <label class="col-md-6">Título:<br />
                        <input type="text" value="" name="titulo" required>
                    </label>
                    <label class="col-md-6">Codigo:<br />
                        <select name="cod" require>
                            <option value="es">Español</option>
                            <option value="en">Inglés</option>
                            <option value="de">Aleman</option>
                            <option value="pt">Portugues</option>
                            <option value="it">Italiano</option>
                            <option value="fr">Francés</option>
                            <option value="zh">Chino</option>
                        </select>
                    </label>
                    <div class="col-md-12 mt-20">
                        <input type="submit" class="btn btn-primary btn-block" name="editar" value="Agregar Idioma" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>