<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$tercercategoria = new Clases\TercerCategorias();
$productos = new Clases\Productos();
$codigo = isset($_GET["codigo"]) ? $funciones->antihack_mysqli($_GET["codigo"]) : '';

$tercercategoria_ = $tercercategoria->list(["cod = '" . $codigo . "'"], "", "")[0];

$template->set("title", "Línea de Productos - " . TITULO);
$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->set("body", "");
$template->themeInit();

?>
<!-- slider -->

<div class="img-slider-content" style="background: url('<?= URL . "/" . $tercercategoria_["images"][1]["ruta"] ?>')center/cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 vertical-align justify-slider-content bf bg-tr">
                <h3 class="pl-30 text-uppercase">
                    <?= $tercercategoria_["data"]["titulo"] ?>
                </h3>
                <span></span>
            </div>
        </div>
    </div>
</div>

<!-- lineas section -->
<section class="pb-50 mt-30">
    <div class="container">
        <?= $tercercategoria_["data"]["descripcion"] ?>
        <?php (strtoupper($tercercategoria_['data']['titulo']) == 'TERMINALES') ? @include_once('terminales.php') : '' ?>
        <div class="row mt-20">
            <?php
            // SE MODIFICO LA BASE COD_PRODUCTO INT PARA ORDENAR
            foreach ($productos->list(["variable1 = '" . $codigo . "'"], "cod_producto ASC", "") as $element) {
                $img = isset($element['images'][0]['ruta']) ?  URL . "/" . $element['images'][0]['ruta'] : URL . '/assets/archivos/sin_imagen.jpg';
            ?>
                <div class="col-md-3 col-xs-6">
                    <div class="category-content">
                        <a class="link-linea" href="<?= URL . '/producto/' . $funciones->normalizar_link($element['data']['titulo']) . "/" . $element['data']['cod'] ?>">
                        <?php if($element['data']['cod']== 'fafdd9dd3a' || $element['data']['cod']=='5b74f30cf3'|| $element['data']['cod']=='30ce3f630a' || $element['data']['cod']=='e5037b4a8e' || $element['data']['cod']=='8ce6577e6e' || $element['data']['cod']=='8c558cdc0c' || $element['data']['cod']=='c55f8b96a0' || $element['data']['cod']== '769a99a475') { ?>
                            <div class="info-icon" style="background: url(<?= $img ?>) center center no-repeat; background-size:40% auto !important"></div>
                        <?php } else { ?>
                            <div class="info-icon" style="background: url(<?= $img ?>) center center no-repeat; background-size:70% auto !important"></div>
                        <?php } ?>
                            <div class="info-text text-center" style="height:70px">
                                <h5 class="fs-16"><?= $element['data']['titulo'] ?></h5>
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