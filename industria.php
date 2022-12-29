<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();


$template->set("title", "Línea Industria - " . TITULO);
$template->set("description", "");
$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->set("body", "");

$template->themeInit();
?>

<style>
    .contentIndustria * {
        font-family: 'Montserrat', sans-serif;
    }
</style>
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">


<div class="img-slider-content-single-product hidden-xs hidden-sm" style="background: #222">
    <div class="col-md-12 vertical-align justify-content-center">
    </div>
</div>

<div class="mt-30 hidden-md hidden-lg"></div>

<div class="contentIndustria">
    <div class="container-fluid">
        <div class="row hidden-xs hidden-sm">
            <div class="col-md-6 pr-0 pl-0">
                <img src="<?= URL . "/assets/archivos/industria/01.jpg" ?>" width="100%">
            </div>
            <div class="col-md-6" style="align-self: center;">
                <div class="fs-20  pr-50 pl-20" style="width: 90%;margin:auto">
                    <h3 class="fs-32 bold">
                        Brindamos SOLUCIONES<br />
                        para la fabricación industrial
                    </h3>
                    <br>
                    <p>
                        Desde 2018 tomamos la decisión de
                        atender al segmento industrial para lo
                        que incorporamos personal, tecnología y
                        los stock necesarios que nos permiten
                        tener una destacada presencia en los
                        principales fabricantes de equipos
                        originales O.EM. de la Argentina.

                    </p>
                </div>
            </div>
        </div>


        <div class="row hidden-md hidden-lg">
            <div class="col-xs-12 pr-20 pl-20" style="align-self: center; position:relative">
                <h3 class="fs-32 bold mt-20">
                    Brindamos SOLUCIONES
                    para la fabricación industrial
                </h3>
                <br>
                <p>
                    Desde 2018 tomamos la decisión de
                    atender al segmento industrial para lo
                    que incorporamos personal, tecnología y
                    los stock necesarios que nos permiten
                    tener una destacada presencia en los
                    principales fabricantes de equipos
                    originales O.EM. de la Argentina.

                </p>
            </div>

            <div class="col-xs-12 pr-0 pl-0">
                <img src="<?= URL . "/assets/archivos/industria/01.jpg" ?>" width="100%" />
            </div>
        </div>

        <div class="row hidden-xs hidden-sm">
            <div class="col-md-6" style="align-self: center; position:relative">
                <div class="fs-20  pr-50 pl-50" style="width: 90%;margin:auto">
                    <h3 class="fs-32 bold">
                        Mejoramos la performance de su
                        PRODUCCIÓN
                    </h3>
                    <br>
                    <p>
                        Somos una empresa preparada para acompañar a
                        los fabricantes de equipos y maquinarias en el
                        cumplimiento y mejoramiento de su performance,
                        la experiencia de nuestro departamento de
                        Ingeniería coordinada con el área Comercial,
                        conforman una herramienta clave para acompañar
                        a nuestros clientes en el desarrollo de sus
                        productos.
                    </p>
                    <img src="<?= URL . "/assets/archivos/industria/02.png" ?>" width="450" class="hidden-xs hidden-sm" style="position: absolute;z-index: 9999;right:-90px;bottom:-270px">
                </div>
            </div>

            <div class="col-md-6 pr-0 pl-0">
                <img src="<?= URL . "/assets/archivos/industria/03.jpg" ?>" width="100%" />
            </div>
        </div>


        <div class="row hidden-md hidden-lg">
            <div class="col-xs-12 pr-20 pl-20" style="align-self: center; position:relative">
                <h3 class="fs-32 bold mt-20">
                    Mejoramos la performance de su
                    PRODUCCIÓN
                </h3>
                <br>
                <p>
                    Somos una empresa preparada para acompañar a
                    los fabricantes de equipos y maquinarias en el
                    cumplimiento y mejoramiento de su performance,
                    la experiencia de nuestro departamento de
                    Ingeniería coordinada con el área Comercial,
                    conforman una herramienta clave para acompañar
                    a nuestros clientes en el desarrollo de sus
                    productos.
                </p>
            </div>

            <div class="col-xs-12 pr-0 pl-0">
                <img src="<?= URL . "/assets/archivos/industria/03.jpg" ?>" width="100%" />
            </div>
        </div>
    </div>
</div>

<div style="background: url(<?= URL . "/assets/archivos/industria/04.jpg" ?>)center/cover no-repeat;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 text-white" style="align-self: center;">
                <div class="fs-24 pt-150 pb-150 ">
                    <h3 class="fs-50 bold">
                        Entregamos valor agregado
                    </h3>
                    <br>
                    <p class="fs-25 pr-40">
                        Tenemos presencia en los principales
                        fabricantes de Maquinaria Agrícola,
                        Transporte de Cargas, Viales y
                        Construcción, Higiene Urbana y
                        Generación de Energía.
                        <br /><br />
                        Nos destacamos por asegurar un
                        producto final confiable mediante
                        estrictos controles de calidad y
                        trazabilidad, con un compromiso de
                        entrega basada en stock acordes a la
                        demanda de nuestros clientes.
                    </p>

                </div>
            </div>
        </div>
    </div>
</div>

<div style="background: black;">
    <div class="container pt-100 pb-100">
        <h3 class="text-center d-block bold fs-35 mb-30" style="color: #ffcc01">Desarrollamos productos para:</h3>
        <div class="d-flex justify-content-center mt-10  hidden-xs hidden-sm" style="color: white; font-weight:800; text-align: center">
            <div class="p-3">
                <img src="<?= URL . "/assets/archivos/industria/MAQUINARIA-AGRIC.png" ?>" height="100px" alt="">
                <h3 class="mt-10">Maquinaria Agricola</h3>
            </div>
            <div class="p-3">
                <img src="<?= URL . "/assets/archivos/industria/TRANSP-CARGA.png" ?>" height="100px" alt="">
                <h3 class="mt-10">Trasporte de Cargas</h3>
            </div>
            <div class="p-3">
                <img src="<?= URL . "/assets/archivos/industria/VIALES Y CONST.png" ?>" height="100px" alt="">
                <h3 class="mt-10">Viales y construcción</h3>
            </div>
            <div class="p-3">
                <img src="<?= URL . "/assets/archivos/industria/HIG-URB.png" ?>" height="100px" alt="">
                <h3 class="mt-10">Higiene Urbana</h3>
            </div>
            <div class="p-3">
                <img src="<?= URL . "/assets/archivos/industria/GENERACION-ENERG.png" ?>" height="100px" alt="">
                <h3 class="mt-10">Generación de energía</h3>
            </div>
        </div>

        <div class="hidden-lg hidden-md text-center ">
            <h3 style="color:#fff" class="mt-10">Maquinaria Agricola</h3>
            <h3 style="color:#fff" class="mt-10">Trasporte de Cargas</h3>
            <h3 style="color:#fff" class="mt-10">Viales y construcción</h3>
            <h3 style="color:#fff" class="mt-10">Higiene Urbana</h3>
            <h3 style="color:#fff" class="mt-10">Generación de energía</h3>
        </div>
    </div>
</div>




<div class="container-fluid hidden-xs hidden-sm">
    <div class="row">
        <div class="col-md-5" style="align-self: center;">
            <div class="fs-18  ml-100">
                <h1 class="bold">
                    <span class="fs-60 bold">10.000m²</span><br><span>de producción</span>
                </h1>
                <br />
                <p>
                    En nuestra planta ubicada en el Parque
                    Industrial de San Francisco, contamos con
                    una fábrica de terminales, accesorios
                    hidráulicos y herramientas para el armado
                    de mangueras de baja, mediana y alta
                    presión.
                </p>
                <a href="<?= URL ?>/contacto" class="btn btn-default btn-block bold fs-20" style="color:#fff;background:#feca0a;border-color:#feca0a">Contáctese con nosotros</a>
            </div>
        </div>

        <div class="col-md-7" style="text-align-last: end;padding-right: 0px">
            <img src="<?= URL . "/assets/img/10000.jpg" ?>" width="90%" height="100%" alt="">
        </div>
    </div>
</div>

<div class="container-fluid hidden-md hidden-lg">
    <div class="row">
        <div class="col-xs-12 pr-20 pl-20 pb-50 pt-50" style="align-self: center;">
            <div class="fs-18">
                <h1 class="bold">
                    <span class="fs-60 bold">10.000m²</span><br><span>de producción</span>
                </h1>
                <br />
                <p>
                    En nuestra planta ubicada en el Parque
                    Industrial de San Francisco, contamos con
                    una fábrica de terminales, accesorios
                    hidráulicos y herramientas para el armado
                    de mangueras de baja, mediana y alta
                    presión.
                </p>
                <a href="<?= URL ?>/contacto" class="btn btn-default btn-block bold fs-20" style="color:#fff;background:#feca0a;border-color:#feca0a">Contáctese con nosotros</a>
            </div>
        </div>

    </div>
</div>


<img src="<?= URL . "/assets/archivos/industria/07.jpg" ?>" width="100%" alt="">
</div>


<?php $template->themeEnd() ?>