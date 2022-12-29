<?php
$imagenes = new Clases\Imagenes();
$zebra = new Clases\Zebra_Image();
$banners = new Clases\Banner();

$cod = $funciones->antihack_mysqli(isset($_GET["cod"]) ? $_GET["cod"] : '');
$borrarImg = $funciones->antihack_mysqli(isset($_GET["borrarImg"]) ? $_GET["borrarImg"] : '');

$banners->set("cod", $cod);
$banner = $banners->view();

$categorias = new Clases\Categorias();
$data = $categorias->list(array("area = 'banners'"), '', '');

$imagenes->set("cod", $banner['data']["cod"]);
$imagenes->set("link", "banners&accion=modificar");

if ($borrarImg != '') {
    $imagenes->set("id", $borrarImg);
    $imagenes->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=banners&accion=modificar&cod=$cod");
}

if (isset($_POST["agregar"])) {
    $count = 0;
    $cod = $banner['data']["cod"];
    $banners->set("cod", $cod);
    $banners->set("nombre", $funciones->antihack_mysqli(isset($_POST["nombre"]) ? $_POST["nombre"] : ''));
    $banners->set("categoria", $funciones->antihack_mysqli(isset($_POST["categoria"]) ? $_POST["categoria"] : ''));
    $banners->set("link", $funciones->antihack_mysqli(isset($_POST["link"]) ? $_POST["link"] : ''));

    if (isset($_FILES['files']['name'])) {
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
                $destinoRecortado = "../assets/archivos/banner/" . $prefijo . "." . $dominio;

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
    }


    $banners->edit();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=banners");
}
?>
<div class="col-md-12 ">
    <h4>
        Banners
    </h4>
    <hr />
    <form method="post" class="row" enctype="multipart/form-data">
        <label class="col-md-8">
            Nombre:<br />
            <input type="text" value="<?= $banner['data']['nombre'] ?>" name="nombre" required>
        </label>
        <label class="col-md-4">
            Categoría:<br />
            <select name="categoria" required>
                <?php
                foreach ($data as $categoria) {
                    if ($banner['data']["categoria"] == $categoria['data']["cod"]) {
                        echo "<option value='" . $categoria['data']["cod"] . "' selected>" . $categoria['data']["titulo"] . "</option>";
                    } else {
                        echo "<option value='" . $categoria['data']["cod"] . "'>" . $categoria['data']["titulo"] . "</option>";
                    }
                }
                ?>
            </select>
        </label>
        <div class="clearfix">
        </div>
        <label class="col-md-12">Url del banner<br />
            <small>*Opcional</small>
            <input type="text" value="<?= $banner['data']['link'] ?>" name="link">
        </label>
        <br />
        <?php
        if (!empty($banner['image'])) {
        ?>
            <div class='col-md-2 mb-20 mt-20'>
                <div style="height:200px;background:url(<?= '../' . $banner['image']['ruta']; ?>) no-repeat center center/contain;">
                </div>
                <a href="<?= URL . '/index.php?op=banners&accion=modificar&cod=' . $banner['data']['cod'] . '&borrarImg=' . $banner['image']['id'] ?>" class="btn btn-sm pull-left btn-danger">
                    BORRAR IMAGEN
                </a>
                <?php
                if ($banner['image']["orden"] == 0) {
                ?>
                    <a href="<?= URL . '/index.php?op=banners&accion=modificar&cod=' . $banner['data']['cod'] . '&ordenImg=' . $banner['image']['cod'] ?>" class="btn btn-sm pull-right btn-warning">
                        <i class="fa fa-star"></i>
                    </a>
                <?php
                } else {
                ?>
                    <a href="#" class="btn btn-sm pull-right btn-success">
                        <i class="fa fa-star"></i>
                    </a>
                <?php
                }
                ?>
                <div class="clearfix"></div>
            </div>
        <?php
        } else {
        ?>
            <label class="col-md-7">Imágenes:<br />
                <input type="file" id="file" name="files[]" accept="image/*" required />
            </label>
        <?php
        }
        ?>
        <div class="clearfix">
        </div>
        <br />
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" name="agregar" value="Modificar Banner" />
        </div>
    </form>
</div>