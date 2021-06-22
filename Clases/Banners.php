<?php

namespace Clases;

class Banners
{

    //Atributos
    public $id;
    public $cod;
    public $titulo;
    public $tituloOn;
    public $subtitulo;
    public $subtituloOn;
    public $categoria;
    public $link;
    public $linkOn;
    public $idioma;
    public $fecha;
    private $con;

    private $imagenes;
    private $categorias;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
        $this->imagenes = new Imagenes();
        $this->categorias = new Categorias();
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
        $sql = "INSERT INTO banners ($attr) VALUES ($values)";
        $stmt = $this->con->conPDO()->prepare($sql);
        $stmt->execute($array);
    }
    public function edit($array, $cod)
    {
        $query = implode(", ", array_map(function ($v) {
            return "$v=:$v";
        }, array_keys($array)));
        $condition = implode(' AND ', $cod);
        $sql = "UPDATE banners SET $query WHERE $condition";
        $stmt = $this->con->conPDO()->prepare($sql);
        $stmt->execute($array);
    }


    public function delete()
    {

        $sql   = "DELETE FROM `banners` WHERE `cod`  = {$this->cod} AND `idioma`  = {$this->idioma} ";
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

    function list($filter = [], $order = '', $limit = '', $idioma = '', $single = false)
    {

        $array = array();
        $filter[] = "idioma = '" . $idioma . "'";
        $filterSql = (is_array($filter)) ? 'WHERE ' . implode(' AND ', $filter) : '';
        $orderSql = ($order != '') ?  $order  : "`id` DESC";
        $limitSql = ($limit != '') ? "LIMIT " . $limit : '';

        $sql   = "SELECT * FROM `banners` $filterSql  ORDER BY $orderSql $limitSql";
        $data = $this->con->sqlReturn($sql);
        if ($data) {
            while ($row = mysqli_fetch_assoc($data)) {
                $cod = $row['cod'];
                $img = $this->imagenes->list(["cod = '$cod'"], "", "", $row['idioma'], true);
                $cat = $this->categorias->list(["cod = '" . $row['categoria'] . "'"], '', '', $row["idioma"], true);
                $array_ = array("data" => $row, "category" => $cat['data'], "image" => $img);
                $array[] = $array_;
            }

            return ($single) ? $array_ : $array;
        } else {
            return false;
        }
    }
}
