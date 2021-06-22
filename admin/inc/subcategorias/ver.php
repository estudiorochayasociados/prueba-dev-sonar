 <?php
    $categorias = new Clases\Categorias();
    $idiomas = new Clases\Idiomas();
    $idioma = isset($_GET["idioma"]) ? $funciones->antihack_mysqli($_GET["idioma"]) : $_SESSION['lang'];
    $data = $categorias->list([], '', '', $idioma);
    ?>
 <div class="mt-20">
     <div class="col-lg-12 col-md-12">
         <h4>
             Categorias
             <a class="btn btn-success pull-right" href="<?= URL_ADMIN ?>/index.php?op=categorias&accion=agregar">
                 AGREGAR CATEGORIAS
             </a>
         </h4>
         <hr />
         <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
         <hr />
         <table class="table  table-bordered  ">
             <thead>
                 <th>
                     Título
                 </th>
                 <th>
                     Área
                 </th>
                 <th>
                     Ajustes
                 </th>
             </thead>
             <tbody>
                 <?php
                    if (is_array($data)) {
                        for ($i = 0; $i < count($data); $i++) {
                            echo "<tr>";
                            echo "<td>" . strtoupper($data[$i]['data']["titulo"]) . "</td>";
                            echo "<td>" . strtoupper($data[$i]['data']["area"]) . "</td>";
                            echo "<td>";
                            echo '<a class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Agregar" href="' . URL_ADMIN . '/index.php?op=subcategorias&accion=agregar&cod=' . $data[$i]['data']["cod"] . '&idioma=' . $idioma . '">
                        <i class="fa fa-plus"></i> SUBCATEGORÍA</a>';
                            echo '<a class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Modificar" href="' . URL_ADMIN . '/index.php?op=categorias&accion=modificar&cod=' . $data[$i]['data']["cod"] . '&idioma=' . $idioma . '"><i class="fa fa-cog"></i></a>';

                            echo '<a class="btn btn-danger deleteConfirm" data-toggle="tooltip" data-placement="top" title="Eliminar" href="' . URL_ADMIN . '/index.php?op=categorias&accion=ver&borrar=' . $data[$i]['data']["cod"] . '">
                        <i class="fa fa-trash"></i></a>';
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
             </tbody>
         </table>
     </div>
 </div>
 <?php
    if (isset($_GET["borrar"])) {
        $cod = isset($_GET["borrar"]) ?  $funciones->antihack_mysqli($_GET["borrar"]) : '';
        $categorias->set("cod", $cod);
        $imagenes->set("cod", $cod);
        $categorias->delete();
        $imagenes->deleteAll();
        $funciones->headerMove(URL_ADMIN . "/index.php?op=categorias&idioma=" . $idioma);
    }
    ?>