<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$subcategoria = new Clases\Subcategorias();
$productos = new Clases\Productos();
$tercercategoria = new Clases\TercerCategorias();
$contenido = new Clases\Contenidos();




$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->set("body", "");
$template->themeInit();
$codigo = isset($_GET["codigo"]) ? $funciones->antihack_mysqli($_GET["codigo"]) : '';
$subcategoria_ = $subcategoria->list(["cod = '" . $codigo . "'"], "", "")[0];
$tercercategoria_ = $tercercategoria->list(["subcategoria = '" . $codigo . "'"], "orden ASC", "");
?>
<!-- slider -->
<style>
    .hoverBtn{
       margin: 5px;
       transition: transform 250ms;
    }
    .hoverBtn:hover {
        border: 5px solid #f4cc07;
        transform: translateY(-10);
    }
</style>
<div class="img-slider-content" style="background: url(<?= URL . "/" . $subcategoria_["images"][1]["ruta"] ?>)center center/100% no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 vertical-align justify-slider-content bf bg-tr">
                <h3 class="pl-30 text-uppercase">
                    <?= $subcategoria_["data"]["titulo"] ?>
                </h3>
            </div>
        </div>
    </div>
</div>

<!-- lineas section -->
<section class="  pb-50 mt-30  ">
    <div class="container">
        <?php /*($subcategoria_['data']['titulo'] == 'CORREAS AUTOMOTOR') ? @include_once('correas.php') : '' ?>
        <?php ($subcategoria_['data']['titulo'] == 'CORREAS AGRICOLAS') ? @include_once('correas-agricolas.php') : '' */ ?>

        <?php (strtoupper($subcategoria_['data']['titulo']) == 'TERMINALES') ? @include_once('terminales.php') : '' ?>

        <?= $subcategoria_["data"]["descripcion"] ?>
        <div class="row mt-20">
            <?php if ($subcategoria_['data']['titulo'] == 'CORREAS AUTOMOTOR') { ?>
                <div class="col-md-2 col-xs-6">
                    <div class="category-content">
                        <a class="link-linea" href="<?= URL ?>/correas.php">
                            <div class="info-icon" style="background: url(<?= URL ?>/assets/archivos/images/buscador.png) center center no-repeat;background-size:70% auto !important">
                            </div>
                            <div class="info-text text-center" style="height:70px">
                                <h5 class="fs-16"> buscá tu correa según tu vehículo</h5>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <?php if ($subcategoria_['data']['titulo'] == 'CORREAS AGRICOLAS') { ?>
                <div class="col-md-6 col-xs-12 ">
                    <a class="link-linea" href="<?= URL ?>/correas-agricolas.php">
                        <img class="hoverBtn" src="<?= URL ?>/assets/img/buscador.jpg" width="100%" alt="">
                    </a>
                </div>
                <div class="col-md-6 col-xs-12 ">
                    <a class="link-linea" href="<?= URL ?>/calculadora.php">
                        <img class="hoverBtn" src="<?= URL ?>/assets/img/calculadora.jpg" width="100%" alt="">
                    </a>
                </div>
                <div class="col-md-12">
                    <hr>
                </div>
            <?php } ?>
            <?php if ($subcategoria_['data']['titulo'] == 'poleas') { ?>
                <div class="col-md-12 col-xs-12" style="text-align: center;">
                    <a class=" link-linea" href="<?= URL ?>/calculadora.php">
                        <img class="hoverBtn" src="<?= URL ?>/assets/img/calculadora.jpg" width="50%" alt="">
                    </a>
                </div>
                <div class="col-md-12">
                    <hr>
                </div>
            <?php } ?>
            <?php
            if ($tercercategoria_) {
                foreach ($tercercategoria_ as $element) {
                    $img = isset($element['images'][0]['ruta']) ? $element['images'][0]['ruta'] : 'assets/archivos/sin_imagen.jpg';
                    $img = URL . '/' . $img;
            ?>
                    <div class="col-md-2 col-xs-6">
                        <div class="category-content">
                            <a class="link-linea" href="<?= URL . '/productos/' . $funciones->normalizar_link($element['data']['titulo']) . "/" . $element['data']['cod'] ?>">
                                <div class="info-icon" style="background: url(<?= $img ?>) center center no-repeat;background-size:70% auto !important">
                                </div>
                                <div class="info-text text-center" style="height:70px">
                                    <h5 class="fs-16"><?= $element['data']['titulo'] ?></h5>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                foreach ($productos->list(["subcategoria = '$codigo'"], "cod_producto ASC", "") as $element) {
                    $img = isset($element['images'][0]['ruta']) ? $element['images'][0]['ruta'] : 'assets/archivos/sin_imagen.jpg';
                    $img = URL . '/' . $img;
                    if ($subcategoria_['data']['cod'] == 'ffa7ac1d4b') {
                    ?>
                        <div class="col-md-3 col-xs-6">
                            <div class="category-content">

                                <a class="link-linea" href="<?= URL . '/producto/' . $funciones->normalizar_link($element['data']['titulo']) . "/" . $element['data']['cod'] ?>">
                                    <div class="info-icon" style="background: url(<?= $img ?>) center center no-repeat;background-size:70% auto !important">
                                    </div>
                                    <div class="info-text text-center" style="height:70px">
                                        <h5 class="fs-16"><?= $element['data']['description'] ?></h5>
                                    </div>
                                </a>
                            </div>
                        </div>

                    <?php } elseif ($subcategoria_['data']['cod'] == '9cf6c0dc6a') { ?>
                        <div class="col-md-3 col-xs-6">
                            <div class="category-content">

                                <a class="link-linea" href="<?= URL . '/producto/' . $funciones->normalizar_link($element['data']['titulo']) . "/" . $element['data']['cod'] ?>">
                                    <div class="info-icon" style="background: url(<?= $img ?>) center center no-repeat;background-size:70% auto !important">
                                    </div>
                                    <div class="info-text text-center" style="height:70px">
                                        <h5 class="fs-16"><?= $element['data']['titulo'] ?></h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-2 col-xs-6">
                            <div class="category-content">

                                <a class="link-linea" href="<?= URL . '/producto/' . $funciones->normalizar_link($element['data']['titulo']) . "/" . $element['data']['cod'] ?>">
                                    <div class="info-icon" style="background: url(<?= $img ?>) center center no-repeat;background-size:70% auto !important">
                                    </div>
                                    <div class="info-text text-center" style="height:70px">
                                        <h5 class="fs-16"><?= $element['data']['titulo'] ?></h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
            <?php
                }
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