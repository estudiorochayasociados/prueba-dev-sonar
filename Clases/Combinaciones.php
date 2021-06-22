<?php


namespace Clases;


class Combinaciones
{
    //Atributos
    public $id;
    public $cod;
    public $codSubatributo;
    public $codProducto;

    private $detalleCombinacion;
    private $subAtributo;
    private $atributo;
    private $con;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
        $this->detalleCombinacion = new DetalleCombinaciones();
        $this->atributo = new Atributos();
        $this->subAtributo = new Subatributos();
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


    public function add()
    {
        $sql = "INSERT INTO `combinaciones`(`cod`,`cod_subatributo`,`cod_producto`) 
                  VALUES ({$this->cod},{$this->codSubatributo},{$this->codProducto})";
        $query = $this->con->sql($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit()
    {
        $sql = "UPDATE `combinaciones` 
                  SET  `cod_subatributo` =  {$this->codSubatributo}  
                  WHERE `cod`= {$this->cod} ";
        $query = $this->con->sql($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }


    public function delete()
    {
        $sql = "DELETE FROM `combinaciones` WHERE `cod`  = {$this->cod}";
        $query = $this->con->sqlReturn($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function view()
    {
        $sql = "SELECT * FROM `combinaciones` WHERE cod = {$this->cod} ORDER BY id DESC LIMIT 1";
        $atributo = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($atributo);
        $array = array("data" => $row);
        return $array;
    }

    public function viewByCod()
    {
        $sql = "SELECT * FROM `combinaciones` WHERE cod = {$this->cod} ORDER BY id DESC LIMIT 1";
        $atributo = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($atributo);
        $this->detalleCombinacion->set("codCombinacion", $row['cod']);
        $detailCombination = $this->detalleCombinacion->view();
        $array = array("combination" => $row, "detail" => $detailCombination);
        return $array;
    }

    public function listByProductCod()
    {
        $array = array();
        $sql = "SELECT * FROM `combinaciones` WHERE cod_producto={$this->codProducto} GROUP BY cod";
        $data = $this->con->sqlReturn($sql);
        if ($data) {
            while ($row = mysqli_fetch_assoc($data)) {
                $this->set("cod", $row['cod']);
                $combinacionesData = $this->listByCod();
                $this->detalleCombinacion->set("codCombinacion", $row['cod']);
                $detailCombination = $this->detalleCombinacion->view();
                $array[] = array("combination" => $combinacionesData, "detail" => $detailCombination, "product" => $row["cod_producto"]);
            }
            return $array;
        }
    }

    public function listOnlyProductCod()
    {
        $array = array();
        $sql = "SELECT * FROM `combinaciones` WHERE cod_producto={$this->codProducto} GROUP BY cod";
        $data = $this->con->sqlReturn($sql);
        if ($data) {
            while ($row = mysqli_fetch_assoc($data)) {
                $this->set("cod", $row['cod']);
                $combinacionesData = $this->listOnlyCod();
                asort($combinacionesData);
                $array[] = array("combination" => $combinacionesData);
            }
            return $array;
        }
    }

    public function listByCod()
    {
        $array = array();
        $sql = "SELECT * FROM `combinaciones` WHERE cod={$this->cod}";
        $data = $this->con->sqlReturn($sql);
        if ($data) {
            while ($row = mysqli_fetch_assoc($data)) {
                $this->subAtributo->set("cod", $row['cod_subatributo']);
                $subData = $this->subAtributo->view();
                $array[] = $subData['data'];
            }
            return $array;
        }
    }

    public function listOnlyCod()
    {
        $array = array();
        $sql = "SELECT * FROM `combinaciones` WHERE cod={$this->cod}";
        $data = $this->con->sqlReturn($sql);
        if ($data) {
            while ($row = mysqli_fetch_assoc($data)) {
                $this->subAtributo->set("cod", $row['cod_subatributo']);
                $subData = $this->subAtributo->view();
                $array[] = $subData['data']["cod"];
            }
            return $array;
        }
    }

    public function listFrontCart()
    {
        $array = array();
        $sql = "SELECT * FROM `combinaciones` WHERE cod_producto={$this->codProducto} GROUP BY cod";
        $data = $this->con->sqlReturn($sql);
        if ($data) {
            while ($row = mysqli_fetch_assoc($data)) {
                $this->set("cod", $row['cod']);
                $combinacionesData = $this->listOnlyCod();
                asort($combinacionesData);
                $array[$row['cod']] = array("combination" => $combinacionesData);
            }
            return $array;
        }
    }

    public function check($atributoPOST, $producto)
    {
        $this->atributo->set("productoCod", $producto);
        $atributosData = $this->atributo->list();
        $this->set("codProducto", $producto);
        $codOnlyComb = $this->listFrontCart();

        $array = array();

        foreach ($atributosData as $atributosData_) {
            if (isset($atributoPOST[$atributosData_['atribute']['cod']])) {
                if ($atributoPOST[$atributosData_['atribute']['cod']] != '') {
                    array_push($array, $atributoPOST[$atributosData_['atribute']['cod']]);
                }
            }
        }

        asort($array);

        $resultValidate = 0;
        $combination = '';
        $implodeArray = implode(",", $array);

        foreach ($codOnlyComb as $key => $codOnly_) {
            asort($codOnly_["combination"]);
            $implodeCod = implode(",", $codOnly_["combination"]);
            if ($implodeArray === $implodeCod) {
                $resultValidate = 1;
                $combination = $key;
            }
        }
        return array("result" => $resultValidate, "combination" => $combination);
    }

    public function detail($combinacion)
    {
        $sql = "SELECT combinaciones.cod_producto , detalle_combinaciones.cod_combinacion , detalle_combinaciones.precio , detalle_combinaciones.stock ,
                subatributos.cod_atributo, atributos.value AS atributo , combinaciones.cod_subatributo, subatributos.value AS subatributo
                FROM `combinaciones`
                LEFT JOIN detalle_combinaciones ON detalle_combinaciones.cod_combinacion = combinaciones.cod
                LEFT JOIN subatributos ON subatributos.cod = combinaciones.cod_subatributo
                LEFT JOIN atributos ON atributos.cod = subatributos.cod_atributo
                WHERE combinaciones.cod = '$combinacion'";

        $data = $this->con->sqlReturn($sql);
        if ($data) {
            while ($row = mysqli_fetch_assoc($data)) {
                $array[] = array("data" => $row);
            }
            return $array;
        }
    }
}
