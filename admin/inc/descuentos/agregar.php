<?php
$descuento = new Clases\Descuentos();
$productos = new Clases\Productos();
$categorias = new Clases\Categorias();
$carrito = new Clases\Carrito();

//lista de categorias y subcategorias
$categoriasArray = $categorias->listForDiscount();
$subcategoriasArray = [];

foreach ($categoriasArray as $categoria) {
    foreach ($categoria["subcategories"] as $subcategoria) {
        $subcategoria["categoriaTitulo"] = $categoria['data']['titulo'];
        $subcategoriasArray[] = $subcategoria;
    }
}

$categoriasArrayJson = json_encode(["status" => true, "category" => $categoriasArray]);
$subcategoriasArrayJson = json_encode(["status" => true, "subcategory" => $subcategoriasArray]);

//agregar
if (isset($_POST["agregar"])) {
    $descuento->set("cod", isset($_POST["cod"]) ? $funciones->antihack_mysqli($_POST["cod"]) : '');
    $descuento->set("titulo", isset($_POST["titulo"]) ? $funciones->antihack_mysqli($_POST["titulo"]) : '');
    $descuento->set("tipo", isset($_POST["tipo"]) ? $funciones->antihack_mysqli($_POST["tipo"]) : '');
    $descuento->set("monto", isset($_POST["monto"]) ? $funciones->antihack_mysqli($_POST["monto"]) : '');
    $descuento->set("productos_cod", isset($_POST["productTags"]) ? $funciones->antihack_mysqli($_POST["productTags"]) : '');
    $descuento->set("categorias_cod", isset($_POST["categoryTags"]) ? $funciones->antihack_mysqli($_POST["categoryTags"]) : '');
    $descuento->set("subcategorias_cod", isset($_POST["subcategoryTags"]) ? $funciones->antihack_mysqli($_POST["subcategoryTags"]) : '');
    $descuento->set("sector", isset($_POST["sector"]) ? $funciones->antihack_mysqli($_POST["sector"]) : '');
    $descuento->set("fecha_inicio", isset($_POST["fecha-inicio"]) ? $funciones->antihack_mysqli($_POST["fecha-inicio"]) : '');
    $descuento->set("fecha_fin", isset($_POST["fecha-fin"]) ? $funciones->antihack_mysqli($_POST["fecha-fin"]) : '');
    $descuento->set("todosProductos", isset($_POST["todos-productos"]) ? $funciones->antihack_mysqli($_POST["todos-productos"]) : 0);
    $descuento->set("todasCategorias", isset($_POST["todas-categorias"]) ? $funciones->antihack_mysqli($_POST["todas-categorias"]) : 0);
    $descuento->set("todasSubcategorias", isset($_POST["todas-subcategorias"]) ? $funciones->antihack_mysqli($_POST["todas-subcategorias"]) : 0);

    $descuento->add();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=descuentos");
}
?>
<div class="mt-20 ">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-uppercase text-center">
                Descuentos
            </h4>
            <hr style="border-style: dashed;">
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="post" id="form-descuento" class="row" enctype="multipart/form-data">
                    <label class="col-md-4">Titulo:<br />
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><b>T</b></span>
                            </div>
                            <input type="text" name="titulo" value="" required>
                        </div>
                    </label>
                    <label class="col-md-4">Código descuento:<br />
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-star"></i></span>
                            </div>
                            <input type="text" name="cod" value="" required>
                        </div>
                    </label>
                    <label class="col-md-2">Tipo:<br />
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect"><b>$ / %</b></label>
                            </div>
                            <select name="tipo" class="custom-select" id="inputGroupSelect" required>
                                <option></option>
                                <option value="0">Efectivo</option>
                                <option value="1">Porcentaje</option>
                            </select>
                        </div>
                    </label>
                    <label class="col-md-2">Monto:<br />
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><b>M</b></span>
                            </div>
                            <input type="number" name="monto" value="" required>
                        </div>
                    </label>
                    <label class="col-md-4">Aplica a:<br />
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="inputGroupSelect"><i class="fas fa-users"></i></label>
                            </div>
                            <select name="sector" class="custom-select" id="inputGroupSelect">
                                <option selected disabled>Seleccionar...</option>
                                <option value="0">Todos los usuarios</option>
                                <option value="1">Solo a usuarios que no posean descuento</option>
                                <option value="2">Solo a usuarios que ya posean descuento</option>
                            </select>
                        </div>
                    </label>
                    <label class="col-md-4">Desde:<br />
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" name="fecha-inicio" value="">
                        </div>
                    </label>
                    <label class="col-md-4">Hasta:<br />
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="date" name="fecha-fin" value="">
                        </div>
                    </label>
                    <label class="col-md-5">Buscar productos: (<input type="checkbox" value="1" name="todos-productos"> Todos los productos)<br />
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                            </div>
                            <input class="form-control" list="productList" id="product">
                        </div>
                        <datalist id="productList"></datalist>
                    </label>
                    <label class="col-md-12">
                        <input data-beautify="false" name="productTags" type="text" class="productTags">
                    </label>
                    <label class="col-md-5 mt-10">Buscar categorias: (<input type="checkbox" value="1" name="todas-categorias"> Todas las categorias)<br />
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                            </div>
                            <input class="form-control" list="categoryList" id="category">
                        </div>
                        <datalist id="categoryList"></datalist>
                    </label>
                    <label class="col-md-12">
                        <input data-beautify="false" name="categoryTags" type="text" class="categoryTags">
                    </label>
                    <label class="col-md-5 mt-10">Buscar subcategorias: (<input type="checkbox" value="1" name="todas-subcategorias"> Todas las subcategorias)<br />
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                            </div>
                            <input class="form-control" list="subcategoryList" id="subcategory">
                        </div>
                        <datalist id="subcategoryList"></datalist>
                    </label>
                    <label class="col-md-12">
                        <input data-beautify="false" name="subcategoryTags" type="text" class="subcategoryTags">
                    </label>
                    <div class="col-md-12 mt-20">
                        <input type="submit" class="btn btn-primary btn-block" id="agregar" name="agregar" value="Crear Descuento" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('.productTags').tokenfield();
        $('.categoryTags').tokenfield();
        $('.subcategoryTags').tokenfield();

        var productTags = [];
        var categoryTags = [];
        var subcategoryTags = [];

        $("#product").keyup(function() {
            if ($(this).val().length == 3) {
                $("#productList").empty();
                refreshProductData($(this).val());
            }

            $('#productList option').each(function() {
                if ($(this).val() == $("#product").val()) {
                    $("#product").val('');
                    productTags = $('.productTags').tokenfield('getTokens');
                    productTags.push({
                        value: $(this).val(),
                        label: $(this).attr('label')
                    });
                    $('.productTags').tokenfield('setTokens', productTags);
                }
            });

        });

        function refreshProductData(currentValue) {
            let url = '<?= URL_ADMIN ?>';

            $.ajax({
                url: url + "/api/descuentos/productos.php",
                type: "POST",
                data: {
                    string: currentValue
                },
                success: function(data) {
                    data = JSON.parse(data);

                    if (data['status'] == true) {
                        $.each(data.productos, function(index, value) {
                            $("#productList").append('<option value="' + value.data.cod + '" label="' + value.data.titulo + ' | ' + value.data.cod_producto + '">');
                        });

                    } else {
                        console.log('error');
                    }
                }
            });
        }

        $("#category").keyup(function() {
            if ($(this).val().length == 3) {
                $("#categoryList").empty();
                refreshCategoryData();
            }

            $('#categoryList option').each(function() {
                if ($(this).val() == $("#category").val()) {
                    $("#category").val('');
                    categoryTags = $('.categoryTags').tokenfield('getTokens');
                    categoryTags.push({
                        value: $(this).val(),
                        label: $(this).attr('label')
                    });
                    $('.categoryTags').tokenfield('setTokens', categoryTags);
                    console.log(categoryTags);
                }
            });

        });



        function refreshCategoryData() { 
            data = JSON.parse('<?= $categoriasArrayJson ?>');
            if (data['status'] == true) {
                $.each(data.category, function(index, value) {
                    $("#categoryList").append('<option value="' + value.data.cod + '" label="' + value.data.titulo + '">');
                });
            } else {
                console.log('error');
            }
        }

        $("#subcategory").keyup(function() {
            if ($(this).val().length == 3) {
                $("#subcategoryList").empty();
                refreshSubcategoryData();
            }

            $('#subcategoryList option').each(function() {
                if ($(this).val() == $("#subcategory").val()) {
                    $("#subcategory").val('');
                    subcategoryTags = $('.subcategoryTags').tokenfield('getTokens');
                    subcategoryTags.push({
                        value: $(this).val(),
                        label: $(this).attr('label')
                    });
                    $('.subcategoryTags').tokenfield('setTokens', subcategoryTags);
                    console.log(subcategoryTags);
                }
            });

        });

        function refreshSubcategoryData() {
            data = JSON.parse('<?= $subcategoriasArrayJson ?>');

            if (data['status'] == true) {
                $.each(data.subcategory, function(index, value) {
                    $("#subcategoryList").append('<option value="' + value.data.cod + '" label="' + value.categoriaTitulo + ' | ' + value.data.titulo + '">');
                });

            } else {
                console.log('error');
            }
        }

    });
</script>


data = JSON.parse('{"status":true,"category":[{"data":{"id":"13","cod":"d63eee7ae6","titulo":"Autos","area":"productos","descripcion":"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus blandit congue augue sit amet vehicula. Proin sagittis lectus ac congue sollicitudin. Vivamus eleifend facilisis sapien, quis hendrerit nisi semper pellentesque. Vivamus quis quam id nisl laoreet interdum. Sed at finibus libero, ut lacinia ligula. Phasellus ultrices, dolor ut volutpat mattis, nisi velit maximus ante, ut iaculis diam turpis vel orci. Donec rhoncus arcu turpis, ac vulputate lectus finibus nec. Morbi nibh orci, ornare in enim vel, cursus efficitur dolor. Nam et ex arcu. Fusce sed lectus tempus, dapibus libero et, volutpat est.\r\n\r\nUt iaculis vestibulum dictum. Suspendisse id diam velit. Duis vitae purus id nibh ullamcorper egestas sed eget tellus. Cras molestie dolor non tellus sodales venenatis ut vel ex. Quisque dapibus nunc sit amet elit dapibus tincidunt. Fusce quis lectus orci. Curabitur eget sem ac felis dapibus mollis. Etiam viverra magna viverra nisi molestie vulputate."},"subcategories":[],"image":{"id":"62","ruta":"assets\/archivos\/recortadas\/_9e7b847c48.png","cod":"d63eee7ae6","orden":"0"}},{"data":{"id":"11","cod":"24d8dbb63c","titulo":"Categoria de productos","area":"productos","descripcion":null},"subcategories":[{"data":{"id":"4","cod":"307f7b9a2c","titulo":"sub 2 de test 2","categoria":"24d8dbb63c"},"image":null},{"data":{"id":"3","cod":"fa8b8122dd","titulo":"sub de test 2","categoria":"24d8dbb63c"},"image":null}],"image":{"id":"58","ruta":"assets\/archivos\/recortadas\/_96d22e9786.jpg","cod":"24d8dbb63c","orden":"0"}},{"data":{"id":"10","cod":"b1771d6dcc","titulo":"Categoria de productos 2","area":"productos","descripcion":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. "},"subcategories":[{"data":{"id":"2","cod":"4a18d3b2f0","titulo":"sub 2 de test","categoria":"b1771d6dcc"},"image":null},{"data":{"id":"1","cod":"a106bdd247","titulo":"sub de test ","categoria":"b1771d6dcc"},"image":null}],"image":{"id":"61","ruta":"assets\/archivos\/recortadas\/_5e2df0dd29.jpg","cod":"b1771d6dcc","orden":"0"}}]}');
data = JSON.parse('{"status":true,"category":[{"data":{"id":"19","cod":"94031c6947c","titulo":"","area":"productos","descripcion":null},"subcategories":[{"data":{"id":"39","cod":"672e633459b","titulo":"subcat 12","categoria":"94031c6947c"},"image":null},{"data":{"id":"38","cod":"58d040cfc34","titulo":"subcat 11","categoria":"94031c6947c"},"image":null},{"data":{"id":"37","cod":"7ae93d8fa35","titulo":"","categoria":"94031c6947c"},"image":null}],"image":null},{"data":{"id":"18","cod":"d3f994fa06a","titulo":"Casa","area":"productos","descripcion":null},"subcategories":[{"data":{"id":"34","cod":"0235b9a9492","titulo":"subcat 12","categoria":"d3f994fa06a"},"image":null}],"image":null},{"data":{"id":"17","cod":"fa3a356b8aa","titulo":"Barco","area":"productos","descripcion":null},"subcategories":[{"data":{"id":"33","cod":"121ff4f5b09","titulo":"subcat 11","categoria":"fa3a356b8aa"},"image":null}],"image":null},{"data":{"id":"16","cod":"9695928ae19","titulo":"Perro","area":"productos","descripcion":null},"subcategories":[{"data":{"id":"32","cod":"4f2b2ec062c","titulo":"subcat 8","categoria":"9695928ae19"},"image":null}],"image":null},{"data":{"id":"15","cod":"68105338e06","titulo":"Gato","area":"productos","descripcion":null},"subcategories":[{"data":{"id":"31","cod":"d82dae69d0b","titulo":"subcat 3","categoria":"68105338e06"},"image":null}],"image":null},{"data":{"id":"6","cod":"4e06a993ac","titulo":"Alambrado P\u00fablico","area":"productos","descripcion":null},"subcategories":[{"data":{"id":"36","cod":"b38c7a81456","titulo":"","categoria":"4e06a993ac"},"image":null},{"data":{"id":"19","cod":"aeb701f8c96","titulo":"subcat 12","categoria":"4e06a993ac"},"image":null},{"data":{"id":"17","cod":"34cc62413cb","titulo":"subcat 10","categoria":"4e06a993ac"},"image":null},{"data":{"id":"13","cod":"bde076ebfb2","titulo":"subcat 6","categoria":"4e06a993ac"},"image":null},{"data":{"id":"11","cod":"45d15add837","titulo":"subcat 4","categoria":"4e06a993ac"},"image":null},{"data":{"id":"9","cod":"24ff3e7d7af","titulo":"subcat 2","categoria":"4e06a993ac"},"image":null},{"data":{"id":"5","cod":"4a950119c8d","titulo":"subcat 1","categoria":"4e06a993ac"},"image":null}],"image":null},{"data":{"id":"5","cod":"4203723bc8","titulo":"Rural","area":"productos","descripcion":null},"subcategories":[{"data":{"id":"8","cod":"55b2b778992","titulo":"subcat 1","categoria":"4203723bc8"},"image":null}],"image":null},{"data":{"id":"4","cod":"884ce62338","titulo":"Industrial","area":"productos","descripcion":null},"subcategories":[{"data":{"id":"7","cod":"0d76adf2d18","titulo":"subcat 1","categoria":"884ce62338"},"image":null}],"image":null},{"data":{"id":"3","cod":"719ea8c11c","titulo":"Hogar","area":"productos","descripcion":null},"subcategories":[{"data":{"id":"35","cod":"ea87b8c4b4e","titulo":"","categoria":"719ea8c11c"},"image":null},{"data":{"id":"20","cod":"553e403ce56","titulo":"subcat 13","categoria":"719ea8c11c"},"image":null},{"data":{"id":"18","cod":"14e7f06cb0c","titulo":"subcat 11","categoria":"719ea8c11c"},"image":null},{"data":{"id":"16","cod":"ba83687ee51","titulo":"subcat 9","categoria":"719ea8c11c"},"image":null},{"data":{"id":"14","cod":"98a6f0f0c76","titulo":"subcat 7","categoria":"719ea8c11c"},"image":null},{"data":{"id":"12","cod":"741ed617000","titulo":"subcat 5","categoria":"719ea8c11c"},"image":null},{"data":{"id":"6","cod":"a6483e9bb87","titulo":"subcat 1","categoria":"719ea8c11c"},"image":null}],"image":null}]}');