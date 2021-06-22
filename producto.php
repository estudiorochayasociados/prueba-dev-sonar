<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
$template = new Clases\TemplateSite();
$f = new Clases\PublicFunction();
$producto = new Clases\Productos();
$carrito = new Clases\Carrito();
$usuario = new Clases\Usuarios();
$atributo = new Clases\Atributos();
$enviar = new Clases\Email();
$combinacion = new Clases\Combinaciones();
$config = new Clases\Config();
$comentarios = new Clases\Comentarios();
#Variables GET
$cod = isset($_GET["cod"]) ?  $f->antihack_mysqli($_GET["cod"]) : '';
#View del producto actual
$data = [
    "filter" => ["productos.cod = " . "'$cod'"],
    "admin" => false,
    "category" => true,
    "subcategory" => true,
    "images" => true,
];
$productoData = $producto->list($data, $_SESSION['lang'], true);
#Se redirecciona si el producto no existe
if (empty($productoData))  $f->headerMove(URL . '/productos');
#Atributos y Combinaciones
if (isset($productoData['data']['cod'])) {
    $atributo->set("productoCod", $productoData['data']['cod']);
    $atributosData = $atributo->list();
    $combinacion->set("codProducto", $productoData['data']['cod']);
    $combinacionData = $combinacion->listByProductCod();
}
$categoria = (isset($productoData['data']['categoria_titulo'])) ? $productoData['data']['categoria_titulo'] : '';
$subcategoria = (isset($productoData['data']['subcategoria_titulo'])) ? " / " . $productoData['data']['subcategoria_titulo'] : '';
$fav = (isset($_SESSION['usuarios']) && !empty($_SESSION['usuarios'])) ? true : false;
if (isset($productoData['favorite']['data']['id'])) {
    $hiddenAddFav = 'd-none';
    $hiddenDeleteFav = '';
} else {
    $hiddenAddFav = '';
    $hiddenDeleteFav = 'd-none';
}
#Información de cabecera
$template->set("title", ucfirst(mb_strtolower(strtoupper($productoData['data']['titulo']))) . " | " . TITULO);
$template->set("description", mb_substr(strip_tags($productoData['data']['desarrollo'], '<p><a>'), 0, 160));
$template->set("keywords", strip_tags($productoData['data']['keywords']));
$template->set("imagen", isset($productoData['images'][0]['url']) ? URL . '/' . $productoData['images'][0]['url'] : LOGO);
$template->themeInit();
?>
<nav class="breadcrumb-section theme1 padding-custom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2 class="title pb-4 text-dark text-uppercase">
                        <?= $productoData['data']['titulo'] ?>
                    </h2>
                </div>
            </div>
            <div class="col-12">
                <ol class="breadcrumb bg-transparent m-0 p-0 align-items-center justify-content-center">
                    <li class="breadcrumb-item"><a href="<?= URL ?>"><?= $_SESSION["lang-txt"]["general"]["inicio"] ?></a></li>
                    <li class="breadcrumb-item"><a href="<?= URL . "/productos" ?>"><?= $_SESSION["lang-txt"]["general"]["productos"] ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= $productoData['data']['titulo'] ?>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</nav>
<section class="product-single theme1 pt-60">
    <div class="container">
        <div class="row">
            <div class="col-md-8 ">
                <div class="row">
                    <div class="col-md-7 ">
                        <div class="product-gallery-box product-gallery-box--default m-b-60">
                            <div class="product-image--large product-image--large-horizontal">
                                <img class="img-fluid" style="object-fit: contain;width:100%" id="img-zoom" src="<?= $productoData['images'][0]['url'] ?>" data-zoom-image="<?= $productoData['images'][0]['url'] ?>" alt="">
                            </div>
                            <?php if (isset($productoData['images'][0]['url'])) { ?>
                                <div id="gallery-zoom" class="product-image--thumb product-image--thumb-horizontal pos-relative mt-10 ">
                                    <?php foreach ($productoData['images'] as $prodImg) { ?>
                                        <a class="zoom-active" onclick="refreshWithImg('<?= $prodImg['data-variable'] ?>')" data-image="<?= $prodImg['url'] ?>" id="<?= isset($prodImg['data-variable']) ? $prodImg['data-variable']  : '' ?>" data-zoom-image="<?= $prodImg['url'] ?>" id="">
                                            <img style="height: 100px;" class="img-fluid" src="<?= $prodImg['url'] ?>" alt="<?= $productoData['data']['titulo'] ?>">
                                        </a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-5  ">
                        <div class="single-product-info">
                            <div class="single-product-head">
                                <h2 class="title mb-20 mt-40 text-uppercase"><?= $productoData['data']['titulo'] ?></h2>
                                <a class="blog-link theme-color text-uppercase mb-10" href="<?= $productoData['link'] ?>" tabindex="0"><?= $categoria . $subcategoria ?></a>

                            </div>
                            <div class="product-body ">
                                <div class="d-flex align-items-center">
                                    <?php
                                    if (!empty($productoData['data']['precio'])) {
                                    ?>
                                        <span class="product-price mr-20">
                                            <?php if ($productoData["data"]["precio_descuento"]) { ?>
                                                <del class="del">$<?= $productoData["data"]["precio"] ?></del>
                                            <?php } ?>
                                            <span class="onsale" id="s-price">$<?= $productoData["data"]["precio_final"] ?></span>
                                        </span>
                                    <?php
                                    } ?>
                                </div>
                                <p>
                                    <?= $productoData['data']['description'] ?>
                                </p>
                            </div>
                            <div class="single-product-quantity">
                                <form class="add-quantity" id="cart-f" data-url="<?= URL ?>" onsubmit="addToCart('cart-f','','<?= URL ?>', '','')">
                                    <?php
                                    if (!empty($atributosData)) {
                                        foreach ($atributosData as $atrib) {
                                    ?>
                                            <div class="form-group">
                                                <label><?= mb_strtoupper($atrib['atribute']['value']) ?></label>
                                                <select class="form-control refreshWithImg" id="<?= $atrib['atribute']['cod'] ?>" onchange="refreshWithSelect('<?= $atrib['atribute']['cod'] ?>');" name="atribute[<?= $atrib['atribute']['cod'] ?>]" required>
                                                    <option disabled selected></option>
                                                    <?php foreach ($atrib['atribute']['subatributes'] as $sub) { ?>
                                                        <option data-value='<?= $sub['value'] ?>' value='<?= $sub['cod'] ?>'><?= $sub['value'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($fav) { ?>
                                        <div class="addto-whish-list">
                                            <a onclick="addFavorite('<?= $productoData['data']['cod'] ?>')" id="btn-addFavorite-<?= $productoData["data"]["cod"] ?>" class="<?= $hiddenAddFav ?>"><i class=" icon-heart"></i> <?= $_SESSION["lang-txt"]["productos"]["agregar_favoritos"] ?></a>
                                            <a onclick="deleteFavorite('<?= $productoData['data']['cod'] ?>')" id="btn-deleteFavorite-<?= $productoData["data"]["cod"] ?>" class="<?= $hiddenDeleteFav ?>"><i class=" icon-heart" style="color:red"></i> <?= $_SESSION["lang-txt"]["productos"]["eliminar_favoritos"] ?></a>
                                        </div>
                                    <?php } ?>
                                    <p class="m-0 p-0"><?= $_SESSION["lang-txt"]["productos"]["cantidad"] ?></p>
                                    <input type="hidden" name="product" value="<?= $productoData['data']['cod'] ?>">
                                    <div class="product-quantity">
                                        <input type="number" style='border-radius:0px !important' step="1" name="stock" id="product-stock-<?= $productoData["data"]["cod"] ?>" min="1" max="<?= $productoData["data"]["stock"] ?>" value="1">
                                    </div>
                                    <div id="btn-a" class="add-to-link mt-20 mb-10">
                                        <button id="btn-a-1" class="btn btn-dark btn--xl mt-5 mt-sm-0">
                                            <span class="mr-2"><i class="ion-android-add"></i></span>
                                            <?= $_SESSION["lang-txt"]["productos"]["agregar_carrito"] ?>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (isset($productoData['data']['desarrollo']) && $productoData['data']['desarrollo']) { ?>
                    <div class="product-tab theme1 bg-white pt-60 pb-80">
                        <div class="container">
                            <div class="product-tab-nav">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <nav class="product-tab-menu single-product">
                                            <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active">Descripcion</a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <!-- product-tab-nav end -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="tab-content" id="pills-tabContent">
                                        <!-- first tab-pane -->
                                        <div>
                                            <div class="single-product-desc">
                                                <p>
                                                    <?= $productoData['data']['desarrollo'] ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-4 ">
                <div id="sideCart">
                    <div class="offcanvas-cart-content">
                        <h2 class="offcanvas-cart-title mb-10 fs-16  text-uppercase ">
                            Carrito de Compra
                            <hr />
                        </h2>
                        <cart></cart>
                        <btn-finalizar-compra></btn-finalizar-compra>
                        <div class="cart-product-btn mt-4 btn-finalizar-carrito mt-10 d-block mt" style="padding-top:20px;">
                            <a href="<?= URL ?>/carrito" class="btn btn-primary fs-14 d-block btn-hover-primary rounded-0"><?= $_SESSION["lang-txt"]["productos"]["finalizar_compra"] ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
$template->themeEnd();
?>
<script src="<?= URL ?>/assets/js/sticky/sticky-sidebar.min.js"></script>
<script>
    var a = new StickySidebar('#sideCart', {
        topSpacing: 110,
        containerSelector: '.container-fluid',
    });
</script>