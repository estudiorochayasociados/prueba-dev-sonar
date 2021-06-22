<?php
$producto = new Clases\Productos();
$funciones = new Clases\PublicFunction();
$idiomas = new Clases\Idiomas();
$idiomaGet = isset($_GET["idioma"]) ? $funciones->antihack_mysqli($_GET["idioma"]) : $_SESSION['lang'];
?>
<section id="table-transactions" class="mt-30">
    <h4 class="mt-20 pull-left">Productos</h4>
    <a class="btn btn-success pull-right text-uppercase mt-15 " href="<?= URL_ADMIN ?>/index.php?op=productos&accion=agregar&idioma=<?= $idiomaGet ?>">
        AGREGAR PRODUCTOS
    </a>
    <div class="clearfix"></div>
    <hr />
    <div class="card">
        <div class="row mt-20">
            <div class="col-md-9">
                <form id="filter-form" onsubmit="getData()">
                    <input name="op" value="productos" type="hidden" />
                    <input name="accion" value="ver" type="hidden" />
                    <input class="form-control" name="busqueda" type="text" value="<?= isset($_GET["busqueda"]) ? $_GET["busqueda"] : ''  ?>" placeholder="Buscar.." />
                </form>
            </div>
            <div class="col-md-3">
                <div class="dropdown pull-right">
                    <button class="btn btn-secondary glow  dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown">
                        <i class="fa fa-eye"></i>
                    </button>
                    <div class="dropdown-menu  product_bar" aria-labelledby="dropdownMenuButton">
                        <label class="dropdown-item" for="lb-titulo"><input id="lb-titulo" class="mr-10" style="width:20px;height:20px" type="checkbox" onchange="toggleColumn('titulo')"> Título </label>
                        <label class="dropdown-item" for="lb-precio"><input id="lb-precio" class="mr-10" style="width:20px;height:20px" type="checkbox" onchange="toggleColumn('precio')"> Precio </label>
                        <label class="dropdown-item" for="lb-precio_descuento"><input id="lb-precio_descuento" class="mr-10" style="width:20px;height:20px" type="checkbox" onchange="toggleColumn('precio_descuento')"> Descuento</label>
                        <label class="dropdown-item" for="lb-precio_mayorista"><input id="lb-precio_mayorista" class="mr-10" style="width:20px;height:20px" type="checkbox" onchange="toggleColumn('precio_mayorista')"> Mayorista</label>
                        <label class="dropdown-item" for="lb-categoria"><input id="lb-categoria" class="mr-10" style="width:20px;height:20px" type="checkbox" onchange="toggleColumn('categoria')"> Categoria</label>
                        <label class="dropdown-item" for="lb-subcategoria"><input id="lb-subcategoria" class="mr-10" style="width:20px;height:20px" type="checkbox" onchange="toggleColumn('subcategoria')"> Subcategoria</label>
                        <label class="dropdown-item" for="lb-keywords"><input id="lb-keywords" class="mr-10" style="width:20px;height:20px" type="checkbox" onchange="toggleColumn('keywords')"> Keywords</label>
                        <label class="dropdown-item" for="lb-stock"><input id="lb-stock" class="mr-10" style="width:20px;height:20px" type="checkbox" onchange="toggleColumn('stock')"> Stock</label>
                        <label class="dropdown-item" for="lb-peso"><input id="lb-peso" class="mr-10" style="width:20px;height:20px" type="checkbox" onchange="toggleColumn('peso')"> Peso (kg)</label>
                        <label class="dropdown-item" for="lb-meli"><input id="lb-meli" class="mr-10" style="width:20px;height:20px" type="checkbox" onchange="toggleColumn('meli')"> Meli</label>
                        <label class="dropdown-item" for="lb-envio_gratis"><input id="lb-envio_gratis" class="mr-10" style="width:20px;height:20px" type="checkbox" onchange="toggleColumn('envio_gratis')"> Envio Gratis</label>
                        <label class="dropdown-item" for="lb-mostrar_web"><input id="lb-mostrar_web" class="mr-10" style="width:20px;height:20px" type="checkbox" onchange="toggleColumn('motrar_web')"> Mostrar en Web</label>
                    </div>
                </div>
            </div>
        </div>
        <hr class="divider mt-30">
        <div class="table-responsive">
            <div id="table-extended-transactions_wrapper" class="dataTables_wrapper no-footer">
                <table id="table-extended-transactions" class="table mb-0 dataTable no-footer" role="grid">
                    <thead>
                        <tr role="row">
                            <th class=" titulo ">Titulo</th>
                            <th class=" precio ">Precio</th>
                            <th class=" precio_descuento ">Precio Descuento</th>
                            <th class=" precio_mayorista ">Precio Mayorista</th>
                            <th class=" categoria ">Categoria</th>
                            <th class=" subcategoria ">Subcategoria</th>
                            <th class=" keywords ">Keywords</th>
                            <th class=" stock ">Stock</th>
                            <th class=" peso ">Peso (kg)</th>
                            <th class=" meli ">Meli</th>
                            <th class=" envio_gratis ">Envio Gratis</th>
                            <th class=" motrar_web ">Mostrar en Web</th>
                            <th> Ajustes</th>
                        </tr>
                    </thead>
                    <ul class="nav nav-tabs">
                        <?php
                        foreach ($idiomas->list("", "id ASC", "") as $key => $idioma_) {
                            $url =  URL_ADMIN . "/index.php?op=productos&accion=ver&idioma=" . $idioma_["data"]["cod"];
                        ?>
                            <a class="nav-link <?= CANONICAL == $url ? "active" : '' ?> " href="<?= $url ?>"><?= mb_strtoupper($idioma_["data"]["titulo"]) ?></a>
                        <?php } ?>
                    </ul>
                    <tbody data-url="<?= URL_ADMIN ?>" id="grid-products" data-idioma="<?= $idiomaGet ?>"></tbody>
                </table>
            </div>
        </div>
        <!-- datatable ends -->
        <div class="row">
            <div class="col-md-12">
                <div class="text-center" id="grid-products-loader">
                    <button id="grid-products-btn" class="btn btn-lg" onclick="loadMore()">
                        CARGAR MÁS
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?= URL_ADMIN ?>/js/loadMoreAdminProduct.js"></script>
<?php
include dirname(__DIR__, 1) . "/mercadolibre/modal.inc.php";
if (isset($_GET["borrar"])) {
    $cod = isset($_GET["borrar"]) ? $funciones->antihack_mysqli($_GET["borrar"]) : '';
    $productos = $producto->list(["filter" => ["productos.cod = '" . $cod . "'"]], $idiomaGet, true);
    $producto->set("cod", $cod);
    // if (!empty($productos['data']['meli'])) {
    //     $producto->meli = $productos['data']['meli'];
    //     $producto->deleteMeli();
    // }
    $producto->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=productos&accion=ver&idioma=" . $idiomaGet);
}
?>
<script src="<?= URL_ADMIN ?>/js/meli.js"></script>