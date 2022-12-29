<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$subcategoria = new Clases\Subcategorias();
$categoria = new Clases\Categorias();
$productos = new Clases\Productos();
$contenido = new Clases\Contenidos();


$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->set("body", "");
$template->themeInit();


$codigo = isset($_GET["codigo"]) ? $funciones->antihack_mysqli($_GET["codigo"]) : '';
$categoria_ = $categoria->list(["cod = '$codigo'"], 1, "")[0];
$subcategoria_ = $subcategoria->list(["categoria = '" . $codigo . "'"], "orden ASC", "");
?>
<!-- slider -->

<div class="img-slider-content" style="background: url(<?= URL . "/" . $categoria_["images"][1]["ruta"] ?>) center center/100% no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-md-6"></div>
            <div class="col-md-6 vertical-align justify-slider-content bf bg-tr">
                <h3 class="pl-30 text-uppercase">
                    LÍNEA <?= $categoria_["data"]["titulo"] ?>
                </h3>
                <span> </span>
            </div>
        </div>
    </div>
</div>

<!-- lineas section -->
<section class="  pb-50 mt-30  ">
    <div class="container">
        <?= $categoria_["data"]["descripcion"] ?>
        <div class="row">
            <?php
            if ($subcategoria_) {
                foreach ($subcategoria_ as $element) {
                    $img = isset($element['images'][0]['ruta']) ?  URL . "/" . $element['images'][0]['ruta'] : URL . '/assets/archivos/sin_imagen.jpg';
            ?>
                    <div class="col-md-3 col-xs-6">
                        <div class="category-content">
                            <a class="link-linea" href="<?= URL . '/tercerlineas/' . $funciones->normalizar_link($element['data']['titulo']) . "/" . $element['data']['cod'] ?>">
                            <?php if($element['data']['cod']== '9cf6c0dc6a') { ?>    
                                <div class="info-icon" style="background: url(<?= $img ?>) center center no-repeat;background-size:50% auto !important"></div>
                                <?php } else { ?>
                                <div class="info-icon" style="background: url(<?= $img ?>) center center no-repeat;background-size:70% auto !important"></div>
                                <?php } ?>
                                <div class="info-text text-center" style="height:70px">
                                    <h5 class="fs-16"><?= $element['data']['titulo'] ?></h5>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php
                }
            } else {
                foreach ($productos->list(["categoria = '$codigo'"], "", "") as $element) {
                    $img = isset($element['images'][0]['ruta']) ?  URL . "/" . $element['images'][0]['ruta'] : URL . '/assets/archivos/sin_imagen.jpg';
                ?>
                    <div class="col-md-3 col-xs-6">
                        <div class="category-content">
                            <a class="link-linea" href="<?= URL . '/producto/' . $funciones->normalizar_link($element['data']['titulo']) . "/" . $element['data']['cod'] ?>">
                                <div class="info-icon" style="background: url(<?= $img ?>) center center no-repeat;background-size:70% auto !important"></div>
                                <div class="info-text text-center" style="height:70px">
                                    <h5 class="fs-16"><?= $element['data']['titulo'] ?></h5>
                                </div>
                            </a>
                        </div>
                    </div>
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