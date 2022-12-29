<?php

namespace config;

//require dirname(__DIR__) . '/vendor/autoload.php';

class autoload
{

    private static $project = '/everwear';
    private static $title = 'Ever Wear';
    private static $titleAdmin = 'ESTUDIO ROCHA CMS';
    private static $protocol = 'https';
    private static $logo = '/assets/img/logo.png';
    private static $salt = 'salt@estudiorochayasoc.com.ar';

    public static function runSitio()
    {
        #Se carga las configuraciones
        self::settings();

        #Se importa librerías
        //require_once dirname(__DIR__) . "/Config/Minify.php";
        require dirname(__DIR__) . '/vendor/autoload.php';

        #Variables Globales
        define('SALT', hash("sha256", self::$salt));
        define('URL', self::$protocol . "://" . $_SERVER['HTTP_HOST'] . self::$project);
        define('URL_ADMIN', self::$protocol . "://" . $_SERVER['HTTP_HOST'] . self::$project . "/admin");
        define('TITULO_ADMIN', self::$titleAdmin);
        define('CANONICAL', self::$protocol . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        define('LOGO', URL . self::$logo);
        define('FAVICON', URL . self::$logo);
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
    }

    public static function settings()
    {
        #Se configura la zona horaria en Argentina
        setlocale(LC_ALL, 'es_AR');
        date_default_timezone_set('America/Argentina/Buenos_Aires');

        #Se mantiene siempre la sesión iniciada
        session_start();

        #Se genera el código de pedido
        $_SESSION["cod_pedido"] = isset($_SESSION["cod_pedido"]) ? $_SESSION["cod_pedido"] : strtoupper(substr(md5(uniqid(rand())), 0, 7));
        !isset($_SESSION['token']) ? $_SESSION['token'] = md5(uniqid(rand(), TRUE)) : null;
    }
}
