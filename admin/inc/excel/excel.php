<?php
$excel = new Clases\Excel();
$f = new Clases\PublicFunction();
$idioma = new Clases\Idiomas();

$idiomas = $idioma->list('', '', '');

if (isset($_POST['export'])) {
    $tabla = isset($_POST['table_export']) ? $f->antihack_mysqli($_POST['table_export']) : '';
    $atributos = isset($_POST['attr_export']) ? $_POST['attr_export'] : '';
    $excel->export($tabla, $atributos);
}

if (isset($_POST['import'])) {
    if (isset($_FILES['excel']['name']) && $_FILES['excel']['name'] != "") {
        $tabla = isset($_POST['table_import']) ? $f->antihack_mysqli($_POST['table_import']) : '';
        $excel->import($tabla);
    }
}

?>
<section id="card-navigation">
    <div class="row">
        <div class="col-md-12">
            <div class="card  mb-3">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="export-tab" data-toggle="tab" href="#export" role="tab" aria-controls="export" aria-selected="true">Exportar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="import-tab" data-toggle="tab" href="#import" role="tab" aria-controls="import" aria-selected="false">Importar</a>
                        </li>
                    </ul>
                    <div class="tab-content pl-0">

                        <!-- EXPORTAR -->
                        <div class="tab-pane fade active show" id="export" role="tabpanel" aria-labelledby="export-tab">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body pl-0">
                                        <form class="row" method="POST">
                                            <div class="col-md-4">
                                                <h6>Seleccione la tabla que desea exportar</h6>
                                                <div class="form-group">
                                                    <select data-url="<?= URL ?>" id="select_table" class="select2-icons form-control" name="table_export" required onchange="attrSelect();">
                                                        <option value="">Seleccionar tabla...</option>
                                                        <option value="productos" data-icon="bx bx-shopping-bag">Productos</option>
                                                        <option value="usuarios" data-icon="bx bx-user">Usuarios</option>
                                                    </select>
                                                </div>
                                                <p>Luego de seleccionar la tabla elija que atributos desea exportar al excel</p>
                                            </div>
                                            <div class="col-md-8">
                                                <h6>Seleccione los atributos que desea exportar</h6>
                                                <div class="form-group">
                                                    <select class="select2 form-control" multiple="multiple" id="select_attr" name="attr_export[]" style="min-height: 200px;" required>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-10">
                                                <button class="btn btn-primary pull-right" name="export" type="submit">Exportar Listado</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIN EXPORTAR -->

                        <!-- IMPORTAR -->
                        <div class="tab-pane fade" id="import" role="tabpanel" aria-labelledby="import-tab">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body pl-0">
                                        <form class="row" method="POST" enctype="multipart/form-data">
                                            <div class="col-md-4">
                                                <h6>Seleccione la tabla que desea exportar</h6>
                                                <div class="form-group">
                                                    <select class="select2-icons form-control" required name="table_import">
                                                        <option value="">Seleccionar tabla...</option>
                                                        <option value="productos" data-icon="bx bx-shopping-bag">Productos</option>
                                                        <option value="usuarios" data-icon="bx bx-user">Usuarios</option>
                                                    </select>
                                                </div>
                                                <p>Luego de seleccionar la tabla elija que atributos desea exportar al excel</p>
                                            </div>
                                            <div class="col-md-8">
                                                <fieldset class="form-group">
                                                    <label for="basicInputFile">Cargue su archivo excel</label>

                                                    <div class="custom-file" style="margin-top: 5px;">
                                                        <input type="file" class="custom-file-input" name="excel" id="file_import">
                                                        <label class="custom-file-label" for="file_import"></label>
                                                    </div>
                                                    <p style="color:red">Utilizar un formato valido, NO CAMBIAR LA PRIMER FILA DE TITULOS, puede exportarlo <a href="<?= CANONICAL ?>"> Aqui</a></p>
                                                    <p >A continuacion se listaran los codigos de idioma que se deben cargar en caso de que corresponda:<br>
                                                <?php foreach ($idiomas as $idioma_) {
                                                    echo "<span><u>" . $idioma_['data']['titulo'] . "</u>:  " .  $idioma_['data']['cod'] . "</span><br>";
                                                } ?>
                                            </p>
                                                </fieldset>
                                            </div>
                                      
                                            <div class="col-md-12 mt-10">
                                                <button class="btn btn-primary pull-right" name="import" type="submit">Importar Listado</button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- FIN IMPORTAR -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>