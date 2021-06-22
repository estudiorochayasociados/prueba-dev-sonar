<?php

namespace Clases;

class Subcategorias
{

    //Atributos
    public $id;
    public $cod;
    public $titulo;
    public $categoria;

    private $con;
    private $imagenes;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
        $this->imagenes = new Imagenes();
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

    public function add($array)
    {
        $attr = implode(",", array_keys($array));
        $values = ":" . str_replace(",", ",:", $attr);
        $sql = "INSERT INTO subcategorias ($attr) VALUES ($values)";
        $stmt = $this->con->conPDO()->prepare($sql);
        $stmt->execute($array);
    }
    public function edit($array, $cod)
    {
        $query = implode(", ", array_map(function ($v) {
            return "$v=:$v";
        }, array_keys($array)));
        $condition = implode(' AND ', $cod);
        $sql = "UPDATE subcategorias SET $query WHERE $condition";
        $stmt = $this->con->conPDO()->prepare($sql);
        $stmt->execute($array);
    }


    public function delete()
    {
        $sql = "DELETE FROM `subcategorias` WHERE `cod`  = {$this->cod} AND `idioma`  = {$this->idioma}";
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

    public function view()
    {
        $sql = "SELECT * FROM `subcategorias` WHERE cod = {$this->cod} ORDER BY id DESC";
        $subcategorias_ = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($subcategorias_);
        if ($row) {
            $img = $this->imagenes->view($row['cod']);
            $row_ = array("data" => $row, "image" => $img);
        } else {
            $row_ = false;
        }
        return $row_;
    }

    public function viewName($cod)
    {
        $sql = "SELECT `titulo` FROM `categorias` WHERE `cod` = `$cod` LIMIT 1";
        $categorias = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($categorias);
        return $row;
    }

    public function viewByTitle($value = null)
    {
        if ($value != '') {
            $value = str_replace("-", " ", $value);
            $sql = "SELECT * FROM `subcategorias` WHERE titulo = '$value' ORDER BY id DESC";
            $subcategorias_ = $this->con->sqlReturn($sql);
            $row = mysqli_fetch_assoc($subcategorias_);
            if (!empty($row)) {
                $img = $this->imagenes->view($row['cod']);
                $row_ = array("data" => $row, "image" => $img);
                return $row_;
            }
        } else {
            return false;
        }
    }


    public function viewById($id = null)
    {
        if ($id != '') {
            $id = str_replace("-", " ", $id);
            $sql = "SELECT * FROM `subcategorias` WHERE id = '$id' ORDER BY id DESC";
            $subcategorias_ = $this->con->sqlReturn($sql);
            $row = mysqli_fetch_assoc($subcategorias_);
            if (!empty($row)) {
                $img = $this->imagenes->view($row['cod']);
                $row_ = array("data" => $row, "image" => $img);
                return $row_;
            }
        } else {
            return false;
        }
    }



    function list($filter = [], $order = '', $limit = '', $idioma, $single = false)
    {
        $array = array();
        $filter[] = "idioma = '" . $idioma . "'";
        $filterSql = (is_array($filter)) ? 'WHERE ' . implode(' AND ', $filter) : '';
        $orderSql = ($order != '') ?  $order  : "`id` DESC";
        $limitSql = ($limit != '') ? "LIMIT " . $limit : '';

        $sql = "SELECT * FROM `subcategorias` $filterSql  ORDER BY $orderSql $limitSql";
        $subcategorias_ = $this->con->sqlReturn($sql);
        if ($subcategorias_->num_rows) {
            while ($row = mysqli_fetch_assoc($subcategorias_)) {
                $img = $this->imagenes->list(["cod = '" . $row['cod'] . "'"], "orden ASC", "", $idioma, true);
                $array_ = array("data" => $row, "image" => $img);
                $array[] = $array_;
            }
            return ($single) ? $array_ : $array;
        } else {
            return false;
        }
    }


    public function listForDiscount($cod)
    {
        $array = array();
        $sql = " SELECT `subcategorias`.`titulo`,`subcategorias`.`cod`  FROM `subcategorias` WHERE `categoria` = '$cod'";
        $listDiscount = $this->con->sqlReturn($sql);
        if ($listDiscount->num_rows) {
            while ($row = mysqli_fetch_assoc($listDiscount)) {
                $array[] = array("data" => $row);
            }
            return $array;
        }
    }
}
