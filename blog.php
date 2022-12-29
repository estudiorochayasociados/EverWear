<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
//
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$novedad = new Clases\Novedades();
$categoria = new Clases\Categorias();
$contenidos = new Clases\Contenidos();
$pagination = new Zebra_Pagination();
//
$novedadesArray = $novedad->list("", "", "");
$novedadesArraySlide = $novedad->list("", "", 8);

//Cantidad de elementos por pagina y totales
$cantidadPagina = 2;
$cantidadNovedades = count($novedadesArray);

//Cantidad total de elementos
$pagination->records($cantidadNovedades);

//Cantidad de elementos por página
$pagination->records_per_page($cantidadPagina);

//Elementos mostrados en la página actual
$novedadesArray = array_slice(
    $novedadesArray,
    (($pagination->get_page() - 1) * $cantidadPagina),
    $cantidadPagina
);

$topHeader = $contenidos->viewByTitle('BLOG');

$template->set("title", "Novedades | " . TITULO);
$template->set("description", "Novedades de " . TITULO);
$template->set("keywords", "Novedades de " . TITULO);
$template->set("body", "shop-page");
$template->themeInit();
?>
<main>
    <!-- slider -->
    <div class="img-slider-content" style="background: url(<?= (count($topHeader["images"]) != 0) ? URL . "/" . $topHeader["images"][0]["ruta"] : URL . "/assets/archivos/60fe6cceb4.png" ?>) center center /cover no-repeat;">
        <div class="container">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6 vertical-align justify-slider-content bf bg-tr  pt-60 pb-60">
                    <h3 class="vertical-text text-uppercase">
                        <?= $topHeader["data"]["titulo"] ?>
                    </h3>
                    <span>
                        <?= $topHeader["data"]["contenido"] ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Blog section -->
    <section class="pt-50 pb-50 section-white box-shadow">
        <div class="container">
            <div class="row">
                <div class="col-md-9 main-blog">
                    <div class="row mb-30">
                        <?php foreach ($novedadesArray as $key => $novedad) {
                            setlocale(LC_ALL, "es_ES");
                            $fecha = ucfirst(strftime("%d/%m/%Y", strtotime($novedad['data']['fecha'])));
                        ?>
                            <div class="col-md-12">
                                <div style="background: url(<?= URL . '/' . $novedad['images'][0]['ruta'] ?>)center/cover no-repeat;height: 465px;"></div>
                                <div class="mb-10">
                                    <div class="pt-10 pb-10">
                                        <span class="date"><i class="far fa-calendar-alt"></i> <?= $fecha ?></span>
                                    </div>
                                    <div class="clearfix"></div>
                                    <h3 class="text-uppercase bold fs-21"><?= $novedad['data']['titulo'] ?></h3>
                                    <p><?= substr(strip_tags($novedad['data']['desarrollo']), 0, 250) ?>...</p>
                                    <a href="<?= URL . '/blog/' . $funciones->normalizar_link($novedad['data']['titulo']) . '/' . $novedad['data']['cod'] ?>" class="btn btn-secondary">LEER MÁS</a>
                                </div>
                                <hr>
                                <br>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="pager justify-content-center">
                        <div class="col-md-12 text-center"><?php $pagination->render(); ?></div>
                    </div>
                </div>
                <div class="col-md-3 aside-blog">
                    <h2>Recientes</h2>
                    <div class="row">
                        <?php foreach ($novedadesArraySlide as $key => $novedad) {
                            setlocale(LC_ALL, "es_ES");
                            $fecha = ucfirst(strftime("%d/%m/%Y", strtotime($novedad['data']['fecha'])));
                        ?>
                            <div class="col-md-12">
                                <a href="<?= URL . '/blog/' . $funciones->normalizar_link($novedad['data']['titulo']) . '/' . $novedad['data']['cod'] ?>">
                                    <div style="background: url(<?= URL . '/' . $novedad['images'][0]['ruta'] ?>)center/cover no-repeat;height: 143px;"></div>
                                    <div class="box">
                                        <span class="date"><i class="far fa-calendar-alt"></i> <?= $fecha ?></span>
                                        <div class="clearfix"></div>
                                        <b class="text-uppercase"><?= $novedad['data']['titulo'] ?></b>
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php $template->themeEnd() ?>