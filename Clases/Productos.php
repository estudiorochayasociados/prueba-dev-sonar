<?php

namespace Clases;

use Clases\Usuarios;

use function JmesPath\search;

class Productos
{
    //Atributos
    public $id;
    public $cod;
    public $titulo;
    public $precio;
    public $precio_descuento;
    public $precio_mayorista;
    public $peso;
    public $stock;
    public $desarrollo;
    public $categoria;
    public $subcategoria;
    public $keywords;
    public $description;
    public $destacado;
    public $envio_gratis;
    public $mostrar_web;
    public $fecha;
    public $meli;
    public $variable1;
    public $variable2;
    public $variable3;
    public $variable4;
    public $variable5;
    public $variable6;
    public $variable7;
    public $variable8;
    public $variable9;
    public $variable10;
    public $cod_producto;
    public $img;
    public $url;

    //Clases
    private $con;
    public $f;
    private $categoriasClass;
    private $subcategoriasClass;
    private $imagenesClass;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
        $this->f = new PublicFunction();
        $this->categoriasClass = new Categorias();
        $this->subcategoriasClass = new Subcategorias();
        $this->imagenesClass = new Imagenes();
        $this->combinacionClass = new Combinaciones();
        $this->favorite = new Favoritos();
    }

    public function set($atributo, $valor)
    {
        if (!empty($valor)) {
            $valor = "'" . $valor . "'";
        } else {
            $valor = "NULL";
        }
        $this->$atributo = $valor;
    }

    public function get($atributo)
    {
        return $this->$atributo;
    }

    public function getAttrWithTitle()
    {
        $data = [];
        $data["cod"] = "Codigo";
        $data["cod_producto"] = "Codigo Producto";
        $data["titulo"] = "Titulo";
        $data["desarrollo"] = "Desarrollo";
        $data["stock"] = "Stock";
        $data["peso"] = "Peso";
        $data["precio"] = "Precio";
        $data["precio_descuento"] = "Precio con Descuento";
        $data["precio_mayorista"] = "Precio Mayorista";
        $data["categoria"] = "Categoria";
        $data["subcategoria"] = "Subcategoria";
        $data["keywords"] = "Palabras Claves";
        $data["description"] = "Descripcion Breve";
        $data["mostrar_web"] = "Mostrar en web";
        $data["idioma"] = "Idioma";
        return $data;
    }



    public function add($array)
    {
        $attr = implode(",", array_keys($array));
        $values = ":" . str_replace(",", ",:", $attr);
        $sql = "INSERT INTO productos ($attr) VALUES ($values)";
        $stmt = $this->con->conPDO()->prepare($sql);
        $stmt->execute($array);
    }

    public function edit($array, $cod)
    {
        $query = implode(", ", array_map(function ($v) {
            return "$v=:$v";
        }, array_keys($array)));
        $condition = implode(' AND ', $cod);
        $sql = "UPDATE productos SET $query WHERE $condition";
        $stmt = $this->con->conPDO()->prepare($sql);
        $stmt->execute($array);
    }

    public function editForExcel()
    {
        $sql = "UPDATE `productos` 
                SET `variable1` = {$this->variable1},
                    `titulo` = {$this->titulo},
                    `precio` = {$this->precio},
                    `categoria` = {$this->categoria},
                    `subcategoria` = {$this->subcategoria},
                    `mostrar_web` = {$this->mostrar_web},
                    `stock` = {$this->stock}
                WHERE `cod_producto`={$this->cod_producto}";
        $query = $this->con->sql($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function editSingle($atributo, $valor, $idioma)
    {
        $sql = "UPDATE `productos` SET `$atributo` = {$valor} WHERE `cod`={$this->cod} AND `idioma`= '{$idioma}'";
        if ($this->con->sqlReturn($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete()
    {
        $sql = "DELETE FROM `productos` WHERE `cod`  = {$this->cod}";
        $query = $this->con->sql($sql);
        if (!empty($this->imagenesClass->list(array("cod={$this->cod}"), '', ''))) {
            $this->imagenesClass->cod = $this->cod;
            $this->imagenesClass->deleteAll();
        }

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function import()
    {
        $sql = "({$this->cod},
                 {$this->titulo},
                 {$this->cod_producto},
                 {$this->precio},
                 {$this->precio_descuento},
                 {$this->precio_mayorista},
                 {$this->variable1},
                 {$this->variable2},
                 {$this->variable3},
                 {$this->variable4},
                 {$this->variable5},
                 {$this->variable6},
                 {$this->variable7},
                 {$this->variable8},
                 {$this->variable9},
                 {$this->variable10},
                 {$this->stock},
                 {$this->peso},
                 {$this->desarrollo},
                 {$this->categoria},
                 {$this->subcategoria},
                 {$this->keywords},
                 {$this->description},
                 {$this->fecha},
                 {$this->meli},
                 {$this->url},
                 {$this->idioma}),";
        return $sql;
    }

    public function query($sql)
    {
        $querySql = "INSERT INTO `productos`(`cod`, `titulo`,`cod_producto`, `precio`,`precio_descuento`,`precio_mayorista`, `variable1`,`variable2`,`variable3`,`variable4`,`variable5`,`variable6`,`variable7`,`variable8`,`variable9`,`variable10`,  `stock`, `peso`, `desarrollo`, `categoria`, `subcategoria`, `keywords`, `description`,`destacado`,`envio_gratis`,`mostrar_web`, `fecha`, `meli`, `url`,`idioma`) 
                VALUES " . $sql;
        $query = $this->con->sql($querySql);
        return $query;
    }

    public function truncate()
    {
        $sql = "TRUNCATE `productos`";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function updateStockAvilableCero()
    {
        $sql = "UPDATE `productos` SET `mostrar_web` = 0 AND `stock` = 0 ";
        return ($this->con->sqlReturn($sql)) ? true : false;
    }

    public function viewSimple($cod)
    {
        if (is_array($cod)) {
            foreach ($cod as $codigo) {
                $sql_filter[] = "`productos`.`cod` = '" . $codigo . "' ";
            }
            $filter = implode(" OR ", $sql_filter);
        } else {
            $filter = "`productos`.`cod` = '" . $cod . "' ";
        }
        $array = [];
        $sql = "SELECT cod, cod_producto , titulo FROM `productos` WHERE  $filter";
        $productos = $this->con->sqlReturn($sql);
        if ($productos) {
            while ($row = mysqli_fetch_assoc($productos)) {
                $array[] = ["data" => $row];
            }
        }
        return $array;
    }

    function listSearch($search, $limit, $idioma)
    {
        $search = trim($search);
        $search_array = explode(' ', $search);
        $searchSql = '';
        foreach ($search_array as $key => $searchData) {
            if ($key == 0) {
                $searchSql .= "`productos`.`cod_producto` LIKE '%$searchData%' OR `productos`.`titulo` LIKE '%$searchData%'";
            } else {
                $searchSql .= " AND `productos`.`titulo` LIKE '%$searchData%'";
            }
        }
        $sql = "SELECT `productos`.`titulo`, `productos`.`cod`  FROM `productos` WHERE mostrar_web = 1 AND idioma = '$idioma' AND ($searchSql) LIMIT $limit";
        $contenido = $this->con->sqlReturn($sql);

        if ($contenido) {
            while ($row = mysqli_fetch_assoc($contenido)) {
                $link = URL . '/producto/' . $this->f->normalizar_link($row['titulo']) . '/' . $row['cod'];
                $array[] = ["value" => $row['titulo'], "label" => $row['titulo'], "link" => $link];
            }
            $array[] = ["value" => 'VER RESULTADOS DE ' . mb_strtoupper($search), "label" => 'VER RESULTADOS DE ' . mb_strtoupper($search), "link" => URL . "/productos/b/titulo/" . $this->f->normalizar_link($search)];
            return $array;
        }
    }

    /**
     *
     * Traer más de un array 
     *
     * @param    array  $filter array con todos los códigos que quiero traer
     * @param    bool  $admin si se entra desde el admin
     * @param    bool  $category si desea traer esa informacion extra sobre el contenido
     * @param    bool  $subcategory si desea traer esa informacion extra sobre el contenido
     * @param    bool  $images si desea traer esa informacion extra sobre el contenido
     * @return   array retorna un array con todos los array internos de productos
     *
     */


    function list($data, $idioma, $single = false)
    {
        $filter = !empty($data['filter']) ? $data['filter'] :  [];
        $idioma = !empty($idioma) ? $idioma :  $_SESSION['lang'];
        $category = !empty($data['category']) ? $data['category'] :  false;
        $subcategory = !empty($data['subcategory']) ? $data['subcategory'] :  false;
        $images = !empty($data['images']) ? $data['images'] :  false;
        $admin = !empty($data['admin']) ? $data['admin'] :  false;
        $order = !empty($data['order']) ? $data['order'] :  '';
        $limit = !empty($data['limit']) ? $data['limit'] :  '';
        $array_ = '';
        $array = array();
        is_array($filter) ? $filter[] = "productos.idioma = '" . $idioma . "'" : $filter = "productos.idioma = '" . $idioma . "'";
        $filterSql = "";
        $filterSql = (is_array($filter)) ? 'WHERE ' . implode(' AND ', $filter) : '';
        if ($category) {
            $arrayAttr[] = "`categorias`.`titulo` as 'categoria_titulo',`categorias`.`area` as 'categoria_area', `categorias`.`descripcion` as 'categoria_descripcion'";
            $arrayLeft[] = "LEFT JOIN `categorias` ON `categorias`.`cod` = `productos`.`categoria` AND `categorias`.`idioma` = '$idioma'";
        }
        if ($subcategory) {
            $arrayAttr[] = "`subcategorias`.`titulo`as 'subcategoria_titulo'";
            $arrayLeft[] = "LEFT JOIN `subcategorias` ON `subcategorias`.`cod` = `productos`.`subcategoria` AND `subcategorias`.`idioma` = '$idioma'";
        }
        if ($images) {
            $arrayAttr[] = "GROUP_CONCAT(`imagenes`.`id` ORDER BY `imagenes`.`orden` SEPARATOR ',') AS 'imagenes_id',
            GROUP_CONCAT(`imagenes`.`orden` ORDER BY `imagenes`.`orden` SEPARATOR ',') AS 'imagenes_orden',
            GROUP_CONCAT(`imagenes`.`ruta` ORDER BY `imagenes`.`orden` SEPARATOR ',') AS 'imagenes_rutas'";
            $arrayLeft[] = "LEFT JOIN `imagenes` ON `imagenes`.`cod` = `productos`.`cod` AND `imagenes`.`idioma` = '$idioma'";
        }
        $attr = isset($arrayAttr) ? " , " . implode(" , ", $arrayAttr) . " " : '';
        $left = isset($arrayLeft) ? implode(" ", $arrayLeft) : '';
        $orderSql = ($order != '') ? $order : "`productos`.`id` DESC";
        $limitSql = ($limit != '') ? "LIMIT " . $limit : '';

        $sql = "SELECT `productos`.* $attr FROM `productos` $left $filterSql 
        GROUP BY `productos`.`id` ORDER BY $orderSql $limitSql";
        $contenido = $this->con->sqlReturn($sql);
        if ($contenido) {
            while ($row = mysqli_fetch_assoc($contenido)) {
                $row = ($admin) ? $row : $this->checkPriceByUser($row);
                $this->combinacionClass->set("codProducto", $row['cod']);
                $combinacionData = $this->combinacionClass->listByProductCod();
                $fav =  (isset($_SESSION['usuarios']['cod'])) ? $this->favorite->view($_SESSION['usuarios']['cod'], $row['cod']) : '';
                $link = URL . '/producto/' .  $this->f->normalizar_link(($row['titulo'])) . '/' . $row['cod'];
                $imagesArray = ($images) ? $this->createArrayImages($row) : '';
                if ($images) unset($row["imagenes_id"], $row["imagenes_orden"], $row["imagenes_rutas"]);
                $array_ =  ["data" => $row, "images" => $imagesArray, "combination" => $combinacionData, "link" => $link, "favorite" => $fav];
                $array[] = $array_;
            }
            return ($single) ? $array_ : $array;
        } else {
            return false;
        }
    }

    public function createArrayImages($row)
    {

        $row['imagenes_id'] = explode(",", $row['imagenes_id']);
        $row['imagenes_orden'] = explode(",", $row['imagenes_orden']);
        $row['imagenes_rutas'] = explode(",", $row['imagenes_rutas']);
        $imagesLength = count($row['imagenes_id']) - 1;

        $images = $this->imagenesClass->checkForProduct($row['cod_producto'], "_");

        for ($i = 0; $i <= $imagesLength; $i++) {
            if ($row["imagenes_id"][$i]) {
                $images[] = ["id" => $row["imagenes_id"][$i], "orden" => $row["imagenes_orden"][$i], "url" => URL . "/" . $row["imagenes_rutas"][$i]];
            }
        }

        $images = (count($images)) ? $images : [["url" => URL . "/assets/archivos/sin_imagen.jpg"]];
        return $images;
    }


    public function viewByCod($cod_producto)
    {
        $array = [];
        $sql = "SELECT * FROM `productos` WHERE  cod_producto = '$cod_producto' LIMIT 1";
        $productos = $this->con->sqlReturn($sql);
        if ($productos) {
            $row = mysqli_fetch_assoc($productos);
            $row = !empty($row) ? $this->checkPriceByUser($row) : '';
            $array = ["data" => $row];
        }
        return $array;
    }



    function listVariable($variable)
    {
        $array = [];
        $sql = "SELECT DISTINCT $variable FROM `productos` ORDER BY $variable";
        $var = $this->con->sqlReturn($sql);
        if ($var) {
            while ($row = mysqli_fetch_assoc($var)) {
                $array[] = array("data" => $row);
            }
        }
        return $array;
    }


    function listMeli($filter, $order, $limit)
    {
        $array = array();
        if (is_array($filter)) {
            $filterSql = "WHERE ";
            $filterSql .= implode(" AND ", $filter);
        } else {
            $filterSql = '';
        }

        if ($order != '') {
            $orderSql = $order;
        } else {
            $orderSql = "id DESC";
        }

        if ($limit != '') {
            $limitSql = "LIMIT " . $limit;
        } else {
            $limitSql = '';
        }

        $sql = "SELECT cod FROM `productos` $filterSql ORDER BY $orderSql $limitSql";
        $producto = $this->con->sqlReturn($sql);
        if ($producto) {
            while ($row = mysqli_fetch_assoc($producto)) {
                $array[] = array("data" => $row);
            }
            return $array;
        }
    }

    //Especiales

    public function reduceStock($cod, $stock)
    {
        $sql = "UPDATE `productos` SET `stock`= `stock` - $stock WHERE `cod` = '$cod'";
        $query = $this->con->sqlReturn($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function getVariables($var, $category)
    {
        if ($category != '') {
            $sql = "SELECT `$var` FROM `productos` WHERE `$var`!='' and `categoria`='$category' GROUP BY `$var` ORDER BY `$var`  DESC";
        } else {
            $sql = "SELECT `$var` FROM `productos` WHERE `$var`!='' GROUP BY `$var` ORDER BY `$var`  DESC";
        }
        $dimensions = $this->con->sqlReturn($sql);
        if ($dimensions) {
            while ($row = mysqli_fetch_assoc($dimensions)) {
                $array[] = array("data" => $row);
            }
            return $array;
        }
    }


    public function checkPriceByUser($product)
    {
        $user = new Usuarios();
        $userSession = (isset($_SESSION["usuarios"]["cod"])) ? $user->refreshSession($_SESSION["usuarios"]["cod"]) : '';
        if (!empty($userSession)) {
            if (!empty($userSession["minorista"])) {
                $product["precio"] = empty($userSession["descuento"]) ? $product['precio'] : $product['precio'] - (($product['precio'] * $userSession['descuento']) / 100);
                !empty($product['precio_descuento']) ? $product['precio_descuento'] = empty($userSession["descuento"]) ? $product['precio_descuento'] : $product['precio_descuento'] - (($product['precio_descuento'] * $userSession['descuento']) / 100) : 0;
            } else {
                $product["precio"] = empty($userSession["descuento"]) ? $product['precio'] : $product['precio'] - (($product['precio'] * $userSession['descuento']) / 100);
                if (!empty($product["precio_mayorista"])) {
                    !empty($product['precio_descuento']) ? $product['precio_descuento'] = empty($userSession["descuento"]) ? $product['precio_mayorista'] : $product['precio_mayorista'] - (($product['precio_mayorista'] * $userSession['descuento']) / 100) : '';
                } else {
                    !empty($product['precio_descuento']) ? $product['precio_descuento'] = empty($userSession["descuento"]) ? $product['precio'] : $product['precio'] - (($product['precio'] * $userSession['descuento']) / 100) : '';
                }
            }
        }

        $product["precio_final"] = !empty($product["precio_descuento"]) ? $product["precio_descuento"] : $product["precio"];

        return $product;
    }

    public function listCodProduct()
    {
        $sql = "SELECT cod_producto FROM `productos`";
        $producto = $this->con->sqlReturn($sql);
        if ($producto) {
            while ($row = mysqli_fetch_assoc($producto)) {
                $array[] = $row['cod_producto'];
            }
            return $array;
        }
    }

    function paginador($filter, $cantidad)
    {
        $filterSql = $this->doAFilter($filter);
        $sql = "SELECT * FROM `productos` $filterSql";
        $contar = $this->con->sqlReturn($sql);
        $total = mysqli_num_rows($contar);
        $totalPaginas = $total / $cantidad;
        return ceil($totalPaginas);
    }

    function doAFilter($filters)
    {
        $filter = [];
        if (!empty($filters)) {
            $filterSql = "WHERE ";
            foreach ($filters as $key => $value) {
                switch ($key) {
                    case 'categoria':
                        $categoria = $this->categoriasClass->list(["filter" => ["cod = $value"]], "", "", $_SESSION['lang'], true);
                        (!empty($categoria)) ? $filter[] = " (categoria='" . $categoria['data']['cod'] . "') " : false;
                        break;
                    case 'subcategoria':
                        $subcategoria = $this->subcategoriasClass->list(["filter" => ["cod = $value"]], "", "", $_SESSION['lang'], true);
                        (!empty($subcategoria)) ? $filter[] = " (subcategoria='" . $subcategoria['data']['cod'] . "') " : false;
                        break;
                    case 'titulo':
                        $filter[] = " (titulo LIKE '%" . $value . "%')";
                        break;
                }
            }
            $filterSql .= implode(" AND ", $filter);
            return $filterSql;
        } else {
            return '';
        }
    }
    public function viewProductMeliImport($cod)
    {
        $sql = "SELECT * FROM `mercadolibre` WHERE  product = '$cod' ";
        $productos = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($productos);
        $array = array("data" => $row);
        return $array;
    }
}
