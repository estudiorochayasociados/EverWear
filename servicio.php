<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$servicio = new Clases\Servicios();
$config = new Clases\Config();

$template->set("title", "Productos | " . TITULO);
$template->set("description", "");
$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->set("body", "");

$cod = isset($_GET["cod"]) ? $_GET["cod"] : '0';
$servicio->set("cod", $cod);

$servicioData = $servicio->view();

$categoriaCod = $servicioData["category"]["data"]["cod"];
$subcategoriaCod = $servicioData["subcategory"]["data"]["cod"];
$filter = ["categoria = '$categoriaCod'", "subcategoria = '$subcategoriaCod'"];

$servicioArray = $servicio->list($filter, "fecha DESC", "");

$titleMoreProducts = "";
if (!empty($categoriaCod)) {
    $titleMoreProducts = 'Más productos de <a href="' . URL . '/lineas/c/' . $servicioData["category"]["data"]["cod"] . '">' . $servicioData["category"]["data"]["titulo"] . "</a>";
}
if (!empty($subcategoriaCod)) {
    $titleMoreProducts = 'Más productos de <a href="' . URL . '/lineas/c/' . $servicioData["category"]["data"]["cod"] . '">' . $servicioData["category"]["data"]["titulo"] . '</a> <i class="fas fa-angle-double-right"></i> <a href="' . URL . '/productos/' . $servicioData["category"]["data"]["cod"] . '/' . $servicioData["subcategory"]["data"]["cod"] . '">' . $servicioData["subcategory"]["data"]["titulo"] . '</a>';
}

$captchaData = $config->viewCaptcha();

$template->themeInit();
?>
<main>
    <!-- slider -->

    <div class="img-slider-content-single-product" style="background: url(<?= URL ?>/assets/archivos/60fe6cceb4.png)center/cover no-repeat">
        <div class="col-md-12 vertical-align justify-content-center">
        </div>
    </div>

    <section class="pt-50 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-uppercase bold"><?= $servicioData["data"]["titulo"] ?></h3>
                    <hr style="border-top: 2px solid #333;" />
                </div>
                <div class="col-md-4">
                    <img src="<?= URL . '/' . $servicioData["images"][0]["ruta"] ?>" width="100%">
                    <hr />
                    <h5 class="text-uppercase bold fs-15 mt-20">¿Te gustaría asesoramiento comercial?</h5>
                    <hr />
                    <form method="post" class="mt-20" id="formProducto" onsubmit="send('<?= URL . '/curl/email/sendEmail.php' ?>', $('#formProducto').serialize())">
                        <div id="smsSend"></div>
                        <div class="row">
                            <input type="hidden" name="producto" value="<?= $servicioData["data"]["titulo"] ?>">
                            <div class="col-md-12 fs-13 mb-5">
                                <label class="mb-0 pb-0" for="nombre"> Nombre y Apellido</label>
                                <input type="text" name="nombre" class="form-control">
                            </div>
                            <div class="col-md-12 fs-13 mb-5">
                                <label class="mb-0 pb-0" for="email"> Email</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="col-md-12 fs-13 mb-5">
                                <label class="mb-0 pb-0" for="telefono"> Teléfono</label>
                                <input type="number" name="telefono" class="form-control">
                            </div>
                            <div class="col-md-12 fs-13 mb-5">
                                <label class="mb-0 pb-0" for="mensaje">Mensaje</label>
                                <textarea name="mensaje" class="required-entry form-control mb-10"></textarea>
                            </div>
                            <div class="col-md-12 check-box mb-10">
                                <div class="g-recaptcha mb-10" data-sitekey="<?= $captchaData['data']['captcha_key'] ?>"></div>
                                <button type="submit" name="enviar" class="btn btn-secondary">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-8">
                    <div class="table-c">
                        <?= $servicioData["data"]["desarrollo"] ?>
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
            <h2 class="fs-22  bold text-center text-uppercase"><?= $titleMoreProducts; ?>
                <hr />
            </h2>

            <div class="owl-carousel owl-theme owl-products">
                <?php foreach (array_chunk($servicioArray, 2) as $element) {
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
                <?php } ?>
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