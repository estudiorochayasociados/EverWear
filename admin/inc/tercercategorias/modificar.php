<?php
$subcategoria = new Clases\Subcategorias();
$tercercategoria = new Clases\TercerCategorias();
$imagen = new Clases\Imagenes();
$zebra = new Clases\Zebra_Image();
$funciones = new Clases\PublicFunction();

$cod = $funciones->antihack_mysqli(isset($_GET["cod"]) ? $_GET["cod"] : '');

$tercercategoria->set("cod", $cod);

$dataTercerCategoria = $tercercategoria->view();
$subcategoria->set("cod", $dataTercerCategoria["data"]["subcategoria"]);
$dataCategoria = $subcategoria->view();
$subcategorias = $subcategoria->list('', '', '');


$borrarImg = $funciones->antihack_mysqli(isset($_GET["borrarImg"]) ? $_GET["borrarImg"] : '');
if ($borrarImg != '') {
    $imagen->set("id", $borrarImg);
    $imagen->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=tercercategorias&accion=modificar&cod=$cod");
}
//CAMBIAR ORDEN DE LAS IMAGENES
if (isset($_GET["ordenImg"]) && isset($_GET["idImg"])) {
    $imagen->set("id", $_GET["idImg"]);
    $imagen->set("orden", $_GET["ordenImg"]);
    $imagen->setOrder();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=tercercategorias&accion=modificar&cod=$cod");
}

if (isset($_POST["agregar"])) {
    $count = 0;
    $codPost = isset($_POST["cod"]) ? $funciones->antihack_mysqli($_POST["cod"]) : '';
    $tercercategoria->set("cod", $codPost);
    $tercercategoria->set("titulo", isset($_POST["titulo"]) ? $funciones->antihack_mysqli($_POST["titulo"]) : '');
    $tercercategoria->set("subcategoria", isset($_POST["subcategoria"]) ? $funciones->antihack_mysqli($_POST["subcategoria"]) : '');
    $tercercategoria->set("orden", isset($_POST["orden"]) ? $funciones->antihack_mysqli($_POST["orden"]) : '0');
    $tercercategoria->set("descripcion", isset($_POST["descripcion"]) ? $funciones->antihack_mysqli($_POST["descripcion"]) : '');
    $tercercategoria->set("id", $dataTercerCategoria['data']['id']);

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

                if ($zebra->resize(800, 700, ZEBRA_IMAGE_NOT_BOXED, $background_color = -1)) {
                    unlink($destinoFinal);
                }

                $imagen->set("cod", $codPost);
                $imagen->set("ruta", str_replace("../", "", $destinoRecortado));
                $imagen->add();
            }
            $count++;
        }
    }
    if ($tercercategoria->edit()) {
        $imagen->set("cod", $codPost);
        $imagen->editAllCod($cod);
        $funciones->headerMove(URL_ADMIN . "/index.php?op=categorias");
    }
}
?>
<div class="col-md-12">
    <h4>
        Subcategorías
    </h4>
    <hr />
    <form method="post" class="row" enctype="multipart/form-data">
        <label class="col-md-3">Código:<br />
            <input type="text" name="cod" value="<?= $cod ?>" required>
        </label>
        <label class="col-md-3">
            Título:<br />
            <input type="text" name="titulo" value="<?= $dataTercerCategoria["data"]["titulo"] ?>" required>
        </label>
        <label class="col-md-3">
            Orden:<br />
            <input type="text" name="orden" value="<?= $dataTercerCategoria["data"]["orden"] ?>" required>
        </label>
        <label class="col-md-3">
            Categoria:<br />
            <select name="subcategoria" required>
                <option value="<?= $dataCategoria["data"]["cod"] ?>" selected>
                    <?= mb_strtoupper($dataCategoria["data"]["titulo"]); ?>
                </option>
                <?php
                foreach ($subcategorias as $subcategoria_) {
                    echo "<option value='" . $subcategoria_["data"]["cod"] . "'>" . mb_strtoupper($subcategoria_["data"]["titulo"]) . "</option>";
                }
                ?>
            </select>
        </label>
        <label class="col-md-12">
            Descripción:<br />
            <textarea type="text" class="ckeditorTextarea" name="descripcion" required><?= $dataTercerCategoria["data"]["descripcion"] ?></textarea>
        </label>
        <div class="clearfix">
        </div>
        <?php
        foreach ($dataTercerCategoria['images'] as $img) {
        ?>
            <div class='col-md-2 mb-20 mt-20'>
                <div style="height:200px;background:url(<?= '../' . $img['ruta']; ?>) no-repeat center center/contain;">
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <a href="<?= URL_ADMIN . '/index.php?op=tercercategorias&accion=modificar&cod=' . $img['cod'] . '&borrarImg=' . $img['id'] ?>" class="btn btn-sm btn-block btn-danger">
                            BORRAR IMAGEN
                        </a>
                    </div>
                    <div class="col-md-5 text-right">
                        <select onchange='$(location).attr("href", "<?= CANONICAL ?>&idImg=<?= $img["id"] ?>&ordenImg="+$(this).val())'>
                            <?php
                            for ($i = 0; $i <= count($dataTercerCategoria['images']); $i++) {
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

        <label class="col-md-12">Imagen:<br />
            <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" />
        </label>

        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" name="agregar" value="Modificar Subcategoría" />
        </div>
    </form>
</div>