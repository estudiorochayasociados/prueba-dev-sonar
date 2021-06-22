<?php
$admin = new Clases\Admin();

if (isset($_POST["agregar"])) {
    $admin->set("email", isset($_POST["email"]) ? $funciones->antihack_mysqli($_POST["email"]) : '');
    $admin->set("password", isset($_POST["pass"]) ? $funciones->antihack_mysqli($_POST["pass"]) : '');

    $admin->add();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=administradores");
}
?>

<div class="mt-20 card">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title text-uppercase text-center">
                Administradores
            </h4>
            <hr style="border-style: dashed;">
        </div>
        <div class="card-content">
            <div class="card-body">
                <form method="post" class="row" enctype="multipart/form-data">
                    <label class="col-md-6">Email:<br />
                        <input type="text" name="email" value="" required>
                    </label>
                    <label class="col-md-6">Contraseña:<br />
                        <input type="text" name="pass" required>
                    </label>
                    <br />
                    <div class="col-md-12 mt-20">
                        <input type="submit" class="btn btn-primary btn-block" name="agregar" value="Crear Administrador" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>