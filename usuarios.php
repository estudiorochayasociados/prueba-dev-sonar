<?php
require_once "Config/Autoload.php";
Config\Autoload::run();

$template = new Clases\TemplateSite();
$f = new Clases\PublicFunction();
$contenido = new Clases\Contenidos();
$config = new Clases\Config();
$usuario = new Clases\Usuarios();
$enviar = new Clases\Email();

#Se carga la sesión del usuario
$userData = $usuario->viewSession();

$link = (isset($_GET["link"])) ? $f->antihack_mysqli($_GET["link"]) : '#';

#Comprueba si existe la sesión
if (!empty($userData)) {
    #Si existe y es un usuario registrado, lo redirige a su panel
    if ($userData["invitado"] == 0) {
        $f->headerMove(URL . '/sesion');
    }
    #Si existe y es un usuario invitado, lo redirige a usuarios para loguearse o registrarse
    if ($userData["invitado"] == 1) {
        $usuario->logout();
        $f->headerMove(URL . '/usuarios');
    }
}
#Se carga la configuración de email
$emailData = $config->viewEmail();
$captchaData = $config->viewCaptcha();
#Información de cabecera
$template->set("title", 'Acceso de usuarios | ' . TITULO);
$template->set("description", "Accedé con tu cuenta o registráte para empezar a comprar en nuestra tienda online.");
$template->set("keywords", "acceso de usuarios, login, registrarse, usuarios");
$template->themeInit();
?>
<nav class="breadcrumb-section theme1 padding-custom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <h2 class="title fs-20 pb-4 text-dark text-capitalize">
                        <?= $_SESSION["lang-txt"]["general"]["usuarios"] ?>
                    </h2>
                </div>
            </div>
            <div class="col-12">
                <ol class="breadcrumb bg-transparent m-0 p-0 align-items-center justify-content-center">
                    <li class="breadcrumb-item"><a href="<?= URL ?>"><?= $_SESSION["lang-txt"]["general"]["inicio"] ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= $_SESSION["lang-txt"]["general"]["usuarios"] ?>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</nav>
<div id="content" class="site-content mt-50 mb-50" tabindex="-1">
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 ">
                    <div class="box">
                        <div class="search-filter">
                            <div class="sidbar-widget pt-0">
                                <h4 class="title fs-20"><?= $_SESSION["lang-txt"]["usuarios"]["ingresar"] ?></h4>
                            </div>
                        </div>
                        <div id="l-error"></div>
                        <form id="login" data-url="<?= URL ?>" data-link="<?= $link ?>" data-type="usuarios" data-captcha="<?= $captchaData["data"]["captcha_key"]  ?>">
                            <input name="link" type="hidden" value="<? ?>">
                            <input name="captcha-response" type="hidden" value="">
                            <input class="form-control" type="hidden" name="stg-l" value="1">
                            <div class="form-fild">
                                <input class="form-control" placeholder="<?= $_SESSION["lang-txt"]["usuarios"]["email"] ?>" name="l-user" value="" type="email" required>
                            </div>
                            <div class="form-fild mt-20 ">
                                <input class="form-control" placeholder="<?= $_SESSION["lang-txt"]["usuarios"]["password"] ?>" name="l-pass" id="l-pass" value="" type="password" required>
                            </div>
                            <div id="btn-l" class="login-submit mt-20 mb-10">
                                <button class="btn btn-secondary btn-lg g-recaptcha" data-sitekey="<?= $captchaData["data"]["captcha_key"] ?>" data-callback='loginUser' data-action='submit'>INGRESAR</button>
                            </div>
                            <div class="lost-password">
                                <a href="<?= URL ?>/recuperar"><?= $_SESSION["lang-txt"]["usuarios"]["olvidaste_password"] ?></a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-8 col-sm-8">
                    <div class="box">
                        <div class="search-filter">
                            <div class="sidbar-widget pt-0">
                                <h4 class="title"><?= $_SESSION["lang-txt"]["usuarios"]["registro"] ?></h4>
                            </div>
                        </div>
                        <div id="r-error"></div>
                        <form id="register" data-url="<?= URL ?>" data-type="usuarios" data-link="<?= $link ?>" data-captcha="<?= $captchaData["data"]["captcha_key"]  ?>">
                            <input name="captcha-response" type="hidden" value="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-fild">
                                        <input class="form-control" placeholder="<?= $_SESSION["lang-txt"]["usuarios"]["nombre"] ?>" name="r-nombre" value="" type="text" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-20">
                                    <div class="form-fild">
                                        <input class="form-control" placeholder="<?= $_SESSION["lang-txt"]["usuarios"]["apellido"] ?>" name="r-apellido" value="" type="text" required>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-20">
                                    <div class="form-fild">
                                        <input class="form-control" placeholder="<?= $_SESSION["lang-txt"]["usuarios"]["email"] ?>" name="r-email" value="" type="email" required>
                                    </div>
                                </div>
                                <div class="mt-20 col-md-6">
                                    <div class="form-fild">
                                        <input class="form-control" placeholder="<?= $_SESSION["lang-txt"]["usuarios"]["password"] ?>" name="r-password1" value="" type="password" required>
                                    </div>
                                </div>
                                <div class="mt-20 col-md-6">
                                    <div class="form-fild">
                                        <input class="form-control" placeholder="<?= $_SESSION["lang-txt"]["usuarios"]["re_password"] ?>" name="r-password2" value="" type="password" required>
                                    </div>
                                </div>
                                <div class="mt-20 col-md-6">
                                    <div class="form-fild">
                                        <input class="form-control" placeholder="<?= $_SESSION["lang-txt"]["usuarios"]["direccion"] ?>" name="r-direccion" value="" type="text" required>
                                    </div>
                                </div>
                                <div class="mt-20 col-md-6">
                                    <div class="form-fild">
                                        <input class="form-control" placeholder="<?= $_SESSION["lang-txt"]["usuarios"]["telefono"] ?>" name="r-telefono" value="" type="text" required>
                                    </div>
                                </div>
                                <div class="col-md-6 widget-list mt-20">
                                    <div class="billing-select mb-20px">
                                        <select id='provincia' data-url="<?= URL ?>" class="form-select mb-3" name="provincia" required>
                                            <option value="" selected><?= $_SESSION["lang-txt"]["usuarios"]["provincia"] ?></option>
                                            <?php $f->provincias(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 widget-list mb-10 ">
                                    <div class="billing-select mb-20px">
                                        <select id='localidad' class="form-select mb-3" name="localidad" required>
                                            <option value="" selected><?= $_SESSION["lang-txt"]["usuarios"]["localidad"] ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="btn-r" class="register-submit mt-10 mb-10">
                                <button class="g-recaptcha btn btn-secondary btn-lg" data-sitekey="<?= $captchaData["data"]["captcha_key"] ?>" data-callback='registerUser' data-action='submit'><?= $_SESSION["lang-txt"]["usuarios"]["registro"] ?></button>
                            </div>
                        </form>
                        <br />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Login Register section end-->
<?php $template->themeEnd(); ?>