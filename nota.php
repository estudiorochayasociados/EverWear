<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$novedad = new Clases\Novedades();

$cod = isset($_GET["cod"]) ? $_GET["cod"] : '0';
$novedad->set("cod", $cod);

$novedadData = $novedad->view();
$novedadesSideArray = $novedad->list("", "", "3");

setlocale(LC_ALL, "es_ES");
$fecha = ucfirst(strftime("%d/%m/%Y", strtotime($novedadData['data']['fecha'])));

$template->set("title", mb_strtoupper($novedadData['data']['titulo'] . " | " . TITULO));
$template->set("description", ucfirst(substr(strip_tags($novedadData['data']['desarrollo']), 0, 160)));
$template->set("keywords", $novedadData['data']['keywords']);
$template->set("imagen", URL . "/" . $novedadData['images'][0]['ruta']);
$template->themeInit();
?>

<main>
    <!-- slider -->

    <div class="img-slider-content-single-product" style="background: #222">
        <div class="col-md-12 vertical-align justify-content-center">
        </div>
    </div>

    <!-- Blog section -->
    <section class="pt-50 pb-50 section-white box-shadow">
        <div class="container">
            <div class="row">
                <div class="col-md-9 main-blog">
                    <div class="row mb-30">
                        <div class="col-md-12">
                            <div style="background: url(<?= URL . '/' . $novedadData['images'][0]['ruta'] ?>)center/cover no-repeat;height: 465px;"></div>
                            <div class="mb-10">
                                <div class="mt-10 mb-10">
                                    <span class="date"><i class="far fa-calendar-alt"></i> <?= $fecha ?></span>
                                </div>
                                <div class="clearfix"></div>
                                <h3 class="text-uppercase bold fs-21"><?= $novedadData['data']['titulo'] ?></h3>
                                <?= strip_tags($novedadData['data']['desarrollo']) ?>

                                <div class="share-article">
                                    <hr />
                                    <div class="single-product-sharing">
                                        <h3 class="fs-14">COMPARTIR EN</h3>
                                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                            <a class="a2a_button_facebook"></a>
                                            <a class="a2a_button_twitter"></a>
                                            <a class="a2a_button_email"></a>
                                            <a class="a2a_button_google_gmail"></a>
                                            <a class="a2a_button_whatsapp"></a>
                                        </div>
                                        <script async src="https://static.addtoany.com/menu/page.js"></script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 aside-blog">
                    <h2>Recientes</h2>
                    <div class="row">
                        <?php foreach ($novedadesSideArray as $key => $novedad) {
                            setlocale(LC_ALL, "es_ES");
                            $fecha = ucfirst(strftime("%d/%m/%Y", strtotime($novedad['data']['fecha'])));
                        ?>
                            <div class="col-md-12  mb-10">
                                <a href="<?= URL . '/blog/' . $funciones->normalizar_link($novedad['data']['titulo']) . '/' . $novedad['data']['cod'] ?>">
                                    <div style="background: url(<?= URL . '/' . $novedad['images'][0]['ruta'] ?>)center/cover no-repeat;height: 143px;"></div>
                                    <div class="box">
                                        <span class="date fs-12"><i class="far fa-calendar-alt"></i> <?= $fecha ?></span>
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