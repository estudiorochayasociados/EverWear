<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$categoria = new Clases\Categorias();
$contenido = new Clases\Contenidos();

$linea = $funciones->antihack_mysqli(isset($_GET["linea"]) ? $_GET["linea"] : null);
$categoriaCod = $funciones->antihack_mysqli(isset($_GET["categoria"]) ? $_GET["categoria"] : null);
$topHeader = $contenido->viewByTitle('LÍNEAS DE PRODUCTOS');

$lineasArray = [];
$categoriasArray = [];
$subcategoriasArray = [];

$filter = '';
$lineas = [];
$lineasFull = [];

$titlePageSup = $topHeader["data"]["titulo"];
$titlePageInf = $topHeader["data"]["titulo"];

$descriptionPage = $topHeader["data"]["contenido"];


//Traigo todos los contenidos de lineas
$lineasArray = $contenido->list(["titulo LIKE 'LINEAS |%'"], "", "");
$img = (count($topHeader["images"]) != 0) ? URL . "/" . $topHeader["images"][0]["ruta"] : URL . "/assets/archivos/60fe6cceb4.png";

foreach ($lineasArray as $lineaData) {
    $lineas[] = $funciones->normalizar_link(trim(explode("|", $lineaData["data"]["titulo"])[1]));
}

if (!empty($linea)) {
    //Compruebo que la linea sea valida
    if (in_array($linea, $lineas)) {
        foreach ($lineasArray as $lineaData) {
            $lineaActual = $funciones->normalizar_link(trim(explode("|", $lineaData["data"]["titulo"])[1]));
            //Busco la línea en la que estoy y obtengo los datos
            if ($linea == $lineaActual) {

                $categoriasActual = explode(",", $lineaData["data"]["subtitulo"]);
                foreach ($categoriasActual as $cat) {
                    $filter .= "cod = '" . $cat . "' OR ";
                }
                $filter = [mb_substr($filter, 0, -3)];

                if (empty($categoriaCod)) {
                    $categoriasArray = $categoria->list($filter, "", "");
                }

                $titlePageSup = 'Línea ' . trim(explode("|", $lineaData["data"]["titulo"])[1]);
                $titlePageInf = '<a href="' . URL . '/lineas" class="link-linea">Líneas</a> <i class="fas fa-angle-double-right"></i> Línea ' . trim(explode("|", $lineaData["data"]["titulo"])[1]);
                $descriptionPage = @explode("|||", $lineaData["data"]["contenido"])[0];
                $descriptionPage2 = @explode("|||", $lineaData["data"]["contenido"])[1];
                $img = @($lineaData["images"][1]["ruta"]) ? URL . "/" . $lineaData["images"][1]["ruta"] : URL . "/assets/archivos/60fe6cceb4.png";
            }
        }
    }
}

if (!empty($categoriaCod)) {
    $categoria->set("cod", $categoriaCod);
    $categoriaData = $categoria->view();

    $subcategoriasArray = $categoriaData["subcategories"];

    foreach ($lineasArray as $lineaData) {
        $categoriasActual = explode(",", $lineaData["data"]["subtitulo"]);
        //Busco la línea en la que estoy y obtengo los datos
        if (in_array($categoriaCod, $categoriasActual)) {
            $titlePageSup = $categoriaData['data']['titulo'];
            $titlePageInf = '<a href="' . URL . '/lineas/l/' . $funciones->normalizar_link(trim(explode('|', $lineaData['data']['titulo'])[1])) . '" class="link-linea">Línea ' . trim(explode('|', $lineaData['data']['titulo'])[1]) . '</a> <i class="fas fa-angle-double-right"></i> ' . $categoriaData['data']['titulo'];
            $descriptionPage = $categoriaData['data']['descripcion'];
        }
    }
}

$template->set("title", ucwords(mb_strtolower($titlePageSup)) . " | " . TITULO);
$template->set("description", strip_tags($descriptionPage));
$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->set("body", "");
$template->themeInit();
?>
<!-- slider -->

<div class="img-slider-content" style="background: url(<?= $img ?>)center/cover no-repeat;">
    <div class="container">
        <div class="row <?= !empty($categoriasArray) ? 'd-block' : 'd-none' ?>">
            <div class="col-md-6"></div>
            <div class="col-md-6 vertical-align justify-slider-content bf bg-tr">
                <h3 class="vertical-text text-uppercase">
                    <?= $titlePageSup; ?>
                </h3>
                <span><?= $descriptionPage; ?></span>
            </div>
        </div>
    </div>
</div>

<!-- lineas section -->
<section class="  pb-50 mt-30  ">
    <div class="container">
        <?php ($linea == 'automotor') ? @include_once('correas.php') : '' ?>
        <?php ($linea == 'hidraulica') ? @include_once('terminales.php') : '' ?>
        <?php
        //echo isset($descriptionPage2) ? $descriptionPage2 : ''  
        ?>
        <hr />
        <h2 class="col-md-12 fs-25 bold text-uppercase">
            <?= $titlePageInf ?>
            <hr />
        </h2>
        <div class="owl-carousel owl-theme owl-categories">
            <?php
            if (empty($linea) && empty($categoriaCod)) {
                foreach ($lineasArray as $element) {
                    $img = isset($element['images'][0]['ruta']) ? $element['images'][0]['ruta'] : 'assets/archivos/sin_imagen.jpg';
                    $img = URL . '/' . $img;
            ?>
                    <div class="item">
                        <div class="category-content">
                            <a class="link-linea" href="<?= URL . '/lineas/l/' . $funciones->normalizar_link(trim(explode("|", $element['data']['titulo'])[1])) ?>">
                                <div class="info-icon" style="background: url(<?= $img ?>)center/contain no-repeat"></div>
                                <div class="info-text text-center">
                                    <h5><?= trim(explode("|", $element['data']['titulo'])[1]) ?></h5>
                                </div>
                            </a>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
            <?php
            if (!empty($categoriasArray)) {
                foreach ($categoriasArray as $element) {
                    $img = isset($element['image']['ruta']) ? $element['image']['ruta'] : 'assets/archivos/sin_imagen.jpg';
                    $img = URL . '/' . $img;

                    $link = empty($element['subcategories']) ? URL . '/productos/c/' . $element['data']['cod'] . '/l/' . $linea  : URL . '/lineas/l/' . $linea . '/c/' . $element['data']['cod'];
            ?>
                    <div class="item">
                        <div class="category-content">
                            <a class="link-linea" href="<?= $link ?>">
                                <div class="info-icon" style="background: url(<?= $img ?>)center/contain no-repeat"></div>
                                <div class="info-text text-center">
                                    <h5><?= $element['data']['titulo'] ?></h5>
                                </div>
                            </a>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
            <?php
            if (!empty($subcategoriasArray)) {
                foreach ($subcategoriasArray as $element) {
                    $img = isset($element['image']['ruta']) ? $element['image']['ruta'] : 'assets/archivos/sin_imagen.jpg';
                    $img = URL . '/' . $img;
            ?>
                    <div class="item">
                        <div class="category-content">
                            <a class="link-linea" href="<?= URL . '/productos/c/' . $categoriaCod . '/s/' . $element['data']['cod'] .  '/l/' . $linea ?>">
                                <div class="info-icon" style="background: url(<?= $img ?>)center/contain no-repeat"></div>
                                <div class="info-text text-center">
                                    <h5><?= $element['data']['titulo'] ?></h5>
                                </div>
                            </a>
                        </div>
                    </div>
            <?php
                }
            }
            ?>
        </div>
        <div class="row mt-40">
            <div class="col-md-6">
                <div style="width:100%;background:#ffc500;padding:30px">
                    <h2 class="fs-16 bold">PROBASTE NUESTRA HERRAMIENTA DE</h2>
                    <h1 class="fs-20 bold">BUSCADOR DE CÓDIGOS CORREAS</h1>
                    <hr />
                    <p>Herramienta creada para que encuentres qué código de terminales tenes que pedirle a tu distrubidor.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div style="width:100%;background:#ffc500;padding:30px">
                    <h2 class="fs-16 bold">PROBASTE NUESTRA HERRAMIENTA DE</h2>
                    <h1 class="fs-20 bold">BUSCADOR DE CÓDIGOS TERMINALES</h1>
                    <hr />
                    <p>Herramienta creada para que encuentres qué código de correas tenes que pedirle a tu distrubidor.</p>
                </div>
            </div>
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