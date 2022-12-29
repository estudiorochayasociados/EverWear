<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$producto = new Clases\Productos();
$config = new Clases\Config();

$producto->set("cod", isset($_GET["cod"]) ? $funciones->antihack_mysqli($_GET["cod"]) : '');
$productoData = $producto->view();

$template->set("title", $productoData["data"]["titulo"] . " | " . TITULO);
$template->set("description", $productoData["data"]["description"]);
$template->set("keywords", $productoData["data"]["keywords"]);
$template->set("imagen", LOGO);
$template->set("body", "");

$captchaData = $config->viewCaptcha();
$template->themeInit();
?>
<main>
    <!-- slider -->

    <div class="img-slider-content-single-product" style="background: #222">
        <div class="col-md-12 vertical-align justify-content-center">
        </div>
    </div>

    <section class="pt-50 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-uppercase bold"><?= $productoData["data"]["titulo"] ?></h3>
                    <hr style="border-top: 2px solid #333;" />
                </div>
                <div class="col-md-4">
                    <img src="<?= URL . '/' . $productoData["images"][0]["ruta"] ?>" width="100%">
                </div>
                <div class="col-md-8 ">
                    <div class="table-c">
                        <?= $productoData["data"]["desarrollo"] ?>
                    </div>
                    <div class="single-product-sharing">
                        <hr />
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
    </section>

    <!-- product section -->
    <section class="pt-50 pb-50 mt-30 section-white box-shadow link-product">
        <div class="container">
            <h2 class="fs-22  bold text-center text-uppercase">
                <!-- <?= $titleMoreProducts; ?> -->
                <hr />
            </h2>

            <div class="owl-carousel owl-theme owl-products">
                <?php /*
                foreach (array_chunk($productoArray, 2) as $element) {
                    $img = isset($element[0]['images'][0]['ruta']) ? $element[0]['images'][0]['ruta'] : 'assets/archivos/sin_imagen.jpg';
                    $img = URL . '/' . $img;
                    if (isset($element[1])) {
                        $img2 = isset($element[1]['images'][0]['ruta']) ? $element[1]['images'][0]['ruta'] : 'assets/archivos/sin_imagen.jpg';
                        $img2 = URL . '/' . $img2;
                    }
                ?>
                    <div class="item">
                        <div class="product-content">
                            <div class="box-content mt-10">
                                <a href="<?= URL . '/producto/' . $funciones->normalizar_link($element[0]['data']['titulo']) . '/' . $element[0]['data']['cod'] ?>">
                                    <div class="info-box" style="background: url(<?= $img ?>)center/contain no-repeat;"></div>
                                    <div class="info-text">
                                        <h6><?= mb_substr($element[0]['data']['titulo'], 0, 39) ?></h6>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- <?php if (isset($element[1])) { ?>
                            <div class="product-content">
                                <div class="box-content mt-10">
                                    <a href="<?= URL . '/producto/' . $funciones->normalizar_link($element[1]['data']['titulo']) . '/' . $element[1]['data']['cod'] ?>">
                                        <div class="info-box" style="background: url(<?= $img2 ?>)center/contain no-repeat;"></div>
                                        <div class="info-text">
                                            <h6><?= mb_substr($element[1]['data']['titulo'], 0, 39) ?></h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php } ?> -->
                    </div>
                <?php }*/ ?>
            </div>
    </section>
</main>
<?php $template->themeEnd() ?>

<script>
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