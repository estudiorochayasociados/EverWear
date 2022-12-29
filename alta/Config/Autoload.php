<?php

namespace config;

use Clases\PublicFunction;

class autoload
{
    //Ruta (https://www.rocha.com/'$project')
    //Ejemplos local: '/'.'Develop'
    //Ejemplos subido: ''
    private static $project = '/everwear/alta';
    private static $title = 'Ever';
    private static $titleAdmin = 'ESTUDIO ROCHA CMS';
    //http o https
    private static $protocol = 'http';
    private static $salt = 'salt@estudiorochayasoc.com.ar';
    private static $logo = '/assets/img/logo.png';
    private static $favicon = '/assets/img/favicon.png';

    //url para la exportacion de la imagen
    //('http://www.XXXXXXX.com.ar/assets/archivos/img_productos/'...)
    private static $urlImage = 'http://www.XXXXXXX.com.ar/assets/archivos/img_productos/';
    //Formato ('.jpg','.png')
    private static $urlImageFormat = '.jpg';

    public static function run()
    {
        self::settings();
        //require_once "Config/Minify.php";
        require dirname(__DIR__) . '/vendor/autoload.php';
        define('SALT', hash("sha256", self::$salt));
        define('URL', self::$protocol . "://" . $_SERVER['HTTP_HOST'] . self::$project);
        define('TITULO_ADMIN', self::$titleAdmin);
        define('URLADMIN', self::$protocol . "://" . $_SERVER['HTTP_HOST'] . self::$project . "/admin");
        $_SESSION["images-folder"] = self::$protocol . "://" . $_SERVER['HTTP_HOST'] . self::$project . "";
        define('CANONICAL', self::$protocol . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        define('LOGO', URL . self::$logo);
        define('FAVICON', URL . "/assets/img/faviconF.png");
        define('TITULO', self::$title);
        require_once dirname(__DIR__) . "/Clases/Zebra_Image.php";
        spl_autoload_register(
            function ($clase) {
                $ruta = str_replace("\\", "/", $clase) . ".php";
                $pos = strpos($ruta, "Clases");
                if ($pos !== false) {
                    include_once dirname(__DIR__) . "/" . $ruta;
                }
            });
    }

    public static function settings()
    {
        setlocale(LC_ALL, 'es_AR');
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        session_start();
        $_SESSION["cod_pedido"] = isset($_SESSION["cod_pedido"]) ? $_SESSION["cod_pedido"] : strtoupper(substr(md5(uniqid(rand())), 0, 7));
    }
    public static function runSitio()
    {
        self::settings();
        require_once "Config/Minify.php";
        require 'vendor/autoload.php';
        define('SALT', hash("sha256", self::$salt));
        define('URL', self::$protocol . "://" . $_SERVER['HTTP_HOST'] . self::$project);
        define('CANONICAL', self::$protocol . "://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        define('LOGO', URL . self::$logo);
        define('FAVICON', URL . self::$favicon);
        define('TITULO', self::$title);
        spl_autoload_register(
            function ($clase) {
                $ruta = str_replace("\\", "/", $clase) . ".php";
                $pos = strpos($ruta, "Clases");
                if ($pos !== false) {
                    include_once $ruta;
                }
            });
    }
    public static function runCurl()
    {
        self::settings();
        require '../../vendor/autoload.php';
        define('URL', self::$protocol . "://" . $_SERVER['HTTP_HOST'] . self::$project);
        define('LOGO', URL . "/assets/images/logo.png");
        define('SALT', hash("sha256", self::$salt));
        define('TITULO', self::$title);
        define('URL_IMG', self::$urlImage);
        define('URL_IMG_FORMAT', self::$urlImageFormat);
        spl_autoload_register(function ($clase) {
            $ruta = "../../" . str_replace("\\", "/", $clase) . ".php";
            $pos = strpos($ruta, "Clases");
            if ($pos !== false) {
                include_once $ruta;
            }
        });
    }
}
