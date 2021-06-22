<?php

namespace Clases;


class Idiomas
{

    //Atributos
    public $id;
    public $cod;
    public $titulo;

    private $con;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
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

    public function add()
    {
        $sql = "INSERT INTO `idiomas`(`cod`, `titulo`,`default`) 
                  VALUES ({$this->cod},{$this->titulo},{$this->default})";
        $query = $this->con->sqlReturn($sql);
        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit()
    {
        $sql = "UPDATE `idiomas` 
                  SET cod = {$this->cod} ,
                      titulo = {$this->titulo}
                      default = {$this->default},
                  WHERE `id`= {$this->id} ";
        $query = $this->con->sqlReturn($sql);
        return true;
    }


    public function delete()
    {
        $sql = "DELETE FROM `idiomas` WHERE `cod`  = {$this->cod}";
        $query = $this->con->sqlReturn($sql);
        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function viewArea()
    {
        $sql = "SELECT * FROM `idiomas` WHERE `cod` = {$this->cod} LIMIT 1";
        $area = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($area);
        $row_ = array("data" => $row);
        if (!empty($row_)) {
            return $row_;
        }
    }
    public function view()
    {
        $sql = "SELECT * FROM `idiomas` WHERE `cod` = {$this->cod} LIMIT 1";
        $area = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($area);
        $row_ = array("data" => $row);
        if (!empty($row_)) {
            return $row_;
        }
    }

    public function list($filter = '', $order = '', $limit = '')
    {
        $array = array();
        $filterSql = is_array($filter) ? "WHERE " . implode(" AND ", $filter) : '';
        $orderSql = ($order != '') ? $order : "id DESC";
        $limitSql = ($limit != '') ? "LIMIT " . $limit : '';
        $sql = "SELECT * FROM `idiomas` $filterSql  ORDER BY $orderSql $limitSql";
        $area = $this->con->sqlReturn($sql);
        if ($area) {
            while ($row = mysqli_fetch_assoc($area)) {
                $array[] = array("data" => $row);
            }
            return $array;
        }
    }
    public function listCod($filter)
    {
        $array = array();
        if (is_array($filter)) {
            $filterSql = "WHERE ";
            $filterSql .= implode(" AND ", $filter);
        } else {
            $filterSql = '';
        }
        $sql = "SELECT `cod` FROM `idiomas` $filterSql";
        $idioma = $this->con->sqlReturn($sql);
        if ($idioma) {
            while ($row = mysqli_fetch_assoc($idioma)) {
                $array[] = array("data" => $row);
            }
            return $array;
        }
    }

    public function listIfHave($db)
    {
        $array = array();
        $sql = " SELECT `idiomas`.`titulo`,`idiomas`.`cod`,`idiomas`.`id`,`idiomas`.`default`, count(`" . $db . "`.`idiomas`) as cantidad FROM `" . $db . "`,`contenidos` WHERE `idiomas` = `contenidos`.`cod` GROUP BY area ORDER BY cantidad DESC ";
        $listIfHave = $this->con->sqlReturn($sql);
        if ($listIfHave) {
            while ($row = mysqli_fetch_assoc($listIfHave)) {
                $array[] = array("data" => $row);
            }
            return $array;
        }
    }
    public function changeDefault($cod)
    {
        $query = array();
        $sqlSet1 = "UPDATE `idiomas` SET `default`= '1' WHERE `cod` = '$cod'";
        $query = $this->con->sqlReturn($sqlSet1);
        $sqlSet0 = "UPDATE `idiomas` SET `default`= '0' WHERE `cod` != '$cod'";
        $query = $this->con->sqlReturn($sqlSet0);
        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }
    public function viewDefault()
    {
        $sql = "SELECT * FROM `idiomas` WHERE `default` = '1' LIMIT 1";
        $area = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($area);
        $row_ = array("data" => $row);
        if (!empty($row_)) {
            return $row_;
        }
    }
}
