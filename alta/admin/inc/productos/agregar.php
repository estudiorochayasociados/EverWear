<?php
$productos = new Clases\Productos();
$imagenes = new Clases\Imagenes();
$zebra = new Clases\Zebra_Image();
$categoria = new Clases\Categorias();
$atributo = new Clases\Atributos();
$subatributo = new Clases\Subatributos();
$ml = new Clases\MercadoLibre();

$categoriasData = $categoria->list(array("area = 'productos'"), "titulo ASC", "");

$cod = substr(md5(uniqid(rand())), 0, 10);

if (isset($_POST["agregar"])) {
    $imgMeli = [];
    $cod = $_POST["cod"];

    $titulo = $funciones->antihack_mysqli(isset($_POST["titulo"]) ? $_POST["titulo"] : '');
    $precio = $funciones->antihack_mysqli(isset($_POST["precio"]) ? $_POST["precio"] : '');
    $stock = $funciones->antihack_mysqli(isset($_POST["stock"]) ? $_POST["stock"] : '');
    $cod_producto = $funciones->antihack_mysqli(isset($_POST["cod_producto"]) ? $_POST["cod_producto"] : '');

    $productos->set("cod", $cod);
    $productos->set("titulo", $titulo);
    $productos->set("cod_producto", $funciones->antihack_mysqli(isset($_POST["cod_producto"]) ? $_POST["cod_producto"] : ''));
    $productos->set("precio", $precio);
    $productos->set("precio_descuento", $funciones->antihack_mysqli(isset($_POST["precio_descuento"]) ? $_POST["precio_descuento"] : ''));
    $productos->set("precio_mayorista", $funciones->antihack_mysqli(isset($_POST["precio_mayorista"]) ? $_POST["precio_mayorista"] : ''));
    $productos->set("peso", $funciones->antihack_mysqli(isset($_POST["peso"]) ? $_POST["peso"] : 0));
    $productos->set("stock", $stock);
    $productos->set("desarrollo", $funciones->antihack_mysqli(isset($_POST["desarrollo"]) ? $_POST["desarrollo"] : ''));
    $productos->set("categoria", $funciones->antihack_mysqli(isset($_POST["categoria"]) ? $_POST["categoria"] : ''));
    $productos->set("subcategoria", $funciones->antihack_mysqli(isset($_POST["subcategoria"]) ? $_POST["subcategoria"] : ''));
    $productos->set("keywords", $funciones->antihack_mysqli(isset($_POST["keywords"]) ? $_POST["keywords"] : ''));
    $productos->set("description", $funciones->antihack_mysqli(isset($_POST["description"]) ? $_POST["description"] : ''));
    $productos->set("fecha", $funciones->antihack_mysqli(isset($_POST["fecha"]) ? $_POST["fecha"] : date("Y-m-d")));
    $productos->set("meli", $funciones->antihack_mysqli(isset($_POST["meli"]) ? $_POST["meli"] : ''));
    $productos->set("url", $funciones->antihack_mysqli(isset($_POST["url"]) ? $_POST["url"] : ''));

    $cod_meli = $funciones->antihack_mysqli(isset($_POST["cod_meli"]) ? $_POST["cod_meli"] : null);

    $productos->set("variable1", $funciones->antihack_mysqli(isset($_POST["variable1"]) ? $_POST["variable1"] : ''));
    $productos->set("variable2", $funciones->antihack_mysqli(isset($_POST["variable2"]) ? $_POST["variable2"] : ''));
    $productos->set("variable3", $funciones->antihack_mysqli(isset($_POST["variable3"]) ? $_POST["variable3"] : ''));
    $productos->set("variable4", $funciones->antihack_mysqli(isset($_POST["variable4"]) ? $_POST["variable4"] : ''));
    $productos->set("variable5", $funciones->antihack_mysqli(isset($_POST["variable5"]) ? $_POST["variable5"] : ''));
    $productos->set("variable6", $funciones->antihack_mysqli(isset($_POST["variable6"]) ? $_POST["variable6"] : ''));
    $productos->set("variable7", $funciones->antihack_mysqli(isset($_POST["variable7"]) ? $_POST["variable7"] : ''));
    $productos->set("variable8", $funciones->antihack_mysqli(isset($_POST["variable8"]) ? $_POST["variable8"] : ''));
    $productos->set("variable9", $funciones->antihack_mysqli(isset($_POST["variable9"]) ? $_POST["variable9"] : ''));
    $productos->set("variable10", $funciones->antihack_mysqli(isset($_POST["variable10"]) ? $_POST["variable10"] : ''));

    $atributos = isset($_POST["atributos"]) ? $_POST["atributos"] : '';

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

            if ($zebra->resize(800, 800, ZEBRA_IMAGE_NOT_BOXED)) {
                unlink($destinoFinal);
            }

            $imagenes->set("cod", $cod);
            $imagenes->set("ruta", str_replace("../", "", $destinoRecortado));
            array_push($imgMeli, ["source" => URL . str_replace("../", "/", $destinoRecortado)]);
            $ml->img = $imgMeli;
            $imagenes->add();
        }
    }

    $error = '';
    $ml->titulo = $titulo;
    $ml->precio = $precio;
    $ml->stock = $stock;
    $ml->variable3 = $titulo;
    $ml->cod_producto = $cod_producto;

    if (isset($_POST['meli'])) {
        if (isset($_SESSION['access_token'])) {
            $result = $ml->create();
            if ($result['status']) $productos->set("meli", $result['data']["id"]);
        } else {
            $error = "No te logueaste con MercadoLibre.";
        }
    } else {
        if ($cod_meli != null) {
            $ml->meli = $cod_meli;
            $validate = $ml->validateItem();
            if ($validate['status']) {
                if ($validate['substatus']) {
                    $result = $ml->update();
                    if ($result['status']) $productos->set("meli", $cod_meli);
                } else {
                    $error = $validate['text'];
                }
            } else {
                $error = $validate['text'];
            }
        }
    }

    if (!empty($result['error'])) {
        if (is_array($result['error'])) {
            foreach ($result['error'] as $err) {
                $error .= "- " . $err['message'] . "<br>";
            }
        } else {
            $error = "- " . $result['error'] . "<br>";
        }
    }

    if (empty($error)) {
        $productos->add();
        $funciones->headerMove(URLADMIN . '/index.php?op=productos');
    }
}
?>

<div class="col-md-12">
    <h4>
        Productos
    </h4>
    <hr/>
    <?php if (!empty($error)) { ?>
        <div class="alert alert-danger" role="alert"><?= $error; ?></div>
    <?php } ?>
    <form method="post" class="row" enctype="multipart/form-data">
        <input type="hidden" name="cod" value="<?= $cod; ?>"/>
        <label class="col-md-4">T??tulo:<br/>
            <input type="text" name="titulo" value="<?= isset($_POST["titulo"]) ? $_POST["titulo"] : ''; ?>" required>
        </label>
        <label class="col-md-3">
            Categor??a:<br/>
            <select name="categoria">
                <option value="">-- categor??as --</option>
                <?php
                foreach ($categoriasData as $categoria) {
                    echo "<option value='" . $categoria["data"]["cod"] . "'>" . mb_strtoupper($categoria["data"]["titulo"]) . "</option>";
                }
                ?>
            </select>
        </label>
        <label class="col-md-3">
            Subcategor??a:<br/>
            <select name="subcategoria">
                <option value="">-- Sin subcategor??a --</option>
                <?php foreach ($categoriasData as $categoria) { ?>
                    <optgroup label="<?= mb_strtoupper($categoria["data"]['titulo']) ?>">
                        <?php
                        foreach ($categoria["subcategories"] as $subcategorias) {
                            echo "<option value='" . $subcategorias["data"]["cod"] . "'>" . mb_strtoupper($subcategorias["data"]["titulo"]) . "</option>";
                        }
                        ?>
                    </optgroup>
                <?php } ?>
            </select>
        </label>
        <label class="col-md-2">C??digo:<br/>
            <input type="text" name="cod_producto" value="<?= isset($_POST["cod_producto"]) ? $_POST["cod_producto"] : ''; ?>">
        </label>
        <label class="col-md-3">Precio:<br/>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                </div>
                <input type="number" step="any" class="form-control" min="0" id="precio" value="<?= isset($_POST["precio"]) ? $_POST["precio"] : 0; ?>" name="precio" required>
            </div>
        </label>
        <label class="col-md-3">Precio descuento:<br/>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                </div>
                <input type="number" class="form-control" min="0" value="<?= isset($_POST["precio_descuento"]) ? $_POST["precio_descuento"] : 0; ?>" name="precio_descuento">
            </div>
        </label>
        <label class="col-md-3">Precio mayorista:<br/>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">$</span>
                </div>
                <input type="number" step="any" class="form-control" min="0" value="<?= isset($_POST["precio_mayorista"]) ? $_POST["precio_mayorista"] : 0; ?>" name="precio_mayorista">
            </div>
        </label>
        <label class="col-md-2">Peso:<br/>
            <input data-suffix="Kg" id="pes" min="0" value="<?= isset($_POST["peso"]) ? $_POST["peso"] : 0; ?>" name="peso" type="number"/>
        </label>
        <label class="col-md-1">Stock:<br/>
            <input type="number" name="stock" id="stock" min="0" value="<?= isset($_POST["stock"]) ? $_POST["stock"] : 0; ?>" required>
        </label>
        <div class="clearfix">
        </div>
        <div class="col-md-6 mt-10">
            <button href="<?= URLADMIN ?>/inc/productos/api/atributos/atributosAgregar.php?cod=<?= $cod ?>" data-title="Agregar Atributos" class="mb-5 btn btn-info modal-page-ajax">AGREGAR ATRIBUTOS +</button>
            <div id="listAttr">

            </div>
        </div>
        <div class="col-md-6 mt-10">
            <button href="<?= URLADMIN ?>/inc/productos/api/variaciones/variacionesAgregar.php?cod=<?= $cod ?>" data-title="Agregar Variaciones" id="variaciones" class="mb-5 btn btn-info modal-page-ajax">AGREGAR VARIACIONES +</button>
            <div id="listComb" class="">

            </div>
        </div>
        <div class="clearfix"></div>
        <label class="col-md-12">
            Desarrollo:<br/>
            <textarea name="desarrollo" class="ckeditorTextarea"><?= isset($_POST["desarrollo"]) ? $_POST["desarrollo"] : ''; ?></textarea>
        </label>
        <div class="clearfix">
        </div>
        <label class="col-md-12">
            Palabras claves dividas por ,<br/>
            <input type="text" name="keywords" value="<?= isset($_POST["keywords"]) ? $_POST["keywords"] : ''; ?>">
        </label>
        <label class="col-md-12">
            Descripci??n breve<br/>
            <textarea name="description"><?= isset($_POST["description"]) ? $_POST["description"] : ''; ?></textarea>
        </label>
        <br/>
        <hr>
        <div class="col-md-12">
            <div class="form-group form-check">
                <?php
                if (isset($_SESSION['access_token'])) {
                    ?>
                    <div class="row">
                        <div class="col-md-6 centro" style="margin-top:5px;">
                            <input type="checkbox" class="form-check-input" id="meli" value="1" name="meli" onchange="$('#cod_meli').attr('disabled',true); $('#stock').attr('min', 1);">
                            <label class="form-check-label display-inline" for="meli">??Publicar en MercadoLibre?</label>
                        </div>
                        <div class="col-md-6 centro">
                            <label> Ya est?? publicado en ML? Ingresar c??digo:</label>
                            <input type="text" class="col-md-3 display-inline" id="cod_meli" name="cod_meli" onchange="$('#meli').attr('disabled',true); $('#stock').attr('min', 1);" value="<?= isset($_POST["cod_meli"]) ? $_POST["cod_meli"] : ''; ?>">
                        </div>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="ml-0 pl-0 mt-20 mb-20">
                        <?php echo '<a class="nav-link" id="mercadolibre-nav" target="_blank" href="' . $meli->getAuthUrl(URL, Meli::$AUTH_URL["MLA"]) . '"><img src="' . URLADMIN . '/img/meli.png" width="30" /> ??Vincularme a Mercadolibre <i class="fa fa-square green">?</i></a>'; ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <hr>
        <label class="col-md-7 mb-40">
            Im??genes:<br/>
            <input type="file" id="file" name="files[]" multiple="multiple" accept="image/*"/>
        </label>
        <div class="clearfix">
        </div>
        <br/>
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" id="guardar" name="agregar" value="Crear Producto"/>
        </div>
    </form>
</div>

<!-- todo: pasar a script -->
<script>
    $("#pes").inputSpinner();

    setInterval(ML, 1000);

    function ML() {
        if ($('#meli').prop('checked') == false && $('#cod_meli').val() == '') {
            $('#cod_meli').attr('disabled', false);
            $('#meli').attr('disabled', false);
            $('#stock').attr('min', 0);
        }
    };


    function checkAttrProducts() {
        $.ajax({
            url: "<?=URLADMIN?>/inc/productos/api/atributos/atributosVer.php",
            type: "GET",
            data: {cod: "<?= $cod ?>"},
            success: function (data) {
                data = JSON.parse(data);
                $('#listAttr').html('');
                if (data.length != 0) {
                    for (i = 0; i < data.length; i++) {
                        var texto = "<strong>" + data[i]["atribute"]["value"] + ": </strong>";
                        for (o = 0; o < data[i]["atribute"]["subatributes"].length; o++) {
                            texto += data[i]["atribute"]["subatributes"][o]["value"] + " | ";
                        }
                        $('#listAttr').append("<span class='text-uppercase mt-10'>" + texto + "</span>");
                        $('#listAttr').append(
                            "<span class='ml-10  mt-10 mb-5 btn btn-warning btn-sm text-uppercase' onclick='openModal(\"<?= URLADMIN ?>/inc/productos/api/atributos/atributosModificar.php?cod=" + data[i]['atribute']['cod'] + "\",\"Modificar " + data[i]['atribute']['value'] + "\")'><i class='fa fa-edit'></i></span><br/>");
                    }

                    $('#variaciones').attr('disabled', false);
                    //si existen atributos mostrar variaciones
                    checkCombProducts();
                } else {
                    $('#variaciones').attr('disabled', true);
                }
            },
            error: function () {
                alert('Error occured');
            }
        });
    }

    function checkCombProducts() {
        $.ajax({
            url: "<?=URLADMIN?>/inc/productos/api/variaciones/variacionesVer.php",
            type: "GET",
            data: {cod: "<?= $cod ?>"},
            success: function (data) {
                data = JSON.parse(data);
                $('#listComb').html('');
                if (data.length != 0) {
                    for (i = 0; i < data.length; i++) {
                        var texto = "";
                        for (o = 0; o < data[i]["combination"].length; o++) {
                            texto += data[i]["combination"][o]["value"] + " | ";
                        }
                        texto += " <strong>Precio:</strong> $" + data[i]['detail']['precio'] + " <strong>Stock:</strong> " + data[i]['detail']['stock'];
                        if (data[i]['detail']['mayorista'] > 0) {
                            texto += " <strong>Precio Mayorista:</strong> $" + data[i]['detail']['mayorista'];
                        } else {
                            texto += " <strong>Precio Mayorista:</strong> No posee";
                        }
                        $('#listComb').append("<span class='text-uppercase mt-10'>" + texto + "</span>");
                        $('#listComb').append(
                            "<span class='ml-10 mt-10 mb-5 btn btn-warning btn-sm text-uppercase' onclick='openModal(\"<?= URLADMIN ?>/inc/productos/api/variaciones/variacionesModificar.php?cod=" + data[i]['detail']['cod_combinacion'] + "&product=" + data[i]['product'] + "\",\"Modificar " + "\")'><i class='fa fa-edit'></i></span><br/>");
                    }
                }
            },
            error: function () {
                alert('Error occured');
            }
        });
    }

    checkCombProducts();
    checkAttrProducts();

    //todo: validar si tiene atributos antes de aplicr una combinacion
</script>