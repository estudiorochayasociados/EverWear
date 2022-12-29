<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$contenidos = new Clases\Contenidos();

$cod = isset($_GET["cod"]) ? $_GET["cod"] : '';
$contenido = $contenidos->viewByTitle('SOMOS EVER');

$contenidos->set("cod", "1217e3ff41");
$contenidoContador[] = $contenidos->view();

$contenidos->set("cod", "68797227cc");
$contenidoContador[] = $contenidos->view();

$contenidos->set("cod", "e9cb0be1cc");
$contenidoContador[] = $contenidos->view();

$contenidos->set("cod", "93a88af04c");
$contenidoContador[] = $contenidos->view();

$contenidos->set("cod", "a9ea7b76c3");
$contenidoContador[] = $contenidos->view();

$template->set("title", ucwords(mb_strtolower($contenido['data']['titulo'])) . " | " . TITULO);
$template->set("description", substr(strip_tags($contenido['data']['contenido']), 0, 120));
$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->set("body", "");
$template->themeInit();
?>
<main>
    <!-- slider -->
    <div class="img-slider-content" style="background: url(<?= (count($contenido["images"]) != 0) ? URL . "/" . $contenido["images"][0]["ruta"] : URL . "/assets/archivos/60fe6cceb4.png" ?>) center center /cover no-repeat;">
        <div class="container">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6 vertical-align">
                    <h3 class="vertical-text">
                        <?= ucfirst($contenido['data']['subtitulo']); ?>
                    </h3>
                    <div>
                        <?= $contenido['data']['contenido']; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about section -->
    <section class="pt-100 pb-100  bold section-yellow box-shadow">
        <div class="container">
            <div class="owl-carousel owl-theme owl-about">
                <div class="item">
                    <div class="about-content">
                        <div class="info-icon-empresa text-center">
                            <h2 class="fs-40 bold"><span class="count"><?= strip_tags($contenidoContador[0]['data']['contenido']) ?></span>m<sup>2</sup></h2>
                            <h5 class="fs-15 text-uppercase"><?= $contenidoContador[0]['data']['subtitulo'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="about-content">
                        <div class="info-icon-empresa text-center">
                            <h2 class="fs-40 bold">+<span class="count"><?= strip_tags($contenidoContador[1]['data']['contenido']) ?></span></h2>
                            <h5 class="fs-15 text-uppercase"><?= $contenidoContador[1]['data']['subtitulo'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="about-content">
                        <div class="info-icon-empresa text-center">
                            <h2 class="fs-40 bold">+<span class="count"><?= strip_tags($contenidoContador[2]['data']['contenido']) ?></span></h2>
                            <h5 class="fs-15 text-uppercase"><?= $contenidoContador[2]['data']['subtitulo'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="about-content">
                        <div class="info-icon-empresa text-center">
                            <h2 class="fs-40 bold"><span class="count"><?= strip_tags($contenidoContador[3]['data']['contenido']) ?></span></h2>
                            <h5 class="fs-15 text-uppercase"><?= $contenidoContador[3]['data']['subtitulo'] ?></h5>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="about-content">
                        <div class="info-icon-empresa text-center">
                            <h2 class="fs-40 bold">+<span class="count"><?= strip_tags($contenidoContador[4]['data']['contenido']) ?></span></h2>
                            <h5 class="fs-15 text-uppercase"><?= $contenidoContador[4]['data']['subtitulo'] ?></h5>
                        </div>
                    </div>
                </div>
            </div>
    </section>

</main>

<?php $template->themeEnd(); ?>

<script>
    $('.owl-about').owlCarousel({
        responsive: {
            0: {
                items: 1,
                loop: true,
                nav: true,
                dots: true,
                autoplay: true
            },
            768: {
                items: 5,
                loop: false,
                dots: true
            }
        }
    });
</script>

<script>
    $('.count').each(function() {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 5000,
            easing: 'swing',
            step: function(now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
</script>