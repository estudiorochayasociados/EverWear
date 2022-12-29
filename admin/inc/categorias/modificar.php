<?php
$categorias = new Clases\Categorias();
$imagenes = new Clases\Imagenes();
$zebra = new Clases\Zebra_Image();
$cod = $funciones->antihack_mysqli(isset($_GET["cod"]) ? $_GET["cod"] : '');
$categorias->set("cod", $cod);
$data = $categorias->view();

$cod = $funciones->antihack_mysqli(isset($_GET["cod"]) ? $_GET["cod"] : '');
$borrarImg = $funciones->antihack_mysqli(isset($_GET["borrarImg"]) ? $_GET["borrarImg"] : '');

if ($borrarImg != '') {
    $imagenes->set("id", $borrarImg);
    $imagenes->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=categorias&accion=modificar&cod=$cod");
}

//CAMBIAR ORDEN DE LAS IMAGENES
if (isset($_GET["ordenImg"]) && isset($_GET["idImg"])) {
    $imagenes->set("id", $_GET["idImg"]);
    $imagenes->set("orden", $_GET["ordenImg"]);
    $imagenes->setOrder();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=categorias&accion=modificar&cod=$cod");
}

if (isset($_POST["agregar"])) {
    $categorias->set("cod", $funciones->antihack_mysqli(isset($_POST["cod"]) ? $_POST["cod"] : ''));
    $categorias->set("titulo", $funciones->antihack_mysqli(isset($_POST["titulo"]) ? $_POST["titulo"] : ''));
    $categorias->set("area", $funciones->antihack_mysqli(isset($_POST["area"]) ? $_POST["area"] : ''));
    $categorias->set("descripcion", $funciones->antihack_mysqli(isset($_POST["descripcion"]) ? $_POST["descripcion"] : ''));
    $categorias->set("orden", $funciones->antihack_mysqli(isset($_POST["orden"]) ? $_POST["orden"] : '0'));
    $categorias->set("id", $data['data']['id']);
    $count = 0;
    if (isset($_FILES['files'])) {
        foreach ($_FILES['files']['name'] as $f => $name) {
            $imgInicio = $_FILES["files"]["tmp_name"][$f];
            $tucadena = $_FILES["files"]["name"][$f];
            $partes = explode(".", $tucadena);
            $dom = (count($partes) - 1);
            $dominio = $partes[$dom];
            $prefijo = substr(md5(uniqid(rand())), 0, 10);
            if ($dominio != '') {
                $destinoFinal = "../assets/archivos/" . $prefijo . "." . $dominio;
                move_uploaded_file($imgInicio, $destinoFinal);
                chmod($destinoFinal, 0777);
                $destinoRecortado = "../assets/archivos/recortadas/a_" . $prefijo . "." . $dominio;

                $zebra->source_path = $destinoFinal;
                $zebra->target_path = $destinoRecortado;
                $zebra->jpeg_quality = 80;
                $zebra->preserve_aspect_ratio = true;
                $zebra->png_compression = true;
                $zebra->enlarge_smaller_images = true;
                $zebra->preserve_time = true;

                if ($zebra->resize(1920, 0, ZEBRA_IMAGE_NOT_BOXED, $background_color = -1)) {
                    unlink($destinoFinal);
                }

                $imagenes->set("cod", $cod);
                $imagenes->set("ruta", str_replace("../", "", $destinoRecortado));
                $imagenes->add();
            }
            $count++;
        }
    }
    if ($categorias->edit()) {
        $imagenes->set("cod", $funciones->antihack_mysqli(isset($_POST["cod"]) ? $_POST["cod"] : ''));
        $imagenes->editAllCod($cod);
        $funciones->headerMove(URL_ADMIN . "/index.php?op=categorias");
    }
}
?>
<div class="col-md-12">
    <h4>Categorías</h4>
    <hr />
    <form method="post" class="row" enctype="multipart/form-data">
        <label class="col-md-3">Código:<br />
            <input type="text" value="<?= $data['data']["cod"] ?>" name="cod" required>
        </label>
        <label class="col-md-3">Título:<br />
            <input type="text" value="<?= $data['data']["titulo"] ?>" name="titulo" required>
        </label>
        <label class="col-md-3">Orden:<br />
            <input type="text" value="<?= $data['data']["orden"] ?>" name="orden" required>
        </label>
        <label class="col-md-3">Área:<br />
            <select name="area" required>
                <option value="<?= $data['data']["area"] ?>" selected><?= ucwords($data['data']["area"]) ?></option>
                <option>---------------</option>
                <option value="sliders">Sliders</option>
                <option value="banners">Banners</option>
                <option value="novedades">Novedades</option>
                <option value="portfolio">Portfolio</option>
                <option value="servicios">Servicios</option>
                <option value="galerias">Galerias</option>
                <option value="productos">Productos</option>
                <option value="landing">Landing</option>
                <option value="videos">Videos</option>
            </select>
        </label>
        <label class="col-md-12">Descripción:<br />
            <textarea class="ckeditorTextarea" name="descripcion"><?= $data['data']["descripcion"] ?></textarea>
        </label>
        <div class="clearfix"></div>
        <br />
        <?php
        foreach ($data['images'] as $img) {
        ?>
            <div class='col-md-2 mb-20 mt-20'>
                <div style="height:200px;background:url(<?= '../' . $img['ruta']; ?>) no-repeat center center/contain;">
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <a href="<?= URL_ADMIN . '/index.php?op=categorias&accion=modificar&cod=' . $img['cod'] . '&borrarImg=' . $img['id'] ?>" class="btn btn-sm btn-block btn-danger">
                            BORRAR IMAGEN
                        </a>
                    </div>
                    <div class="col-md-5 text-right">
                        <select onchange='$(location).attr("href", "<?= CANONICAL ?>&idImg=<?= $img["id"] ?>&ordenImg="+$(this).val())'>
                            <?php
                            for ($i = 0; $i <= count($data['images']); $i++) {
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
        ?>

        <label class="col-md-12">Imágenes:<br />
            <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" />
        </label>
        <div class="clearfix">
        </div>
        <br />
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" name="agregar" value="Modificar Categoría" />
        </div>
    </form>
</div>