<?php

namespace Clases;

class Pedidos
{

    //Atributos
    public $id;
    public $cod;
    public $producto;
    public $cantidad;
    public $total;
    public $estado;
    public $pago;
    public $usuario;
    public $detalle;
    public $fecha;
    public $visto;

    private $con;
    private $detallePedido;
    private $user;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
        $this->detallePedido = new DetallePedidos();
        $this->user = new Usuarios();
        $this->f = new PublicFunction();
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
        $sql = "INSERT INTO `pedidos`(`cod`,`total`, `estado`,`pago`, `usuario`, `detalle`, `fecha`, `visto`) 
                  VALUES ({$this->cod},
                          {$this->total},
                          {$this->estado},
                          {$this->pago},
                          {$this->usuario},
                          {$this->detalle},
                          {$this->fecha},
                          {$this->visto})";
        $query = $this->con->sql($sql);
        return true;
    }

    public function edit()
    {
        $sql = "UPDATE `pedidos` 
                SET  total =  {$this->total}  ,
                     estado = {$this->estado},           
                     pago = {$this->pago},           
                     usuario = {$this->usuario},           
                     detalle = {$this->detalle},           
                     fecha = {$this->fecha},           
                     visto = {$this->visto}           
                  WHERE `cod`= {$this->cod} ";
        $query = $this->con->sql($sql);
        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }
    public function editSingle($atributo, $valor)
    {
        $sql = "UPDATE `pedidos` SET `$atributo` = '{$valor}' WHERE `cod`={$this->cod}";
        $this->con->sql($sql);
    }
    public function changeState()
    {
        $sql = "UPDATE `pedidos` SET `estado`={$this->estado} WHERE `cod`={$this->cod}";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function changeValue($key)
    {
        $sql = "UPDATE `pedidos` SET `$key`={$this->$key} WHERE `cod`={$this->cod}";
        $query = $this->con->sql($sql);
        return $query;
    }


    public function delete()
    {
        $sql = "DELETE FROM `pedidos` WHERE `cod`  = {$this->cod}";
        $query = $this->con->sql($sql);
        //$this->detallePedido->delete($this->cod);
        return $query;
    }

    public function view()
    {
        $sql = "SELECT * FROM `pedidos` WHERE cod = {$this->cod} ORDER BY id DESC";
        $pedidos = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($pedidos);
        if ($row) {
            $details = $this->detallePedido->list($this->cod);
            $this->user->set("cod", $row['usuario']);
            $user = $this->user->view();
            $data = ["data" => $row, "user" => $user, "detail" => $details, "status_text" => $this->showStatus($row["estado"])];
        } else {
            $data = false;
        }
        return $data;
    }


    public function showStatus($status_number)
    {
        switch ($status_number) {
            case 0:
                return "CARRITO NO CERRADO";
                break;
            case 1:
                return "PENDIENTE";
                break;
            case 2:
                return "APROBADO";
                break;
            case 3:
                return "ENVIADO";
                break;
            case 4:
                return "RECHAZADO";
                break;
        }
    }

    function list($filter, $order, $limit)
    {
        $array = [];
        $filterSql = '';
        if (is_array($filter)) {
            $filterSql = "WHERE ";
            $filterSql .= implode(" AND ", $filter);
        }
        if (isset($filter['status'])) {
            $filterSql = "WHERE ";
            $filterSql .= implode(" OR ", $filter['status']);
        }
        if (isset($filter['date'])) {
            $filterSql = "WHERE ";
            $filterSql .= implode(" AND ", $filter['date']);
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
        $sql = "SELECT * FROM `pedidos` $filterSql  ORDER BY $orderSql $limitSql";
        $result = $this->con->sqlReturn($sql);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $details = $this->detallePedido->list("'" . $row['cod'] . "'");
                $this->user->set("cod", $row['usuario']);
                $user = $this->user->view();
                $array[] = ["data" => $row, "user" => $user, "detail" => $details, "status_text" => $this->showStatus($row["estado"])];
            }
        }
        return $array;
    }

    public function getTotalByStatus($filter = '')
    {
        // Genero todo el array en vacio
        $status = [];
        $statusTotal = [
            "0" => ["data" => ["cantidad" => 0, "total" => 0]],
            "1" => ["data" => ["cantidad" => 0, "total" => 0]],
            "2" => ["data" => ["cantidad" => 0, "total" => 0]],
            "3" => ["data" => ["cantidad" => 0, "total" => 0]]
        ];
        if (is_array($filter)) {
            $filterSql = "WHERE ";
            $filterSql .= implode(" AND ", $filter['date']);
        } else {
            $filterSql = '';
        }

        $sql = "SELECT COUNT(*) as cantidad, SUM(pedidos.total) AS total , estados_pedidos.id as idEstado, estados_pedidos.titulo as titulo, estados_pedidos.estado  FROM pedidos 
        INNER JOIN estados_pedidos ON pedidos.estado = estados_pedidos.id $filterSql GROUP BY estados_pedidos.id ORDER BY estados_pedidos.estado ASC";
        $pedidos = $this->con->sqlReturn($sql);
        if ($pedidos) {
            while ($row = mysqli_fetch_assoc($pedidos)) {
                $status[] = ["data" => $row]; // Relleno el array vacio con los datos que traiga de la consulta y si no encuentra mantiene el vacio
                switch ($row['estado']) {
                    case 0:
                        $statusTotal[0] = ["data" => [
                            "cantidad" => ($statusTotal[0]['data']['cantidad'] + $row['cantidad']),
                            "total" => ($statusTotal[0]['data']['total'] + $row['total'])
                        ]];
                        break;
                    case 1:
                        $statusTotal[1] = ["data" => [
                            "cantidad" => ($statusTotal[1]['data']['cantidad'] + $row['cantidad']),
                            "total" => ($statusTotal[1]['data']['total'] + $row['total'])
                        ]];
                        break;
                    case 2:
                        $statusTotal[2] = ["data" => [
                            "cantidad" => ($statusTotal[2]['data']['cantidad'] + $row['cantidad']),
                            "total" => ($statusTotal[2]['data']['total'] + $row['total'])
                        ]];
                        break;
                    case 3:
                        $statusTotal[3] = ["data" => [
                            "cantidad" => ($statusTotal[3]['data']['cantidad'] + $row['cantidad']),
                            "total" => ($statusTotal[3]['data']['total'] + $row['total'])
                        ]];
                        break;
                }
            }
            $array = ["status" => $status, "statusTotal" => $statusTotal];
        }
        return $array;
    }



    public function tooltipData($totalByStatus)
    {
        $tooltipName[] = [];
        foreach ($totalByStatus as $tootltipStatus) {
            switch ($tootltipStatus['data']['estado']) {
                case 0:
                    $tooltipName[0][] = [
                        "cantidad" => $tootltipStatus['data']['cantidad'],
                        "total" => $tootltipStatus['data']['total'],
                        "titulo" => $tootltipStatus['data']['titulo']
                    ];
                    break;
                case 1:
                    $tooltipName[1][] = [
                        "cantidad" => $tootltipStatus['data']['cantidad'],
                        "total" => $tootltipStatus['data']['total'],
                        "titulo" => $tootltipStatus['data']['titulo']
                    ];
                    break;
                case 2:
                    $tooltipName[2][] = [
                        "cantidad" => $tootltipStatus['data']['cantidad'],
                        "total" => $tootltipStatus['data']['total'],
                        "titulo" => $tootltipStatus['data']['titulo']
                    ];
                    break;
                case 3:
                    $tooltipName[3][] = [
                        "cantidad" => $tootltipStatus['data']['cantidad'],
                        "total" => $tootltipStatus['data']['total'],
                        "titulo" => $tootltipStatus['data']['titulo']
                    ];
                    break;
            }
        }
        return $tooltipName;
    }
    public function getTooltip($tooltipData)
    {
        $total = count($tooltipData);
        $i = 0;
        foreach ($tooltipData as $tooltip) {
            $i++;
            echo "<div class='mt-20'><b>" . $tooltip["titulo"] . "</b> ( " . $tooltip["cantidad"] . " )<br/> <b>$" . number_format($tooltip["total"], "2", ",", ".") . "</div>";
            echo ($i != $total) ? "<hr/>" : "<br/>";
        }
    }



    /**
     *
     * Traer un array con el detalle del pedido y el  de informacion '' o 'pago'
     *
     * @param    array  $detalle array con la informacion del pedido
     * @param    string  $typeInfo  de informacion si es del apartado de pagos o del de s
     * @return   array retorna un array con cada dato ya incluido en una etiqueta <p></p>
     *
     */
    public function getInfoPedido($detalle, $typeInfo)
    {
        $textReturn = '';
        foreach ($detalle[$typeInfo] as $key => $value) {
            if ($key != 'similar' && $key != 'factura') {
                $textReturn .= !empty($value) ? "<p class='mb-0 fs-13'><b>" . ucfirst($key) . ": </b>" . preg_replace('/u([\da-fA-F]{4})/', '&#x\1;', $value) . "</p> " : "";
            }
        }
        return $textReturn;
    }




    public function checkMercadoPago()
    {
        $urlCanonical = explode("&", CANONICAL);
        $collection_id = str_replace(URL . "/checkout/detail?collection_id=", "", $urlCanonical[0]);
        if ($collection_id != "null") {
            if (isset($collection_id) && !empty($collection_id)) {
                $this->f->curl("GET", URL . "/api/payments/ipn.php?id=" . $collection_id, '');
            }
        }

        ($collection_id == "null") ? $this->editSingle("estado", 1) : '';
    }
}
