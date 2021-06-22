<?php

namespace Clases;

use PhpOffice\PhpSpreadsheet\Helper\Html as HtmlHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


class Excel
{
    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
        $this->f = new PublicFunction();
        $this->usuarios = new Usuarios();
        $this->atributo = new Atributos();
        $this->subatributo = new Subatributos();
    }

    public function import($table)
    {
        if (!empty($table)) {
            // Identifico extencion del excel, lo leo y lo guardo en una variable.
            $spreadsheet = new Spreadsheet();
            $inputFileType = IOFactory::identify($_FILES['excel']['tmp_name']);
            $reader = IOFactory::createReader($inputFileType);
            $spreadsheet = $reader->load($_FILES['excel']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            // Extraigo del excel la primer fila con los nombres de las variables para luego.
            $attr = array_shift($sheetData);

            // Busco keys especificas para validar que tipo de excel se importo.
            $keyTitle = array_search('titulo', $attr);
            $keyCat = array_search('categoria', $attr);
            $keySubCat = array_search('subcategoria', $attr);
            $keyEmail = array_search('email', $attr);
            $keyPassword = array_search('password', $attr);
            $keyIdioma = array_search('idioma', $attr);
            $keyVar1 = array_search('variable1', $attr);

            foreach ($sheetData as $key => $data) {
                if (!empty($data[$keyTitle]) || !empty($data[$keyEmail])) {

                    // Si tiene categoria/subcategoria busca por titulo, si lo encuentra me devuelve el codigo sino crea una nueva y me devuelve el nuevo cod.
                    if ($keyCat || $keySubCat) {
                        $cod_cat = $this->checkCategory("categorias", $data[$keyCat], $table, $data[$keyIdioma]);
                        $cod_subCat = $this->checkCategory("subcategorias", $data[$keySubCat], $cod_cat);
                        $data = array_replace($data, [$keyCat => $cod_cat, $keySubCat => $cod_subCat]);
                    }
                    // $atributoVal = explode("|", $data[$keyVar1]);
                    $newCod = substr(md5(uniqid(rand())), 0, 10);
                    // //elimina todos los atributos del producto
                    // $this->atributo->checkAndDelete((isset($data["A"]) && $data["A"] != "NULL") ? $data["A"] : $newCod);
                    // if (isset($atributoVal) && !empty($atributoVal)) {
                    //     foreach ($atributoVal as $atributoItem) {
                    //         $attr_ = explode(":", $atributoItem);
                    //         if (isset($attr_) && !empty($attr_)) {
                    //             //se crea el atributo
                    //             $codAtributo = substr(md5(uniqid(rand())), 0, 10);
                    //             $this->atributo->set("productoCod", (isset($data["A"]) && $data["A"] != "NULL") ? $data["A"] : $newCod);
                    //             $this->atributo->set("cod", $codAtributo);
                    //             $this->atributo->set("value", $attr_[0]);
                    //             if ($this->atributo->add()) {
                    //                 //se crea el sub atributo
                    //                 $subAtributoVal = explode("_", $attr_[1]);
                    //                 if (isset($subAtributoVal) && !empty($subAtributoVal)) {
                    //                     foreach ($subAtributoVal as $subAttr_) {
                    //                         $codSubatributo = substr(md5(uniqid(rand())), 0, 10);
                    //                         $this->subatributo->set("cod", $codSubatributo);
                    //                         $this->subatributo->set("codAtributo", $codAtributo);
                    //                         $this->subatributo->set("value", $subAttr_);
                    //                         $this->subatributo->add();
                    //                     }
                    //                 }
                    //             }
                    //         }
                    //     }
                    // }
                    // Valida que el email no este en uso
                    // Si el email esta en uso en otra cuenta, salto la fila y si corresponde a la misma cuenta lo edita
                    if ($keyEmail) {
                        $validate = $this->validateEmail($data[$keyEmail], $data['A']);
                        if (!$validate['status']) {
                            echo $validate['message'];
                            continue;
                        }
                    }

                    foreach ($data as $key_ => $value) {
                        if (is_string($value) && $data[$key_] != $data['A']) {
                            $data[$key_] = "'" . $value . "'";
                        }
                        if ($value == '') {
                            $data[$key_] = "NULL";
                        }
                    }

                    if ($this->view($table, $attr['A'], $data['A'])) { // Busco por codigo
                        $data['A'] = "'" . $data['A'] . "'";
                        $value = array_combine($attr, $data);
                        if ($this->edit($table, $value)) { // Si lo encuentro edito 
                            echo  $data['A'] . " - editado<hr>";
                        } else {
                            echo "ocurrio un error edit<hr>";
                        }
                    } else { // Sino agrego
                        $cod = array('A' => $newCod);
                        $data = array_replace($data, $cod);
                        $data['A'] = "'" . $data['A'] . "'";
                        if ($keyEmail) { // valido si es una tabla de usuarios
                            $data[] = 0; // Defino que no es usuario invitado porque en la base de datos esta prdefinido que se cargue como invitado.
                            if ($keyPassword) { // si se cargo un password en el excel lo hashea sino genera uno nuevo.
                                if (empty($data[$keyPassword])) {
                                    $data[$keyPassword] = "'" . hash('sha256', $this->generatePassword($data[$keyEmail]) . SALT) . "'";
                                } else {
                                    $data[$keyPassword] = "'" . hash('sha256', $data[$keyPassword] . SALT) . "'";
                                }
                            } else {
                                $data[] = "'" . hash('sha256', $this->generatePassword($data[$keyEmail]) . SALT) . "'";
                            }
                        }
                        $arrayAdd[$key] =  implode(" , ", $data); // Uno todos los datos que se van a crear en un solo string.
                    }
                }
            }
            if (isset($arrayAdd)) { // Valido si existen datos para agregar.
                if ($keyEmail) { // Genero atributo de invitado y si no existe el de contraseña.
                    $attr[] = "invitado";
                    if (!$keyPassword) {
                        $attr[] = "password";
                    }
                }
                if ($this->add($table, $attr, $arrayAdd)) { // Envio una sola peticion con todo lo que hay que agregar
                    echo "<hr>";
                    echo "Se agregaron " . count($arrayAdd) . " " . ucfirst($table) . " en el sistema.";
                } else {
                    echo "Ocurrio un error al agregar " . $table;
                }


                echo "<hr/>";
            }
        }
    }



    public function export($table, $attr)
    {
        if (!empty($table) && !empty($attr)) {
            array_unshift($attr, "cod"); // Forzamos el campo de COD para luego poder importar 

            $spreadsheet = new Spreadsheet();
            $wizard = new HtmlHelper();
            $data = $this->listExport($table, $attr); // Listo los datos segun la tabla y los atributos que pase de la vista

            // Genero ruta y nombre del excel a exportar 
            $folder = "../export/$table/";
            $filename = "Lista de " . ucfirst($table) . " " . date("d-m-Y");
            $finalPath = $folder . $filename . '.xlsx';

            //Defino las propiedades del documento
            $spreadsheet->getProperties()->setCreator('Estudio Rocha & Asoc.')
                ->setLastModifiedBy(TITULO)
                ->setTitle($filename)
                ->setSubject($filename)
                ->setDescription('Listado de ' . $table)
                ->setKeywords($filename . ' , ' . $table)
                ->setCategory($table);



            $letter = 'A';
            // Tomo los attr que pase desde la vista y los recorro generando la primer fila del excel.
            foreach ($attr as $attr_) {
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue($letter . '1', $attr_);
                $letter++;
            }
            $rowCount = 2;
            // Recorro los datos que traje de la base de datos
            foreach ($data as $value) {
                $letter = 'A';
                foreach ($value['data'] as $key => $val) {
                    if ($key != "password") { // Evito que me extraiga los datos de la contraseña si es la tabla de usuarios. Para que quede el campo vacio por si la desean modificar.
                        if ($key == "desarrollo") { // Si el attr es Desarrollo genera la celda con un poco mas de formato.
                            $richText = $wizard->toRichTextObject(isset($val) ? $val : '');
                            $spreadsheet->getActiveSheet()
                                ->setCellValue($letter . $rowCount, $richText);
                            $spreadsheet->getActiveSheet()
                                ->getColumnDimension($letter)
                                ->setWidth(60);
                            $spreadsheet->getActiveSheet()
                                ->getRowDimension(1)
                                ->setRowHeight(-1);
                            $spreadsheet->getActiveSheet()->getStyle($letter . $rowCount)
                                ->getAlignment()
                                ->setWrapText(true);
                        } else { // Sino agrega la celda simple
                            $spreadsheet->setActiveSheetIndex(0)
                                ->setCellValue($letter . $rowCount, isset($val) ? $val : '');
                        }
                    }
                    $letter++;
                }
                $rowCount++;
            }

            // Defino nombre y hoja del excel
            $spreadsheet->getActiveSheet()->setTitle($table);
            $spreadsheet->setActiveSheetIndex(0);

            // Genero extencion del excel, Guardo el archivo en el servidor y fuerzo que se descargue.
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save($finalPath);
            $this->f->headerMove($finalPath);
        }
    }

    function listExport($table, $attr)
    {
        // Si existe "categoria" o "Subcategoria" agrega el left join correspondiente para que me traiga solo el titulo y agilizar la consulta
        if (in_array('categoria', $attr)) {
            $join_data = $this->f->leftJoin($table, "categorias", "cod", "categoria", "titulo");
            // Genero el atributo "categorias.titulo" con uan bandera de "%" que me servira mas abajo y lo cambio por el atrr categoria que me devolveria el cod.
            $replace = [array_search('categoria', $attr) => "%" . $join_data['show']];
            $attr = array_replace($attr, $replace);
            // guardo en un array el LEFT JOIN
            $join[] = $join_data['join'];
        }
        if (in_array('subcategoria', $attr)) {
            $join_data = $this->f->leftJoin($table, "subcategorias", "cod", "subcategoria", "titulo");
            $replace = [array_search('subcategoria', $attr) => "%" . $join_data['show']];
            $attr = array_replace($attr, $replace);
            $join[] = $join_data['join'];
        }

        // Genero en 1 string cada atributo que me va a traer con su respectiva tabla. Para no generar conflicto ambiguo en la base de datos

        $attr = implode(" , " . $table . ".", $attr);
        if (!empty($join)) {
            $join =  implode(" ", $join);
            // Elimino la tabla principal con la bandera que puse antes de categoria y subcategoria, sino quedaria ej: "productos.categorias.titulo".
            $attr = str_replace("$table.%", "", $attr);
        } else {
            $join = '';
        }

        $sql = "SELECT $table.$attr FROM $table $join";

        $var = $this->con->sqlReturn($sql);
        if ($var) {
            while ($row = mysqli_fetch_assoc($var)) {
                $array[] = ["data" => $row];
            }
        }
        return $array;
    }

    public function add($table, $attr, $values)
    {
        $attr =  (is_array($attr)) ? implode(",", $attr) : $attr;
        $values =  (is_array($values)) ? implode(") , (", $values) : $values;

        $sql = "INSERT INTO $table ($attr) VALUES ($values)";
        $query = $this->con->sqlReturn($sql);
        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    function edit($table, $attr)
    {
        if (!isset($attr["password"])) {
            unset($attr["password"]);
        }

        foreach ($attr as $key => $value) {
            if ($key == "password") {
                $data[$key] = "`" . $key . "` = '" . hash('sha256', $value . SALT) . "'";
            } else {
                $data[$key] = "`" . $key . "` = " . $value;
            }
        }


        $cod = array_shift($data);
        $attr =  implode(" , ", $data);

        $sql = "UPDATE $table SET $attr WHERE $cod";
        if ($this->con->sqlReturn($sql)) {
            return true;
        } else {
            return false;
        }
    }

    function editSimple($table, $attr, $cod)
    {
        $sql = "UPDATE $table SET $attr WHERE $cod";

        if ($this->con->sqlReturn($sql)) {
            return true;
        } else {
            return false;
        }
    }

    function view($table, $attr, $value)
    {
        $sql = "SELECT `$table`.`$attr` FROM `$table` WHERE `$attr` = '$value'";
        $var = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($var);
        return $row;
    }

    function checkCategory($table, $title, $value, $idioma = '')
    {
        $search = ($table == "categorias") ? "titulo = '$title' AND area = '$value' AND idioma = '$idioma'"  : "titulo = '$title' AND categoria = '$value'";
        $sql = "SELECT $table.cod FROM $table WHERE $search";
        $query = $this->con->sqlReturn($sql);
        $rowSearch = mysqli_fetch_assoc($query);
        if (!empty($rowSearch)) {
            $cod = $rowSearch['cod'];
        } else {
            $cod = substr(md5(uniqid(rand())), 0, 11);
            $attr = ($table == "categorias") ? "cod , titulo , area , descripcion" : "cod , titulo , categoria";
            $values = ($table == "categorias") ? "'$cod', '$title', '$value', NULL " : "'$cod', '$title', '$value'";
            $this->add($table, $attr, $values);
        }
        return $cod;
    }


    function validateEmail($email, $cod)
    {
        $this->usuarios->set("email", $email);
        $validate = $this->usuarios->validate();

        if (!$validate['status']) {
            $return = array("status" => true);
        } else {
            if ($validate['data']['cod'] == $cod) {
                $return = array("status" => true, "message" => "Edit");
            } else {
                $return = array("status" => false, "message" => "El email " . $email . " ya se encuentra en uso en la cuenta de: " . $validate['data']['nombre'] . " " . $validate['data']['apellido'] . ".<hr>");
            }
        }
        return $return;
    }

    function generatePassword($email)
    {
        $arrayEmail = explode("@", $email);
        $pass1 = substr($arrayEmail[0], 0, 2);
        $pass2 = ucfirst(substr($arrayEmail[1], 0, 2));
        $password = $pass1 . $pass2 . date("Y");

        return $password;
    }
}
