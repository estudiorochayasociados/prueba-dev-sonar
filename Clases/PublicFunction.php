<?php

namespace Clases;


class PublicFunction
{

    public function antihackMulti($array)
    {
        foreach ($array as $key => $value) {
            $data[$key] = $value;
            if ($value != strip_tags($value)) continue;
            $data[$key] = ($value != '') ? $this->antihack_mysqli($value) : null;
        }
        return $data;
    }


    public function antihack_mysqli($str)
    {
        $con = new Conexion();
        $conexion = $con->con();
        $str = mysqli_real_escape_string($conexion, $str);
        return $str;
    }

    public function antihack($str)
    {
        $str = stripslashes($str);
        $str = strip_tags($str);
        $str = htmlentities($str);
        return $str;
    }

    public function headerMove($location)
    {
        echo "<script> document.location.href='" . $location . "';</script>";
    }


    public function normalizar_link($string)
    {
        $string = str_replace("á", "a", $string);
        $string = str_replace("Á", "A", $string);
        $string = str_replace("ä", "a", $string);
        $string = str_replace("Ä", "A", $string);
        $string = str_replace("é", "e", $string);
        $string = str_replace("ë", "e", $string);
        $string = str_replace("Ë", "E", $string);
        $string = str_replace("É", "E", $string);
        $string = str_replace("í", "i", $string);
        $string = str_replace("ì", "i", $string);
        $string = str_replace("ï", "i", $string);
        $string = str_replace("Í", "I", $string);
        $string = str_replace("Ï", "I", $string);
        $string = str_replace("Ì", "I", $string);
        $string = str_replace("ó", "o", $string);
        $string = str_replace("Ó", "O", $string);
        $string = str_replace("ö", "o", $string);
        $string = str_replace("Ö", "O", $string);
        $string = str_replace("ú", "u", $string);
        $string = str_replace("Ú", "U", $string);
        $string = str_replace("Ü", "U", $string);
        $string = str_replace("ü", "u", $string);
        $string = str_replace(" ", "-", $string);
        $string = str_replace("!", "", $string);
        $string = str_replace("ñ", "n", $string);
        $string = str_replace("Ñ", "N", $string);
        $string = str_replace("!", "", $string);
        $string = str_replace("?", "", $string);
        $string = str_replace("¿", "", $string);
        $string = str_replace("&", "", $string);
        $string = str_replace("*", "", $string);
        $string = str_replace("#", "", $string);
        $string = str_replace("~", "", $string);
        $string = str_replace("_", "", $string);
        $string = str_replace("'", "", $string);
        $string = str_replace("\"", "", $string);
        $string = str_replace("¡", "", $string);
        $string = str_replace("/", "", $string);
        $string = str_replace(",", "", $string);
        $string = str_replace(";", "", $string);
        $string = str_replace("(", "", $string);
        $string = str_replace(")", "", $string);
        $string = str_replace("+", "", $string);
        $string = str_replace(".", "", $string);
        $string = str_replace("°", "", $string);
        $string = str_replace("%", "", $string);
        $string = str_replace("&", "", $string);
        $string = str_replace("º", "", $string);
        $string = str_replace("$", "", $string);
        $string = str_replace("´", "", $string);
        $string = str_replace("^", "", $string);
        $string = str_replace("}", "", $string);
        $string = str_replace("'", "", $string);
        $string = str_replace('"', "", $string);
        $string = str_replace('`', "", $string);
        $string = str_replace('´', "", $string);
        $string = str_replace("{", "", $string);
        $string = str_replace("_", "", $string);
        $string = str_replace(":", "", $string);
        $string = strtolower($string);
        //para ampliar los caracteres a reemplazar agregar lineas de este tipo:
        //$string = str_replace("caracter - que - queremos - cambiar","caracter - por - el - cual - lo - vamos - a - cambiar",$string);
        return $string;
    }


    public function normalizar_meli($string)
    {
        $string = str_replace("á", "a", $string);
        $string = str_replace("Á", "A", $string);
        $string = str_replace("ä", "a", $string);
        $string = str_replace("Ä", "A", $string);
        $string = str_replace("é", "e", $string);
        $string = str_replace("ë", "e", $string);
        $string = str_replace("Ë", "E", $string);
        $string = str_replace("É", "E", $string);
        $string = str_replace("í", "i", $string);
        $string = str_replace("ï", "i", $string);
        $string = str_replace("Í", "I", $string);
        $string = str_replace("Ï", "I", $string);
        $string = str_replace("Ì", "I", $string);
        $string = str_replace("ó", "o", $string);
        $string = str_replace("Ó", "O", $string);
        $string = str_replace("ö", "o", $string);
        $string = str_replace("Ö", "O", $string);
        $string = str_replace("ú", "u", $string);
        $string = str_replace("Ú", "U", $string);
        $string = str_replace("Ü", "U", $string);
        $string = str_replace("ü", "u", $string);
        $string = str_replace(" ", "%20", $string);
        $string = str_replace("!", "", $string);
        $string = str_replace("ñ", "n", $string);
        $string = str_replace("Ñ", "N", $string);
        $string = str_replace("!", "", $string);
        $string = str_replace("?", "", $string);
        $string = str_replace("¿", "", $string);
        $string = str_replace("&", "", $string);
        $string = str_replace("*", "", $string);
        $string = str_replace("#", "", $string);
        $string = str_replace("~", "", $string);
        $string = str_replace("_", "", $string);
        $string = str_replace("'", "", $string);
        $string = str_replace("\"", "", $string);
        $string = str_replace("¡", "", $string);
        $string = str_replace("/", "", $string);
        $string = str_replace(",", "", $string);
        $string = str_replace(";", "", $string);
        $string = str_replace("(", "", $string);
        $string = str_replace(")", "", $string);
        $string = str_replace("+", "", $string);
        $string = str_replace(".", "", $string);
        $string = str_replace("°", "", $string);
        $string = str_replace("&", "", $string);
        $string = str_replace("º", "", $string);
        $string = str_replace("$", "", $string);
        $string = str_replace("´", "", $string);
        $string = str_replace("^", "", $string);
        $string = str_replace("}", "", $string);
        $string = str_replace("{", "", $string);
        $string = str_replace("_", "", $string);
        $string = str_replace(":", "", $string);
        $string = strtolower($string);
        //para ampliar los caracteres a reemplazar agregar lineas de este tipo:
        //$string = str_replace("caracter - que - queremos - cambiar","caracter - por - el - cual - lo - vamos - a - cambiar",$string);
        return $string;
    }


    public function leftJoin($table_main, $table_join, $attr_join, $attr_main, $attr_show)
    {
        if (is_array($attr_show)) {
            foreach ($attr_show as $attr_print) {
                $show[] = ["`$table_join`.`$attr_print` as `$table_join" . "_" . "$attr_print` "];
            }
        } else {
            $show = "`$table_join`.`$attr_show` as `$table_join" . "_" . "$attr_show` ";
        }
        $join = " LEFT JOIN `$table_join` ON `$table_join`.`$attr_join` = `$table_main`.`$attr_main` ";

        return array("show" => $show, "join" => $join);
    }



    function curl($method, $url, $data)
    {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // OPTIONS:
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // EXECUTE:
        $result = curl_exec($curl);
        if (!$result) {
            die("Connection Failure" . curl_error($curl) . " " . curl_errno($curl));
        }
        curl_close($curl);
        return $result;
    }

    function curlML($method, $url, $data)
    {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // EXECUTE:
        $result = curl_exec($curl);
        if (!$result) {
            die("Connection Failure" . curl_error($curl) . " " . curl_errno($curl));
        }
        curl_close($curl);
        return $result;
    }

    function curlXML($method, $url, $data)
    {
        $curl = curl_init();

        switch ($method) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "DELETE":
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/xml',
        ));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // EXECUTE:
        $result = curl_exec($curl);
        if (!$result) {
            die("Connection Failure" . curl_error($curl) . " " . curl_errno($curl));
        }
        curl_close($curl);
        return $result;
    }


    public function localidades()
    {
        $con = new Conexion();
        $palabra = ($_GET["elegido"]);
        $sql = "SELECT  distinct `_provincias`.`nombre`,`_localidades`.`nombre` FROM  `_localidades` , `_provincias` WHERE  `_localidades`.`provincia_id` =  `_provincias`.`id` AND `_provincias`.`nombre`  LIKE '%$palabra%' AND `_localidades`.`nombre` != '' ORDER BY `_localidades`.`nombre`";
        $notas = $con->sqlReturn($sql);
        while ($row = mysqli_fetch_assoc($notas)) {
            echo strtoupper($row["nombre"]) . ";";
        }
    }

    public function provincias($default = '')
    {
        $con = new Conexion();
        $sql = "SELECT `nombre` FROM  `_provincias` ORDER BY nombre";
        $provincias = $con->sqlReturn($sql);
        while ($row = mysqli_fetch_assoc($provincias)) {
            $selected = ($row['nombre'] == $default) ? 'selected' : '';
            echo '<option value="' . $row['nombre'] . '" ' . $selected . '>' . mb_strtoupper($row['nombre']) . '</option>';
        }
    }

    public function fileExists($url)
    {
        return (@fopen($url, "r") == true);
    }

    public function eliminar_get($url, $varname)
    {
        $parsedUrl = parse_url($url);
        $query = array();

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $query);
            unset($query[$varname]);
        }

        $path = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
        $query = !empty($query) ? '?' . http_build_query($query) : '';

        return $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $path . $query;
    }

    public function variables_get_input($hidden)
    {
        foreach ($_GET as $key => $val) {
            if ($key == "pagina") {
            } else {
                if ($key != $hidden) {
                    echo "<input type='hidden' name='" . $key . "' value='" . $val . "' />";
                }
            }
        }
    }

    public function normalize($string)
    {
        $utf8 = [
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u' => 'A',
            '/[ÍÌÎÏ]/u' => 'I',
            '/[íìîï]/u' => 'i',
            '/[éèêë]/u' => 'e',
            '/[ÉÈÊË]/u' => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u' => 'O',
            '/[úùûü]/u' => 'u',
            '/[ÚÙÛÜ]/u' => 'U',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            '/ñ/' => 'n',
            '/Ñ/' => 'N',
            '/–/' => '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u' => ' ', // Literally a single quote
            '/[“”«»„]/u' => ' ', // Double quote
            '/ /' => ' ', // nonbreaking space (equiv. to 0x160)
        ];
        $string = preg_replace(array_keys($utf8), array_values($utf8), $string);

        $first = '/[^A-Za-z0-9\ ';
        $end = '-]/';

        $string = preg_replace($first . $end, ' ', $string);

        return $string;
    }

    function parseInput()
    {
        $data = file_get_contents("php://input");

        if ($data == false)
            return array();

        parse_str($data, $result);

        return $result;
    }
}
