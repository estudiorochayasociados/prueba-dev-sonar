<?php
require_once "Config/Autoload.php";
Config\Autoload::run();

$template = new Clases\TemplateSite();
$f = new Clases\PublicFunction();
$producto = new Clases\Productos();
$categoria = new Clases\Categorias();

#Variables GET
$tituloGet = isset($_GET["titulo"]) ? $f->antihack_mysqli(str_replace("-", " ", $_GET["titulo"])) : '';
$categoriaGet = isset($_GET["categoria"]) ? $f->antihack_mysqli(str_replace("-", " ", $_GET["categoria"])) : '';
$subcategoriaGet = isset($_GET["subcategoria"]) ? $f->antihack_mysqli(str_replace("-", " ", $_GET["subcategoria"])) : '';

#List de categorías del área productos
$categoriasData = $categoria->listIfHave('productos');

#Información de cabecera
$template->set("title", "Productos | " . TITULO);
$template->set("description", "");
$template->set("keywords", "");
$template->themeInit();
?>

<nav class="breadcrumb-section theme4 padding-custom pt-10 pb-10">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title mb-0 pb-3 text-center">
                    <h2 class="title pb-2 text-dark text-capitalize">
                        <?= $_SESSION["lang-txt"]["general"]["productos"] ?>
                    </h2>
                </div>
            </div>
            <div class="col-12">
                <ol class="breadcrumb bg-transparent m-0 p-0 align-items-center justify-content-center">
                    <li class="breadcrumb-item"><a href="<?= URL ?>"><?= $_SESSION["lang-txt"]["general"]["inicio"] ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= $_SESSION["lang-txt"]["general"]["productos"] ?>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</nav>
<div class="product-tab bg-white pt-80 pb-50">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 mb-30 order-lg-first">
                <aside class="left-sidebar theme1">
                    <!-- search-filter start -->
                    <form id="filter-form" onsubmit="event.preventDefault();getData()">
                        <div class="container">
                            <div class="search-filter">
                                <div class="sidbar-widget pt-0">
                                    <h4 class="title"><?= $_SESSION["lang-txt"]["productos"]["filtros"] ?></h4>
                                </div>
                            </div>
                            <div class="seachbar-block" data-url="<?= URL ?>">
                                <div class="searchbar">
                                    <input class="search_input fs-14 pl-15 search-bar" type="text" name="" placeholder="<?= $_SESSION["lang-txt"]["productos"]["buscar_productos"] ?>">
                                </div>
                            </div>
                            <div class="widget-list mb-10 mt-20">
                                <div class="search-filter">
                                    <div class="sidbar-widget pt-0">
                                        <h4 class="title"><?= $_SESSION["lang-txt"]["productos"]["categorias"] ?></h4>
                                    </div>
                                </div>
                                <ul class="ulProducts">
                                    <?php
                                    if (!empty($categoriasData)) {
                                        foreach ($categoriasData as $key => $cat) {
                                    ?>
                                            <li class=" list-style-none mb-10 text-uppercase drop menu-item-has-children">
                                                <input id="cat-<?= $key ?>" value="<?= $cat['data']['cod'] ?>" <?= ($categoriaGet == $cat["data"]["cod"]) ? 'checked' : '' ?> name="categories[]" type="checkbox" class="check" onchange="getData()">
                                                <label for="cat-<?= $key ?>" onclick="$('#<?= $cat['data']['cod'] ?>SubCat').toggle();getData()" class="text-uppercase"> <?= $cat['data']['titulo'] ?></label>
                                                <ul id="<?= $cat['data']['cod'] ?>SubCat" class="ulProductsDropdown pl-20 dropdown" style="<?= ($categoriaGet == $cat["data"]["cod"]) ? '' : 'display:none' ?>">
                                                    <?php foreach ($cat["subcategories"] as $key_ => $sub) { ?>
                                                        <li class="list-style-none">
                                                            <label>
                                                                <input id="sub-<?= $key ?>-<?= $key_ ?>" value="<?= $sub['data']['cod'] ?>" <?= ($subcategoriaGet == $sub['data']['cod']) ? 'checked' : '' ?> class="check" name="subcategories[]" type="checkbox" onchange="getData()">
                                                                <?= $sub['data']['titulo'] ?>
                                                            </label>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                    <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                            <hr />
                            <div class="row hidden-md-up">
                                <div class="col-6">
                                    <div style="border-radius:5px;color:white;margin-bottom: 20px;padding: 10px;background-color: #e15987 !important; border-color: white !important" onclick="$('#filters').hide();"><i class="fa fa-times-circle"></i> CERRAR</div>
                                </div>
                                <div class="col-6">
                                    <div style="border-radius:5px;color:white;margin-bottom: 20px;padding: 10px;background-color: #e15987 !important; border-color: white !important" onclick="$('#filters').hide();"><i class="fa fa-check-circle"></i> APLICAR</div>
                                </div>
                            </div>
                        </div>
                    </form>
                </aside>
            </div>
            <div class="col-lg-7 mb-30">
                <div class="grid-nav-wraper bg-lighten2 mb-30">
                    <div class="row align-items-center">
                        <div class="position-relative">
                            <div class="shop-grid-button d-flex align-items-center">
                                <span><?= $_SESSION["lang-txt"]["productos"]["ordenar"] ?></span>
                                <select class="form-select custom-select" style="width: 80%;margin-left: 10px;" onchange="orderBy(this.value)">
                                    <option value="1">
                                        <?= $_SESSION["lang-txt"]["productos"]["ultimos"] ?>
                                    </option>
                                    <option value="2">
                                        <?= $_SESSION["lang-txt"]["productos"]["menor_mayor"] ?>
                                    </option>
                                    <option value="3">
                                        <?= $_SESSION["lang-txt"]["productos"]["mayor_menor"] ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- product-tab-nav end -->
                <div class="tab-content" id="pills-tabContent">
                    <!-- first tab-pane -->
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="row grid-view theme1">
                            <div class="pull-right hidden-md-up" style="width: 100%">
                                <button style="margin-bottom: 50px;padding: 20px;width: 100%!important; background-color: #e15987 !important; border-color: white !important;" id="filter-button" class="btn btn-primary" onclick="$('#filters').show();"> <b><?= $_SESSION["lang-txt"]["productos"]["ver_filtros"] ?></b></button>
                            </div>
                            <div class="products-section shop mt-0">
                                <div class=" shop_wrapper grid_3">
                                    <div class="row grid-products" data-url="<?= URL ?>"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-12 col-lg-12 text-center mt-40">
                                <button id="grid-products-btn" class="btn btn__secondary loadMoreportfolio" onclick="loadMore()">
                                    <?= $_SESSION["lang-txt"]["productos"]["cargar_mas"] ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3  pull-right d-none d-lg-block navCart">
                <div id="sideCart">
                    <div class="offcanvas-cart-content">
                        <h2 class="offcanvas-cart-title mb-10 fs-16  text-uppercase ">
                            <i class="fa fa-shopping-cart"></i> <?= $_SESSION["lang-txt"]["carrito"]["mi_carrito"] ?>
                            <hr />
                        </h2>
                        <cart></cart>
                        <div class="cart-product-btn mt-4 btn-finalizar-carrito mt-10 d-block mt" style="padding-top:20px;">
                            <a href="<?= URL ?>/carrito" class="btn btn-primary fs-14 d-block btn-hover-primary rounded-0"><?= $_SESSION["lang-txt"]["productos"]["finalizar_compra"] ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$template->themeEnd();
?>
<script src="<?= URL ?>/assets/js/sticky/sticky-sidebar.min.js"></script>
<script src="<?= URL ?>/assets/js/services/products.js"></script>
