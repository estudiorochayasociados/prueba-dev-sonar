<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
$template = new Clases\TemplateSite();

$f = new Clases\PublicFunction();
$checkout = new Clases\Checkout();
$carrito = new Clases\Carrito();
$config = new Clases\Config();

$link = (!empty($_SESSION['usuarios'])) ? $checkout->checkSkip($_SESSION['usuarios']['minorista']) : '';

#Redireccionar al carrito si no se abrieron los stages (en carrito se abren los stages)
if (empty($_SESSION['stages'])) {
    $f->headerMove(URL . '/carrito');
} else {
    #Revisar si hay un usuario ya sea invitado o no
    if (!empty($_SESSION['usuarios'])) {

        #Si por alguna razón no se guardo el user_cod, se guarda
        if (empty($_SESSION['stages']['user_cod'])) {
            $checkout->user($_SESSION['usuarios']['cod'], 'USER');
            #Si ya tiene guardado el user_cod, se redirecciona a shipping
        } else {
            $f->headerMove(URL . "/" . $link);
        }
    }
}

#Variable que almacena el progeso de los stages
$progress = $checkout->progress();

$captchaData = $config->viewCaptcha();
#Información de cabecera
$template->set("title", 'Identificación | ' . TITULO);
$template->themeInitStages();
?>
<div class="checkout-estudiorocha">
    <?php
    if (!empty($_SESSION['stages'])) {

        if (empty($_SESSION['stages']['user_cod'])) {
    ?>
            <div class="container mt-40">
                <div class="row">
                    <div class="col-md-4 col-sm-4 ">
                        <div class="box mb-40 ">
                            <div class="text-center">
                                Si estás interesado en comprar sin necesidad de crear una cuenta, hacé click en el siguiente botón.
                                <br />
                                <i class="fa fa-arrow-down"></i>
                                <br />
                                <a href="<?= URL ?>/checkout/shipping" style="line-height: 2.333333;" class="fs-20 btn btn-primary btn-lg btn-block">COMPRAR COMO INVITADO</a>
                            </div>
                            <hr />
                        </div>
                        <div class="box">
                            <div class="search-filter">
                                <div class="sidbar-widget pt-0">
                                    <h4 class="title fs-20"><?= $_SESSION["lang-txt"]["usuarios"]["ingresar"] ?></h4>
                                </div>
                            </div>
                            <div id="l-error"></div>
                            <form id="login" data-url="<?= URL ?>" data-link="<?= CANONICAL ?>" data-type="usuarios" data-captcha="<?= $captchaData["data"]["captcha_key"]  ?>">
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
                        <div class="box mb-40">
                            <div class="search-filter">
                                <div class="sidbar-widget pt-0">
                                    <h4 class="title"><?= $_SESSION["lang-txt"]["usuarios"]["registro"] ?></h4>
                                </div>
                            </div>
                            <div id="r-error"></div>
                            <form id="register" data-url="<?= URL ?>" data-type="stages" data-captcha="<?= $captchaData["data"]["captcha_key"]  ?>" onsubmit="registerUser()">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-fild mb-12">
                                            <span><label><?= $_SESSION["lang-txt"]["usuarios"]["nombre"] ?> <span class="required">*</span></label></span>
                                            <input class="form-control" name="r-nombre" value="" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-fild mb-12">
                                            <span><label><?= $_SESSION["lang-txt"]["usuarios"]["apellido"] ?> <span class="required">*</span></label></span>
                                            <input class="form-control" name="r-apellido" value="" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-fild mb-12">
                                            <span><label><?= $_SESSION["lang-txt"]["usuarios"]["email"] ?> <span class="required">*</span></label></span>
                                            <input class="form-control" name="r-email" value="" type="email" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-fild mb-12">
                                            <span><label><?= $_SESSION["lang-txt"]["usuarios"]["password"] ?> <span class="required">*</span></label></span>
                                            <input class="form-control" name="r-password1" value="" type="password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-fild mb-12">
                                            <span><label><?= $_SESSION["lang-txt"]["usuarios"]["re_password"] ?> <span class="required">*</span></label></span>
                                            <input class="form-control" name="r-password2" value="" type="password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-fild mb-12">
                                            <span><label><?= $_SESSION["lang-txt"]["usuarios"]["direccion"] ?> <span class="required">*</span></label></span>
                                            <input class="form-control" name="r-direccion" value="" type="text" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-fild mb-12">
                                            <span><label><?= $_SESSION["lang-txt"]["usuarios"]["telefono"] ?> <span class="required">*</span></label></span>
                                            <input class="form-control" name="r-telefono" value="" type="text" required>
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
                                    <div class="col-md-6 widget-list  mt-20">
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
    <?php
        } else {
            $f->headerMove(URL . "/" . $link);
        }
    } else {
        $f->headerMove(URL . '/carrito');
    }
    ?>
</div>
<?php
$template->themeEndStages();
?>

<script src="<?= URL ?>/assets/js/services/user.js"></script>