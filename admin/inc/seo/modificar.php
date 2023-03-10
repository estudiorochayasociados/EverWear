<?php
$seo = new Clases\Seo();
$imagenes = new Clases\Imagenes();
$zebra = new Clases\Zebra_Image();

$cod = isset($_GET["cod"]) ? $funciones->antihack_mysqli($_GET["cod"]) : '';
$borrarImg = isset($_GET["borrarImg"]) ? $funciones->antihack_mysqli($_GET["borrarImg"]) : '';

$seo->set("cod", $cod);
$url = $seo->view();

$imagenes->set("cod", $url['data']["cod"]);
$imagenes->set("link", "seo&accion=modificar");

if (isset($_GET["ordenImg"]) && isset($_GET["idImg"])) {
    $imagenes->set("id", $_GET["idImg"]);
    $imagenes->set("orden", $_GET["ordenImg"]);
    $imagenes->setOrder();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=seo&accion=modificar&cod=$cod");
}

if ($borrarImg != '') {
    $imagenes->set("id", $borrarImg);
    $imagenes->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=seo&accion=modificar&cod=$cod");
}

if (isset($_POST["agregar"])) {
    $count = 0;
    $cod = $url['data']["cod"];
    $seo->set("cod", $cod);
    $seo->set("url", isset($_POST["url"]) ? $funciones->antihack_mysqli($_POST["url"]) : '');
    $seo->set("title", isset($_POST["title"]) ? $funciones->antihack_mysqli($_POST["title"]) : '');
    $seo->set("description", isset($_POST["description"]) ? $funciones->antihack_mysqli($_POST["description"]) : '');
    $seo->set("keywords", isset($_POST["keywords"]) ? $funciones->antihack_mysqli($_POST["keywords"]) : '');

    if (isset($_FILES['files'])) {
        $imagenes->resizeImages($cod, $_FILES['files'], "../assets/archivos", "../assets/archivos/recortadas");
    }

    $seo->edit();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=seo");
}
?>

<div class="col-md-12 ">
    <h4>SEO</h4>
    <hr/>
    <form method="post" class="row" enctype="multipart/form-data">
    <label class="col-md-8">URL:<br/>
            <input type="text" value="<?= $url['data']["url"] ?>" name="url" required>
        </label>
        <label class="col-md-4">Título:<br/>
            <input type="text" value="<?= $url['data']["title"] ?>" name="title">
        </label>

        <div class="clearfix"></div>
        <label class="col-md-12">Palabras claves dividas por ,<br/>
            <input type="text" name="keywords" value="<?= $url['data']["keywords"] ?>">
        </label>
        <label class="col-md-12">Descripción<br/>
            <textarea name="description"><?= $url['data']["description"] ?></textarea>
        </label>
        <br/>
        <div class="col-md-12">
            <div class="row">
                <?php
                if (!empty($url['images'])) {
                    foreach ($url['images'] as $img) {
                        ?>
                        <div class='col-md-2 mb-20 mt-20'>
                            <div style="height:200px;background:url(<?= '../' . $img['ruta']; ?>) no-repeat center center/contain;">
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <a href="<?= URL_ADMIN . '/index.php?op=seo&accion=modificar&cod=' . $img['cod'] . '&borrarImg=' . $img['id'] ?>" class="btn btn-sm btn-block btn-danger">
                                        BORRAR IMAGEN
                                    </a>
                                </div>
                                <div class="col-md-5 text-right">
                                    <select onchange='$(location).attr("href", "<?= CANONICAL ?>&idImg=<?= $img["id"] ?>&ordenImg="+$(this).val())'>
                                        <?php
                                        for ($i = 0; $i <= count($url['images']); $i++) {
                                            if ($img["orden"] == $i) {
                                                echo "<option value='$i' selected>$i</option>";
                                            } else {
                                                echo "<option value='$i'>$i</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                    <i>orden</i>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="clearfix">
        </div>
        <label class="col-md-12">Imágenes:<br/>
            <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*"/>
        </label>
        <div class="clearfix"></div>
        <br/>
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" name="agregar" value="Modificar SEO"/>
        </div>
    </form>
</div>