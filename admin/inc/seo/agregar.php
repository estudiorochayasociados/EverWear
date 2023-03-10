<?php
$seo = new Clases\Seo();
$imagenes = new Clases\Imagenes();
$zebra = new Clases\Zebra_Image();


if (isset($_POST["agregar"])) {
    $count = 0;
    $cod = substr(md5(uniqid(rand())), 0, 10);

    $seo->set("cod", $cod);
    $seo->set("url", isset($_POST["url"]) ? $funciones->antihack_mysqli($_POST["url"]) : '');
    $seo->set("title", isset($_POST["title"]) ? $funciones->antihack_mysqli($_POST["title"]) : '');
    $seo->set("description", isset($_POST["description"]) ? $funciones->antihack_mysqli($_POST["description"]) : '');
    $seo->set("keywords", isset($_POST["keywords"]) ? $funciones->antihack_mysqli($_POST["keywords"]) : '');

    if (isset($_FILES['files'])) {
        $imagenes->resizeImages($cod, $_FILES['files'], "../assets/archivos", "../assets/archivos/recortadas");
    }

    $seo->add();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=seo");
}

?>

<div class="col-md-12 ">
    <h4>SEO</h4>
    <hr/>
    <form method="post" class="row" enctype="multipart/form-data">
    <label class="col-md-8">URL:<br/>
            <input type="url" name="url" required>
        </label>
        <label class="col-md-4">Título:<br/>
            <input type="text" name="title">
        </label>
        <div class="clearfix"></div>
        <label class="col-md-12">Palabras claves dividas por ,<br/>
            <input type="text" name="keywords">
        </label>
        <label class="col-md-12">Descripción<br/>
            <textarea name="description"></textarea>
        </label>
        <br/>
        <label class="col-md-7">Imágenes:<br/>
            <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*" />
        </label>
        <div class="clearfix"></div>
        <br/>
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" name="agregar" value="Crear SEO"/>
        </div>
    </form>
</div>
