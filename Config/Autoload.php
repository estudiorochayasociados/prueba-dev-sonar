<?php

namespace config;

use Clases\Idiomas;

require dirname(__DIR__) . '/vendor/autoload.php';

class autoload
{
    private static $project = '/estudio_rocha_tarde';
    private static $title = 'Estudio Rocha . Consultora de Empresas';
    private static $titleAdmin = 'ESTUDIO ROCHA CMS';
    private static $protocol = 'https';
    private static $logo = '/assets/images/logo.png';
    private static $favicon = '/assets/images/favicon.png';
    private static $salt = 'salt@estudiorochayasoc.com.ar';



    public static function run()
    {
        #Se carga las configuraciones

        #Se importa librerías
        // require_once dirname(__DIR__) . "/Config/Minify.php";
 
        #Variables Globales
        define('SALT', hash("sha256", self::$salt));
        define('URL', self::$protocol . "://" . $_SERVER['HTTP_HOST'] . self::$project);
        define('URL_ADMIN', self::$protocol . "://" . $_SERVER['HTTP_HOST'] . self::$project . "/admin");
        define('TITULO_ADMIN', self::$titleAdmin);
        define('CANONICAL', self::$protocol . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        define('LOGO', URL . self::$logo);
        define('FAVICON', URL . self::$favicon);
        define('TITULO', self::$title);

        #Autoload
        spl_autoload_register(
            function ($clase) {
                $ruta = str_replace("\\", "/", $clase) . ".php";
                $pos = strpos($ruta, "Clases");
                if ($pos !== false) {
                    include_once dirname(__DIR__) . "/" . $ruta;
                }
            }
        );

        self::settings();
    }

    public static function settings()
    {
        #Se configura la zona horaria en Argentina
        setlocale(LC_ALL, 'es_RA.UTF-8');
        date_default_timezone_set('America/Argentina/Buenos_Aires');

        #Se mantiene siempre la sesión iniciada
        session_start();

        #Se define el idioma de la pagina
        $idioma = new Idiomas();

        $_SESSION["lang"] = isset($_SESSION["lang"]) ? $_SESSION["lang"]  : $idioma->viewDefault()['data']['cod'];
        if (isset($_SESSION["usuarios"]["idioma"])) $_SESSION["lang"] = $_SESSION["usuarios"]["idioma"];


        $_SESSION["defaultLang"] = isset($_SESSION["defaultLang"]) ? $_SESSION["defaultLang"]  : $idioma->viewDefault()['data']['cod'];
        $_SESSION["lang-txt"] = json_decode(file_get_contents(dirname(__DIR__) . '/lang/' . $_SESSION["lang"] . '.json'), true);
        $_SESSION["cod_pedido"] = isset($_SESSION["cod_pedido"]) ? $_SESSION["cod_pedido"] : strtoupper(substr(md5(uniqid(rand())), 0, 7));
        !isset($_SESSION['token']) ? $_SESSION['token'] = md5(uniqid(rand(), TRUE)) : null;
    }
}
