<link href="subir-archivos/css/style.css" rel="stylesheet" />
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body card-dashboard">
                    <a class="btn btn-primary" href="<?= URL_ADMIN ?>/index.php?op=subir-archivos&accion=ver-img"><i class="fa fa-cog"></i> Administrar imágenes</a>
                    <form id="upload" method="post" action="subir-archivos/upload.php" enctype="multipart/form-data">
                        <div id="drop">
                            Arrastrar imágenes aquí
                            <br />
                            <a>Buscar</a>
                            <input type="file" name="upl" multiple />
                        </div>

                        <ul>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="subir-archivos/js/script.js"></script>