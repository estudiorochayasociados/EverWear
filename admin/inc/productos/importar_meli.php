<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1>Exportar productos a MercadoLibre
                    <small style="font-size: 30%">v0.2.3</small>
                </h1>
            </div>
            <div class="col-md-12 text-center">
                <button id="btnEx1" class="btn btn-success " onclick="exportMLType(1);" disabled>TODOS (EDITAR/AGREGAR)</button>
                <button id="btnEx2" class="btn btn-success " onclick="exportMLType(2);" disabled>SOLO PRODUCTOS NO VINCULADOS</button>
                <button id="btnEx3" class="btn btn-success " onclick="exportMLType(3);" disabled>SOLO PRODUCTOS VINCULADOS</button>
                <button id="btnCfg" class="btn btn-primary" data-toggle="modal" data-target="#configModal"><i class="fa fa-cogs"></i></button>
            </div>
        </div>
        <div id="info">

        </div>
    </div>
    <div class="col-md-12 mt-5">
        <div class="row" id="results">
        </div>
    </div>
</div>
<div id="modalS" class="modal fade mt-120" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <i class="fa fa-check-circle fs-90 " style="color:green"></i>
                    <br>
                    <div class="text-uppercase text-center">
                        <p class="fs-18 mt-10" style="margin:auto;width: 250px" id="textS"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalE" class="modal fade mt-120" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <i class="fa fa-exclamation-circle fs-90 " style="color:red"></i>
                    <br>
                    <span class="text-uppercase fs-16" id="error"></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="configModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Configuraciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 text-center">
                        <label>
                            <b>% para publicacion Clasica</b>
                        </label>
                        <input data-suffix="%" class="porcentaje" id="cfg-classic" min="-100" max="100" type="range" value="0"/>
                    </div>
                    <div class="col-md-6 text-center">
                        <label>
                            <b>% para publicacion Premium</b>
                        </label>
                        <input data-suffix="%" class="porcentaje" id="cfg-premium" min="-100" max="100" type="range" value="0"/>
                    </div>
                </div>
                <hr>
                <div class="row mt-5">
                    <div class="col-md-12">
                        <label for="cfg-check-1" style="font-weight: 700;">
                            <input id="cfg-check-1" value="1" type="checkbox">
                            Calcular automaticamente el costo del envio por medio de MercadoLibre?
                        </label>
                        <p class="alert alert-info ml-15">
                            Al marcar la casilla, si el producto posee envío gratis, se le sumará el costo del envío al precio del producto. Caso contrario, mercado libre asume que el costo del envío ya está asumido en el precio del producto.
                        </p>
                        <p class="alert alert-warning ml-15">
                            Aclaración sin importar si la casilla está o no marcada:
                            <br>Por defecto, todos los productos se publican con mercado envios.
                            <br>En caso de que la categoría del producto no sea aceptada por mercado envíos, por ejemplo una máquina muy grande, entrará como "acordar con el vendedor".
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="enableExportBtn()">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(".porcentaje").inputSpinner();
    let costClassic, costPremium, check1;

    function delay() {
        return new Promise(resolve => setTimeout(resolve, 3000));
    }

    function disableExportBtn() {
        $('#btnEx1').attr("disabled", true);
        $('#btnEx2').attr("disabled", true);
        $('#btnEx3').attr("disabled", true);
    }

    function enableExportBtn() {
        $('#btnEx1').attr("disabled", false);
        $('#btnEx2').attr("disabled", false);
        $('#btnEx3').attr("disabled", false);
    }

    function exportMLType(type) {
        $.ajax({
            url: "<?=URLSITE?>/curl/ml/list.php",
            type: "POST",
            data: {type: type},
            beforeSend: function () {
                disableExportBtn();
                $('#btnCfg').attr("disabled", true);
                switch (type) {
                    default:
                        $('#btnEx1').addClass("ld-ext-right running");
                        $('#btnEx1').append("<div class='ld ld-ring ld-spin'></div>");
                        break;
                    case 2:
                        $('#btnEx2').addClass("ld-ext-right running");
                        $('#btnEx2').append("<div class='ld ld-ring ld-spin'></div>");
                        break;
                    case 3:
                        $('#btnEx3').addClass("ld-ext-right running");
                        $('#btnEx3').append("<div class='ld ld-ring ld-spin'></div>");
                        break;
                }
            },
            success: async function (data) {
                console.log(data);
                switch (type) {
                    default:
                        $('#btnEx1').html("TODOS (EDITAR/AGREGAR) ");
                        $('#btnEx1').removeClass("ld-ext-right running");
                        break;
                    case 2:
                        $('#btnEx2').html("SOLO PRODUCTOS NO VINCULADOS ");
                        $('#btnEx2').removeClass("ld-ext-right running");
                        break;
                    case 3:
                        $('#btnEx3').html("SOLO PRODUCTOS VINCULADOS ");
                        $('#btnEx3').removeClass("ld-ext-right running");
                        break;
                }
                data = JSON.parse(data);
                if (data['status']) {
                    costClassic = $('#cfg-classic').val();
                    costPremium = $('#cfg-premium').val();
                    check1 = $('#cfg-check-1:checked').val() ? true : false;

                    var increment = (1 * 100) / data['products'].length;
                    var total = data['products'].length;
                    var estimated = (4 * total) / 60;
                    var estimate;
                    var estimateM;
                    var m = Math.round(estimated % 3600 / 60);
                    if (m > 1) {
                        estimate = " (~" + m + " Horas)";
                    } else {
                        estimateM = Math.round(estimated);
                        estimate = " (~" + estimateM + " Minutos)";
                    }

                    $('#info').append("<h5 class='text-center'>Los productos se estan subiendo/actualizando en MercadoLibre, por favor aguarde y no cierre esta página.</h5>");
                    $('#info').append("<div class='text-center ld-ext-right running fs-17'><strong>Producto: </strong><strong id='productSingle'>0</strong><strong id='products'>/" + total + " </strong><label> " + estimate + "</label><div class='ld ld-ring ld-spin'></div></div>");
                    $('#info').append("<progress id='progress-bar' class='prb' max='100' value='0'></progress>");

                    $('#results').append(
                        "<table class='table'>" +
                        "    <thead class='thead-dark'>" +
                        "    <tr>" +
                        "        <th>TITULO</th>" +
                        "        <th class='text-center'>CÓDIGO</th>" +
                        "        <th class='text-center'>PRECIO</th>" +
                        "        <th class='text-center'>ENVÍO</th>" +
                        "        <th class='text-center'>ESTADO</th>" +
                        "        <th class='text-center'>MENSAJE</th>" +
                        "    </tr>" +
                        "    </thead>" +
                        "    <tbody id='resultsRow'>" +
                        "    </tbody>" +
                        "</table>"
                    );

                    let ok = true;
                    for (var i = 0; i < total; i++) {
                        let response = await sendML(data['products'][i], increment);
                        response = JSON.parse(response);
                        if (!response['response']) {
                            ok = false;
                            break;
                        }
                    }

                    if (ok) {
                        if (i == total) {
                            $('#textS').html('');
                            $('#textS').append("Carga de productos finalizada.");
                            $('#info').html('');
                            $('#modalS').modal('toggle');
                        }
                    } else {
                        $('#info').html('');
                        $('#error').html('');
                        $('#error').append('Ocurrió un error con la vinculación a MercadoLibre, intente nuevamente.');
                        $('#modalE').modal('toggle');
                    }

                } else {
                    $('#error').html('');
                    $('#error').append(data['message']);
                    $('#modalE').modal('toggle');
                }
            }
        });
    }

    function sendML(product, increment) {
        return $.ajax({
            url: "<?=URLSITE?>/curl/ml/export.php",
            type: "POST",
            data: {
                product: product,
                classic: costClassic,
                premium: costPremium,
                check1: check1
            },
            success: function (data) {
                console.log(data);
                data = JSON.parse(data);
                if (data['response']) {
                    $('#progress-bar').val($('#progress-bar').val() + increment);

                    $('#productSingle').html(parseInt($('#productSingle').text()) + 1);

                    $('#resultsRow').append(data['text']);

                    if ($('#progress-bar').val() >= 100) {
                        $('#textS').html('');
                        $('#textS').append("Carga de productos finalizada.");
                        $('#info').html('');
                        $('#modalS').modal('toggle');
                    }
                }
            }
        });
    }

    function loginML() {
        return $.ajax({
            url: "https://auth.mercadolibre.com.ar/authorization?client_id=7886107849656513&response_type=code&redirect_uri=https%3A%2F%2Fwww.rocha.com%2Faimar%2Frepuestos%2Fexportador%2Fadmin",
            type: "GET",
            data: {},
            success: function (data) {
                console.log(data);
                data = JSON.parse(data);
            }
        });
    }
</script>
