<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$categoria = new Clases\Categorias();
$contenido = new Clases\Contenidos();
$automotores = new Clases\Automotores();

$marca_select = '';
$modelo_select = '';
$anio_select = '';
$motor_select = '';

//ACA ESTA EL ERROR
$filter = [];

if (isset($_POST["marca"])) {
    $marca_select = $funciones->antihack_mysqli($_POST["marca"]);
    $filter[] = "marca = '" . $marca_select . "'";
}
if (isset($_POST["modelo"])) {
    $modelo_select = $funciones->antihack_mysqli($_POST["modelo"]);
    $filter[] = "modelo = '" . $modelo_select . "'";
}
if (isset($_POST["motor"])) {
    $motor_select = $funciones->antihack_mysqli($_POST["motor"]);
    $filter[] = "motor = '" . $motor_select . "'";
}

if (isset($_POST["anio"])) {
    $anio_select = $funciones->antihack_mysqli($_POST["anio"]);
    $filter[] = "anio = '" . $anio_select . "'";
}

//PRIMERO CHEQUEAS SI TE VIENE EL POST DE LOS 3 ELEMENTOS (MARCA MODELO ANIO)
$marcaList = $automotores->listDistinct("marca", "");
$modeloList = !empty($marca_select) ? $automotores->listDistinct('modelo', array('marca = "' . $marca_select . '"')) : '';
$motorList = (!empty($marca_select) && !empty($modelo_select)) ? $automotores->listDistinct("motor", array("marca = '" . $marca_select . "'", "modelo = '" . $modelo_select . "'")) : '';
$anioList = (!empty($marca_select) && !empty($modelo_select) && !empty($motor_select)) ? $automotores->listDistinct("anio", array("motor = '" . $motor_select . "'", "marca = '" . $marca_select . "'", "modelo = '" . $modelo_select . "'")) : '';

$listAutomotor = (!empty($marca_select) && !empty($modelo_select) && !empty($motor_select)) ? $automotores->list($filter, "", "") : array();
$template->themeInit();
?>
<div class="img-slider-content-single-product" style="background: url(<?= URL ?>/assets/archivos/60fe6cceb4.png)center/cover no-repeat">
    <div class="col-md-12 vertical-align justify-content-center">
    </div>
</div>
<!-- lineas section -->
<section class="  pb-50  mt-30  " style="z-index:999 !Important">

    <div class="container" style="z-index:999">
        <div>
            <form method="post" class="col-md-12 text-center pt-10 pb-10" style="background:#FFC500">
                <h2 class="col-md-12 bold text-center fs-25 bold text-uppercase">
                    Buscá tu correa según tu vehículo
                    <hr />
                </h2>
                <div class="row">
                    <div class="col-md-3">
                        <b class="fs-20">MARCAS</b>
                        <select name="marca" class="text-uppercase" id="marca" onchange="$('#modelo').val('');$('#anio').val('');this.form.submit()">
                            <option disabled selected>Elija la marca</option>
                            <?php foreach ($marcaList as $marcas) { ?>
                                <option <?= ($marcas['data']['marca'] == $marca_select) ? 'selected' : '' ?> value="<?= $marcas['data']['marca'] ?>"><?= $marcas['data']['marca'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <?php if ($marca_select) { ?>
                        <div class="col-md-3">
                            <b class="fs-20">MODELOS</b>
                            <select name="modelo" class="text-uppercase" id="modelo" onchange="$('#anio').val('');this.form.submit()">
                                <option disabled selected>Elija el modelo</option>
                                <?php foreach ($modeloList as $modelos) { ?>
                                    <option <?= ($modelos['data']['modelo'] == $modelo_select) ? 'selected' : '' ?> value="<?= $modelos['data']['modelo'] ?>"><?= $modelos['data']['modelo'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                    <?php if ($modelo_select) { ?>
                        <div class="col-md-3">
                            <b class="fs-20">MOTOR DEL VEHÍCULO</b>
                            <select name="motor" class="text-uppercase" id="motor" onchange="this.form.submit()">
                                <option disabled selected>Elija el motor</option>
                                <?php foreach ($motorList as $motors) { ?>
                                    <option <?= ($motors['data']['motor'] == $motor_select) ? 'selected' : '' ?> value="<?= $motors['data']['motor'] ?>"><?= $motors['data']['motor'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                    <?php if ($motor_select) { ?>
                        <div class="col-md-3">
                            <b class="fs-20">AÑO DEL VEHÍCULO</b>
                            <select name="anio" class="text-uppercase" id="anio" onchange="this.form.submit()">
                                <option disabled selected>Elija el año</option>
                                <?php foreach ($anioList as $anios) { ?>
                                    <option <?= ($anios['data']['anio'] == $anio_select) ? 'selected' : '' ?> value="<?= $anios['data']['anio'] ?>"><?= $anios['data']['anio'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>
                </div>
            </form>
            <div class="col-md-12">
                <div class="row">
                    <?php if (is_array($listAutomotor)) {
                        foreach ($listAutomotor as $correas) {
                            echo "<div class='shadow col-md-6 text-uppercase'> ";
                            echo "<div class=' mt-20 pt-20 pb-20 pr-20 pl-20' style='background:#f7f7f7'>";
                            $app_ = "";
                            $app___ = explode(" / ", $correas["data"]["aplicacion"]);
                            echo "<img src='" . URL . "/assets/img/sistema-correas/" . mb_strtolower(str_replace([" ", "/"], "-", trim(utf8_encode($correas["data"]["marca"])))) . ".jpg' width='65' style='float:right !important' />";
                            echo "<b style='background:#000;color:#ffc500' class='pl-5 pr-5 fs-23 pull-right'>" . $correas['data']['cod_producto'] . "</b><br/>";
                            echo "<b>" . $correas['data']['marca'] . ' ' . $correas['data']['modelo'] . ' ' . $correas['data']['anio'] . "</b><br/>";
                            echo "<b>MOTOR:</b> " . $correas['data']['motor'] . "<br/>";
                            if (count($app___) > 1) {
                                echo "<hr class='mt-5 mb-5' />";
                                echo "<b>APLICACIONES DEL PRODUCTO</b><hr class='mt-5 mb-10' />";
                                echo "<div class='row'>";
                                foreach ($app___ as $app) {
                                    $app_ = $automotores->checkApplication(trim($app));
                                    if ($app_) {
                                        echo "<div class='col-3 text-center'>";
                                        echo "<img src='" . URL . "/assets/img/sistema-correas/" . $app_["img"] . "'width='70' class='img-circle img-rounded rounded rounded-circle pt-10 pb-10 pl-10 pr-10' style='background:#FFC500' /><br/>";
                                        echo "<p class='mt-10 fs-12' style='min-height:30px;line-height:12px'>" . mb_strtoupper($app_["texto"]) . "</p>";
                                        echo "</div>";
                                    }
                                }
                                echo "</div>";
                            }
                            echo "</div>";
                            echo "</div>";
                        }
                    } ?>
                </div>
                <hr />
            </div>
        </div>
    </div>
</section>

<?php $template->themeEnd() ?>