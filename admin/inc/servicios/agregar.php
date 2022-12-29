<?php
$servicio = new Clases\Servicios();
$imagenes = new Clases\Imagenes();
$zebra = new Clases\Zebra_Image();

$categorias = new Clases\Categorias();
$categoriasData = $categorias->list(array("area = 'servicios'"), "titulo ASC", "");

if (isset($_POST["agregar"])) {
    $count = 0;
    $cod = substr(md5(uniqid(rand())), 0, 10);

    $servicio->set("cod", $cod);
    $servicio->set("titulo", $funciones->antihack_mysqli(!empty($_POST["titulo"]) ? $_POST["titulo"] : ''));
    $servicio->set("categoria", $funciones->antihack_mysqli(!empty($_POST["categoria"]) ? $_POST["categoria"] : ''));
    $servicio->set("subcategoria", $funciones->antihack_mysqli(!empty($_POST["subcategoria"]) ? $_POST["subcategoria"] : ''));
    $servicio->set("desarrollo", $funciones->antihack_mysqli(!empty($_POST["desarrollo"]) ? $_POST["desarrollo"] : ''));
    $servicio->set("fecha", $funciones->antihack_mysqli(!empty($_POST["fecha"]) ? $_POST["fecha"] : ''));
    $servicio->set("description", $funciones->antihack_mysqli(!empty($_POST["description"]) ? $_POST["description"] : ''));
    $servicio->set("keywords", $funciones->antihack_mysqli(!empty($_POST["keywords"]) ? $_POST["keywords"] : ''));

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
            $zebra->enlarge_smaller_images = true;
            $zebra->preserve_time = true;

            if ($zebra->resize(800, 700, ZEBRA_IMAGE_NOT_BOXED)) {
                unlink($destinoFinal);
            }

            $imagenes->set("cod", $cod);
            $imagenes->set("ruta", str_replace("../", "", $destinoRecortado));
            $imagenes->add();
        }
        $count++;
    }
    $servicio->add();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=servicios");
}
?>

<div class="col-md-12">
    <h4>Servicios</h4>
    <hr />
    <form method="post" class="row" enctype="multipart/form-data">
        <label class="col-md-3">Título:<br />
            <input type="text" name="titulo" required>
        </label>
        <label class="col-md-3">
            Categoría:<br />
            <select name="categoria">
                <option value="" selected>-- categorías --</option>
                <?php
                foreach ($categoriasData as $categoria) {
                    echo "<option value='" . $categoria["data"]["cod"] . "'>" . mb_strtoupper($categoria["data"]["titulo"]) . "</option>";
                }
                ?>
            </select>
        </label>
        <label class="col-md-3">
            Subcategoría:<br />
            <select name="subcategoria">
                <option value="" selected>-- Sin subcategoría --</option>
                <?php
                foreach ($categoriasData as $categoria) {
                ?>
                    <optgroup label="<?= mb_strtoupper($categoria["data"]['titulo']) ?>">
                        <?php
                        foreach ($categoria["subcategories"] as $subcategorias) {
                            echo "<option value='" . $subcategorias["data"]["cod"] . "'>" . mb_strtoupper($subcategorias["data"]["titulo"]) . "</option>";
                        }
                        ?>
                    </optgroup>
                <?php
                }
                ?>
            </select>
        </label>
        <label class="col-md-3">Fecha:<br />
            <input type="date" name="fecha">
        </label>
        <div class="clearfix"></div>
        <label class="col-md-12">Desarrollo:<br />
            <textarea name="desarrollo" class="ckeditorTextarea" required></textarea>
        </label>
        <div class="clearfix"></div>
        <label class="col-md-12">Palabras claves dividas por ,<br />
            <input type="text" name="keywords">
        </label>
        <label class="col-md-12">Descripción breve<br />
            <textarea name="description"></textarea>
        </label>
        <br />
        <label class="col-md-7">Imágenes:<br />
            <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" />
        </label>
        <div class="clearfix"></div>
        <br />
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" name="agregar" value="Agregar" />
        </div>
    </form>
</div>