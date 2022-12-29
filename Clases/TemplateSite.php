<?php

namespace Clases;

class TemplateSite
{
    public $title;
    public $keywords;
    public $description;
    public $imagen;
    public $favicon;
    public $body;

    private $config;
    private $contactData;

    public function __construct()
    {
        $this->body = '';
        $this->config = new Config();
        $this->contactData = $this->config->viewContact();
        $this->seo = new Seo();
    }

    private $canonical = CANONICAL;
    private $autor = TITULO;
    private $copy = TITULO;

    public function themeInit($nav = true)
    {
        $this->seo->set("url", $this->canonical);
        $url = $this->seo->viewURL();
        if (is_array($url)) {
            $this->title = isset($url['data']['title']) ? $url['data']['title'] :  $this->title;
            $this->description = isset($url['data']['description']) ? $url['data']['description'] : $this->description;
            $this->keywords =  isset($url['data']['keywords']) ? $url['data']['keywords'] : $this->keywords;
            $this->imagen = isset($url['images'][0]['ruta']) ? URL . "/" . $url['images'][0]['ruta'] : $this->imagen;
        }


        echo '<!DOCTYPE html>';
        echo '<html lang="es">';
        echo '<head>';
        echo '<meta charset="utf-8"/>';
        echo '<meta name="author" lang="es" content="' . $this->autor . '" />';
        echo '<link rel="author" href="' . $this->contactData['data']['email'] . '" rel="nofollow" />';
        echo '<meta name="copyright" content="' . $this->copy . '" />';
        echo '<link rel="canonical" href="' . strip_tags($this->canonical) . '" />';
        echo '<meta name="distribution" content="global" />';
        echo '<meta name="robots" content="all" />';
        echo '<meta name="rating" content="general" />';
        echo '<meta name="content-language" content="es-ar" />';
        echo '<meta name="DC.identifier" content="' . strip_tags($this->canonical) . '" />';
        echo '<meta name="DC.format" content="text/html" />';
        echo '<meta name="DC.coverage" content="' . $this->contactData['data']['pais'] . '" />';
        echo '<meta name="DC.language" content="es-ar" />';
        echo '<meta http-equiv="window-target" content="_top" />';
        echo '<meta name="robots" content="all" />';
        echo '<meta http-equiv="content-language" content="es-ES" />';
        echo '<meta name="google" content="notranslate" />';
        echo '<meta name="geo.region" content="AR-X" />';
        echo '<meta name="geo.placename" content="' . $this->contactData['data']['provincia'] . '" />';
        echo '<meta name="geo.position" content="' . $this->contactData['data']['localidad'] . '" />';
        echo '<meta name="ICBM" content="' . $this->contactData['data']['localidad'] . '" />';
        echo '<meta content="public" name="Pragma" />';
        echo '<meta http-equiv="pragma" content="public" />';
        echo '<meta http-equiv="cache-control" content="public" />';
        echo '<meta property="og:url" content="' . strip_tags($this->canonical) . '" />';
        echo '<meta charset="utf-8">';
        echo '<meta content="IE=edge" http-equiv="X-UA-Compatible">';
        echo '<meta content="width=device-width, initial-scale=1" name="viewport">';
        echo '<meta name="language" content="Spanish">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />';
        echo '<title>' . strip_tags($this->title) . '</title>';
        echo '<meta http-equiv="title" content="' . strip_tags($this->title) . '" />';
        echo '<meta name="description" lang=es content="' . strip_tags($this->description) . '" />';
        echo '<meta name="keywords" lang=es content="' . strip_tags($this->keywords) . '" />';
        echo '<link href="' . URL . '/assets/img/logo.png" rel="Shortcut Icon" />';
        echo '<meta name="DC.title" content="' . strip_tags($this->title) . '" />';
        echo '<meta name="DC.subject" content="' . strip_tags($this->description) . '" />';
        echo '<meta name="DC.description" content="' . strip_tags($this->description) . '" />';
        echo '<meta property="og:title" content="' . strip_tags($this->title) . '" />';
        echo '<meta property="og:description" content="' . strip_tags($this->description) . '" />';
        echo '<meta property="og:image" content="' . $this->imagen . '" />';
        echo '<link href="' . FAVICON . '" rel="Shortcut Icon" />';
        include 'assets/inc/header.inc.php';
        echo '</head>';
        echo '<body class="' . $this->body . '">';
        ($nav) ? include 'assets/inc/nav.inc.php' : '';
    }

    public function themeEnd($footer = true)
    {
        ($footer) ? include 'assets/inc/footer.inc.php' : include 'assets/inc/scripts.inc.php';
        echo '</body>';
        echo '</html>';
    }

    public function set($atributo, $valor)
    {
        if (!empty($valor)) {
            $valor = $valor;
        } else {
            $valor = "NULL";
        }
        $this->$atributo = $valor;
    }
}
