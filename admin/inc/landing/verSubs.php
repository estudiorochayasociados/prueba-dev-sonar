<?php
$landing = new Clases\Landing();
$landingSubs = new Clases\LandingSubs();
$cod = isset($_GET["cod"]) ? $_GET["cod"] : '0';
$filter = array();
$landingRequestsArray = $landingSubs->list("landing_cod = '$cod'");
$landing->set("cod", $cod);
$landingData = $landing->view();
$landingSubs->set("landingCod", $cod);

$winner = $landingSubs->searchWinner();
if (isset($_POST["winner"])) {
    $limit = $funciones->antihack_mysqli(isset($_POST["winner"]) ? $_POST["winner"] : '');
    $ganador = $landingSubs->selectWinner($limit);
    foreach ($ganador as $key => $ganador_) {
        $landingSubs->set("id", $ganador_['id']);
        $landingSubs->set("ganador", $key + 1);
        $landingSubs->updateWinner();
    }
    $funciones->headerMove(URL_ADMIN . '/index.php?op=landing&accion=verSubs&cod=' . $cod);
}
if (isset($_POST["reset"])) {
    $landingSubs->resetWinner();
    $funciones->headerMove(URL_ADMIN . '/index.php?op=landing&accion=verSubs&cod=' . $cod);
}
?>


<div class="content-wrapper">
    <div class="content-body">
        <section class="users-list-wrapper">
            <div class="users-list-table">


                <h4 class="mt-20 pull-left">Peticiones</h4>
                <?php
                if (empty($winner) && empty($landingRequestsArray)) {
                ?>
                    <div class="dropdown pull-right">
                        <button class="btn btn-secondary pull-right glow  dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown">
                            Seleccionar Ganadores
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <form method="post" class="inline-block">
                                <input type="hidden" name="winner" value="1">
                                <button name="winner1" type="submit" style="background-color:#fff;border:none" class="mt-10 fs-16 ">
                                    Seleccionar 1 Ganador
                                </button>
                            </form>
                            <form method="post" class="inline-block">
                                <input type="hidden" name="winner" value="2">
                                <button name="winner2" type="submit" style="background-color:#fff;border:none" class="mt-10 fs-16 ">
                                    Seleccionar 2 Ganadores
                                </button>
                            </form>
                            <form method="post" class="inline-block">
                                <input type="hidden" name="winner" value="3">
                                <button name="winner3" type="submit" style="background-color:#fff;border:none" class="mt-10 fs-16 ">
                                    Seleccionar 3 Ganadores
                                </button>
                            </form>
                            <form method="post" class="inline-block">
                                <input type="hidden" name="winner" value="4">
                                <button name="winner4" type="submit" style="background-color:#fff;border:none" class="mt-10 fs-16">
                                    Seleccionar 4 Ganadores
                                </button>
                            </form>
                            <form method="post" class="inline-block">
                                <input type="hidden" name="winner" value="5">
                                <button name="winner5" type="submit" style="background-color:#fff;border:none" class="mt-10 fs-16">
                                    Seleccionar 5 Ganadores
                                </button>
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>
                <hr />

                <?php
                if (!empty($winner)) {
                ?>
                    <div class="alert alert-success text-center">
                        <?php
                        if (@count($winner) == 1) {
                            echo "<h2>Ganador/a:</h2><br>";
                        } else {
                            echo "<h2>Ganadores/as:</h2><br>";
                        }
                        foreach ($winner as $winner_) {
                        ?>
                            <div class="inline-block mr-10 text-center">
                                <h5><?= $winner_['ganador'] ?>º</h5>
                                <b>Nombre: </b><?= $winner_['nombre'] . ' ', $winner_['apellido'] ?><br>
                                <b>Email: </b><?= $winner_['email'] ?><br>
                                <b>Celular: </b><?= $winner_['celular'] ?><br>
                                <b>DNI: </b><?= $winner_['dni'] ?><br>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="mt-10" style="text-align: right">
                            <form method="post">
                                <button name="reset" type="submit" class="btn btn-warning ml-10">
                                    REINICIAR
                                </button>
                            </form>
                        </div>
                    </div>
                <?php
                }
                ?>

                <div class="clearfix"></div>
                <hr />
                <fieldset class="form-group position-relative has-icon-left mb-20">
                    <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
                    <div class="form-control-position">
                        <i class="bx bx-search"></i>
                    </div>
                </fieldset>
                <div class="clearfix"></div>
                <hr />

                <br>
                <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
                <hr />
                <table class="table  table-bordered  ">
                    <thead>
                        <th>
                            Landing
                        </th>
                        <th>
                            Nombre
                        </th>
                        <th>
                            Apellido
                        </th>
                        <th>
                            Celular
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Dni
                        </th>
                        <th>
                            Fecha
                        </th>
                    </thead>
                    <tbody>
                        <?php
                        if (is_array($landingRequestsArray)) {
                            for ($i = 0; $i < count($landingRequestsArray); $i++) {
                                echo "<tr>";
                                echo "<td>" . strtoupper($landingData['data']["titulo"]) . "</td>";
                                echo "<td>" . strtoupper($landingRequestsArray[$i]["nombre"]) . "</td>";
                                echo "<td>" . strtoupper($landingRequestsArray[$i]["apellido"]) . "</td>";
                                echo "<td>" . strtoupper($landingRequestsArray[$i]["celular"]) . "</td>";
                                echo "<td>" . strtoupper($landingRequestsArray[$i]["email"]) . "</td>";
                                echo "<td>" . strtoupper($landingRequestsArray[$i]["dni"]) . "</td>";
                                echo "<td>" . strtoupper($landingRequestsArray[$i]["fecha"]) . "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
        </section>
    </div>
</div>