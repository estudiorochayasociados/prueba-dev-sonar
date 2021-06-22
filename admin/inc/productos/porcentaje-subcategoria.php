<?php
//
$productos = new Clases\Productos();
$imagenes = new Clases\Imagenes();
$zebra = new Clases\Zebra_Image();
$categoria = new Clases\Categorias();
$atributo = new Clases\Atributos();
$subatributo = new Clases\Subatributos();

$categoriasData = $categoria->list(["area = 'productos'"], "", "", $_SESSION['lang']);
$cod = substr(md5(uniqid(rand())), 0, 10);

if (isset($_POST["agregar"])) {
    $subcategoria = isset($_POST["subcategoria"]) ? $funciones->antihack_mysqli($_POST["subcategoria"]) : '';
    $producto = $productos->list(["filter" => ["productos.subcategoria = '$subcategoria'"]], $_SESSION['lang']);
    foreach ($producto as $product_) {
        if ($product_['data']['subcategoria'] == $subcategoria) {
            $productos->set("cod", $product_["data"]['cod']);
            $precio = number_format(($product_["data"]['precio'] * $_POST["porcentaje"] / 100 + $product_["data"]['precio']), 2, ".", "");
            $precio_descuento = number_format(($product_["data"]['precio_descuento'] * $_POST["porcentaje"] / 100 + $product_["data"]['precio_descuento']), 2, ".", "");
            $precio_mayorista = number_format(($product_["data"]['precio_mayorista'] * $_POST["porcentaje"] / 100 + $product_["data"]['precio_mayorista']), 2, ".", "");
            $productos->editSingle('precio', $precio);
            $productos->editSingle('precio_descuento', $precio_descuento);
            $productos->editSingle('precio_mayorista', $precio_mayorista);
        }
    }
    $error = '';
    if (empty($error)) {
        $funciones->headerMove(URL_ADMIN . '/index.php?op=productos');
    }
}
?>
<div class="mt-20 ">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-uppercase text-center">
                Productos
            </h4>
            <hr style="border-style: dashed;">
        </div>
        <div class="card-content">
            <div class="card-body">
                <?php
                if (!empty($error)) {
                ?>
                    <div class="alert alert-danger" role="alert"><?= $error; ?></div>
                <?php
                }
                ?>
                <form method="post" class="row" enctype="multipart/form-data">

                    <input type="hidden" name="cod" value="<?= $cod; ?>" />
                    <label class="col-md-6">
                        Subcategoría:<br />
                        <select name="subcategoria">
                            <option value="">-- Sin subcategoría --</option>
                            <?php
                            foreach ($categoriasData as $categoria) {
                            ?>
                                <optgroup label="<?= mb_strtoupper($categoria["data"]['titulo']) ?>">
                                    <?php foreach ($categoria["subcategories"] as $subcategorias) { ?>
                                        <option name="subcategorias" value="<?= $subcategorias["data"]["cod"] ?>"><?= mb_strtoupper($subcategorias["data"]["titulo"]) ?></option>
                                    <?php } ?>
                                </optgroup>
                            <?php
                            }
                            ?>
                        </select>
                    </label>

                    <label class="col-md-6">Porcentaje:<br />
                        <input data-suffix="%" id="pes" value="<?= isset($_POST["porcentaje"]) ? $_POST["porcentaje"] : 0; ?>" name="porcentaje" type="number" min="-100" />
                    </label>
                    <hr>
                    <div class="col-md-12 mt-20">
                        <input type="submit" class="btn btn-primary btn-block" id="guardar" name="agregar" value="Modificar Porcentaje de Subcategoria" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>