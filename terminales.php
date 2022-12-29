<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$contenido = new Clases\Contenidos();
$terminales = new Clases\Terminales();

$template->set("title", "Buscador de Terminales - Ever Wear");
$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->set("body", "");
$template->themeInit(false);
?>

<!-- lineas section -->
<section class="mt-50 text-center " style="z-index:999 !Important">
    <div class="container" style="z-index:999;">
        <div class="terminales-container text-uppercase bold">
            <span class="fs-25">Búsqueda de terminales</span>
            <form method="post" style="display: flex">
                <input id="search" type="text" class="pt-20 pb-20 form-control text-center fs-20" onkeyup="catchKeys()" onclick="catchKeys()" placeholder="ingresar el código del terminal">
                <img class="terminales-loader" id="loader" src="<?= URL ?>/assets/img/loader.svg" style="display: none;">
            </form>

            <div class="terminales-data-search" id="data-search"></div>

            <div id="table-result"></div>
        </div>
    </div>
</section>

<?php $template->themeEnd(false) ?>

<script>
    function catchKeys() {
        let search = $("#search").val();
        document.getElementById("loader").style.display = "block";
        setTimeout(generate, 500);
    }

    function generate() {
        let search = $("#search").val().toUpperCase();
        console.log(search);
        $.get("<?= URL ?>/curl/terminales/terminales.php?search=" + search, function(data) {
            document.getElementById("data-search").innerHTML = '';
            if (data != "error") {
                let terminales = JSON.parse(data);
                let content = [];
                let brida = '';
                let marca = '';
                let codigoBuscado = '';

                terminales.forEach(element => {
                    console.log(element);
                    content[0] = !(element.codigo.search(search)) ? element.codigo + '||' : null;
                    //content[0] = !(element.codigo.search(search)) ? element.codigo + '||' : null;
                    content[1] = !(element.cañiflex.search(search)) ? element.cañiflex + '||' : null;
                    //content[1] = !(element.cañiflex.search(search)) ? element.cañiflex + '|CAÑIFLEX|' : null;
                    content[2] = !(element.iron_r2_pp.search(search)) ? element.iron_r2_pp + '||R2 PP' : null;
                    //content[2] = !(element.iron_r2_pp.search(search)) ? element.iron_r2_pp + '|IRON|R2 PP' : null;
                    content[3] = !(element.iron_r2_sp.search(search)) ? element.iron_r2_sp + '||R2 SP' : null;
                    //content[3] = !(element.iron_r2_sp.search(search)) ? element.iron_r2_sp + '|IRON|R2 SP' : null;
                    content[4] = !(element.iron_r1.search(search)) ? element.iron_r1 + '||R1' : null;
                    //content[4] = !(element.iron_r1.search(search)) ? element.iron_r1 + '|IRON|R1' : null;
                    content[5] = !(element.iron_r9.search(search)) ? element.iron_r9 + '||R9' : null;
                    //content[5] = !(element.iron_r9.search(search)) ? element.iron_r9 + '|IRON|R9' : null;
                    content[6] = !(element.iron_r13.search(search)) ? element.iron_r13 + '||R13' : null;
                    //content[6] = !(element.iron_r13.search(search)) ? element.iron_r13 + '|IRON|R13' : null;
                    content[7] = !(element.metalurgicajs.search(search)) ? element.metalurgicajs + '||' : null;
                    //content[7] = !(element.metalurgicajs.search(search)) ? element.metalurgicajs + '|METALURGICA JS|' : null;
                    content[8] = !(element.metalurgicajs_r1_sp.search(search)) ? element.metalurgicajs_r1_sp + '||R1 SP' : null;
                    //content[8] = !(element.metalurgicajs_r1_sp.search(search)) ? element.metalurgicajs_r1_sp + '|METALURGICA JS|R1 SP' : null;
                    content[9] = !(element.metalurgicajs_r2_sp.search(search)) ? element.metalurgicajs_r2_sp + '||R2 SP' : null;
                    //content[9] = !(element.metalurgicajs_r2_sp.search(search)) ? element.metalurgicajs_r2_sp + '|METALURGICA JS|R2 SP' : null;
                    content[10] = !(element.metalurgicajs_r1_pp.search(search)) ? element.metalurgicajs_r1_pp + '||R1 PP' : null;
                    //content[10] = !(element.metalurgicajs_r1_pp.search(search)) ? element.metalurgicajs_r1_pp + '|METALURGICA JS|R1 PP' : null;
                    content[11] = !(element.metalurgicajs_r2_pp.search(search)) ? element.metalurgicajs_r2_pp + '||R2 PP' : null;
                    //content[11] = !(element.metalurgicajs_r2_pp.search(search)) ? element.metalurgicajs_r2_pp + '|METALURGICA JS|R2 PP' : null;
                    content[12] = !(element.metalurgicajs_r12.search(search)) ? element.metalurgicajs_r12 + '||R12' : null;
                    //content[12] = !(element.metalurgicajs_r12.search(search)) ? element.metalurgicajs_r12 + '|METALURGICA JS|R12' : null;
                    content[13] = !(element.metalurgicajs_r13.search(search)) ? element.metalurgicajs_r13 + '||R13' : null;
                    //content[13] = !(element.metalurgicajs_r13.search(search)) ? element.metalurgicajs_r13 + '|METALURGICA JS|R13' : null;
                    content[14] = !(element.parker.search(search)) ? element.parker + '||' : null;
                    //content[14] = !(element.parker.search(search)) ? element.parker + '|PARKER|' : null;
                    content[15] = !(element.tecnicord.search(search)) ? element.tecnicord + '||' : null;
                    //content[15] = !(element.tecnicord.search(search)) ? element.tecnicord + '|TECNICORD|' : null;
                    content[16] = !(element.hsf.search(search)) ? element.hsf + '||' : null;
                    //content[16] = !(element.hsf.search(search)) ? element.hsf + '|HSF|' : null;

                    content.forEach(elem => {
                        if (elem != null) {
                            codigoBuscado = elem.split("|")[0];
                            marca = elem.split("|")[1];
                            brida = elem.split("|")[2];
                            document.getElementById("data-search").innerHTML += '<p onclick="clickResult(\'' + element.codigo + '\',\'' + codigoBuscado + '\',\'' + element.descripcion + '\',\'' + element.aclaracion + '\',\'' + marca + '\',\'' + brida + '\')">' + codigoBuscado + '</p>';
                        }
                    });

                });
            } else {
                document.getElementById("data-search").innerHTML = '<p>Sin resultados.</p>';
            }
            document.getElementById("loader").style.display = "none";
        });
    }

    function clickResult(codigoEver, codigoBuscado, descripcion, aclaracion, marca, brida) {
        let content = '<div class="terminales-table-result pt-30 pb-30 shadow" style="background:#f7f7f7">';
        content += '<span class="fs-13">código Ever Wear</span>';
        content += '<p class="fs-30" style="background:#000;color:#ffc500">' + codigoEver + '</p>';
        if (brida.length > 0) {
            content += '<p class="fs-20"><b>BRIDA</b>: ' + brida + '</p>';
        }
        content += '<p class="fs-20">' + descripcion + '</p>';
        content += '<p class="fs-12">' + aclaracion + '</p>';
        content += '</div>';
        document.getElementById("table-result").innerHTML = content;
        document.getElementById("data-search").innerHTML = '';
        document.getElementById("search").value = codigoBuscado + ' ' + marca;
    }
</script>