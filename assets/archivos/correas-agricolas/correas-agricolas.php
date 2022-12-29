<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$categoria = new Clases\Categorias();
$contenido = new Clases\Contenidos();
$correaAgricola = new Clases\CorreasAgricolas();

$marca_select = '';
$modelo_select = '';

$filter = [];

if (isset($_POST["marca"])) {
    $marca_select = $funciones->antihack_mysqli($_POST["marca"]);
    $filter[] = "marca = '" . $marca_select . "'";
}
if (isset($_POST["modelo"])) {
    $modelo_select = $funciones->antihack_mysqli($_POST["modelo"]);
    $filter[] = "modelo = '" . $modelo_select . "'";
}

$marcaList = $correaAgricola->listDistinct("marca", "");
if (!empty($marca_select)) {
    $modeloList = $correaAgricola->listDistinct('modelo', ['marca = "' . $marca_select . '"']);
} else {
    $modeloList = $correaAgricola->listDistinct('modelo', "");
}

$listCorreasAgricolas = isset($marca_select) ? $correaAgricola->list($filter, "lado, sector ASC", "") : array();
$template->themeInit(false);
?>
<!-- lineas section -->
<section class="  pb-50   " style="z-index:999 !Important">

    <div class="container" style="z-index:999">
        <h2 class="col-md-12  text-center fs-25 bold text-uppercase mt-20">
            Buscá tu correa agrícola
            <hr />
        </h2>
        <div>
            <form method="post" class="col-md-12 text-center">
                <div class="row">
                    <div class="col-md-6">
                        <b class="fs-20">MARCAS</b>
                        <select name="marca" class="text-uppercase" id="marca" onchange="$('#modelo').val('');$('#anio').val('');this.form.submit()">
                            <option disabled selected>Elija la marca</option>
                            <?php foreach ($marcaList as $marcas) { ?>
                                <option <?= ($marcas['data']['marca'] == $marca_select) ? 'selected' : '' ?> value="<?= $marcas['data']['marca'] ?>"><?= $marcas['data']['marca'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <b class="fs-20">MODELOS</b>
                        <select name="modelo" class="text-uppercase" id="modelo" onchange="this.form.submit()" <?= ($marca_select) ? '' : 'disabled' ?>>
                            <option disabled selected>Elija el modelo</option>
                            <?php foreach ($modeloList as $modelos) { ?>
                                <option <?= ($modelos['data']['modelo'] == $modelo_select) ? 'selected' : '' ?> value="<?= $modelos['data']['modelo'] ?>"><?= $modelos['data']['modelo'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </form>
            <div class="col-md-12">
                <div class="row mt-20">
                    <div class="col-md-9">
                        <?php
                        if (is_array($listCorreasAgricolas)) {
                            $marca = str_replace("/", "-", $listCorreasAgricolas[0]["data"]["marca"]);
                            $modelo = str_replace("/", "-", $listCorreasAgricolas[0]["data"]["modelo"]);
                            $img = 'assets/archivos/correas-agricolas/' . $marca . '/' . $modelo . '.png';
                            //$imgCheck = getimagesize("$img");
                        ?>
                            <img src="<?= URL . '/assets/archivos/correas-agricolas/' . $marca . '/' . $modelo . '.png' ?>" width="100%">
                            <table class="table table-hover table-sm fs-13">
                                <thead class="thead-dark">
                                    <th>LADO</th>
                                    <th>SECTOR</th>
                                    <th>OEM</th>
                                    <th>MARCA</th>
                                    <th>MODELO</th>
                                    <th>DESCRIPCIÓN</th>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($listCorreasAgricolas as $correasAgricolas) { ?>
                                        <tr onclick="mostrarEquivalencia('<h1><?= ($correasAgricolas["data"]["ever_wear"]) ? $correasAgricolas["data"]["ever_wear"] : 'CONSULTAR' ?></h1><span class=\'fs-12\'><b><?= htmlspecialchars($correasAgricolas["data"]["marca"]) ?> | <?= htmlspecialchars($correasAgricolas["data"]["modelo"]) ?></b> <br/> <?= $correasAgricolas["data"]["descripcion"] ?></span>')" style="cursor: pointer">
                                            <td><?= $correasAgricolas["data"]["lado"] ?></td>
                                            <td><?= $correasAgricolas["data"]["sector"] ?></td>
                                            <td><?= $correasAgricolas["data"]["oem"] ?></td>
                                            <td><?= $correasAgricolas["data"]["marca"] ?></td>
                                            <td><?= $correasAgricolas["data"]["modelo"] ?></td>
                                            <td><?= $correasAgricolas["data"]["descripcion"] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                    <div class="col-md-3">
                        <div id="equivalencia" class="equivalencia text-center"></div>
                    </div>
                </div>
                <hr />
            </div>
        </div>
    </div>
</section>

<?php $template->themeEnd(false) ?>

<script>
    function mostrarEquivalencia(equiv) {
        document.getElementById("equivalencia").style.display = 'block';
        document.getElementById("equivalencia").innerHTML = '<h5 class="bold">COD Ever Wear</h5>' + equiv;
    }
</script>

<style>
    .equivalencia {
        background: #ffc500;
        text-transform: uppercase;
        color: #000;
        padding: 20px 0px;
        display: none;
    }
</style>