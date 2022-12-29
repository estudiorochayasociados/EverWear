<div class="container pt-30">
    <form method="post" class="row" id="account-form2" enctype="multipart/form-data" data-url="<?= URL ?>" onsubmit="event.preventDefault();sendAccountRequest()">
        <div class="col-md-12 mt-10 mb-10">
            <h2 class="bold mt-30 color-primary">DATOS GENERALES DE LA CUENTA</h2>
            <hr class="mt-0 mb-0"/>

            <div class="row">
                <div class="col-md-7">
                    <label><b class="fs-14">RESPONSABLE COMERCIAL DE LA CUENTA</b></label>
                    <input type="text" class="form-control" name="f1-responsable" required data-validation="required">
                </div>
                <div class="col-md-5">
                    <label><b class="fs-14">ZONA</b></label>
                    <input type="text" class="form-control" name="f1-zona" required data-validation="required">
                </div>

                <div class="col-md-12">
                    <label><b class="fs-14">APELLIDO NOMBRE / RAZÓN SOCIAL</b></label>
                    <input type="text" class="form-control" name="f1-razon" required data-validation="required">
                </div>

                <div class="col-md-12">
                    <label><b class="fs-14">NOMBRE COMERCIAL</b></label>
                    <input type="text" class="form-control" name="f1-nombre" required data-validation="required">
                </div>

                <div class="col-md-6">
                    <label><b class="fs-14">CALLE</b></label>
                    <input type="text" class="form-control" name="f1-calle" required data-validation="required">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3">
                    <label><b class="fs-14">NUMERO</b></label>
                    <input type="number" class="form-control" name="f1-numero" required data-validation="number">
                </div>
                <div class="col-xs-6 col-sm-6  col-md-3">
                    <label><b class="fs-14">C.P.</b></label>
                    <input type="number" class="form-control" name="f1-postal" required data-validation="number">
                </div>
                <div class="clearfix"></div>

                <div class="col-md-6">
                    <label><b class="fs-14">PROVINCIA</b></label>
                    <select class="form-control" id="f1-provincia" name="f1-provincia" required data-validation="required" onchange="getStates('f1-provincia','f1-localidad')">
                        <option disabled selected> ELEGIR UNA PROVINCIA</option>
                        <?= $funciones->provincias() ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label><b class="fs-14">LOCALIDAD</b></label>
                    <select class="form-control" id="f1-localidad" name="f1-localidad" required data-validation="required">

                    </select>
                </div>

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <label><b class="fs-14">TELÉFONO FIJO</b></label>
                            <div class="row">
                                <div class="col-xs-5 col-sm-5 col-md-5">
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon mt-2 mr-2">(</div>
                                            <input type="number" maxlength="5" name="f1-tel[0][zona]" class="form-control" required data-validation="number"/>
                                            <div class="input-group-addon mt-2 ml-2">)</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-7 col-sm-7 col-md-7">
                                    <input type="number" class="form-control" name="f1-tel[0][numero]" required data-validation="required">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <label><b class="fs-14">CELULAR ADMINISTRACIÓN</b></label>
                            <div class="row">
                                <div class="col-xs-5 col-sm-5 col-md-5">
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon mt-2 mr-2">(</div>
                                            <input type="number" maxlength="5" name="f1-tel[1][zona]" class="form-control" required data-validation="number"/>
                                            <div class="input-group-addon mt-2 ml-2">)</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-7 col-sm-7 col-md-7">
                                    <input type="number" class="form-control" name="f1-tel[1][numero]" required data-validation="number">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4">
                            <label><b class="fs-14">CELULAR COMPRA</b> (necesario que tenga Whatsapp)</label>
                            <div class="row">
                                <div class="col-xs-5 col-sm-5 col-md-5">
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon mt-2 mr-2">(</div>
                                            <input type="number" maxlength="5" name="f1-tel[2][zona]" class="form-control" required data-validation="number"/>
                                            <div class="input-group-addon mt-2 ml-2">)</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-7 col-sm-7 col-md-7">
                                    <input type="number" class="form-control" name="f1-tel[2][numero]" required data-validation="number">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <label><b class="fs-14">CORREO ELECTRÓNICO</b> (aquí se enviará la confirmación cuando se cree la planilla)</label>
                    <input type="email" class="form-control" name="f1-email" required data-validation="required">
                </div>
                <div class="col-md-6">
                    <label><b class="fs-14">CORREO ELECTRÓNICO COMPRAS</b></label>
                    <input type="email" class="form-control" name="f1-email-compra" required data-validation="required">
                </div>

                <div class="col-md-12">
                    <label><b class="fs-14">TIPO SOCIETARIO</b></label>
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control" name="f1-tipo-societario" id="societaryType" required data-validation="required"
                                    onchange="($(this).val() == 'OTRA') ? $('#societaryTypeOtra').attr('disabled',false) : $('#societaryTypeOtra').attr('disabled',true)">
                                <option disabled selected> ELEGIR UN TIPO</option>
                                <option value="UNIPERSONAL">UNIPERSONAL</option>
                                <option value="S.A">S.A</option>
                                <option value="S.R.L.">S.R.L.</option>
                                <option value="SOC. HECHO">SOC. HECHO</option>
                                <option value="OTRA">OTRA</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <br class="hidden-md hidden-lg hidden-xl">
                            <input type="text" name="f1-tipo-societario-otra" id="societaryTypeOtra" class="form-control" disabled>
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="bold mt-30 color-primary">DATOS IMPOSITIVOS</h2>
            <hr class="mt-0 mb-0"/>

            <div class="row">
                <div class="col-md-12">
                    <label><b class="fs-14">C.U.I.T</b> (Ingresar número sin guiones ni espacios.)</label>
                    <input type="number" min="0" class="form-control" name="f2-cuit" required data-validation="required">
                </div>

                <div class="col-md-6">
                    <label><b class="fs-14">IMPUESTO AL VALOR AGREGADO</b></label>
                    <select class="form-control" name="f2-imp-agregado" required data-validation="required">
                        <option value="RES. INCS.">RES. INCS.</option>
                        <option value="MONOTRIBUTO">MONOTRIBUTO</option>
                        <option value="EXENTO">EXENTO</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label><b class="fs-14">IMPUESTO A LAS GANANCIAS</b></label>
                    <select class="form-control" name="f2-imp-ganancias" required data-validation="required">
                        <option value="INSCRIPTO">INSCRIPTO</option>
                        <option value="MONOTRIBUTO">MONOTRIBUTO</option>
                        <option value="NO INSCRIP./EXENTO">NO INSCRIP./EXENTO</option>
                    </select>
                </div>

                <div class="col-md-8">
                    <label><b class="fs-14">IMPUESTO A LOS INGRESOS BRUTOS</b></label>
                    <select class="form-control" name="f2-imp-brutos" required data-validation="required">
                        <option value="INSCRIPTO CONTRIB. LOCAL">INSCRIPTO CONTRIB. LOCAL</option>
                        <option value="INSCRIP CONVENIO MULTILATERAL">INSCRIP CONVENIO MULTILATERAL</option>
                        <option value="EXENTO">EXENTO</option>
                        <option value="NO INSCRIP EN IIBB">NO INSCRIP EN IIBB</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label><b class="fs-14">Nº INSCRIPCIÓN</b></label>
                    <input type="number" class="form-control" name="f2-inscripcion" required data-validation="required">
                </div>
            </div>

            <h2 class="bold mt-30 color-primary">DATOS COMERCIALES</h2>
            <hr class="mt-0 mb-0"/>

            <div class="row">
                <div class="col-xs-12 col-sm-12 mt-10 col-md-6">
                    <h5 class="fs-14 bold">DOMICILIOS DE ENTREGA DE LA MERCADERIA</h5>
                    <div class="row">
                        <div class="clearfix"></div>
                        <div class="col-xs-8 col-sm-8  col-md-8">
                            <label><b class="fs-14">CALLE</b></label>
                            <input type="text" class="form-control" name="f3-t-calle" required data-validation="required">
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <label><b class="fs-14">Nº</b></label>
                            <input type="number" class="form-control" name="f3-t-numero" required data-validation="number">
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-6">
                            <label><b class="fs-14">PROVINCIA</b></label>
                            <select class="form-control" id="f3-t-provincia" name="f3-t-provincia" required data-validation="required"
                                    onchange="getStates('f3-t-provincia','f3-t-localidad')">
                                <option disabled selected> ELEGIR UNA PROVINCIA</option>
                                <?= $funciones->provincias() ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label><b class="fs-14">LOCALIDAD</b></label>
                            <select class="form-control" id="f3-t-localidad" name="f3-t-localidad" required data-validation="required">

                            </select>
                        </div>
                    </div>
                    <h5 class="fs-14 bold mt-10">TRANSPORTES PARA EL ENVIO DE LA MERCADERIA</h5>
                    <div class="row">
                        <div class="clearfix"></div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label><b class="fs-14">TRANSPORTE</b></label>
                            <input type="text" class="form-control" name="f3-t-transporte-1" required data-validation="required">
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label><b class="fs-14">TELÉFONO</b></label>
                            <input type="text" class="form-control" name="f3-t-transporte-1-t" required data-validation="required">
                        </div>
                        <div class="clearfix"></div>
                        <!--                        <div class="col-md-12">-->
                        <!--                            <label><b class="fs-14">TRANSPORTE Nº 2</b></label>-->
                        <!--                            <input type="text" class="form-control" name="f3-t-transporte-2">-->
                        <!--                        </div>-->
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 mt-10 col-md-6">
                    <h5 class="fs-14 bold">DOMICILIOS DE ENTREGA DE LA MERCADERIA</h5>
                    <div class="row">
                        <div class="clearfix"></div>
                        <div class="col-xs-8 col-sm-8 col-md-8">
                            <label><b class="fs-14">CALLE</b></label>
                            <input type="text" class="form-control" name="f3-r-calle">
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <label><b class="fs-14">Nº</b></label>
                            <input type="number" class="form-control" name="f3-r-numero">
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-6">
                            <label><b class="fs-14">PROVINCIA</b></label>
                            <select class="form-control" id="f3-r-provincia" name="f3-r-provincia"
                                    onchange="getStates('f3-r-provincia','f3-r-localidad')">
                                <option disabled selected> ELEGIR UNA PROVINCIA</option>
                                <?= $funciones->provincias() ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label><b class="fs-14">LOCALIDAD</b></label>
                            <select class="form-control" id="f3-r-localidad" name="f3-r-localidad">

                            </select>
                        </div>
                    </div>
                    <h5 class="fs-14 bold mt-10">TRANSPORTES PARA EL ENVIO DE LA MERCADERIA</h5>
                    <div class="row">
                        <div class="clearfix"></div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label><b class="fs-14">REDESPACHO</b></label>
                            <input type="text" class="form-control" name="f3-r-transporte-1">
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6">
                            <label><b class="fs-14">TELÉFONO</b></label>
                            <input type="text" class="form-control" name="f3-r-transporte-1-t">
                        </div>
                        <div class="clearfix"></div>
                        <!--                        <div class="col-md-12">-->
                        <!--                            <label><b class="fs-14">REDESPACHO Nº 2</b></label>-->
                        <!--                            <input type="text" class="form-control" name="f3-r-transporte-2">-->
                        <!--                        </div>-->
                    </div>
                </div>
            </div>

            <h2 class="bold mt-30 color-primary">REFERENCIAS COMERCIALES Y BANCARIAS PROPUESTAS</h2>
            <hr class="mt-0 mb-0"/>

            <div class="row">
                <div class="col-md-12 mt-10">
                    <label><b class="fs-14">DESEA REALIZAR LA APERTURA COMO:</b></label>
                    <select type="checkbox" id="f4-apertura" name="f4-apertura" class="form-control" onchange="disableReferences()">
                        <option value="1">CUENTA CORRIENTE</option>
                        <option value="0">PAGO ANTICIPADO</option>
                    </select>
                </div>
                <div class="col-md-6 mt-10">
                    <div class="row">
                        <div class="col-md-12">
                            <label><b class="fs-14">1) RAZÓN SOCIAL:</b></label>
                            <input id="f4-ref1" type="text" class="form-control" name="f4[0][razon]" required data-validation="required">
                        </div>

                        <div class="col-md-12">
                            <label><b class="fs-14">CONTACTO:</b></label>
                            <input id="f4-ref2" type="text" class="form-control" name="f4[0][contacto]" required data-validation="required">
                        </div>

                        <div class="col-md-6">
                            <label><b class="fs-14">RUBRO:</b></label>
                            <input id="f4-ref3" type="text" class="form-control" name="f4[0][rubro]" required data-validation="required">
                        </div>
                        <div class="col-md-6">
                            <label><b class="fs-14">TEL:</b></label>
                            <input id="f4-ref4" type="text" class="form-control" name="f4[0][tel]" required data-validation="required">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-10">
                    <div class="row">
                        <div class="col-md-12">
                            <label><b class="fs-14">2) RAZÓN SOCIAL:</b></label>
                            <input id="f4-ref5" type="text" class="form-control" name="f4[1][razon]" required data-validation="required">
                        </div>

                        <div class="col-md-12">
                            <label><b class="fs-14">CONTACTO:</b></label>
                            <input id="f4-ref6" type="text" class="form-control" name="f4[1][contacto]" required data-validation="required">
                        </div>

                        <div class="col-md-6">
                            <label><b class="fs-14">RUBRO:</b></label>
                            <input id="f4-ref7" type="text" class="form-control" name="f4[1][rubro]" required data-validation="required">
                        </div>
                        <div class="col-md-6">
                            <label><b class="fs-14">TEL:</b></label>
                            <input id="f4-ref8" type="text" class="form-control" name="f4[1][tel]" required data-validation="required">
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <hr class="mt-0 mb-0"/>
                </div>

                <div class="col-md-6 mt-10">
                    <div class="row">
                        <div class="col-md-12">
                            <label><b class="fs-14">3) RAZÓN SOCIAL:</b></label>
                            <input id="f4-ref9" type="text" class="form-control" name="f4[2][razon]" required data-validation="required">
                        </div>

                        <div class="col-md-12">
                            <label><b class="fs-14">CONTACTO:</b></label>
                            <input id="f4-ref10" type="text" class="form-control" name="f4[2][contacto]" required data-validation="required">
                        </div>

                        <div class="col-md-6">
                            <label><b class="fs-14">RUBRO:</b></label>
                            <input id="f4-ref11" type="text" class="form-control" name="f4[2][rubro]" required data-validation="required">
                        </div>
                        <div class="col-md-6">
                            <label><b class="fs-14">TEL:</b></label>
                            <input id="f4-ref12" type="text" class="form-control" name="f4[2][tel]" required data-validation="required">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-10">
                    <div class="row">
                        <div class="col-md-12">
                            <label><b class="fs-14">4) RAZÓN SOCIAL:</b></label>
                            <input id="f4-ref13" type="text" class="form-control" name="f4[3][razon]">
                        </div>

                        <div class="col-md-12">
                            <label><b class="fs-14">CONTACTO:</b></label>
                            <input id="f4-ref14" type="text" class="form-control" name="f4[3][contacto]">
                        </div>

                        <div class="col-md-6">
                            <label><b class="fs-14">RUBRO:</b></label>
                            <input id="f4-ref15" type="text" class="form-control" name="f4[3][rubro]">
                        </div>
                        <div class="col-md-6">
                            <label><b class="fs-14">TEL:</b></label>
                            <input id="f4-ref16" type="text" class="form-control" name="f4[3][tel]">
                        </div>
                    </div>
                </div>
            </div>

            <h2 class="bold mt-30 color-primary">DOCUMENTACIÓN REQUERIDA PARA LA APERTURA</h2>
            <hr class="mt-0 mb-0"/>

            <div class="row">
                <div class="col-md-4">
                    <label><b class="fs-14">CONSTANCIA DE CUIT</b></label>
                    <input type="file" class="form-control" name="files[]" multiple="multiple">
                </div>
                <div class="col-md-4">
                    <label><b class="fs-14">Formulario 1276 API - SANTA FE</b></label>
                    <input type="file" class="form-control" name="files[]" multiple="multiple">
                </div>
                <div class="col-md-4">
                    <label><b class="fs-14">Constancia de inscripción en IIBB</b></label>
                    <input type="file" class="form-control" name="files[]" multiple="multiple" required data-validation="required">
                </div>
                <div class="col-md-4">
                    <label><b class="fs-14">CM 05 (último año)</b></label>
                    <input type="file" class="form-control" name="files[]" multiple="multiple">
                </div>
                <div class="col-md-8">
                    <label><b class="fs-14">Constancia de exclusión de retención y percepción de impuestos</b></label>
                    <input type="file" class="form-control" name="files[]" multiple="multiple">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mt-30">
                    <label><b class="fs-14">NOMBRE DE LA PERSONA DE EVER WEAR QUE LO ATIENDE/VISITA</b></label>
                    <input type="text" class="form-control" name="f5-viajante">
                </div>
                <div class="col-md-12 mt-30" id="btn-a">
                    <button id="btn-a-1" type="submit" class="btn btn-lg btn-success btn-block">GUARDAR LOS DATOS</button>
                </div>
                <div class="col-md-12 mt-30 mb-100">
                    <span class="fs-10">* Al hacer click en éste botón acepto que EVER WEAR pueda contactarse con los datos de contactos que he brindado.</span>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function fil(id) {
        var fil = $('input[type=file]');
        let formData = new FormData();
        formData.append("id", id);
        for (let i = 0; i < fil.length; i++) {
            for (let j = 0; j < fil[i].files.length; j++) {
                formData.append(fil[i].files[j].name+i, fil[i].files[j]);
            }
        }
        const API_ENDPOINT = "<?=URL?>/api/clients/uploadFile.php";
        const request = new XMLHttpRequest();

        request.open("POST", API_ENDPOINT, true);
        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                data = JSON.parse(response);
                if (data['status']) {
                    data['data'].forEach(file => {
                        if (!file['status']) {
                            alertSide(file['message']);
                        } else {
                            //si queres enviar un mensaje de exito
                        }
                    });
                } else {
                    alertSide(data['message']);
                }
            }
        };

        request.send(formData);
    }

    //$('input[type=select]').select2();

    function sendEmail(id) {
        var url = $('#account-form2').attr("data-url");
        $.ajax({
            url: url + "/api/email/sendClient.php",
            type: "POST",
            data: {id: id},
            success: function (data) {
                checkSendEmailStatus(id);
            }
        });
    }

    function checkUploadFileStatus(id) {
        let existeId = false;
        $.getJSON("<?=URL?>/api/clients/uploadFileStatus.json?nocache="+ (new Date()).getTime()).then(data => {
            console.log(data);
            console.log(id);
            data.forEach(function (element) {
                if (id == element.id) {
                   existeId = true;
                    successSide("Enviando email....");
                    sendEmail(id);
                }
            });
            if(!existeId){
                setTimeout(function () {
                    checkUploadFileStatus(id);
                }, 1000);
            }
        });

    }

    function checkSendEmailStatus(id) {
        let existeId = false;

        $.getJSON("<?=URL?>/api/email/sendClientStatus.json?nocache="+ (new Date()).getTime()).then(data => {

            data.forEach(function (element) {
                if (id == element.id) {
                    existeId = true;
                    successSide("Email enviado....");
                    //window.location.href = "<?=URL?>/sesion/listado";
                }
            });
            if(!existeId){
                setTimeout(function () {
                    checkSendEmailStatus(id);
                }, 1000);
            }
        });

    }


    function sendAccountRequest() {
        let btn = $('#btn-a-1');
        btn.attr("disabled", true);
        btn.html("");
        btn.addClass("ld-ext-right running");
        btn.append("<div class='ld ld-ring ld-spin'></div>");
        var url = $('#account-form2').attr("data-url");
        $.ajax({
            url: url + "/api/clients/create.php",
            type: "POST",
            data: $('#account-form2').serialize(),
            success: function (data) {
                console.log(data);
                data = JSON.parse(data);
                if (data['status']) {
                    successSide(data['message']);
                    successSide("Procesando archivos....");
                    fil(data['id']);
                    checkUploadFileStatus(data['id']);
                    //setTimeout(function () {
                    //    await sendEmail(data['id']);
                    //    successSide("Procesando email....");
                    //    setTimeout(function () {
                    //        window.location.href = "<?//=URL?>///sesion/listado";
                    //    }, 10000);
                    //}, 5000);

                } else {
                    alertSide("Ya existe un cliente con ese CUIT.");
                    btn.html("GUARDAR LOS DATOS ");
                    btn.removeClass("ld-ext-right running");
                    btn.attr("disabled", false);
                }
            }
        });
    }

    function getStates(from, to) {
        let obj = $('#' + from);
        let state = obj.val();
        let url = $('#account-form2').attr("data-url");
        $.ajax({
            url: url + "/api/cities/list.php",
            type: "POST",
            data: {
                state: state
            },
            success: function (data) {
                data = JSON.parse(data);
                if (data['status']) {
                    let target = $('#' + to);
                    target.html('');
                    data['data'].forEach(city => {
                        target.append("<option value='" + city + "'>" + city + "</option>");
                    })
                } else {
                }
            }
        });
    }

    function disableReferences() {
        let value = $("#f4-apertura").val();
        if (value == 1) {
            $("#f4-ref1").attr("disabled", false);
            $("#f4-ref2").attr("disabled", false);
            $("#f4-ref3").attr("disabled", false);
            $("#f4-ref4").attr("disabled", false);
            $("#f4-ref5").attr("disabled", false);
            $("#f4-ref6").attr("disabled", false);
            $("#f4-ref7").attr("disabled", false);
            $("#f4-ref8").attr("disabled", false);
            $("#f4-ref9").attr("disabled", false);
            $("#f4-ref10").attr("disabled", false);
            $("#f4-ref11").attr("disabled", false);
            $("#f4-ref12").attr("disabled", false);
            $("#f4-ref13").attr("disabled", false);
            $("#f4-ref14").attr("disabled", false);
            $("#f4-ref15").attr("disabled", false);
            $("#f4-ref16").attr("disabled", false);
        } else {
            $("#f4-ref1").attr("disabled", true);
            $("#f4-ref2").attr("disabled", true);
            $("#f4-ref3").attr("disabled", true);
            $("#f4-ref4").attr("disabled", true);
            $("#f4-ref5").attr("disabled", true);
            $("#f4-ref6").attr("disabled", true);
            $("#f4-ref7").attr("disabled", true);
            $("#f4-ref8").attr("disabled", true);
            $("#f4-ref9").attr("disabled", true);
            $("#f4-ref10").attr("disabled", true);
            $("#f4-ref11").attr("disabled", true);
            $("#f4-ref12").attr("disabled", true);
            $("#f4-ref13").attr("disabled", true);
            $("#f4-ref14").attr("disabled", true);
            $("#f4-ref15").attr("disabled", true);
            $("#f4-ref16").attr("disabled", true);

            $("#f4-ref1").val("");
            $("#f4-ref2").val("");
            $("#f4-ref3").val("");
            $("#f4-ref4").val("");
            $("#f4-ref5").val("");
            $("#f4-ref6").val("");
            $("#f4-ref7").val("");
            $("#f4-ref8").val("");
            $("#f4-ref9").val("");
            $("#f4-ref10").val("");
            $("#f4-ref11").val("");
            $("#f4-ref12").val("");
            $("#f4-ref13").val("");
            $("#f4-ref14").val("");
            $("#f4-ref15").val("");
            $("#f4-ref16").val("");
        }
    }
</script>