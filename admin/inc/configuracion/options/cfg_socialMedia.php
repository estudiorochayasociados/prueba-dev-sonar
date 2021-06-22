<?php
if (isset($_POST["agregar-redes"])) {
    $config->set("facebook", isset($_POST["s-facebook"]) ? $funciones->antihack_mysqli($_POST["s-facebook"]) : '');
    $config->set("twitter", isset($_POST["s-twitter"]) ? $funciones->antihack_mysqli($_POST["s-twitter"]) : '');
    $config->set("instagram", isset($_POST["s-instagram"]) ? $funciones->antihack_mysqli($_POST["s-instagram"]) : '');
    $config->set("linkedin", isset($_POST["s-linkedin"]) ? $funciones->antihack_mysqli($_POST["s-linkedin"]) : '');
    $config->set("youtube", isset($_POST["s-youtube"]) ? $funciones->antihack_mysqli($_POST["s-youtube"]) : '');
    $config->set("googleplus", isset($_POST["s-google"]) ? $funciones->antihack_mysqli($_POST["s-google"]) : '');
    $error = $config->addSocial();
    if ($error) {
        $funciones->headerMove(URL_ADMIN . '/index.php?op=configuracion&accion=modificar&tab=social-tab');
    } else {
        echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
    }
}
?>
<div class=" ">
    <div class="content-body">
        <section class="users-list-wrapper">
            <div class="users-list-table">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body ">
                            <form method="post" action="<?= URL_ADMIN ?>/index.php?op=configuracion&accion=modificar&tab=social-tab">
                                <div class="row">
                                    <label class="col-md-12">
                                        Facebook:<br />
                                        <input type="text" class="form-control" name="s-facebook" value="<?= $socialData['data']["facebook"] ? $socialData['data']["facebook"] : '' ?>" />
                                    </label>
                                    <label class="col-md-12">
                                        Twitter:<br />
                                        <input type="text" class="form-control" name="s-twitter" value="<?= $socialData['data']["twitter"] ? $socialData['data']["twitter"] : '' ?>" />
                                    </label>
                                    <label class="col-md-12">
                                        Instragram:<br />
                                        <input type="text" class="form-control" name="s-instagram" value="<?= $socialData['data']["instagram"] ? $socialData['data']["instagram"] : '' ?>" />
                                    </label>
                                    <label class="col-md-12">
                                        Linkedin:<br />
                                        <input type="text" class="form-control" name="s-linkedin" value="<?= $socialData['data']["linkedin"] ? $socialData['data']["linkedin"] : '' ?>" />
                                    </label>
                                    <label class="col-md-12">
                                        YouTube:<br />
                                        <input type="text" class="form-control" name="s-youtube" value="<?= $socialData['data']["youtube"] ? $socialData['data']["youtube"] : '' ?>" />
                                    </label>
                                    <label class="col-md-12">
                                        Google Plus:<br />
                                        <input type="text" class="form-control" name="s-google" value="<?= $socialData['data']["googleplus"] ? $socialData['data']["googleplus"] : '' ?>" />
                                    </label>
                                    <div class="col-md-12 mt-20">
                                        <button class="btn btn-primary btn-block" type="submit" name="agregar-redes">Guardar cambios</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>