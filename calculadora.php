<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$contenido = new Clases\Contenidos();
$terminales = new Clases\Terminales();

$template->set("title", "Como obtener rpm y correas - Ever Wear");
$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->set("body", "");
$template->themeInit();
?>



<!-- lineas section -->
<section class="pb-50 mt-30">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-100" style="text-align: center;">
                <img src="<?= URL ?>/assets/img/calculadora2.jpg" width="60%" alt="">
                <hr>
            </div>
            <div class="col-md-6 border-right">

                <div class="row bold" style="place-content: center;text-align-last: center;">
                    <div class="col-md-12 mt-10">
                        <h4 class="pl-30 text-uppercase bold">
                            CALCULAR RPM
                        </h4>
                        <hr>
                    </div>
                    <div class="col-md-4 ">
                        <label for="rpm">RPM Motor</label>
                        <div class="input-group">
                            <input type="number" onkeyup="calcularRpm()" aria-describedby="basic-addon2" class="form-control" style="background-color:#F0F0F0" value="1500" id="rpm">

                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">X</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <label for="conductora" class="text-uppercase">Ø de polea o engranaje de la conductora</label>
                        <input type="number" onkeyup="calcularRpm()" class="form-control" style="background-color:#F0F0F0" id="conductora">
                        <hr>
                        <label for="conducida" class="text-uppercase">Ø de polea o engranaje de la conducida </label>
                        <input type="number" onkeyup="calcularRpm()" class="form-control" style="background-color:#F0F0F0" id="conducida">
                    </div>
                    <div class="form-group col-md-12">
                        <hr>
                        <label>RPM RESULTANTE</label>
                        <br>
                        <span class="bold" id="resultadoRpm" style="font-size: 30px;"></span>
                    </div>


                </div>
                <div class="mt-30" style="text-align: -webkit-center;">
                    <div class="row" style="place-content: center;">
                
                        <div class=" col-6">
                            <div class="card">
                                <h5 class="card-header">CONDUCTORA</h5>
                                <div class="card-body">

                                    <p class="card-text text-uppercase">
                                        a mayor Ø,<br> mayor revolucion
                                    </p>
                                    <hr>
                                    <p class="card-text text-uppercase">
                                        a menor Ø,<br> menor revolucion
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card">
                                <h5 class="card-header">CONDUCIDA</h5>
                                <div class="card-body">

                                    <p class="card-text text-uppercase">
                                        a mayor Ø,<br> menor revolucion
                                    </p>
                                    <hr>
                                    <p class="card-text text-uppercase">
                                        a menor Ø,<br> mayor revolucion
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="row bold" style="place-content: center;text-align-last: center;">
                                 <div class="col-md-12 mt-10">
                        <h4 class="pl-30 text-uppercase bold">
                            CALCULAR N° DE CORREA
                        </h4>
                        <hr>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="grande">DIAMETRO POLEA Grande (mm)</label>
                        <input type="number" class="form-control" id="grande" style="background-color:#F0F0F0" onkeyup="calcularCorrea()">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="chica">DIAMETRO POLEA chica (mm)</label>
                        <input type="number" class="form-control" id="chica" style="background-color:#F0F0F0" onkeyup="calcularCorrea()">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="eje">DISTENCIA ENTRE EJES (mm)</label>
                        <input type="number" class="form-control" id="eje" style="background-color:#F0F0F0" onkeyup="calcularCorrea()">
                    </div>
                    <div class="form-group col-md-12">
                        <hr>
                        <label>NUMERO DE CORREA</label>
                        <br>
                                             <span class="bold"  id="resultadoCorrea" style="font-size: 30px;"></span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


<?php $template->themeEnd() ?>

<script>
    function calcularRpm() {
        var rpm = $("#rpm").val();
        var conductora = $("#conductora").val();
        var conducida = $("#conducida").val();
        if (conductora != '' && conducida != '' && rpm != '') {
            var resultado = rpm * conductora / conducida;
            $("#resultadoRpm").html("<span style='padding: 7px;background-color: #f4cc07;border-radius: 5px;'>"+ new Intl.NumberFormat("es-AR").format(Math.trunc(resultado)) +"</span>");
            $
        }
    }

    function calcularCorrea() {
        var grande = $("#grande").val();
        var chica = $("#chica").val();
        var eje = $("#eje").val();
        if (grande != '' && chica != '' && eje != '') {
            var resultado = (2 * Math.sqrt(Math.pow(((grande - chica) / 2), 2) + (Math.pow(eje, 2))) + (1.5708 * grande) + (
                1.5708 * chica)) / 25.4;
            $("#resultadoCorrea").html("<span style='padding: 7px;background-color: #f4cc07;border-radius: 5px;'>"+ new Intl.NumberFormat("es-AR").format(Math.round(resultado)) +"</span>");
        }
    }
</script>