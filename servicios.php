<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$categoria = new Clases\Categorias();
$subcategoria = new Clases\Subcategorias();
$servicio = new Clases\Servicios();
$contenido = new Clases\Contenidos();

$categoriaCod = isset($_GET["categoria"]) ? $_GET["categoria"] : null;
$subcategoriaCod = isset($_GET["subcategoria"]) ? $_GET["subcategoria"] : null;
$linea = isset($_GET["linea"]) ? $_GET["linea"] : null;

$lineasArray = $contenido->list(["titulo LIKE 'LINEAS | $linea'"], "", "")[0];

$categoria->set("cod", $categoriaCod);
$categoriaData = $categoria->view();

$subcategoria->set("cod", $subcategoriaCod);
$subcategoriaData = $subcategoria->view();

$filter = [];

if (!empty($categoriaCod)) {
    $filter[] = "categoria = '" . $categoriaCod . "'";
    $titlePageSup = $categoriaData["data"]["titulo"];
    $titlePageInf = $categoriaData["data"]["titulo"];
    $descriptionPage = $categoriaData["data"]["descripcion"];
}

if (!empty($subcategoriaCod)) {
    $filter[] = "subcategoria = '" . $subcategoriaCod . "'";
    $titlePageSup = $subcategoriaData["data"]["titulo"];
    $titlePageInf = "<a href='" . URL . '/lineas/l/' . $linea . '/c/' . $categoriaData["data"]["cod"] . "'>" . $categoriaData["data"]["titulo"] . '</a> <i class="fas fa-angle-double-right"></i> ' . $subcategoriaData["data"]["titulo"];
    $descriptionPage = $subcategoriaData["data"]["descripcion"];
}


$serviciosArray = $servicio->list($filter, "", "");

$template->themeInit();

$img = (count($lineasArray["images"]) != 0) ? URL . "/" . $lineasArray["images"][1]["ruta"] : URL . "/assets/archivos/60fe6cceb4.png";

$template->set("title", "Productos | " . TITULO);
$template->set("description", "");
$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->set("body", "");

?>
<main>
    <!-- slider -->
    <?php if (!empty($subcategoriaCod) || !empty($categoriaCod)) { ?>
        <div class="img-slider-content" style="background: url(<?= $img ?>) center/cover no-repeat;">
            <div class="container">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6 vertical-align justify-slider-content bf bg-tr">
                        <h3 class="vertical-text text-uppercase">
                            <?= $titlePageSup; ?>
                        </h3>
                        <span class="text-capitalize"><?= $descriptionPage; ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- product section -->
    <section class="pt-50 pb-50 mt-30 section-white box-shadow link-product">
        <div class="container">
            <h2 class="text-uppercase fs-25 bold"><?= $titlePageInf; ?>
                <hr />
            </h2>
            <div class="row">
                <?php foreach ($serviciosArray as $element) {
                    $img = isset($element['images'][0]['ruta']) ? $element['images'][0]['ruta'] : 'assets/archivos/sin_imagen.jpg';
                    $img = URL . '/' . $img;
                ?>
                    <div class="col-md-3">
                        <a href="<?= URL . '/producto/' . $funciones->normalizar_link($element['data']['titulo']) . '/' . $element['data']['cod'] ?>">
                            <div class="box-content mt-10">
                                <div class="info-box" style="background: url(<?= $img ?>)"></div>
                                <div class="info-text">
                                    <h6><?= mb_substr($element['data']['titulo'], 0, 39) ?></h6>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
</main>
<?php $template->themeEnd() ?>