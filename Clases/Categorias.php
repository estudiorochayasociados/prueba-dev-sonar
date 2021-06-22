<?php

namespace Clases;

use function GuzzleHttp\Psr7\str;

class Categorias
{

    //Atributos
    public $id;
    public $cod;
    public $titulo;
    public $area;
    public $descripcion;
    public $idioma;

    private $con;
    private $subcategoria;
    private $imagenes;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
        $this->subcategoria = new Subcategorias();
        $this->imagenes = new Imagenes();
    }

    public function set($atributo, $valor)
    {
        if (strlen($valor)) {
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

    public function add($array)
    {
        $attr = implode(",", array_keys($array));
        $values = ":" . str_replace(",", ",:", $attr);
        $sql = "INSERT INTO categorias ($attr) VALUES ($values)";
        $stmt = $this->con->conPDO()->prepare($sql);
        $stmt->execute($array);
    }
    public function edit($array, $cod)
    {
        $query = implode(", ", array_map(function ($v) {
            return "$v=:$v";
        }, array_keys($array)));
        $condition = implode(' AND ', $cod);
        $sql = "UPDATE categorias SET $query WHERE $condition";
        $stmt = $this->con->conPDO()->prepare($sql);
        $stmt->execute($array);
    }

    public function delete()
    {
        $sql = "DELETE FROM `categorias` WHERE `cod`  = {$this->cod} AND `idioma`  = {$this->idioma}";
        $query = $this->con->sqlReturn($sql);
        if (!empty($this->imagenes->list(array("cod={$this->cod}"), 'orden ASC', ''))) {
            $this->imagenes->cod = $this->cod;
            $this->imagenes->deleteAll();
        }
        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }
    public function searchCategoryForArea($area)
    {
        $array = [];
        $sql = "SELECT * FROM `categorias` WHERE `area`  = '$area'";
        $query = $this->con->sqlReturn($sql);
        if ($query->num_rows) {
            while ($row = mysqli_fetch_assoc($query)) {
                $array[] = array("data" => $row);
            }
        }
        return $array;
    }
    public function deleteForArea($area)
    {
        $categoriasArea  = $this->searchCategoryForArea($area);
        foreach ($categoriasArea as $catItem) {
            $cod = $catItem['data']['cod'];
            if (!empty($this->imagenes->list(array("cod={$cod}"), 'orden ASC', ''))) {
                $this->imagenes->cod = $cod;
                $this->imagenes->deleteAll();
            }
        }
        $sql = "DELETE FROM `categorias` WHERE `area`  =  '$area' ";
        $query = $this->con->sqlReturn($sql);
    }



    public function list($filter = [], $order = '', $limit = '', $idioma, $single = false)
    {
        $array = array();
        $filter[] = "idioma = '" . $idioma . "'";
        $filterSql = (is_array($filter)) ? 'WHERE ' . implode(' AND ', $filter) : '';
        $orderSql = ($order != '') ?  $order  : "`id` DESC";
        $limitSql = ($limit != '') ? "LIMIT " . $limit : '';

        $sql = "SELECT * FROM `categorias` $filterSql ORDER BY $orderSql $limitSql";
        $categorias = $this->con->sqlReturn($sql);
        if ($categorias->num_rows) {
            while ($row = mysqli_fetch_assoc($categorias)) {
                $img = $this->imagenes->list(["cod = '" . $row['cod'] . "'"], "orden ASC", "", $idioma, true);
                $sub = $this->subcategoria->list(["categoria='" . $row['cod'] . "'"], '', '', $idioma);
                $array_ = array("data" => $row, "subcategories" => $sub, "image" => $img);
                $array[] = $array_;
            }
            return ($single) ? $array_ : $array;
        } else {
            return false;
        }
    }

    /**
     *
     * Traer un array con todas las categorias que esten en uso en la base de datos buscada.
     *
     * @param    string $db nombre de la base de datos de la cual se desea traer las categorias.
     * @param    string  $area en caso de que la base de datos sea Contenido podes identificar un area en especifico.
     * @return   array retorna un array con toda la informacion de las categorias y la cantidad de veces que se usa.
     *
     */
    public function listIfHave($db, $area = '')
    {
        $idioma = $_SESSION['lang'];
        if (!empty($area)) {
            $area = ($area != 'productos') ? " AND `categorias`.`area` = '$area' " :  " AND `categorias`.`area` = '$area' AND productos.mostrar_web = 1  AND productos.idioma = '$idioma'";
        }
        $productos = ($db == 'productos') ? " AND  productos.mostrar_web = 1 " : "";
        $array = array();
        $sql = " SELECT `categorias`.`titulo`,`categorias`.`cod`,`categorias`.`id`, count(`" . $db . "`.`categoria`) as cantidad FROM `" . $db . "`,`categorias` WHERE categorias.idioma = '$idioma'  AND  `categoria` = `categorias`.`cod` $area  $productos GROUP BY categoria ORDER BY titulo ASC ";

        $listIfHave = $this->con->sqlReturn($sql);
        if ($listIfHave->num_rows) {
            while ($row = mysqli_fetch_assoc($listIfHave)) {
                $img = $this->imagenes->view($row['cod']);
                $sub = $this->subcategoria->list(["categoria='" . $row['cod'] . "'"], '', '', $idioma);
                $array[] = array("data" => $row, "subcategories" => $sub, "image" => $img);
            }
            return $array;
        }
    }



    public function listForManyCods($cods, $idioma)
    {

        $array = [];

        $categoriasFilterStr = '';
        foreach ($cods as $cod) {
            $categoriasFilterStr .= "cod = '" . $cod . "' OR ";
        }
        $categoriasFilterStr = substr($categoriasFilterStr, 0, -4);

        $sql = "SELECT * FROM `categorias` WHERE $categoriasFilterStr";
        $categorias = $this->con->sqlReturn($sql);
        if ($categorias->num_rows) {
            while ($row = mysqli_fetch_assoc($categorias)) {
                $img = $this->imagenes->view($row['cod']);
                $sub = $this->subcategoria->list(["categoria='" . $row['cod'] . "'"], '', '', $row["idioma"]);
                $array[] = array("data" => $row, "subcategories" => $sub, "image" => $img);
            }
            return $array;
        }
    }

    public function listSubcategoriesForManyCods($cods, $idioma)
    {

        $categoriasArray = $this->list(["area = 'productos'"], "", "", $idioma);
        $subcategoriasSavedArray = [];
        foreach ($categoriasArray as $categoria) {
            foreach ($categoria["subcategories"] as $subcategoria) {
                $subcategoria["categoriaTitulo"] = $categoria['data']['titulo'];
                if (in_array($subcategoria['data']['cod'], $cods)) {
                    $subcategoriasSavedArray[] = $subcategoria;
                }
            }
        }

        return $subcategoriasSavedArray;
    }

    public function listForDiscount()
    {

        $array = array();
        $sql = " SELECT `categorias`.`titulo`,`categorias`.`cod` FROM `categorias` WHERE `area` = 'productos'";
        $listDiscount = $this->con->sqlReturn($sql);
        if ($listDiscount) {
            while ($row = mysqli_fetch_assoc($listDiscount)) {
                $sub = $this->subcategoria->listForDiscount($row['cod']);
                $array[] = array("data" => $row, "subcategories" => $sub);
            }
            return $array;
        }
    }
    public function listAreas()
    {
        $array = array();
        $sql = "SELECT * FROM `categorias` GROUP BY area";
        $areas = $this->con->sqlReturn($sql);
        if ($areas->num_rows) {
            while ($row = mysqli_fetch_assoc($areas)) {
                $array[] = array("data" => $row);
            }
            return $array;
        }
    }
}
