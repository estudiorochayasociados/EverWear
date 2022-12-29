<?php
$descuento = new Clases\Descuentos();
$productos = new Clases\Productos();
$categorias = new Clases\Categorias();
$carrito = new Clases\Carrito();

$productosArray = $productos->list("", "", "");
$categoriasArray = $categorias->list("area = 'productos'", "", "");

$productosArrayNew = array();
$categoriasArrayNew = array();
$subcategoriasArrayNew = array();

//productos
foreach ($productosArray as $key => $value) {
    $productosArrayNew[$key]["cod"] = $value["data"]["cod"];
    $productosArrayNew[$key]["cod_producto"] = $value["data"]["cod_producto"];
    $productosArrayNew[$key]["titulo"] = $value["data"]["titulo"];
}
$productosArrayNewJson = json_encode($productosArrayNew);

//categorias
foreach ($categoriasArray as $key => $value) {
    $categoriasArrayNew[$key]["cod"] = $value["data"]["cod"];
    $categoriasArrayNew[$key]["titulo"] = $value["data"]["titulo"];
}
$categoriasArrayNewJson = json_encode($categoriasArrayNew);


//subcategorias
$i = 0;
foreach ($categoriasArray as $key => $value) {
    foreach ($value["subcategories"] as $value2) {
        $subcategoriasArrayNew[$i]["cod"] = $value2["data"]["cod"];
        $subcategoriasArrayNew[$i]["titulo"] = $value2["data"]["titulo"];
        $i++;
    }
}
$subcategoriasArrayNewJson = json_encode($subcategoriasArrayNew);


//agregar
if (isset($_POST["agregar"])) {
    $descuento->set("cod", $funciones->antihack_mysqli(isset($_POST["cod"]) ? $_POST["cod"] : ''));
    $descuento->set("titulo", $funciones->antihack_mysqli(isset($_POST["titulo"]) ? $_POST["titulo"] : ''));
    $descuento->set("tipo", $funciones->antihack_mysqli(isset($_POST["tipo"]) ? $_POST["tipo"] : ''));
    $descuento->set("monto", $funciones->antihack_mysqli(isset($_POST["monto"]) ? $_POST["monto"] : ''));
    $descuento->set("productos_cod", $funciones->antihack_mysqli(isset($_POST["productos-cod"]) ? $_POST["productos-cod"] : ''));
    $descuento->set("categorias_cod", $funciones->antihack_mysqli(isset($_POST["categorias-cod"]) ? $_POST["categorias-cod"] : ''));
    $descuento->set("subcategorias_cod", $funciones->antihack_mysqli(isset($_POST["subcategorias-cod"]) ? $_POST["subcategorias-cod"] : ''));
    $descuento->set("sector", $funciones->antihack_mysqli(isset($_POST["sector"]) ? $_POST["sector"] : ''));
    $descuento->set("fecha_inicio", $funciones->antihack_mysqli(isset($_POST["fecha-inicio"]) ? $_POST["fecha-inicio"] : ''));
    $descuento->set("fecha_fin", $funciones->antihack_mysqli(isset($_POST["fecha-fin"]) ? $_POST["fecha-fin"] : ''));

    $descuento->add();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=descuentos");
}
?>

<div class="col-md-12">
    <h4>Descuentos</h4>
    <hr />
    <form method="post" id="form-descuento" class="row" enctype="multipart/form-data">
        <label class="col-md-4">Titulo:<br />
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><b>T</b></span>
                </div>
                <input type="text" name="titulo" value="" required>
            </div>
        </label>
        <label class="col-md-4">Código descuento:<br />
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-star"></i></span>
                </div>
                <input type="text" name="cod" value="" required>
            </div>
        </label>
        <label class="col-md-2">Tipo:<br />
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect"><b>$ / %</b></label>
                </div>
                <select name="tipo" class="custom-select" id="inputGroupSelect">
                    <option selected disabled>Seleccionar...</option>
                    <option value="0">Efectivo</option>
                    <option value="1">Porcentaje</option>
                </select>
            </div>
        </label>
        <label class="col-md-2">Monto:<br />
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><b>M</b></span>
                </div>
                <input type="number" name="monto" value="" required>
            </div>
        </label>
        <label class="col-md-4">Aplica a:<br />
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect"><i class="fas fa-users"></i></label>
                </div>
                <select name="sector" class="custom-select" id="inputGroupSelect">
                    <option selected disabled>Seleccionar...</option>
                    <option value="0">Todos los usuarios</option>
                    <option value="1">Solo a usuarios que no posean descuento</option>
                    <option value="2">Solo a usuarios que ya posean descuento</option>
                </select>
            </div>
        </label>
        <label class="col-md-4">Desde:<br />
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input type="date" name="fecha-inicio" value="">
            </div>
        </label>
        <label class="col-md-4">Hasta:<br />
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                </div>
                <input type="date" name="fecha-fin" value="">
            </div>
        </label>
        <label class="col-md-12">Productos:<br />
            <input class="form-control magicsearch" id="select-product" placeholder="buscar productos...">
            <input type="hidden" id="magic-product" name="productos-cod">
        </label>
        <label class="col-md-12">Categorias:<br />
            <input class="form-control magicsearch" id="select-category" placeholder="buscar categorias...">
            <input type="hidden" id="magic-category" name="categorias-cod">
        </label>
        <label class="col-md-12">Subcategorias:<br />
            <input class="form-control magicsearch" id="select-subcategory" placeholder="buscar subcategorias...">
            <input type="hidden" id="magic-subcategory" name="subcategorias-cod">
        </label>
        <br />
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary" id="agregar" name="agregar" value="Crear Descuento" />
        </div>
    </form>
</div>


<script>
    $(function() {

        var jsonProductsFromPhp = '<?= $productosArrayNewJson ?>';
        var dataProducts = JSON.parse(jsonProductsFromPhp);

        var jsonCategoriesFromPhp = '<?= $categoriasArrayNewJson ?>';
        var dataCategories = JSON.parse(jsonCategoriesFromPhp);

        var jsonSubcategoriesFromPhp = '<?= $subcategoriasArrayNewJson ?>';
        var dataSubcategories = JSON.parse(jsonSubcategoriesFromPhp);

        $('#select-product').magicsearch({
            dataSource: dataProducts,
            fields: ['cod_producto', 'titulo'],
            id: 'cod',
            format: '%cod_producto% · %titulo%',
            multiple: true,
            multiField: 'titulo',
            multiStyle: {
                space: 5,
                width: 150
            }
        });
        $('#select-category').magicsearch({
            dataSource: dataCategories,
            fields: ['cod', 'titulo'],
            id: 'cod',
            format: '%cod% · %titulo%',
            multiple: true,
            multiField: 'titulo',
            multiStyle: {
                space: 5,
                width: 150
            }
        });
        $('#select-subcategory').magicsearch({
            dataSource: dataSubcategories,
            fields: ['cod', 'titulo'],
            id: 'cod',
            format: '%cod% · %titulo%',
            multiple: true,
            multiField: 'titulo',
            multiStyle: {
                space: 5,
                width: 150
            }
        });
        $('#agregar').click(function() {
            $('.magicsearch-wrapper[data-index]').each(function() {
                var setIndex = $(this).attr('data-index');
                var setName = '';
                var elements = '';
                var element = '';

                if (setIndex == 1) {
                    setName = '#magic-product';
                }
                if (setIndex == 2) {
                    setName = '#magic-category';
                }
                if (setIndex == 3) {
                    setName = '#magic-subcategory';
                }

                $(this).children('.multi-items').children('.multi-item').each(function() {
                    element = $(this).attr('data-id');
                    elements = elements + ',' + element;
                });

                $(setName).val(elements.substring(1));

            });
        });
    });
</script>