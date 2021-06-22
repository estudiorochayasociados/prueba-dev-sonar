<?php
$menu = new Clases\Menu(true);
$idiomas = new Clases\Idiomas();
$categorias = new Clases\Categorias();


// $categoryData = $categorias->list('', '', '',);


if (isset($_POST["update"])) {
    $menu->set("id", $_POST["id"]);
    foreach ($_POST as $key => $value) {
        if ($key == "update" || $key == "id") continue;
        $menu->editSingle($key, $value);
    }
    $funciones->headerMove(URL_ADMIN . "/index.php?op=menu");
}
?>

<div class="content-wrapper">
    <div class="content-body">
        <section class="users-list-wrapper">
            <div class="users-list-table">
                <h4 class="mt-20 pull-left">MENU</h4>
                <button class="btn btn-success pull-right text-uppercase mt-15 " onclick="$('#create').toggle()">
                    AGREGAR
                </button>
                <div class="clearfix"></div>

                <div class="card">
                    <div id="create" style="display:none">
                        <hr />
                        <?php

                        if (isset($_POST["create"])) {
                            foreach ($_POST as $key => $value) {
                                if ($key == "create") continue;
                                $menu->set($key, $value);
                            }
                            $menu->add();
                            $funciones->headerMove(URL_ADMIN . "/index.php?op=menu");
                        }
                        ?>
                        <form method="POST">
                            <div class="form-row align-items-center mb-0">
                                <div class="col">
                                    <input type="text" class="fs-13 mb-2" placeholder="titulo" name="titulo" required>
                                </div>

                                <!-- <input type="text" class="fs-13 mb-2" placeholder="link" name="link" required> -->
                                <div class="col form-group">
                                    <input type="text" list="link" name="link" />
                                    <!-- <datalist id="link" class="linkList" name="link" required>
                                        <? // $menu->menuOptions($categoryData) ?>
                                    </datalist> -->
                                </div>


                                <div class="col">
                                    <input type="text" class="fs-13 mb-2" placeholder="icono" name="icono">
                                </div>
                                <div class="col">
                                    <select class="fs-13 mb-2" name="target" required>
                                        <option value="_self">Misma Ventana</option>
                                        <option value="_blank">Nueva Ventana</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="fs-13 mb-2" name="padre" required>
                                        <option value="0" selected>Menu Superior</option>
                                        <?php $menu->build_options("", "", $row["padre"]) ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" class="fs-13 mb-2" placeholder="orden" name="orden" required>
                                </div>
                                <div class="col">
                                    <select name="idioma" class="fs-13 mb-2" required>
                                        <?php
                                        foreach ($idiomas->list('', '', '') as $idioma) { ?>
                                            <option <?= $idioma['data']['cod'] == 'es' ? 'Selected' : '' ?> value="<?= $idioma['data']['cod'] ?>"><?= $idioma['data']['titulo'] ?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <button type="submit" name="create" class="btn-small btn btn-primary mb-2"><i class="fa fa-save"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr />
                    <?php
                    $menu->build_admin("", 0);
                    ?>
                </div>
            </div>
        </section>
    </div>
</div>
<?php
if (isset($_GET["borrar"])) {
    $id = isset($_GET["borrar"]) ? $funciones->antihack_mysqli($_GET["borrar"]) : '';
    $menu->set("id", $id);
    $menu->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=menu");
}

?> 