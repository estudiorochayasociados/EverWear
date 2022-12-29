<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$contenidos = new Clases\Contenidos();

$cod = isset($_GET["cod"]) ? $_GET["cod"] : '';
$contenidos->set("cod", $cod);
$contenido = $contenidos->view();

if (!empty($contenido["images"])) {
    $imagen = URL . "/assets/images/" . $funciones->normalizar_link($contenido["images"][0]["ruta"]) . ".jpg";
} else {
    $imagen = URL . "/assets/images/error404.jpg";
}

$template->set("title", $contenido['data']['cod'] . " | " . TITULO);
$template->set("description", substr($contenido['data']['contenido'], 0, 120));
$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->set("body", "");
$template->themeInit();
?>
<main>
    <!-- slider -->
    <div class="img-slider-content" style="background: #222;height: 900px;">
        <div class="col-md-6"></div>
        <div class="col-md-6 vertical-align">
            <h3 class="vertical-text">
                <?php
                if (!empty($contenido["data"])) {
                    echo ucfirst($contenido['data']['subtitulo']);
                } else {
                    echo 'Error 404';
                } ?>
            </h3>
            <?php
            if (!empty($contenido["data"])) {
                echo $contenido['data']['contenido'];
            } else {
                echo '<h2>Error 404</h2>';
            } ?>
        </div>
    </div>

    <!-- lineas section -->
    <section class="pt-50 pb-50 section-yellow box-shadow">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div>
                        <div class="info-icon">
                            <img src="<?= URL ?>/assets/img/linea-icon.svg">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div>
                        <div class="info-icon">
                            <img src="<?= URL ?>/assets/img/linea-icon.svg">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div>
                        <div class="info-icon">
                            <img src="<?= URL ?>/assets/img/linea-icon.svg">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div>
                        <div class="info-icon">
                            <img src="<?= URL ?>/assets/img/linea-icon.svg">
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- empty section -->
    <section class="pt-100 pb-100 mt-25 section-white">
        <div class="container">
    </section>

</main>

<?php
$template->themeEnd();
?>