<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$contenido = new Clases\Contenidos();
$terminales = new Clases\Terminales();

$template->set("title", "CALCULAR NUMERO DE UNA CORREA - Ever Wear");
$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->set("body", "");
$template->themeInit();
?>
<div style="min-height: 70vh;">

    <div class="img-slider-content" style="background: url('')center/cover no-repeat;">
        <div class="container">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6 vertical-align justify-slider-content bf bg-tr">
                    <h3 class="pl-30 text-uppercase">
                        CALCULAR NUMERO DE UNA CORREA
                    </h3>
                    <span></span>
                </div>
            </div>
        </div>
    </div>

    <!-- lineas section -->
    <section class="pb-50 mt-30">
        <div class="container">
            <div class="row bold" style="place-content: center;text-align-last: center;">
                <div class="form-group col-md-4">
                    <label for="grande">DIAMETRO POLEA Grande (mm)</label>
                    <input type="number" class="form-control" id="grande" onkeyup="calcularCorrea()">
                </div>
                <div class="form-group col-md-4">
                    <label for="chica">DIAMETRO POLEA chica (mm)</label>
                    <input type="number" class="form-control" id="chica" onkeyup="calcularCorrea()">
                </div>
                <div class="form-group col-md-4">
                    <label for="eje">DISTENCIA ENTRE EJES (mm)</label>
                    <input type="number" class="form-control" id="eje" onkeyup="calcularCorrea()">
                </div>
                <div class="form-group col-md-12">
                    <hr>
                    <label>NUMERO DE CORREA</label>
                    <br>
                    <span id="resultado" style="font-size: 30px;"></span>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $template->themeEnd() ?>

<script>
    function calcularCorrea() {
        var grande = $("#grande").val();
        var chica = $("#chica").val();
        var eje = $("#eje").val();
        if (grande != '' && chica != '' && eje != '') {
            var resultado = (2 * Math.sqrt(Math.pow(((grande - chica) / 2), 2) + (Math.pow(eje, 2))) + (1.5708 * grande) + (1.5708 * chica)) / 25.4;
            $("#resultado").html(Math.round(resultado));
        }
    }
</script>