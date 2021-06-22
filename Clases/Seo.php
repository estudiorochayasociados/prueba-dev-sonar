<?php

namespace Clases;

class Seo
{

    //Atributos
    public $id;
    public $cod;
    public $url;
    public $title;
    public $description;
    public $keywords;

    private $con;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
        $this->imagenes = new Imagenes();
        $this->f = new PublicFunction();
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
        $sql = "INSERT INTO `seo`(`cod`, `url`, `title`,`description`,`keywords`) 
                VALUES ({$this->cod},
                        {$this->url},
                        {$this->title},
                        {$this->description},
                        {$this->keywords})";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function edit()
    {
        $sql = "UPDATE `seo` 
                SET cod = {$this->cod},
                    url = {$this->url},
                    title = {$this->title},
                    description = {$this->description},
                    keywords = {$this->keywords}
                WHERE `cod`={$this->cod}";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function delete()
    {
        $sql = "DELETE FROM `seo` WHERE `cod`  = {$this->cod}";
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
        $sql = "SELECT * FROM `seo` WHERE cod = {$this->cod} ORDER BY id DESC LIMIT 1";
        $seo = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($seo);
        $img = $this->imagenes->list(array("cod = '" . $row['cod'] . "'"), "orden ASC", "");
        $array = array("data" => $row, "images" => $img);
        return $array;
    }

    public function viewURL()
    {
        $sql = "SELECT * FROM `seo` WHERE url = {$this->url} ORDER BY id DESC LIMIT 1";
        $seo = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($seo);
        if ($row) {
            $img = $this->imagenes->list(array("cod = '" . $row['cod'] . "'"), "orden ASC", "");
            $array = array("data" => $row, "images" => $img);
        } else {
            $array = false;
        }

        return $array;
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

        $sql = "SELECT * FROM `seo` $filterSql ORDER BY $orderSql $limitSql";
        $seo = $this->con->sqlReturn($sql);
        if ($seo) {
            while ($row = mysqli_fetch_assoc($seo)) {
                $img = $this->imagenes->list(array("cod = '" . $row['cod'] . "'"), "orden ASC", "");
                $array[] = array("data" => $row, "images" => $img);
            }
            return $array;
        }
    }
}
