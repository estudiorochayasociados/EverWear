<?php
$servicio = new Clases\Servicios();
$imagen = new Clases\Imagenes();
$zebra = new Clases\Zebra_Image();
$categorias = new Clases\Categorias();

$cod = $funciones->antihack_mysqli(isset($_GET["cod"]) ? $_GET["cod"] : '');
$borrarImg = $funciones->antihack_mysqli(isset($_GET["borrarImg"]) ? $_GET["borrarImg"] : '');
$categoriasData = $categorias->list(array("area = 'servicios'"), "titulo ASC", "");

$servicio->set("cod", $cod);
$servicioSingle = $servicio->view();

//CAMBIAR ORDEN DE LAS IMAGENES
if (isset($_GET["ordenImg"]) && isset($_GET["idImg"])) {
    $imagen->set("id", $_GET["idImg"]);
    $imagen->set("orden", $_GET["ordenImg"]);
    $imagen->setOrder();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=servicios&accion=modificar&cod=$cod");
}

//BORRAR IMAGEN
if ($borrarImg != '') {
    $imagen->set("id", $borrarImg);
    $imagen->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=servicios&accion=modificar&cod=$cod");
}

//GUARDAR
if (isset($_POST["modificar"])) {
    $count = 0;
    $servicio->set("cod", $cod);
    $servicio->set("titulo", $funciones->antihack_mysqli(isset($_POST["titulo"]) ? $_POST["titulo"] : ''));
    $servicio->set("categoria", $funciones->antihack_mysqli(isset($_POST["categoria"]) ? $_POST["categoria"] : ''));
    $servicio->set("subcategoria", $funciones->antihack_mysqli(isset($_POST["subcategoria"]) ? $_POST["subcategoria"] : ''));
    $servicio->set("desarrollo", $funciones->antihack_mysqli(isset($_POST["desarrollo"]) ? $_POST["desarrollo"] : ''));
    $servicio->set("fecha", $funciones->antihack_mysqli(isset($_POST["fecha"]) ? $_POST["fecha"] : ''));
    $servicio->set("description", $funciones->antihack_mysqli(isset($_POST["description"]) ? $_POST["description"] : ''));
    $servicio->set("keywords", $funciones->antihack_mysqli(isset($_POST["keywords"]) ? $_POST["keywords"] : ''));

    foreach ($_FILES['files']['name'] as $f => $name) {
        $imgTemp = $_FILES["files"]["tmp_name"][$f];
        $imgNombre = $_FILES["files"]["name"][$f];
        $explodeNombre = explode(".", $imgNombre);
        $imgExtension = (count($explodeNombre) - 1);
        $extension = $explodeNombre[$imgExtension];
        $nombreAlternativo = substr(md5(uniqid(rand())), 0, 10);
        if ($extension != '') {
            $imgDestino = "../assets/archivos/" . $nombreAlternativo . "." . $extension;
            move_uploaded_file($imgTemp, $imgDestino);
            chmod($imgDestino, 0777);
            $imgRecortada = "../assets/archivos/recortadas/a_" . $nombreAlternativo . "." . $extension;

            $zebra->source_path = $imgDestino;
            $zebra->target_path = $imgRecortada;
            $zebra->jpeg_quality = 80;
            $zebra->preserve_aspect_ratio = true;
            $zebra->enlarge_smaller_images = true;
            $zebra->preserve_time = true;

            if ($zebra->resize(800, 700, ZEBRA_IMAGE_NOT_BOXED)) {
                unlink($imgDestino);
            }

            $imagen->set("cod", $cod);
            $imagen->set("ruta", str_replace("../", "", $imgRecortada));
            $imagen->add();
        }
        $count++;
    }
    $servicio->edit();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=servicios");
}
//print("<pre>".print_r($categoriasData,true)."</pre>");
?>

<div class="col-md-12 ">
    <h4>
        Servicios
    </h4>
    <hr />
    <form method="post" class="row" enctype="multipart/form-data">
        <label class="col-md-3">
            T??tulo:<br />
            <input type="text" value="<?= $servicioSingle["data"]["titulo"] ?>" name="titulo" required>
        </label>
        <label class="col-md-3">
            Categor??a:<br />
            <select name="categoria">
                <option value="">-- categor??as --</option>
                <?php
                foreach ($categoriasData as $categoria) {
                    if ($servicioSingle["data"]["categoria"] == $categoria["data"]["cod"]) {
                        echo "<option value='" . $categoria["data"]["cod"] . "' selected>" . mb_strtoupper($categoria["data"]["titulo"]) . "</option>";
                    } else {
                        echo "<option value='" . $categoria["data"]["cod"] . "'>" . mb_strtoupper($categoria["data"]["titulo"]) . "</option>";
                    }
                }
                ?>
            </select>
        </label>
        <label class="col-md-3">
            Subcategor??a:<br />
            <select name="subcategoria">
                <option value="">-- Sin subcategor??a --</option>
                <?php
                foreach ($categoriasData as $categoria) {
                ?>
                    <optgroup label="<?= mb_strtoupper($categoria["data"]['titulo']) ?>">
                        <?php
                        foreach ($categoria["subcategories"] as $subcategorias) {
                            if ($servicioSingle["data"]["subcategoria"] == $subcategorias["data"]["cod"]) {
                                echo "<option value='" . $subcategorias["data"]["cod"] . "' selected>" . mb_strtoupper($subcategorias["data"]["titulo"]) . "</option>";
                            } else {
                                echo "<option value='" . $subcategorias["data"]["cod"] . "'>" . mb_strtoupper($subcategorias["data"]["titulo"]) . "</option>";
                            }
                        }
                        ?>
                    </optgroup>
                <?php
                }
                ?>
            </select>
        </label>
        <label class="col-md-3">
            Fecha:<br />
            <input type="date" name="fecha" value="<?= $servicioSingle["data"]["fecha"] ?>">
        </label>

        <div class="clearfix">
        </div>
        <label class="col-md-12">
            Desarrollo:<br />
            <textarea name="desarrollo" class="ckeditorTextarea" required>
                <?= $servicioSingle["data"]["desarrollo"]; ?>
            </textarea>
        </label>
        <div class="clearfix">
        </div>
        <label class="col-md-12">
            Palabras claves dividas por ,<br />
            <input type="text" name="keywords" value="<?= $servicioSingle["data"]["keywords"] ?>">
        </label>
        <label class="col-md-12">
            Descripci??n breve<br />
            <textarea name="description"><?= $servicioSingle["data"]["description"] ?></textarea>
        </label>
        <br />
        <div class="col-md-12">
            <div class="row">
                <?php
                if (!empty($servicioSingle['images'])) {
                    foreach ($servicioSingle['images'] as $img) {
                ?>
                        <div class='col-md-2 mb-20 mt-20'>
                            <div style="height:200px;background:url(<?= '../' . $img['ruta']; ?>) no-repeat center center/contain;">
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <a href="<?= URL_ADMIN . '/index.php?op=servicios&accion=modificar&cod=' . $servicioSingle["data"]['cod'] . '&borrarImg=' . $img['id'] ?>" class="btn btn-sm btn-block btn-danger">
                                        BORRAR IMAGEN
                                    </a>
                                </div>
                                <div class="col-md-5 text-right">
                                    <select onchange='$(location).attr("href", "<?= CANONICAL ?>&idImg=<?= $img["id"] ?>&ordenImg="+$(this).val())'>
                                        <?php
                                        for ($i = 0; $i <= count($servicioSingle['images']); $i++) {
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
        <label class="col-md-12">
            Im??genes:<br />
            <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" />
        </label>
        <div class="clearfix">
        </div>
        <br />
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" name="modificar" value="Modificar" />
        </div>
    </form>
</div>