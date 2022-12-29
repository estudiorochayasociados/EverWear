<?php
$rol = $_SESSION["admin"]["rol"];

$pages = [
    "contenidos" => false,
    "multimedia" => false,
    "novedades" => false,
    "videos" => false,
    "sliders" => false,
    "galerias" => false,
    "banners" => false,
    "productos" => false,
    "importar" => false,
    "exportar" => false,
    "servicios" => false,
    "portfolio" => false,
    "ecommerce" => false,
    "pedidos" => false,
    "pagos" => false,
    "descuentos" => false,
    "envios" => false,
    "marketing" => false,
    "landing" => false,
    "analitica" => false,
    "usuarios" => false,
    "categorias" => false,
    "subcategorias" => false,
    "configuracion" => false,
    "administradores" => false,
    "seo" => false,
];

foreach ($rol as $value) {
    switch ($value) {
        //desarrollador
        case 1:
            $pages["contenidos"] = true;
            $pages["multimedia"] = true;
            $pages["novedades"] = true;
            $pages["videos"] = true;
            $pages["sliders"] = true;
            $pages["galerias"] = true;
            $pages["banners"] = true;
            $pages["productos"] = true;
            $pages["importar"] = true;
            $pages["exportar"] = true;
            $pages["servicios"] = true;
            $pages["portfolio"] = true;
            $pages["ecommerce"] = true;
            $pages["pedidos"] = true;
            $pages["pagos"] = true;
            $pages["descuentos"] = true;
            $pages["envios"] = true;
            $pages["marketing"] = true;
            $pages["landing"] = true;
            $pages["analitica"] = true;
            $pages["usuarios"] = true;
            $pages["categorias"] = true;
            $pages["subcategorias"] = true;
            $pages["configuracion"] = true;
            $pages["administradores"] = true;
            $pages["seo"] = true;
            break;
        //superadmin
        case 2:
            $pages["contenidos"] = true;
            $pages["multimedia"] = true;
            $pages["novedades"] = true;
            $pages["videos"] = true;
            $pages["sliders"] = true;
            $pages["galerias"] = true;
            $pages["banners"] = true;
            $pages["productos"] = true;
            $pages["importar"] = true;
            $pages["exportar"] = true;
            $pages["servicios"] = true;
            $pages["portfolio"] = true;
            $pages["ecommerce"] = true;
            $pages["pedidos"] = true;
            $pages["pagos"] = true;
            $pages["descuentos"] = true;
            $pages["envios"] = true;
            $pages["marketing"] = true;
            $pages["landing"] = true;
            $pages["analitica"] = true;
            $pages["usuarios"] = true;
            $pages["categorias"] = true;
            $pages["subcategorias"] = true;
            $pages["configuracion"] = true;
            $pages["administradores"] = true;
            $pages["seo"] = true;
            break;
        //marketing
        case 3:
            $pages["marketing"] = true;
            $pages["landing"] = true;
            $pages["analitica"] = true;
            $pages["seo"] = true;
            break;
        //ecommerce
        case 4:
            $pages["ecommerce"] = true;
            $pages["pedidos"] = true;
            $pages["pagos"] = true;
            $pages["envios"] = true;
            $pages["descuentos"] = true;
            $pages["productos"] = true;
            $pages["importar"] = true;
            $pages["exportar"] = true;
            break;
        //generador contenidos
        case 5:
            $pages["contenidos"] = true;
            $pages["servicios"] = true;
            $pages["portfolio"] = true;
            $pages["multimedia"] = true;
            $pages["novedades"] = true;
            $pages["videos"] = true;
            $pages["sliders"] = true;
            $pages["galerias"] = true;
            $pages["banners"] = true;
            break;
    }
}