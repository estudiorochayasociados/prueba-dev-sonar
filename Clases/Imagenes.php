<?php

namespace Clases;

class Imagenes
{

    //Atributos
    public $id;
    public $link;
    public $ruta;
    public $orden;
    public $cod;
    public $idioma;
    private $con;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
        $this->f = new PublicFunction();
        $this->zebra = new Zebra_Image();
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
        $sql = "INSERT INTO `imagenes`(`ruta`, `cod`, `orden`, `idioma`) VALUES ({$this->ruta}, {$this->cod},0,{$this->idioma})";
        $query = $this->con->sql($sql);
        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit()
    {
        $sql = "UPDATE `imagenes` SET ruta = {$this->ruta}, cod = {$this->cod} WHERE `id`={$this->id}";
        $query = $this->con->sql($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function editAllCod($cod)
    {
        $sql = "UPDATE `imagenes` SET cod = {$this->cod} WHERE `cod`='$cod'";
        $query = $this->con->sql($sql);
        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete()
    {
        $sql = $this->idioma != '' ? "SELECT * FROM `imagenes` WHERE `id` = {$this->id} AND `idioma` = {$this->idioma}" : "SELECT * FROM `imagenes` WHERE `id` = {$this->id}";

        $imagen = $this->con->sqlReturn($sql);
        while ($row = mysqli_fetch_assoc($imagen)) {
            $file = explode(".", $row["ruta"]);
            $sqlDelete = $this->idioma != '' ? "DELETE FROM `imagenes` WHERE `id` = '" . $row['id'] . "' AND `idioma` = {$this->idioma} " :  "DELETE FROM `imagenes` WHERE `id` = '" . $row['id'] . "'";

            $query = $this->con->sqlReturn($sqlDelete);
            $files = $row["ruta"];
            $filesx1 = $file[0] . "_x1." . $file[1];
            $filesx2 = $file[0] . "_x2." . $file[1];
            @unlink("../" . $files);
            @unlink("../" . $filesx1);
            @unlink("../" . $filesx2);
        }
    }

    public function deleteAll()
    {
        $sql = "SELECT * FROM `imagenes` WHERE cod = {$this->cod} ORDER BY cod DESC";
        $imagen = $this->con->sqlReturn($sql);

        while ($row = mysqli_fetch_assoc($imagen)) {
            $file = explode(".", $row["ruta"]);
            $files = $row["ruta"];
            $filesx1 = $file[0] . "_x1." . $file[1];
            $filesx2 = $file[0] . "_x2." . $file[1];
            unlink("../" . $files);
            @unlink("../" . $filesx1);
            @unlink("../" . $filesx2);
        }

        $sqlDelete = "DELETE FROM `imagenes` WHERE cod = {$this->cod}";
        $query = $this->con->sql($sqlDelete);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function view($cod)
    {
        $idioma = str_replace("''", "'", $this->idioma);
        $sql = ($this->idioma) != '' ?  "SELECT * FROM `imagenes` WHERE `cod` = '$cod' AND `idioma` = $idioma ORDER BY id ASC" :  "SELECT * FROM `imagenes` WHERE `cod` = '$cod' ORDER BY id ASC";
        $imagenes = $this->con->sqlReturn($sql);
        if (!empty($imagenes)) {
            $row = mysqli_fetch_assoc($imagenes);
        } else {
            $row = false;
        }
        return $row;
    }


    /**
     *
     * Mandamos la ruta de una imagen y nos de vuelve la misma pero con sus tamaños inferiores
     *
     * @param    string  $variable un string con la ruta de la imagen
     * @return    array retorna un array con 2 opciones $variable["x1"] y variable["x2"]
     *
     */


    function selectImageSize($variable)
    {
        $variable = str_replace(".jpg", "", $variable);
        $urlx1 = dirname(__DIR__) . "/" .  $variable . '_x1.jpg';
        $urlx2 = dirname(__DIR__) . "/" .  $variable . '_x2.jpg';
        $ruta["x1"] =  (@getimagesize($urlx1) ?  $variable . '_x1.jpg' :  'assets/archivos/sin_imagen.jpg');
        $ruta["x2"] =  (@getimagesize($urlx2) ?  $variable . '_x2.jpg' :  'assets/archivos/sin_imagen.jpg');
        return $ruta;
    }
    function list($filter = '', $order = '', $limit = '', $idioma = '', $single = false)
    {
        $array = array();
        $filter[] = "idioma = '" . $idioma . "'";
        $filterSql = (is_array($filter)) ? 'WHERE ' . implode(' AND ', $filter) : '';
        $orderSql = ($order != '') ?  $order  : "`id` DESC";
        $limitSql = ($limit != '') ? "LIMIT " . $limit : '';

        $sql = "SELECT * FROM `imagenes` $filterSql  ORDER BY $orderSql $limitSql";
        $image = $this->con->sqlReturn($sql);
        if ($image->num_rows) {
            while ($row = mysqli_fetch_assoc($image)) {
                $array_ = $row;
                $array[] = $array_;
            }
            return ($single) ? $array_ : $array;
        } else {
            return false;
        }
    }

    function checkForProduct($variable, $delimiter = '')
    {
        $variable_attr = '';
        $images = [];
        $matches = glob(dirname(__DIR__) . '/assets/archivos/productos/' . $variable . '*');
        if (is_array($matches)) {
            foreach ($matches as $filename) {
                if (!empty($delimiter)) {
                    $variable_attr = strpos($filename, "$delimiter") ? (($delimiter) ? explode(".", explode($delimiter, $filename)[1])[0] : '') : '';
                }
                $images[] = ["url" => URL . "/assets/" . explode("/assets/", $filename)[1], "data-variable" => $variable_attr];
            }
        }
        return $images;
    }


    function listValidation($cod)
    {
        $array = array();
        $sql = "SELECT * FROM `imagenes` WHERE cod = '$cod' ORDER BY id ASC";
        $imagenes = $this->con->sqlReturn($sql);
        if ($imagenes->num_rows == 0) {
            return false;
        } else {
            while ($row = mysqli_fetch_assoc($imagenes)) {
                $array[] = $row;
            }
            return $array;
        }
    }


    public function setOrder()
    {
        $sql = "UPDATE `imagenes` SET orden = {$this->orden} WHERE id = {$this->id}";
        $query = $this->con->sql($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function resizeImagesWithLanguage($cod, $files, $path, $final_path, $final_name = "", $idioma)
    {


        foreach ($files['name'] as $f => $name) {
            $tmpFile = $files["tmp_name"][$f];
            $nameFile = $files["name"][$f];
            $explodeName = explode('.', $nameFile);
            $countPoint = (count($explodeName) - 1);
            $extension = $explodeName[$countPoint];
            $unique_path =  $path . "/" . $this->f->normalizar_link($final_name) . "_" . substr(md5(uniqid(rand())), 0, 10) . "." . $extension;
            move_uploaded_file($tmpFile, $unique_path);

            if ($extension != '') {
                $this->zebra->jpeg_quality = 80;
                $this->zebra->preserve_aspect_ratio = true;
                $this->zebra->enlarge_smaller_images = true;
                $this->zebra->preserve_time = true;

                foreach ($idioma as $idiomaItem) {
                    $lang = isset($idiomaItem['data']['cod']) ? $idiomaItem['data']['cod'] : $idiomaItem;
                    $final_name_image = '';
                    $final_name_image = $this->f->normalizar_link($final_name) . "_" . substr(md5(uniqid(rand())), 0, 10) . "_" . $lang;
                    $path_ = $path . "/" . $final_name_image  . "." . $extension;
                    $this->zebra->source_path = $unique_path;

                    $path_final_ = $final_path . "/" . $final_name_image . "_x1." . $extension;
                    $this->zebra->target_path = $path_final_;
                    $this->zebra->resize(150, 150, ZEBRA_IMAGE_NOT_BOXED, -1);

                    $path_final_ = $final_path . "/" . $final_name_image . "_x2." . $extension;
                    $this->zebra->target_path = $path_final_;
                    $this->zebra->resize(300, 300, ZEBRA_IMAGE_NOT_BOXED, -1);

                    $path_final_ = $final_path . "/" . $final_name_image . "." . $extension;
                    $this->zebra->target_path = $path_final_;
                    $this->zebra->resize(0, 0, ZEBRA_IMAGE_NOT_BOXED, -1);

                    $this->set("cod", $cod);
                    $this->set("idioma", $lang);
                    $this->set("ruta", str_replace("../", "", $path_final_));
                    $this->add();
                }
                unlink($unique_path);
            }
        }
    }


    function selectSize($file_image, $x = false)
    {
        $file = explode(".", $file_image);
        $name_file = ($x) ? $file[0] . "_x$x." . $file[1] : $file_image;
        return $name_file;
    }
}
