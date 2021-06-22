<?php

namespace Clases;

class Menu
{

    //Atributos
    public $id;
    public $padre;
    public $titulo;
    public $icono;
    public $link;
    public $target;
    public $orden;
    public $categoria;
    public $options;
    public $total;
    public $idioma;
    private $con;

    //Metodos
    public function __construct($admin = false)
    {
        $this->con = new Conexion();
        $this->f = new PublicFunction();
        $this->idiomas = new Idiomas();
        $this->categorias = new Categorias();
        $this->total = $this->listByLanguage($admin);
    }


    public function get_all()
    {
        $sql = "SELECT * FROM `menu`  ORDER BY `orden` ASC";
        $menu = $this->con->sqlReturn($sql);
        $array = [];

        if ($menu->num_rows) {
            while ($row = mysqli_fetch_assoc($menu)) {
                $array[$row['id']] = $row;
            }
        }
        return $array;
    }

    public function listByLanguage($admin)
    {

        $filter = (!$admin) ? "WHERE `idioma` = '" . $_SESSION['lang'] . "'" : '';
        $sql = "SELECT * FROM `menu` $filter ORDER BY `idioma`,`orden`  ASC ";
        $menu = $this->con->sqlReturn($sql);
        $array = [];

        if ($menu->num_rows) {
            while ($row = mysqli_fetch_assoc($menu)) {
                $array[$row['id']] = $row;
            }
        }
        return $array;
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
        $sql = "INSERT INTO `menu`(`padre`,`titulo`,`icono`,`link`,`target`,`orden`, `idioma`) 
                VALUES ({$this->padre},
                        {$this->titulo},
                        {$this->icono}, 
                        {$this->link},
                        {$this->target},
                        {$this->orden},
                        {$this->idioma})";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function edit()
    {
        $sql = "UPDATE `menu` 
                SET `padre`  = {$this->padre},
                    `titulo`  = {$this->titulo},
                    `icono`  = {$this->icono}, 
                    `link`  = {$this->link},
                    `target`  = {$this->target},
                    `orden`  = {$this->orden},
                    `idioma`  = {$this->idioma}
                WHERE `id`= {$this->id}";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function delete()
    {
        $sql = "DELETE FROM `menu` WHERE `id`  = {$this->id} OR `padre`  = {$this->id}";
        $query = $this->con->sqlReturn($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function build_nav($padre_id = "", $child = true)
    {
        $ul_class = empty($padre_id) ? "nav-menu" : "dropdown";
        $li_class = ($child) ? "" : "";
        $a_class = ($child) ? "" : "";

        $r = array_filter($this->total, function ($value) use ($padre_id) {
            return $value['padre'] == $padre_id;
        });
        if ($r) {
            echo "<ul class='$ul_class'>";
            foreach ($r as $value) {
                $preset_dropdown = (strpos($value['link'], '#') !== false) ? $this->build_category($value['link']) : '';
                $arrow_icon = ($this->checkIfHave($value['id']) || !empty($preset_dropdown)) ? '<i class="fa fa-angle-down"></i>' : '';
                echo "<li class='$li_class'><a href='" . URL . "/" . $value['link'] . "' target='" . $value['target'] . "' class='$a_class'><i class='" . $value['icono'] . "' ></i> " . $value['titulo'] . " $arrow_icon</a>";

                echo $preset_dropdown;
                $this->build_nav($value['id'], true);

                echo "</li>";
            }
            echo "</ul>";
        }
    }

    public function build_category($type)
    {
        $types = explode('#', $type);
        $data = $this->categorias->list(["area = '" . $types[0] . "'"], '', '');
        $opciones = '';

        if ($types[1] == "categorias") {
            $opciones .= "<ul class='dropdown-menu'>";
            foreach ($data as $value) {
                $opciones .= "<li class='nav__item'><a href='" . URL . "/productos/c/" . $this->f->normalizar_link($value['data']['titulo']) . "/" . $value['data']['cod'] . "' class='nav__item-link'> " . $value['data']['titulo'] . "</a></li>";
            }
            $opciones .= "</ul>";
        } else {
            $opciones .= "<ul class='dropdown-menu'>";
            foreach ($data as $value) {
                $link = URL . "/productos/c/" .  $this->f->normalizar_link($value['data']['titulo']) . "/" . $value['data']['cod'];
                $arrow_icon = (!empty($value["subcategories"])) ? '<i class="fa fa-angle-down"></i>' : '';
                $opciones .= "<li class='nav__item with-dropdown'><a href='" . $link . "' class='nav__item-link dropdown-toggle'>" . $value['data']['titulo'] . " " . $arrow_icon . "</a>";
                if (!empty($value["subcategories"])) {
                    $linkSub = str_replace("/c/", "/s/", $link);
                    $opciones .= "<ul class='dropdown-menu'>";
                    foreach ($value["subcategories"] as $value_) {
                        $opciones .= "<li class='nav__item'><a href='" . $linkSub . "/" . $this->f->normalizar_link($value_['data']['titulo']) . "/" . $value_['data']['cod'] . "' class='nav__item-link'> " . $value_['data']['titulo'] . "</a></li>";
                    }
                    $opciones .= "</ul>";
                }
                $opciones .= "</li>";
            }
            $opciones .= "</ul>";
        }


        return $opciones;
    }

    public function build_nav_mobile($padre_id = "", $child = true)
    {
        $ul_class = empty($padre_id) ? "has-children" : "offcanvas-submenu";
        $li_class = ($child) ? "" : "";
        $a_class = ($child) ? "" : "";

        $r = array_filter($this->total, function ($value) use ($padre_id) {
            return $value['padre'] == $padre_id;
        });
        if ($r) {
            echo "<ul class='$ul_class'>";
            foreach ($r as $value) {
                $preset_dropdown = (strpos($value['link'], '#') !== false) ? $this->build_category($value['link']) : '';
                $arrow_icon = ($this->checkIfHave($value['id']) || !empty($preset_dropdown)) ? '<i class="fa fa-angle-down"></i>' : '';
                echo "<li class='$li_class'><a href='" . URL . "/" . $value['link'] . "' target='" . $value['target'] . "' class='$a_class'><i class='" . $value['icono'] . "' ></i> " . $value['titulo'] . " $arrow_icon</a>";

                echo $preset_dropdown;
                $this->build_nav($value['id'], true);

                echo "</li>";
            }
            echo "</ul>";
        }
    }


    public function build_admin($padre_id = "", $margin)
    {

        $r = array_filter($this->total, function ($value) use ($padre_id) {
            return $value['padre'] == $padre_id;
        });
        echo "<div class='" . $padre_id . "' style='" . (($margin != 0) ? "display:none" : "") . "'>";
        foreach ($r as $key => $row) {
            ($key == 0) ? $idiomaCheck = $row['idioma'] : '';
            echo (isset($idiomaCheck) && $idiomaCheck != $row['idioma']) ? "<hr>" : '';
            $idiomaCheck = $row['idioma'];
?>
            <div style="margin-left:<?= $margin ?>px">
                <form method="POST">
                    <div class="form-row align-items-center mb-0">
                        <input type="hidden" class="fs-13 mb-1" placeholder="id" name="id" value="<?= $row["id"] ?>">
                        <img class="mb-1" src="<?= URL_ADMIN ?>/img/idiomas/<?= $row["idioma"] ?>.png" width="35" />
                        <div class="col ">
                            <input type="text" class="fs-13 mb-1" placeholder="titulo" name="titulo" value="<?= $row["titulo"] ?>">
                        </div>
                        <div class="col ">
                            <input type="text" class="fs-13 mb-1" placeholder="link" name="link" value="<?= $row["link"] ?>">
                        </div>
                        <div class="col ">
                            <input type="text" class="fs-13 mb-1" placeholder="icono" name="icono" value="<?= $row["icono"] ?>">
                        </div>
                        <div class="col ">
                            <select class="fs-13 mb-1" name="target">
                                <option value="_blank" <?= ($row["target"] == "_blank") ? "selected" : "" ?>>Nueva Ventana</option>
                                <option value="_self" <?= ($row["target"] == "_self") ? "selected" : "" ?>>Misma Ventana</option>
                            </select>
                        </div>
                        <div class="col ">
                            <select class="fs-13 mb-1" name="padre">
                                <option selected disabled>Menu Superior</option>
                                <?php $this->build_options("", "", $row["padre"]) ?>
                            </select>
                        </div>
                        <div class="col ">
                            <input type="text" class="fs-13 mb-1" placeholder="orden" name="orden" value="<?= $row["orden"] ?>">
                        </div>
                        <div class="col-auto ">
                            <select name="idioma" class="fs-13 mb-1">
                                <?php
                                foreach ($this->idiomas->list('', '', '') as $idioma) { ?>

                                    <option value="<?= $idioma['data']['cod'] ?>" <?= ($idioma['data']['cod'] == $row['idioma']) ? "selected" : '' ?>><?= $idioma['data']['titulo'] ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                        <div class="col ">
                            <?php
                            if ($this->checkIfHave($row['id'])) { ?>
                                <button type="button" onclick="$('.<?= $row['id'] ?>').toggle()" class="btn-small btn btn-info"><i class="fa fa-caret-down"></i></button>
                            <?php }  ?>
                            <button type="submit" name="update" class="btn-small btn btn-primary"><i class="fa fa-save"></i></button>
                            <a href="<?= URL_ADMIN ?>/index.php?op=menu&accion=ver&borrar=<?= $row["id"] ?>" class="btn-small btn btn-danger"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                </form>
            </div>

<?php
            $this->build_admin($row['id'], $margin + 20);
        }
        echo "</div>";
    }

    public function build_options($padre_id = "", $separador = "", $selected = "aa")
    {
        echo $selected;

        $r = array_filter($this->total, function ($value) use ($padre_id) {
            return $value['padre'] == $padre_id;
        });
        foreach ($r as $value) {
            $check_selected = ($selected == $value["id"]) ? "selected" : "";
            echo '<option value="' . $value["id"] . '" ' . $check_selected . ' >' . $separador . ' ' . $value["titulo"] . '</option>';
            $this->build_options($value['id'], $separador . "-", $selected);
        }
    }

    public function menuOptions($data, $subcat = false)
    {
        $options = '';
        $options .= $this->menuOptionsArea();
        foreach ($data as $categoria) {
            $link = strtolower($this->f->normalizar_link($categoria['data']['area'])) . "/c/" . $this->f->normalizar_link($categoria['data']['titulo']) . "/" . $categoria['data']['cod'];
            $options .= "<option value='" . $link . "'>" . $categoria['data']['titulo'] . "</option>";
            if ($subcat) {
                if (!empty($categoria["subcategories"])) {
                    $link = str_replace("/c/", "/s/", $link);
                    $options .= "<optgroup label='" . $categoria['data']['titulo'] . "'>";
                    foreach ($categoria['subcategories'] as $subcategoria) {
                        $linksub = $link . "/" . $this->f->normalizar_link($subcategoria['data']['titulo']) . "/" . $subcategoria['data']['cod'];
                        $options .= "<option value='" . $linksub . "'>" .  $categoria['data']['titulo'] . " - " . $subcategoria['data']['titulo'] . "</option>";
                    }
                    $options .= "</optgroup>";
                }
            }
        }
        return $options;
    }
    public function menuOptionsArea()
    {
        $categoryData = $this->categorias->listAreas('', '', '');        
        $options = '';
        foreach ($categoryData as $category) {
            $options .= "<option value='" . $category['data']['area'] . "#categorias" . "'>Categorias de " . $category['data']['area'] . "</option>";
            $options .= "<option value='" . $category['data']['area'] . "#subcategorias" . "'>Categorias y Subcategorias de " . $category['data']['area'] . "</option>";
        }
        return $options;
    }
    public function checkIfHave($id)
    {
        $sql = "SELECT * FROM `menu` WHERE padre = $id ORDER BY `orden` ASC";
        $query = $this->con->sqlReturn($sql);
        if ($query->num_rows) {
            return true;
        } else {
            return false;
        }
    }

    public function editSingle($atribute, $value)
    {
        $sql = "UPDATE `menu` SET $atribute = '$value' WHERE `id`={$this->id}";
        $query = $this->con->sql($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }
}
