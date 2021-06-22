<?php
$directorio = dirname(__DIR__, 3) . '/assets/archivos/productos';
$url = URL . '/assets/archivos/productos';
is_dir($url) ? mkdir($directorio) : '';
$ficheros = @scandir($directorio);

if (isset($_POST["remove-all"])) {
    foreach ($_POST["img"] as $img) {
        unlink($img);
    }
    $funciones->headerMove(URL_ADMIN . '/index.php?op=subir-archivos&accion=ver-img');
}

if (isset($_POST["remove-single"])) {
    unlink($_POST["img-single"]);
    $funciones->headerMove(URL_ADMIN . '/index.php?op=subir-archivos&accion=ver-img');
}
?>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <form method="post" id="unlink-all" class="inline-block">
                            <button class="btn btn-primary" type="submit" name="remove-all"><i class="fa fa-trash"></i> Eliminar seleccionadas</button>
                        </form>
                        <a class="btn btn-success inline-block" href="<?= URL_ADMIN ?>/index.php?op=subir-archivos&accion=ver"><i class="fa fa-upload"></i> Cargar imágenes</a>
                        <br>
                        <hr>

                        <div class="row">

                            <?php foreach (@array_slice($ficheros, 2) as $fichero) { ?>

                                <div class="col-md-2 imagenesAdmin" style="margin-bottom: 20px">
                                    <div style="box-shadow: 2px 2px 14px 1px #ccc;padding: 10px">
                                        <div style="background: url(<?= $url . '/' . $fichero ?>)center/contain no-repeat; height: 100px;">
                                            <input type="checkbox" form="unlink-all" name="img[]" value="<?= $directorio . '/' . $fichero ?>">

                                            <form method="post" style="float: right">
                                                <input type="hidden" name="img-single" value="<?= $directorio . '/' . $fichero ?>">
                                                <button class="btn btn-primary" type="submit" name="remove-single"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </div>
                                        <div class="link">
                                            <a target="_blank" href="<?= $url . '/' . $fichero ?>"> <?= $fichero ?> </a>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>