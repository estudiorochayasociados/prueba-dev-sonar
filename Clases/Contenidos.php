<?php

namespace Clases;

class Contenidos
{

    //Atributos
    public $id;
    public $cod;
    public $titulo;
    public $titulo_on;
    public $subtitulo;
    public $subtitulo_on;
    public $contenido;
    public $categoria;
    public $subcategoria;
    public $keywords;
    public $description;
    public $link;
    public $link_on;
    public $area;
    public $fecha;
    public $idioma;
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

    /**
     *
     * Realizamos un list de varios ....
     *
     * @param    array  $array  todos los campos a actualizar con la key = campo sql
     *
     */

    public function add($array)
    {
        $attr = implode(",", array_keys($array));
        $values = ":" . str_replace(",", ",:", $attr);
        $sql = "INSERT INTO contenidos ($attr) VALUES ($values)";
        $stmt = $this->con->conPDO()->prepare($sql);
        $stmt->execute($array);
    }


    /**
     *
     * Realizamos un list de varios ....
     *
     * @param    array  $array  todos los campos a actualizar con la key = campo sql
     * @param    array  $params filtros para el where del update ["id = 1"]     
     *
     */

    public function edit($array, $params)
    {
        $query = implode(", ", array_map(function ($v) {
            return "$v=:$v";
        }, array_keys($array)));
        $condition = implode(' AND ', $params);
        $sql = "UPDATE contenidos SET $query WHERE $condition";
        $stmt = $this->con->conPDO()->prepare($sql);
        $stmt->execute($array);
    }

    public function delete()
    {
        $sql = "DELETE FROM `contenidos` WHERE `cod`  = {$this->cod} AND `idioma`  = {$this->idioma}";
        $query = $this->con->sqlReturn($sql);
        if (!empty($this->imagenes->list(array("cod={$this->cod}"), 'orden ASC', ''))) {
            $this->imagenes->cod = $this->cod;
            $this->imagenes->deleteAll();
        }

        return (!empty($query)) ? true : false;
    }


    /**
     *
     * Pasar un array con "clave" => "valor"
     * $data = [
     * "filter" => $filter,
     * "images" => true,
     *];
     * @param    array  $filter se agrega un filtro
     * @param    string  $idioma se pasa el codigo de la $_SESSION['lang'] o el código de un idioma en especifico
     * @param    bool  $subcategory si desea traer esa informacion extra sobre el contenido true/false
     * @param    bool  $category si desea traer esa informacion extra sobre el contenido true/false
     * @param    bool  $images si desea traer esa informacion extra sobre el contenido true/false
     * @param    bool  $gallery si desea traer esa informacion extra sobre el contenido true/false
     * @param    int  $order agregar un orden Ej: id DESC
     * @param    int  $limit agregar un limite de contenidos a retornar
     * @return   array retorna un array con los contenidos 
     *
     */
    function list($data, $idioma, $single = false)
    {
        $filter = !empty($data['filter']) ? $data['filter'] :  [];
        $idioma = !empty($idioma) ? $idioma :  $_SESSION['lang'];
        $category = !empty($data['category']) ? $data['category'] :  false;
        $subcategory = !empty($data['subcategory']) ? $data['subcategory'] :  false;
        $images = !empty($data['images']) ? $data['images'] :  false;
        $gallery = !empty($data['gallery']) ? $data['gallery'] :  false;
        $order = !empty($data['order']) ? $data['order'] :  '';
        $limit = !empty($data['limit']) ? $data['limit'] :  '';

        $filter[] = "idioma = '" . $idioma . "'";
        $filterSql = (is_array($filter)) ? 'WHERE contenidos.' . implode(' AND contenidos.', $filter) : '';

        if ($category) {
            $arrayAttr[] = "`categorias`.`titulo` as 'categoria_titulo',`categorias`.`area` as 'categoria_area', `categorias`.`descripcion` as 'categoria_descripcion'";
            $arrayLeft[] = "LEFT JOIN `categorias` ON `categorias`.`cod` = `contenidos`.`categoria`  AND `categorias`.`idioma` = '$idioma'";
        }
        if ($subcategory) {
            $arrayAttr[] = "`subcategorias`.`titulo`as 'subcategoria_titulo'";
            $arrayLeft[] = "LEFT JOIN `subcategorias` ON `subcategorias`.`cod` = `contenidos`.`subcategoria`  AND `subcategorias`.`idioma` = '$idioma'";
        }
        if ($images) {
            $arrayAttr[] = "GROUP_CONCAT(`imagenes`.`id` ORDER BY `imagenes`.`orden` SEPARATOR ',') AS 'imagenes_id',
            GROUP_CONCAT(`imagenes`.`orden` ORDER BY `imagenes`.`orden` SEPARATOR ',') AS 'imagenes_orden',
            GROUP_CONCAT(`imagenes`.`ruta` ORDER BY `imagenes`.`orden` SEPARATOR ',') AS 'imagenes_rutas'";
            $arrayLeft[] = "LEFT JOIN `imagenes` ON `imagenes`.`cod` = `contenidos`.`cod` AND `imagenes`.`idioma` = '$idioma'";
        }

        $attr = isset($arrayAttr) ? " , " . implode(" , ", $arrayAttr) . " " : '';
        $left = isset($arrayLeft) ? implode(" ", $arrayLeft) : '';
        $orderSql = ($order != '') ? "`contenidos`.`" . $order . "`" : "`contenidos`.`idioma`,`contenidos`.`id` DESC";
        $limitSql = ($limit != '') ? "LIMIT " . $limit : '';

        $sql = "SELECT `contenidos`.* $attr FROM `contenidos` $left $filterSql 
        GROUP BY `contenidos`.`id` ORDER BY $orderSql $limitSql";
        $array = array();
        $contenido = $this->con->sqlReturn($sql);

        if ($contenido) {
            while ($row = mysqli_fetch_assoc($contenido)) {
                $array_ = ($gallery) ? $this->doSlideOrGallery(["data" => $row]) : ["data" => $row];
                $array_["images"] = ($images) ? $this->createArrayImages($row) : [];
                unset($row['imagenes_id'], $row['imagenes_orden'], $row['imagenes_rutas']);
                $array[$row["cod"]] = $array_;
            }
            return ($single) ? $array_ : $array;
        } else {
            return false;
        }
    }




    public function createArrayImages($row)
    {
        if ($row['imagenes_id']) {
            $row['imagenes_id'] = explode(",", $row['imagenes_id']);
            $row['imagenes_orden'] = explode(",", $row['imagenes_orden']);
            $row['imagenes_rutas'] = explode(",", $row['imagenes_rutas']);
            $imagesLength = count($row['imagenes_id']) - 1;
            $images_array = [];
            if ($row['imagenes_id']) {
                for ($i = 0; $i <= $imagesLength; $i++) {
                    if ($row["imagenes_id"][$i]) {
                        $images_array[] = ["id" => $row["imagenes_id"][$i], "orden" => $row["imagenes_orden"][$i], "url" => URL . "/" . $row["imagenes_rutas"][$i]];
                    }
                }
                $images = (count($images_array)) ? $images_array : [["id" => 000000, "url" => URL . "/assets/archivos/sin_imagen.jpg"]];
                return $images;
            }
        } else {
            return false;
        }
    }
    /**
     *
     * Realizamos un list de varios ....
     *
     * @param    array  $filter array con todos los códigos que quiero traer
     * @return    array retorna un array con todos los array internos, con a key de código de contenidos
     *
     */

    public function listMany($filter, $images = true)
    {
        $filter = implode(" OR ", $filter);
        $sql = "SELECT * FROM `contenidos` WHERE  $filter  ORDER BY area ASC";
        $contenido = $this->con->sqlReturn($sql);
        $area = '';
        while ($row = mysqli_fetch_assoc($contenido)) {
            $area = ($row["area"] == $area) ? $area : $row["area"];
            $img = ($images) ? $this->imagenes->list(array("cod = '" . $row['cod'] . "'"), "orden ASC", "") : [];
            $array[$area][$row['cod']] = array("data" => $row,  "images" => $img);
        }
        return $array;
    }



    function filterArray($categoria, $subcategoria, $buscar, $contenidosArray)
    {
        if (!empty($categoria) || !empty($subcategoria) || !empty($buscar)) {
            foreach ($contenidosArray as $key => $contenidoItem) {
                $tituloItem = $this->f->normalizar_link($contenidoItem["data"]["titulo"]);
                $categoriaItem = $this->f->normalizar_link($contenidoItem["category"]["data"]["titulo"]);
                $subcategoriaItem = $this->f->normalizar_link($contenidoItem["subcategory"]["data"]["titulo"]);
                if (!empty($categoria) && $categoria != $categoriaItem) {
                    unset($contenidosArray[$key]);
                }
                if (!empty($subcategoria) && $subcategoria != $subcategoriaItem) {
                    unset($contenidosArray[$key]);
                }
                if (!empty($buscar) && !is_numeric(mb_strpos($tituloItem, $buscar))) {
                    unset($contenidosArray[$key]);
                }
            }
        }
        return $contenidosArray;
    }


    public function editSingle($atribute, $value)
    {
        $sql = "UPDATE `contenidos` SET $atribute = $value WHERE `id`={$this->id} OR `cod`={$this->cod}";
        $query = $this->con->sql($sql);

        return (!empty($query)) ? true : false;
    }

    public function doSlideOrGallery($contenido)
    {
        $contenido = $this->createGallery($contenido);
        $contenido = $this->createSlider($contenido);
        return $contenido;
    }

    public function createGallery($contenido)
    {
        $galeryCheck = strpos($contenido['data']['contenido'], "[gallery");
        if ($galeryCheck !== false) {
            preg_match("/\[[^\]]*\]/", $contenido['data']['contenido'], $check);
            $string = str_replace(["[", "]"], "", $check[0]);
            $stringExplode = explode("|", $string);
            $col = isset($stringExplode[1]) ? $stringExplode[1] : 12;
            $galeria = "<div class='galleryDev'><div class='row'>";
            $count = 0;
            foreach ($contenido["data"]["imagenes_rutas"] as $img) {
                $count++;
                $galeria .= '<div class="col-md-' . $col  . '"><a href="' . URL . "/" . $img . '" class="thumbnail" data-toggle="modal" data-target="#lightbox' . $count . '"><img src="' . URL . "/" . $img . '" alt="' . $contenido["data"]["titulo"] . '"></a></div>';
                $galeria .= "<div id='lightbox" . $count . "' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <button type='button' class='close hidden' data-dismiss='modal' aria-hidden='true'>×</button>
                                <div class='modal-content'>
                                <div class='modal-body'>
                                    <img src='" . URL . "/" . $img . "' alt='' />
                                </div>
                            </div>
                        </div>
                    </div>";
            }
            $galeria .= "</div></div>";
            $contenido["data"]["contenido"] = str_replace($check[0], $galeria, $contenido["data"]["contenido"]);
        }
        return $contenido;
    }

    public function createSlider($contenido)
    {
        $sliderCheck = strpos($contenido['data']['contenido'], "[slider]");
        if ($sliderCheck !== false) {
            $i = 0;
            $galeria = '<div id="carousel" class="carousel slide" data-ride="carousel"><div class="carousel-inner">';
            foreach ($contenido["data"]["imagenes_rutas"] as $img) {
                $check = ($i === 0) ? "active" : "";
                $galeria .= '<div class="carousel-item ' . $check . '"><img class="d-block w-100"   src="' . URL . "/" . $img . '" alt="' . $contenido["data"]["titulo"] . '" /></div>';
                $i++;
            }
            $galeria .= '</div><a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="sr-only">Previous</span>  </a>  <a class="carousel-control-next" href="#carousel" role="button" data-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="sr-only">Next</span></a></div>';

            $contenido["data"]["contenido"] = str_replace("[slider]", $galeria, $contenido["data"]["contenido"]);
        }
        return $contenido;
    }




    public function duplicateByLanguage($lang, $langTo)
    {
        foreach ($this->list([], $lang) as $contenido_) {
            unset($contenido_["data"]["id"]);
            $contenido_["data"]["idioma"] = $langTo;
            $this->add($contenido_["data"]);
        }
    }
    public function countContents($filter = [], $idioma)
    {
        $filter[] = "idioma = '" . $idioma . "'";
        $filterSql = (is_array($filter)) ? 'WHERE contenidos.' . implode(' AND contenidos.', $filter) : '';
        $sql = "SELECT COUNT(*) as cantidad FROM `contenidos` $filterSql ";
        $query = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($query);
        return $row["cantidad"];
    }
  
    /**
     *
     * Creacion del paginador segun la cantidad de contenidos a mostrar ....
     *
     * @param    string  $url url de la pagina a paginar
     * @param    array  $filter array con la informacion de contenidos a traer
     * @param    int  $limit numero de contenidos por pagina
     * @param    int  $page pagina en la que se encuentra
     * @param    int  $range cantidad de paginas a mostrar en el paginador entre las flechas  < x x 3 x x > 
     * @return   html retorna un HTML con el paginador
     *
     */
    public function paginador($url, $filter, $limit, $page = 1, $range = 1)
    {
        $count = $this->countContents($filter, $_SESSION["lang"]);
        $total = ceil($count / $limit);
        $pre = $page - 1;
        $next = $page + 1;
        $html = "<nav class='pagination-section mt-30'>";
        $html .=  "<ul class='pagination justify-content-center'>";
        if ($pre > 0) {
            $html .= "<li class='page-item' style='height:5px'>";
            $html .= "<a class='page-link' href='$url/p/1'><i class='ion-ios-arrow-left'></i><i class='ion-ios-arrow-left'></i></a>";
            $html .=  "</li>";
            $html .=  "<li class='page-item'>";
            $html .=  "<a class='page-link' href='$url/p/$pre'><i class='ion-chevron-left'></i></a>";
            $html .=  "</li>";
        }
        foreach (range($page - $range, $page + $range) as $i) {
            if ($i > 0 && $i <= $total) {
                $active = ($i == $page) ? 'active' : '';
                $html .=  "<li class='page-item $active'>";
                $html .=  "<a class='page-link' href='$url/p/$i'>$i</a>";
                $html .=  "</li>";
            }
        }
        if ($next <= $total) {
            $html .= "<li class='page-item'>";
            $html .= "<a class='page-link' href='$url/p/$next'><i class='ion-chevron-right'></i></a>";
            $html .=  "</li>";
            $html .= "<li class='page-item' style='height:5px'>";
            $html .= "<a class='page-link' href='$url/p/$total'><i class='ion-ios-arrow-right'></i><i class='ion-ios-arrow-right'></i></a>";
            $html .=  "</li>";
        }
        $html .=  "</ul>";
        $html .=  "</nav>";
        return $html;
    }
}
