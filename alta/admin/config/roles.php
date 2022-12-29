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
            $pages["subir-archivos"] = true;
            break;
        //superadmin
        case 2:
            $pages["contenidos"] = false;
            $pages["multimedia"] = false;
            $pages["novedades"] = false;
            $pages["videos"] = false;
            $pages["sliders"] = false;
            $pages["galerias"] = false;
            $pages["banners"] = false;
            $pages["productos"] = false;
            $pages["importar"] = false;
            $pages["exportar"] = false;
            $pages["servicios"] = false;
            $pages["portfolio"] = false;
            $pages["ecommerce"] = false;
            $pages["pedidos"] = false;
            $pages["pagos"] = false;
            $pages["descuentos"] = false;
            $pages["envios"] = false;
            $pages["marketing"] = false;
            $pages["landing"] = false;
            $pages["analitica"] = false;
            $pages["usuarios"] = true;
            $pages["categorias"] = false;
            $pages["subcategorias"] = false;
            $pages["configuracion"] = false;
            $pages["administradores"] = true;
            $pages["subir-archivos"] = false;
            break;
        //marketing
        case 3:
            $pages["marketing"] = false;
            $pages["landing"] = false;
            $pages["analitica"] = false;
            $pages["subir-archivos"] = false;
            break;
        //ecommerce
        case 4:
            $pages["ecommerce"] = false;
            $pages["pedidos"] = false;
            $pages["pagos"] = false;
            $pages["envios"] = false;
            $pages["descuentos"] = false;
            $pages["productos"] = false;
            $pages["importar"] = false;
            $pages["exportar"] = false;
            break;
        //generador contenidos
        case 5:
            $pages["contenidos"] = false;
            $pages["servicios"] = false;
            $pages["portfolio"] = false;
            $pages["multimedia"] = false;
            $pages["novedades"] = false;
            $pages["videos"] = false;
            $pages["sliders"] = false;
            $pages["galerias"] = false;
            $pages["banners"] = false;
            $pages["subir-archivos"] = false;
            break;
    }
}