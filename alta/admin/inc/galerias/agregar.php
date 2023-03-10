<?php
$galerias = new Clases\Galerias();
$categorias = new Clases\Categorias();
$imagenes = new Clases\Imagenes();
$zebra = new Clases\Zebra_Image();
$data = $categorias->list(array("area = 'galerias'"), '', '');

if (isset($_POST["agregar"])) {
    $count = 0;
    $cod = substr(md5(uniqid(rand())), 0, 10);

    $galerias->set("cod", $cod);
    $galerias->set("titulo", $funciones->antihack_mysqli(isset($_POST["titulo"]) ? $_POST["titulo"] : ''));
    $galerias->set("categoria", $funciones->antihack_mysqli(isset($_POST["categoria"]) ? $_POST["categoria"] : ''));
    $galerias->set("desarrollo", $funciones->antihack_mysqli(isset($_POST["desarrollo"]) ? $_POST["desarrollo"] : ''));
    $galerias->set("fecha", $funciones->antihack_mysqli(isset($_POST["fecha"]) ? $_POST["fecha"] : ''));
    $galerias->set("description", $funciones->antihack_mysqli(isset($_POST["description"]) ? $_POST["description"] : ''));
    $galerias->set("keywords", $funciones->antihack_mysqli(isset($_POST["keywords"]) ? $_POST["keywords"] : ''));

    if (isset($_FILES['files'])) {
        $imagenes->resizeImages($cod, $_FILES['files'], "../assets/archivos", "../assets/archivos/recortadas");
    }

    $galerias->add();
    $funciones->headerMove(URLADMIN . "/index.php?op=galerias");
}

?>

<div class="col-md-12 ">
    <h4>Galerias</h4>
    <hr/>
    <form method="post" class="row" enctype="multipart/form-data">
        <label class="col-md-4">Título:<br/>
            <input type="text" name="titulo" required>
        </label>
        <label class="col-md-4">Categoría:<br/>
            <select name="categoria" >
                <option value="" disabled selected>-- categorías --</option>
                <?php
                foreach ($data as $categoria) {
                    echo "<option value='" . $categoria['data']["cod"] . "'>" . $categoria['data']["titulo"] . "</option>";
                }
                ?>
            </select>
        </label>
        <label class="col-md-4">Fecha:<br/>
            <input type="date" name="fecha">
        </label>
        <div class="clearfix"></div>
        <label class="col-md-12">Desarrollo:<br/>
            <textarea name="desarrollo" class="ckeditorTextarea"></textarea>
        </label>
        <div class="clearfix"></div>
        <label class="col-md-12">Palabras claves dividas por ,<br/>
            <input type="text" name="keywords">
        </label>
        <label class="col-md-12">Descripción breve<br/>
            <textarea name="description"></textarea>
        </label>
        <br/>
        <label class="col-md-7">Imágenes:<br/>
            <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" required/>
        </label>
        <div class="clearfix"></div>
        <br/>
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" name="agregar" value="Crear Galerias"/>
        </div>
    </form>
</div>
