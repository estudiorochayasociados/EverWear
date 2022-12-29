<?php
$sliders  = new Clases\Sliders();
$imagenes = new Clases\Imagenes();
$zebra    = new Clases\Zebra_Image();

$categorias = new Clases\Categorias();
$data = $categorias->list(array("area = 'sliders'"), '', '');

if (isset($_POST["agregar"])) {
    $cod = substr(md5(uniqid(rand())), 0, 10);

    $sliders->set("cod", $cod);
    $sliders->set("titulo", $funciones->antihack_mysqli(isset($_POST["titulo"]) ? $_POST["titulo"] : ''));
    $sliders->set("tituloOn", $funciones->antihack_mysqli(isset($_POST["tituloOn"]) ? $_POST["tituloOn"] : ''));
    $sliders->set("subtitulo", $funciones->antihack_mysqli(isset($_POST["subtitulo"]) ? $_POST["subtitulo"] : ''));
    $sliders->set("subtituloOn", $funciones->antihack_mysqli(isset($_POST["subtituloOn"]) ? $_POST["subtituloOn"] : ''));
    $sliders->set("categoria", $funciones->antihack_mysqli(isset($_POST["categoria"]) ? $_POST["categoria"] : ''));
    $sliders->set("link", $funciones->antihack_mysqli(isset($_POST["link"]) ? $_POST["link"] : ''));
    $sliders->set("linkOn", $funciones->antihack_mysqli(isset($_POST["linkOn"]) ? $_POST["linkOn"] : ''));
    $sliders->set("fecha", $funciones->antihack_mysqli(isset($_POST["fecha"]) ? $_POST["fecha"] : date("Y-m-d")));

    foreach ($_FILES['files']['name'] as $f => $name) {
        $imgInicio = $_FILES["files"]["tmp_name"][0];
        $tucadena  = $name;
        $partes    = explode(".", $tucadena);
        $dom       = (count($partes) - 1);
        $dominio   = $partes[$dom];
        $prefijo   = substr(md5(uniqid(rand())), 0, 10);
        if ($dominio != '') {
            $destinoFinal = "../assets/archivos/" . $prefijo . "." . $dominio;
            move_uploaded_file($imgInicio, $destinoFinal);
            chmod($destinoFinal, 0777);
            $destinoRecortado = "../assets/archivos/recortadas/a_" . $prefijo . "." . $dominio;

            $zebra->source_path            = $destinoFinal;
            $zebra->target_path            = $destinoRecortado;
            $zebra->jpeg_quality           = 80;
            $zebra->preserve_aspect_ratio  = true;
            $zebra->enlarge_smaller_images = true;
            $zebra->preserve_time          = true;

            if ($zebra->resize(0, 0, ZEBRA_IMAGE_NOT_BOXED)) {
                unlink($destinoFinal);
            }

            $imagenes->set("cod", $cod);
            $imagenes->set("ruta", str_replace("../", "", $destinoRecortado));
            $imagenes->add();
        }
    }

    $sliders->add();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=sliders&accion=ver");
}
?>

<div class="col-md-12 ">
    <h4>Sliders</h4>
    <hr />
    <form method="post" class="row" enctype="multipart/form-data">
        <label class="col-md-4">Título (mostrar <input type="checkbox" name="tituloOn" value="1">):<br />
            <input type="text" name="titulo" required>
        </label>
        <label class="col-md-4">Subtitulo (mostrar <input type="checkbox" id="chsub" name="subtituloOn" value="1">):<br />
            <input type="text" id="sub" name="subtitulo">
        </label>
        <label class="col-md-4">Categoría:<br />
            <select name="categoria" required>
                <?php
                foreach ($data as $categoria) {
                    echo "<option value='" . $categoria['data']["cod"] . "'>" . $categoria['data']["titulo"] . "</option>";
                }
                ?>
            </select>
        </label>
        <label class="col-md-12">Link mostrar(<input type="checkbox" id="chli" name="linkOn" value="1">):<br />
            <input type="text" id="link" name="link">
        </label>
        <label class="col-md-7">Imágen:<br />
            <input type="file" id="file" name="files[]" accept="image/*" required />
        </label>
        <div class="clearfix"></div>
        <br />
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" name="agregar" value="Crear Slider" </div> </form> </div> <script>
            setInterval(D, 1000);

            function D() {
            if ($('#chsub').prop('checked')) {
            $('#sub').attr('required', true);
            }else{
            $('#sub').attr('required', false);
            }
            if ($('#chli').prop('checked')) {
            $('#link').attr('required', true);
            }else{
            $('#link').attr('required', false);
            }
            }
            </script>