<?php
$pedidos = new Clases\Pedidos();
$funciones = new Clases\PublicFunction();
$usuarios = new Clases\Usuarios();
$estadosPedidos  = new Clases\EstadosPedidos();
$detalles = new Clases\DetallePedidos();

$topTeenAprobado = $detalles->topBuy(3, 10);
$userData = $usuarios->userPurchases();
?>
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <h4 class="mt-20 pull-left">Top 10 productos mas vendidos</h4>
                        <div class="clearfix"></div>
                        <hr />
                        <div class="table-responsive">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table zero-configuration dataTable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                                <tr role="row">
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Codigo</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Titulo</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Cant. Vendida</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Cant. Pedidos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($topTeenAprobado as $dataTop) {
                                                ?>
                                                    <tr role="row" class="odd">
                                                        <td><?= $dataTop['data']['cod_producto'] ?></td>
                                                        <td><?= strtoupper($dataTop['data']['producto']) ?></td>
                                                        <td><?= $dataTop['data']['cantidad_vendida'] ?></td>
                                                        <td><?= $dataTop['data']['cantidad_pedidos'] ?></td>
                                                    </tr>
                                                <?php
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body card-dashboard">
                        <h4 class="mt-20 pull-left">Top usuarios con mas compras</h4>
                        <div class="clearfix"></div>
                        <hr />
                        <div class="table-responsive mb-100">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table zero-configuration dataTable" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                                <tr role="row">
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Nombre</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Cant. Pedidos</th>
                                                    <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">Gastado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($userData as $dataTop) {
                                                ?>
                                                    <tr role="row" class="odd">
                                                        <td><?= strtoupper($dataTop["user"]["data"]["nombre"] . ' ' . $dataTop["user"]["data"]["apellido"]) ?></td>
                                                        <td><?= $dataTop["data"]["cantidad_pedidos"] ?></td>
                                                        <td>$<?= $dataTop["data"]["cantidad_gastada"] ?></td>
                                                    </tr>
                                                <?php
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>