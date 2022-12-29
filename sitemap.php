<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$funciones = new Clases\PublicFunction();
$productos = new Clases\Productos();
$contenidos = new Clases\Contenidos();
$servicios = new Clases\Servicios();
$portfolio = new Clases\Productos();
$landing = new Clases\Landing();
$novedades = new Clases\Novedades();
$categorias = new Clases\Categorias();
$servicios = new Clases\Servicios();
$otras = array("sesion", "sesion/cuenta", "sesion/pedidos", "index", "blog", "productos", "tienda", "carrito", "feed", "contacto", "usuarios", "busqueda");

$xml = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';


foreach (($data = $novedades->list("", '', '')) as $novedad) {
    $cod = $novedad['data']["cod"];
    $titulo = $funciones->normalizar_link($novedad['data']["titulo"]);
    $xml .= '<url><loc>' . URL . '/blog/' . $titulo . '/' . $cod . '</loc><lastmod>' . $novedad['data']["fecha"] . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
}

foreach (($data = $contenidos->list("", '', '')) as $contenido) {
    $titulo = $funciones->normalizar_link($contenido['data']["titulo"]);
    $cod = $contenido['data']["cod"];
    $xml .= '<url><loc>' . URL . '/c/' . $titulo . '/' . $cod . '</loc><lastmod>' . date("Y-m-d") . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
}

foreach (($data = $categorias->list(array("area='productos'"), '', '')) as $cat) {
    $cod = $cat['data']["cod"];
    $titulo = $funciones->normalizar_link($cat['data']["titulo"]);
    $xml .= '<url><loc>' . URL . '/productos/' . $titulo . '/' . $cod . '</loc><lastmod>' . date("Y-m-d") . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
}

foreach (($data = $portfolio->list("", '', '')) as $port) {
    $cod = $port['data']["cod"];
    $titulo = $funciones->normalizar_link($port['data']["titulo"]);
    $xml .= '<url><loc>' . URL . '/producto/' . $titulo . '/' . $cod . '</loc><lastmod>' . date("Y-m-d") . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
}

foreach (($data = $landing->list("", '', '')) as $land) {
    $cod = $land['data']["cod"];
    $titulo = $funciones->normalizar_link($land['data']["titulo"]);
    $xml .= '<url><loc>' . URL . '/landing/' . $titulo . '/' . $cod . '</loc><lastmod>' . date("Y-m-d") . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
}

foreach (($data = $servicios->list("", '', '')) as $serv) {
    $cod = $serv['data']["cod"];
    $titulo = $funciones->normalizar_link($serv['data']["titulo"]);
    $xml .= '<url><loc>' . URL . '/s/' . $titulo . '/' . $cod . '</loc><lastmod>' . date("Y-m-d") . '</lastmod><changefreq>weekly</changefreq><priority>0.8</priority></url>';
}

foreach ($otras as $otro) {
    $xml .= '<url><loc>' . URL . '/' . $otro . '</loc><lastmod>' . date("Y-m-d") . '</lastmod><changefreq>weekly</changefreq><priority>1</priority></url>';
}

$xml .= '</urlset>';

// Opcion 2
header("Content-Type: text/xml;");
echo $xml;


