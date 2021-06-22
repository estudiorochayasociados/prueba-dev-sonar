<?php

namespace Clases;

class Landing
{

    //Atributos
    public $id;
    public $cod;
    public $titulo;
    public $desarrollo;
    public $categoria;
    public $keywords;
    public $description;
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

    public function add()
    {
        $sql = "INSERT INTO `landing`(`cod`, `titulo`, `desarrollo`, `categoria`, `keywords`, `description`, `fecha`) 
                  VALUES ({$this->cod},
                          {$this->titulo},
                          {$this->desarrollo},
                          {$this->categoria},
                          {$this->keywords},
                          {$this->description},
                          {$this->fecha})";
        $query = $this->con->sql($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit()
    {
        $sql = "UPDATE `landing` 
                  SET cod = {$this->cod},
                      titulo = {$this->titulo},
                      desarrollo = {$this->desarrollo},
                      categoria = {$this->categoria},
                      keywords = {$this->keywords},
                      description = {$this->description},
                      fecha = {$this->fecha} 
                  WHERE `cod`={$this->cod}";

        $query = $this->con->sql($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete()
    {
        $sql = "DELETE FROM `landing` WHERE `cod`  = {$this->cod}";
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
        $sql = "SELECT * FROM `landing` WHERE cod = {$this->cod} ORDER BY id DESC";
        $landing = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($landing);
        $img = $this->imagenes->list(array("cod='" . $row['cod'] . "'"), 'orden ASC', '');
        $cat = $this->categorias->list(["cod = '" . $row['categoria'] . "'"], '', '', $row["idioma"]);
        $row_ = array("data" => $row, "category" => $cat, "images" => $img);
        return $row_;
    }

    function list($filter, $order, $limit)
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

        $sql = "SELECT * FROM `landing` $filterSql  ORDER BY $orderSql $limitSql";
        $landing = $this->con->sqlReturn($sql);

        if ($landing) {
            while ($row = mysqli_fetch_assoc($landing)) {
                $img = $this->imagenes->list(array("cod='" . $row['cod'] . "'"), 'orden ASC', '');
                $cat = $this->categorias->list(["cod = '" . $row['categoria'] . "'"], '', '', $row["idioma"]);
                $array[] = array("data" => $row, "category" => $cat, "images" => $img);
            }
            return $array;
        }
    }
}
