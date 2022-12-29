<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$slider = new Clases\Sliders();
$contenido = new Clases\Contenidos();
$categoria = new Clases\Categorias();

$template->set("title", TITULO);
$template->set("description", "");
$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->set("body", "");

$sliderArray = $slider->list("", "", "");

$contenido->set("cod", "c9f39d5bfb");
$contenido1 = $contenido->view();

$contenido->set("cod", "086eb475d9");
$contenido2 = $contenido->view();

$contenido->set("cod", "2a9729f7e1");
$contenido3 = $contenido->view();

$template->themeInit();
?>

<main>
    <!-- slider -->
    <div class="img-slider owl-carousel owl-theme owl-slider">
        <?php foreach ($sliderArray as $slider) { ?>
            <div class="item">
                <img src="<?= URL . '/' . $slider['image']['ruta'] ?>" width="100%" />
                <div class="d-none d-md-block info-slider">
                    <?php if ($slider['data']['titulo_on']) { ?>
                        <span class="bold fs-50 wow animated fadeInUp"><?= $slider['data']['titulo'] ?></span><br />
                    <?php } ?>
                    <?php if ($slider['data']['subtitulo_on']) { ?>
                        <span class="bold fs-50  wow animated fadeInUp delay-1s"><?= $slider['data']['subtitulo'] ?></span><br />
                    <?php } ?>
                    <?php if ($slider['data']['link_on']) { ?>
                        <br><br>
                        <a class="btn btn-ever" href="<?= $slider['data']['link'] ?>" target="_blank">Ver más</a>
                    <?php } ?>
                </div>
                <div class="d-md-none info-slider">
                    <?php if ($slider['data']['titulo_on']) { ?>
                        <span class="bold fs-20 wow animated fadeInUp"><?= $slider['data']['titulo'] ?></span><br />
                    <?php } ?>
                    <?php if ($slider['data']['subtitulo_on']) { ?>
                        <span class="bold fs-20  wow animated fadeInUp delay-1s"><?= $slider['data']['subtitulo'] ?></span><br />
                    <?php } ?>
                    <?php if ($slider['data']['link_on']) { ?>
                        <br><br>
                        <a class="btn btn-ever" href="<?= $slider['data']['link'] ?>" target="_blank">Ver más</a>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>


    <!-- info section -->
    <section class="pt-50 pb-50 section-gray box-shadow">
        <div class="container wow animated fadeInUp">
            <?= $contenido1['data']['contenido'] ?>
        </div>
    </section>

    <section class="  pb-50 mt-30  ">
        <div class="container text-center">
            <h2>LÍNEAS DE PRODUCTOS</h2>
            <hr />
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
</main>


<?php $template->themeEnd() ?>
<script>
    $('.owl-slider').owlCarousel({
        items: 1,
        loop: true,
        dots: false,
        autoplay: true
    });

    $('.owl-contents').owlCarousel({
        responsive: {
            0: {
                items: 1,
                loop: true,
                nav: true,
                dots: true,
                autoplay: true
            },
            768: {
                items: 3,
                loop: false,
                dots: true
            }
        }
    });

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

    $('.owl-products').owlCarousel({
        responsive: {
            0: {
                items: 1,
                loop: true,
                nav: true,
                dots: true,
                autoplay: true
            },
            768: {
                items: 4,
                loop: false,
                dots: true
            }
        }
    });
</script>