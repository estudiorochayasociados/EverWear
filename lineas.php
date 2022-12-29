<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$categoria = new Clases\Categorias();
$contenido = new Clases\Contenidos();

$template->set("title", "Líneas de Productos - " . TITULO);
$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->set("body", "");
$template->themeInit();
$topHeader = $contenido->viewByTitle('LÍNEAS DE PRODUCTOS');

?>
<!-- slider -->

<div class="img-slider-content" style="background: url(<?= URL . "/assets/banner.jpg" ?>)center/cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 vertical-align justify-slider-content bf bg-tr">
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

<!-- lineas section -->
<section class="  pb-50 mt-30  ">
    <div class="container">
        <div class="owl-carousel owl-theme owl-categories">
            <?php
            foreach ($categoria->list(["area = 'productos'"], "orden ASC", "") as $element) {
                $img = isset($element['images'][0]['ruta']) ? URL . '/' . $element['images'][0]['ruta'] : URL . '/assets/archivos/sin_imagen.jpg';
            ?>
                <div class="item">
                    <div class="category-content">
                        <a class="link-linea" href="<?= URL . '/sublineas/' . $funciones->normalizar_link($element['data']['titulo']) . "/" . $element['data']['cod'] ?>">
                            <div class="info-icon" style="background: url(<?= $img ?>)center/contain no-repeat"></div>
                            <div class="info-text text-center">
                                <h5><?= $element['data']['titulo'] ?></h5>
                            </div>
                        </a>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
</section>

<?php $template->themeEnd() ?>

<script>
    $('.owl-categories').owlCarousel({
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