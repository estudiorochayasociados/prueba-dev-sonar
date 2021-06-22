<?php

namespace Clases;

class DetallePedidos
{

    //Atributos
    public $id;
    public $cod;
    public $producto;
    public $cantidad;
    public $precio;
    public $tipo;
    public $descuento;
    public $cod_producto;
    public $cod_combinacion;
    private $con;


    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
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
        $sql = "INSERT INTO `detalle_pedidos`(`cod`, `producto`,`cantidad`,`precio`, `tipo`, `descuento`, `cod_producto`, `cod_combinacion`) 
                VALUES ({$this->cod}, 
                        {$this->producto},
                        {$this->cantidad},
                        {$this->precio}, 
                        {$this->tipo}, 
                        {$this->descuento}, 
                        {$this->cod_producto},
                        {$this->cod_combinacion})";
      $query = $this->con->sqlReturn($sql);

      if (!empty($query)) {
          return true;
      } else {
          return false;
      }
    }
    public function editSingle($atributo, $valor)
    {
        $sql = "UPDATE `detalle_pedidos` SET `$atributo` = '{$valor}' WHERE `cod`={$this->cod}";
        $this->con->sql($sql);
    }

    public function editSingleShipping($atributo, $valor)
    {
        $sql = "UPDATE `detalle_pedidos` SET `$atributo` = '{$valor}' WHERE `cod`={$this->cod} AND `tipo`= {$this->tipo}";
        $this->con->sql($sql);
    }

    public function delete($id)
    {
        $sql   = "DELETE FROM `detalle_pedidos` WHERE `id`  = {$id}";
        $query = $this->con->sql($sql);
        return $query;
    }

    function list($cod)
    {
        $array = array();
        $sql = "SELECT * FROM `detalle_pedidos` WHERE `cod`  = {$cod} ORDER BY id ASC";
        $result = $this->con->sqlReturn($sql);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $array[] = $row;
            }
            return $array;
        }
    }


    function topBuy($status, $limit)
    {
        $array = array();

        $sql = "SELECT `detalle_pedidos`.`cod_producto`, `detalle_pedidos`.`producto`, `detalle_pedidos`.`cod_combinacion`, COUNT(*) as `cantidad_pedidos`, SUM(detalle_pedidos.cantidad) AS `cantidad_vendida` FROM `detalle_pedidos` 
        LEFT JOIN `pedidos` ON `pedidos`.`cod` = `detalle_pedidos`.`cod` 
        LEFT JOIN `estados_pedidos` ON `pedidos`.`estado` = `estados_pedidos`.`id` 
        WHERE `estados_pedidos`.`estado` = $status AND detalle_pedidos.tipo = 'PR' 
        GROUP BY `detalle_pedidos`.`cod_producto` ORDER BY `cantidad_vendida` DESC LIMIT $limit";
        $result = $this->con->sqlReturn($sql);

        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $array[] = ["data" => $row];
            }
            return $array;
        }
    }

}
