<?php
$cuentaCorriente = new Clases\CuentasCorrientes();
$transporte = new Clases\Transportes();
$referencia = new Clases\Referencias();
$archivo = new Clases\Archivos();

if (empty($_SESSION["usuarios"]) || $_SESSION['usuarios']['invitado'] == 1) {
    $usuario->logout();
    $funciones->headerMove(URL);
}

$id = $funciones->antihack_mysqli(isset($_GET['id']) ? $_GET['id'] : '');
$cuentaCorriente->set("id", $id);
$cuentaCorriente->set("usuario", $_SESSION['usuarios']['cod']);
$cuenta = $cuentaCorriente->view();

if (empty($cuenta['data'])) $funciones->headerMove(URL . "/sesion/listado");
?>
<div class="container pt-30">
    <div id="accordion">
        <div class="card mt-5">
            <a class="btn btn-primary" data-toggle="collapse" data-target="#stage1" aria-expanded="false" aria-controls="stage1" style="width: 100%;background: #282828 !important;margin-bottom:5px">
                <div class="card-header pb-10 pt-10" id="headingOne" style="border-bottom: unset">
                    <h5 class="mb-0 " style="color: yellow;font-weight:700;margin:0px">
                        DATOS GENERALES DE LA CUENTA
                    </h5>
                </div>
            </a>
            <div id="stage1" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                    <form method="post" id="account-form-1" data-url="<?= URL ?>" onsubmit="event.preventDefault();updateGeneral()">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <div class="row">
                            <div class="col-md-7">
                                <label><b class="fs-12">RESPONSABLE COMERCIAL DE LA CUENTA</b></label>
                                <input type="text" class="form-control" name="f1-responsable" required data-validation="required"
                                       value="<?= !empty($cuenta['data']['responsable']) ? $cuenta['data']['responsable'] : '' ?>">
                            </div>
                            <div class="col-md-5">
                                <label><b class="fs-12">ZONA</b></label>
                                <input type="text" class="form-control" name="f1-zona" required data-validation="required"
                                       value="<?= !empty($cuenta['data']['zona']) ? $cuenta['data']['zona'] : '' ?>">
                            </div>

                            <div class="col-md-12">
                                <label><b class="fs-12">APELLIDO NOMBRE / RAZÓN SOCIAL</b></label>
                                <input type="text" class="form-control" name="f1-razon" required data-validation="required"
                                       value="<?= !empty($cuenta['data']['razon_social']) ? $cuenta['data']['razon_social'] : '' ?>">
                            </div>

                            <div class="col-md-12">
                                <label><b class="fs-12">NOMBRE COMERCIAL</b></label>
                                <input type="text" class="form-control" name="f1-nombre" required data-validation="required"
                                       value="<?= !empty($cuenta['data']['nombre_comercial']) ? $cuenta['data']['nombre_comercial'] : '' ?>">
                            </div>

                            <div class="col-md-6">
                                <label><b class="fs-12">CALLE</b></label>
                                <input type="text" class="form-control" name="f1-calle" required data-validation="required"
                                       value="<?= !empty($cuenta['data']['calle']) ? $cuenta['data']['calle'] : '' ?>">
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-6 col-sm-6 col-md-3">
                                <label><b class="fs-12">NUMERO</b></label>
                                <input type="number" class="form-control" name="f1-numero" required data-validation="number"
                                       value="<?= !empty($cuenta['data']['numero']) ? $cuenta['data']['numero'] : '' ?>">
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-3">
                                <label><b class="fs-12">C.P.</b></label>
                                <input type="number" class="form-control" name="f1-postal" required data-validation="number"
                                       value="<?= !empty($cuenta['data']['postal']) ? $cuenta['data']['postal'] : '' ?>">
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-6 col-xs-12">
                                <label><b class="fs-12">PROVINCIA</b></label><br/>
                                <select id="f1-provincia" name="f1-provincia" required data-validation="required" onchange="getStates('f1-provincia','f1-localidad')" class="form-control">
                                    <!--<option value="<?= $cuenta['data']['provincia'] ?>"> <?= $cuenta['data']['provincia'] ?></option>-->
                                    <option disabled> ELEGIR UNA PROVINCIA</option>
                                    <?= $funciones->provincias() ?>
                                </select>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <label><b class="fs-12">LOCALIDAD</b></label><br/>
                                <select id="f1-localidad" name="f1-localidad" required data-validation="required" class="form-control">
                                    <!--<option value="<?= $cuenta['data']['localidad'] ?>"> <?= $cuenta['data']['localidad'] ?></option>-->
                                </select>
                            </div>

                            <?php
                            $telefono = explode("-", $cuenta['data']['telefono']);
                            $celularAdm = explode("-", $cuenta['data']['celular_adm']);
                            $celularCompra = explode("-", $cuenta['data']['celular_compra']);
                            ?>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <label><b class="fs-12">TELÉFONO FIJO</b></label>
                                        <div class="row">
                                            <div class="col-xs-5 col-sm-5 col-md-5">
                                                <div class="form-group ">
                                                    <div class="input-group">
                                                        <div class="input-group-addon mt-2 mr-2">(</div>
                                                        <input type="number" maxlength="5" name="f1-tel[0][zona]" class="form-control" required data-validation="number"
                                                               value="<?= !empty($telefono[0]) ? $telefono[0] : '' ?>"/>
                                                        <div class="input-group-addon mt-2 ml-2">)</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-7 col-sm-7 col-md-7">
                                                <input type="number" class="form-control" name="f1-tel[0][numero]" required data-validation="number"
                                                       value="<?= !empty($telefono[1]) ? $telefono[1] : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <label><b class="fs-12">CELULAR ADMINISTRACIÓN</b></label>
                                        <div class="row">
                                            <div class="col-xs-5 col-sm-5 col-md-5">
                                                <div class="form-group ">
                                                    <div class="input-group">
                                                        <div class="input-group-addon mt-2 mr-2">(</div>
                                                        <input type="number" maxlength="5" name="f1-tel[1][zona]" class="form-control" required data-validation="number"
                                                               value="<?= !empty($celularAdm[0]) ? $celularAdm[0] : '' ?>"/>
                                                        <div class="input-group-addon mt-2 ml-2">)</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-7 col-sm-7 col-md-7">
                                                <input type="number" class="form-control" name="f1-tel[1][numero]" required data-validation="number"
                                                       value="<?= !empty($celularAdm[1]) ? $celularAdm[1] : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-4">
                                        <label><b class="fs-12">CELULAR COMPRA</b></label>
                                        <div class="row">
                                            <div class="col-xs-5 col-sm-5 col-md-5">
                                                <div class="form-group ">
                                                    <div class="input-group">
                                                        <div class="input-group-addon mt-2 mr-2">(</div>
                                                        <input type="number" maxlength="5" name="f1-tel[2][zona]" class="form-control"
                                                               value="<?= !empty($celularCompra[0]) ? $celularCompra[0] : '' ?>"/>
                                                        <div class="input-group-addon mt-2 ml-2">)</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-7 col-sm-7 col-md-7">
                                                <input type="number" class="form-control" name="f1-tel[2][numero]"
                                                       value="<?= !empty($celularCompra[1]) ? $celularCompra[1] : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label><b class="fs-12">CORREO ELECTRÓNICO</b></label>
                                <input type="email" class="form-control" name="f1-email" required data-validation="required"
                                       value="<?= !empty($cuenta['data']['email']) ? $cuenta['data']['email'] : '' ?>">
                            </div>
                            <div class="col-md-6">
                                <label><b class="fs-12">CORREO ELECTRÓNICO COMPRAS</b></label>
                                <input type="email" class="form-control" name="f1-email-compra" required data-validation="required"
                                       value="<?= !empty($cuenta['data']['email_compra']) ? $cuenta['data']['email_compra'] : '' ?>">
                            </div>

                            <?php
                            $tipoSocietario = explode("-", $cuenta['data']['tipo_societario']);
                            ?>
                            <div class="col-md-12">
                                <label><b class="fs-12">TIPO SOCIETARIO</b></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="form-control" name="f1-tipo-societario" required data-validation="required"
                                                onchange="($(this).val() == 'OTRA') ? $('#societaryTypeOtra').attr('disabled',false) : $('#societaryTypeOtra').attr('disabled',true)">
                                            <option disabled selected> ELEGIR UN TIPO</option>
                                            <option value="UNIPERSONAL" <?= $tipoSocietario[0] == "UNIPERSONAL" ? "selected" : "" ?>>UNIPERSONAL</option>
                                            <option value="S.A" <?= $tipoSocietario[0] == "S.A" ? "selected" : "" ?>>S.A</option>
                                            <option value="S.R.L." <?= $tipoSocietario[0] == "S.R.L." ? "selected" : "" ?>>S.R.L.</option>
                                            <option value="SOC. HECHO" <?= $tipoSocietario[0] == "SOC. HECHO" ? "selected" : "" ?>>SOC. HECHO</option>
                                            <option value="OTRA" <?= $tipoSocietario[0] == "OTRA" ? "selected" : "" ?>>OTRA</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <br class="hidden-md hidden-lg hidden-xl">
                                        <input type="text" name="f1-tipo-societario-otra" id="societaryTypeOtra" class="form-control"
                                               value="<?= !empty($tipoSocietario[1]) ? $tipoSocietario[1] : '' ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h4 class="fs-14 bold mt-20">DATOS IMPOSITIVOS</h4>
                        <hr class="mt-0 mb-0"/>

                        <div class="row">
                            <div class="col-md-12">
                                <label><b class="fs-12">C.U.I.T</b></label>
                                <input type="number" min="0" class="form-control" name="f2-cuit" required data-validation="required"
                                       value="<?= !empty($cuenta['data']['cuit']) ? $cuenta['data']['cuit'] : '' ?>">
                            </div>

                            <div class="col-md-6">
                                <label><b class="fs-12">IMPUESTO AL VALOR AGREGADO</b></label>
                                <select class="form-control" name="f2-imp-agregado" required data-validation="required">
                                    <option value="RES. INCS." <?= $cuenta['data']['impuesto_agregado'] == 'RES. INCS.' ? 'selected' : '' ?>>
                                        RES. INCS.
                                    </option>
                                    <option value="MONOTRIBUTO" <?= $cuenta['data']['impuesto_agregado'] == 'MONOTRIBUTO' ? 'selected' : '' ?>>
                                        MONOTRIBUTO
                                    </option>
                                    <option value="EXENTO" <?= $cuenta['data']['impuesto_agregado'] == 'EXENTO' ? 'selected' : '' ?>>
                                        EXENTO
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label><b class="fs-12">IMPUESTO A LAS GANANCIAS</b></label>
                                <select class="form-control" name="f2-imp-ganancias" required data-validation="required">
                                    <option value="INSCRIPTO" <?= $cuenta['data']['impuesto_ganancia'] == 'INSCRIPTO' ? 'selected' : '' ?>>
                                        INSCRIPTO
                                    </option>
                                    <option value="MONOTRIBUTO" <?= $cuenta['data']['impuesto_ganancia'] == 'MONOTRIBUTO' ? 'selected' : '' ?>>
                                        MONOTRIBUTO
                                    </option>
                                    <option value="NO INSCRIP./EXENTO" <?= $cuenta['data']['impuesto_ganancia'] == 'NO INSCRIP./EXENTO' ? 'selected' : '' ?>>
                                        NO INSCRIP./EXENTO
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-8">
                                <label><b class="fs-12">IMPUESTO A LOS INGRESOS BRUTOS</b></label>
                                <select class="form-control" name="f2-imp-brutos" required data-validation="required">
                                    <option value="INSCRIPTO CONTRIB. LOCAL" <?= $cuenta['data']['impuesto_brutos'] == 'INSCRIPTO CONTRIB. LOCAL' ? 'selected' : '' ?>>
                                        INSCRIPTO CONTRIB. LOCAL
                                    </option>
                                    <option value="INSCRIP CONVENIO MULTILATERAL" <?= $cuenta['data']['impuesto_brutos'] == 'INSCRIP CONVENIO MULTILATERAL' ? 'selected' : '' ?>>
                                        INSCRIP CONVENIO MULTILATERAL
                                    </option>
                                    <option value="EXENTO" <?= $cuenta['data']['impuesto_brutos'] == 'EXENTO' ? 'selected' : '' ?>>
                                        EXENTO
                                    </option>
                                    <option value="NO INSCRIP EN IIBB" <?= $cuenta['data']['impuesto_brutos'] == 'NO INSCRIP EN IIBB' ? 'selected' : '' ?>>
                                        NO INSCRIP EN IIBB
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label><b class="fs-12">Nº INSCRIPCIÓN</b></label>
                                <input type="number" class="form-control" name="f2-inscripcion" required data-validation="required"
                                       value="<?= !empty($cuenta['data']['numero_inscripcion']) ? $cuenta['data']['numero_inscripcion'] : '' ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-30">
                                <button id="account-form-1-btn" type="submit" class="btn btn-lg btn-success btn-block ">GUARDAR LOS DATOS</button>
                            </div>
                            <div class="col-md-12 mt-30">
                                <span class="fs-10">* Al hacer click en éste botón acepto que EVER WEAR pueda contactarse con los datos de contactos que he brindado.</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            $transporte->set("idCuentaCorriente", $id);
            $transporte->set("tipo", 1);
            $transporteData = $transporte->viewByType();
            $transporte->set("tipo", 2);
            $redespachoData = $transporte->viewByType();
            ?>
            <a class="btn btn-primary" data-toggle="collapse" data-target="#stage2" aria-expanded="false" aria-controls="stage2" style="width: 100%;background: #282828 !important;margin-bottom:5px">
                <div class="card-header pb-10 pt-10" id="headingTwo" style="border-bottom: unset">
                    <h5 class="mb-0 " style="color: yellow;font-weight:700;margin:0px">
                        DATOS COMERCIALES
                    </h5>
                </div>
            </a>
            <div id="stage2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                <div class="card-body">
                    <form method="post" id="account-form-2" data-url="<?= URL ?>" onsubmit="event.preventDefault();updateCommercial()">
                        <div class="row">
                            <div class="col-md-6 mt-10">
                                <h5 class="fs-14 bold">DOMICILIOS DE ENTREGA DE LA MERCADERIA</h5>
                                <div class="row">
                                    <input type="hidden" name="f3-t-id" value="<?= $transporteData['data']['id'] ?>">
                                    <div class="clearfix"></div>
                                    <div class="col-xs-8 col-sm-8 col-md-8">
                                        <label><b class="fs-12">CALLE</b></label>
                                        <input type="text" class="form-control" name="f3-t-calle" required data-validation="required"
                                               value="<?= !empty($transporteData['data']['calle']) ? $transporteData['data']['calle'] : '' ?>">
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                        <label><b class="fs-12">Nº</b></label>
                                        <input type="number" class="form-control" name="f3-t-numero" required data-validation="number"
                                               value="<?= !empty($transporteData['data']['numero']) ? $transporteData['data']['numero'] : '' ?>">
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="col-md-6">
                                        <label><b class="fs-12">PROVINCIA</b></label>
                                        <select class="form-control" id="f3-t-provincia" name="f3-t-provincia" required data-validation="required"
                                                onchange="getStates('f3-t-provincia','f3-t-localidad')">
                                            <option value="<?= $transporteData['data']['provincia'] ?>" selected><?= $transporteData['data']['provincia'] ?></option>
                                            <option disabled> ELEGIR UNA PROVINCIA</option>
                                            <?= $funciones->provincias() ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label><b class="fs-12">LOCALIDAD</b></label>
                                        <select class="form-control" id="f3-t-localidad" name="f3-t-localidad" required data-validation="required">
                                            <option value="<?= $transporteData['data']['localidad'] ?>" selected><?= $transporteData['data']['localidad'] ?></option>
                                        </select>
                                    </div>
                                </div>
                                <h5 class="fs-14 bold mt-10">TRANSPORTES PARA EL ENVIO DE LA MERCADERIA</h5>
                                <div class="row">
                                    <div class="clearfix"></div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <label><b class="fs-14">TRANSPORTE</b></label>
                                        <input type="text" class="form-control" name="f3-t-transporte-1" required data-validation="required"
                                        value="<?= !empty($transporteData['data']['transporte_1']) ? $transporteData['data']['transporte_1'] : '' ?>">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <label><b class="fs-14">TELÉFONO</b></label>
                                        <input type="text" class="form-control" name="f3-t-transporte-1-t" required data-validation="required"
                                        value="<?= !empty($transporteData['data']['transporte_1_telefono']) ? $transporteData['data']['transporte_1_telefono'] : '' ?>">
                                    </div>
                                    <div class="clearfix"></div>
<!--                                    <div class="col-md-12">-->
<!--                                        <label><b class="fs-12">TRANSPORTE Nº 2</b></label>-->
<!--                                        <input type="text" class="form-control" name="f3-t-transporte-2"-->
<!--                                               value="--><?//= !empty($transporteData['data']['transporte_2']) ? $transporteData['data']['transporte_2'] : '' ?><!--">-->
<!--                                    </div>-->
                                </div>
                            </div>
                            <div class="col-md-6 mt-10">
                                <h5 class="fs-14 bold">DOMICILIOS DE ENTREGA DE LA MERCADERIA</h5>
                                <div class="row">
                                    <input type="hidden" name="f3-r-id" value="<?= $redespachoData['data']['id'] ?>">
                                    <div class="clearfix"></div>
                                    <div class="col-xs-8 col-sm-8 col-md-8">
                                        <label><b class="fs-12">CALLE</b></label>
                                        <input type="text" class="form-control" name="f3-r-calle"
                                               value="<?= !empty($redespachoData['data']['calle']) ? $redespachoData['data']['calle'] : '' ?>">
                                    </div>
                                    <div class="col-xs-4 col-sm-4 col-md-4">
                                        <label><b class="fs-12">Nº</b></label>
                                        <input type="number" class="form-control" name="f3-r-numero"
                                               value="<?= !empty($redespachoData['data']['numero']) ? $redespachoData['data']['numero'] : '' ?>">
                                    </div>
                                    <div class="clearfix"></div>

                                    <div class="col-md-6">
                                        <label><b class="fs-12">PROVINCIA</b></label>
                                        <select class="form-control" id="f3-r-provincia" name="f3-r-provincia"
                                                onchange="getStates('f3-r-provincia','f3-r-localidad')">
                                            <option value="<?= $redespachoData['data']['provincia'] ?>" selected><?= $redespachoData['data']['provincia'] ?></option>
                                            <option disabled> ELEGIR UNA PROVINCIA</option>
                                            <?= $funciones->provincias() ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label><b class="fs-12">LOCALIDAD</b></label>
                                        <select class="form-control" id="f3-r-localidad" name="f3-r-localidad">
                                            <option value="<?= $redespachoData['data']['localidad'] ?>" selected><?= $redespachoData['data']['localidad'] ?></option>
                                        </select>
                                    </div>
                                </div>
                                <h5 class="fs-14 bold mt-10">TRANSPORTES PARA EL ENVIO DE LA MERCADERIA</h5>
                                <div class="row">
                                    <div class="clearfix"></div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <label><b class="fs-14">REDESPACHO</b></label>
                                        <input type="text" class="form-control" name="f3-r-transporte-1"
                                        value="<?= !empty($redespachoData['data']['transporte_1']) ? $redespachoData['data']['transporte_1'] : '' ?>">
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <label><b class="fs-14">TELÉFONO</b></label>
                                        <input type="text" class="form-control" name="f3-r-transporte-1-t"
                                        value="<?= !empty($redespachoData['data']['transporte_1_telefono']) ? $redespachoData['data']['transporte_1_telefono'] : '' ?>">
                                    </div>
                                    <div class="clearfix"></div>
<!--                                    <div class="col-md-12">-->
<!--                                        <label><b class="fs-12">REDESPACHO Nº 2</b></label>-->
<!--                                        <input type="text" class="form-control" name="f3-r-transporte-2"-->
<!--                                               value="--><?//= !empty($redespachoData['data']['transporte_2']) ? $redespachoData['data']['transporte_2'] : '' ?><!--">-->
<!--                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-30">
                                <button id="account-form-2-btn" type="submit" class="btn btn-lg btn-success btn-block ">GUARDAR LOS DATOS</button>
                            </div>
                            <div class="col-md-12 mt-30">
                                <span class="fs-10">* Al hacer click en éste botón acepto que EVER WEAR pueda contactarse con los datos de contactos que he brindado.</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            $referenciasData = $referencia->list(["id_cuenta_corriente=$id"], 'id ASC', '');
            ?>
            <a class="btn btn-primary" data-toggle="collapse" data-target="#stage3" aria-expanded="false" aria-controls="stage3" style="width: 100%;background: #282828 !important;margin-bottom:5px">
                <div class="card-header pb-10 pt-10" id="headingThree" style="border-bottom: unset">
                    <h5 class="mb-0 " style="color: yellow;font-weight:700;margin:0px">
                        REFERENCIAS COMERCIALES Y BANCARIAS PROPUESTAS
                    </h5>
                </div>
            </a>
            <div id="stage3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                <div class="card-body">
                    <form method="post" id="account-form-3" data-url="<?= URL ?>" onsubmit="event.preventDefault();updateReference()">
                        <input type="hidden" name="f4-cc" value="<?= $id ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <hr/>
                                <div class="row">
                                    <input type="hidden" name="f4[0][id]" value="<?= !empty($referenciasData[0]['data']['id']) ? $referenciasData[0]['data']['id'] : '' ?>">
                                    <div class="col-md-12">
                                        <label><b class="fs-12">1) RAZÓN SOCIAL:</b></label>
                                        <input type="text" class="form-control" name="f4[0][razon]" required data-validation="required"
                                               value="<?= !empty($referenciasData[0]['data']['razon_social']) ? $referenciasData[0]['data']['razon_social'] : '' ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <label><b class="fs-12">CONTACTO:</b></label>
                                        <input type="text" class="form-control" name="f4[0][contacto]" required data-validation="required"
                                               value="<?= !empty($referenciasData[0]['data']['contacto']) ? $referenciasData[0]['data']['contacto'] : '' ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <label><b class="fs-12">RUBRO:</b></label>
                                        <input type="text" class="form-control" name="f4[0][rubro]" required data-validation="required"
                                               value="<?= !empty($referenciasData[0]['data']['rubro']) ? $referenciasData[0]['data']['rubro'] : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label><b class="fs-12">TEL:</b></label>
                                        <input type="text" class="form-control" name="f4[0][tel]" required data-validation="required"
                                               value="<?= !empty($referenciasData[0]['data']['telefono']) ? $referenciasData[0]['data']['telefono'] : '' ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <label><b class="fs-12">DETALLE:</b></label>
                                        <textarea class="form-control" name="f4[0][detalle]" rows="3"><?= !empty($referenciasData[0]['data']['detalle']) ? $referenciasData[0]['data']['detalle'] : '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <hr/>
                                <div class="row">
                                    <input type="hidden" name="f4[1][id]" value="<?= !empty($referenciasData[1]['data']['id']) ? $referenciasData[1]['data']['id'] : '' ?>">
                                    <div class="col-md-12">
                                        <label><b class="fs-12">2) RAZÓN SOCIAL:</b></label>
                                        <input type="text" class="form-control" name="f4[1][razon]" required data-validation="required"
                                               value="<?= !empty($referenciasData[1]['data']['razon_social']) ? $referenciasData[1]['data']['razon_social'] : '' ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <label><b class="fs-12">CONTACTO:</b></label>
                                        <input type="text" class="form-control" name="f4[1][contacto]" required data-validation="required"
                                               value="<?= !empty($referenciasData[1]['data']['contacto']) ? $referenciasData[1]['data']['contacto'] : '' ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <label><b class="fs-12">RUBRO:</b></label>
                                        <input type="text" class="form-control" name="f4[1][rubro]" required data-validation="required"
                                               value="<?= !empty($referenciasData[1]['data']['rubro']) ? $referenciasData[1]['data']['rubro'] : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label><b class="fs-12">TEL:</b></label>
                                        <input type="text" class="form-control" name="f4[1][tel]" required data-validation="required"
                                               value="<?= !empty($referenciasData[1]['data']['telefono']) ? $referenciasData[1]['data']['telefono'] : '' ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <label><b class="fs-12">DETALLE:</b></label>
                                        <textarea class="form-control" name="f4[1][detalle]" rows="3"><?= !empty($referenciasData[1]['data']['detalle']) ? $referenciasData[1]['data']['detalle'] : '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="col-md-6">
                                <hr/>
                                <div class="row">
                                    <input type="hidden" name="f4[2][id]" value="<?= !empty($referenciasData[2]['data']['id']) ? $referenciasData[2]['data']['id'] : '' ?>">
                                    <div class="col-md-12">
                                        <label><b class="fs-12">3) RAZÓN SOCIAL:</b></label>
                                        <input type="text" class="form-control" name="f4[2][razon]" required data-validation="required"
                                               value="<?= !empty($referenciasData[2]['data']['razon_social']) ? $referenciasData[2]['data']['razon_social'] : '' ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <label><b class="fs-12">CONTACTO:</b></label>
                                        <input type="text" class="form-control" name="f4[2][contacto]" required data-validation="required"
                                               value="<?= !empty($referenciasData[2]['data']['contacto']) ? $referenciasData[2]['data']['contacto'] : '' ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <label><b class="fs-12">RUBRO:</b></label>
                                        <input type="text" class="form-control" name="f4[2][rubro]" required data-validation="required"
                                               value="<?= !empty($referenciasData[2]['data']['rubro']) ? $referenciasData[2]['data']['rubro'] : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label><b class="fs-12">TEL:</b></label>
                                        <input type="text" class="form-control" name="f4[2][tel]" required data-validation="required"
                                               value="<?= !empty($referenciasData[2]['data']['telefono']) ? $referenciasData[2]['data']['telefono'] : '' ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <label><b class="fs-12">DETALLE:</b></label>
                                        <textarea class="form-control" name="f4[2][detalle]" rows="3"><?= !empty($referenciasData[2]['data']['detalle']) ? $referenciasData[2]['data']['detalle'] : '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <hr/>
                                <div class="row">
                                    <input type="hidden" name="f4[3][id]" value="<?= !empty($referenciasData[3]['data']['id']) ? $referenciasData[3]['data']['id'] : '' ?>">
                                    <div class="col-md-12">
                                        <label><b class="fs-12">4) RAZÓN SOCIAL:</b></label>
                                        <input type="text" class="form-control" name="f4[3][razon]"
                                               value="<?= !empty($referenciasData[3]['data']['razon_social']) ? $referenciasData[3]['data']['razon_social'] : '' ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <label><b class="fs-12">CONTACTO:</b></label>
                                        <input type="text" class="form-control" name="f4[3][contacto]"
                                               value="<?= !empty($referenciasData[3]['data']['contacto']) ? $referenciasData[3]['data']['contacto'] : '' ?>">
                                    </div>

                                    <div class="col-md-6">
                                        <label><b class="fs-12">RUBRO:</b></label>
                                        <input type="text" class="form-control" name="f4[3][rubro]"
                                               value="<?= !empty($referenciasData[3]['data']['rubro']) ? $referenciasData[3]['data']['rubro'] : '' ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label><b class="fs-12">TEL:</b></label>
                                        <input type="text" class="form-control" name="f4[3][tel]"
                                               value="<?= !empty($referenciasData[3]['data']['telefono']) ? $referenciasData[3]['data']['telefono'] : '' ?>">
                                    </div>

                                    <div class="col-md-12">
                                        <label><b class="fs-12">DETALLE:</b></label>
                                        <textarea class="form-control" name="f4[3][detalle]" rows="3"><?= !empty($referenciasData[3]['data']['detalle']) ? $referenciasData[3]['data']['detalle'] : '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-30">
                                <button id="account-form-3-btn" type="submit" class="btn btn-lg btn-success btn-block ">GUARDAR LOS DATOS</button>
                            </div>
                            <div class="col-md-12 mt-30">
                                <span class="fs-10">* Al hacer click en éste botón acepto que EVER WEAR pueda contactarse con los datos de contactos que he brindado.</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <a class="btn btn-primary" data-toggle="collapse" data-target="#stage4" aria-expanded="false" aria-controls="stage4" style="width: 100%;background: #282828 !important;margin-bottom:5px">
                <div class="card-header pb-10 pt-10" id="headingFour" style="border-bottom: unset">
                    <h5 class="mb-0 " style="color: yellow;font-weight:700;margin:0px">
                        DATOS FINANCIEROS Y ESTRATEGICOS
                    </h5>
                </div>
            </a>
            <div id="stage4" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                <div class="card-body">
                    <form method="post" id="account-form-4" data-url="<?= URL ?>" onsubmit="event.preventDefault();updateFinancial()">
                        <input type="hidden" name="f5-cc" value="<?= $id ?>">
                        <div class="row">
                            <div class="col-md-4">
                                <label><b class="fs-12">Lista de precio</b></label>
                                <div class="form-group ">
                                    <div class="input-group">
                                        <input type="number" min="0" max="100" maxlength="3" class="form-control" name="f5-lista" required data-validation="required"
                                               value="<?= !empty($cuenta['data']['lista']) ? $cuenta['data']['lista'] : 0 ?>">
                                        <div class="input-group-addon mt-2 ml-2">%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label><b class="fs-12">Condición de venta</b></label>
                                        <select class="form-control" name="f5-condicion" required data-validation="required">
                                            <option disabled selected> ELEGIR</option>
                                            <option <?= $cuenta['data']['condicion'] == "CONTRAREEMBOLSO" ? 'selected' : '' ?>>CONTRAREEMBOLSO</option>
                                            <option <?= $cuenta['data']['condicion'] == "PAGO ANTICIPADO" ? 'selected' : '' ?>>PAGO ANTICIPADO</option>
                                            <option <?= $cuenta['data']['condicion'] == "CUENTA CORRIENTE" ? 'selected' : '' ?>>CUENTA CORRIENTE</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label><b class="fs-12">Forma de pago</b></label>
                                        <select class="form-control" name="f5-forma" required data-validation="required">
                                            <option disabled selected> ELEGIR</option>
                                            <option <?= $cuenta['data']['forma'] == "NETO" ? 'selected' : '' ?>>NETO</option>
                                            <option <?= $cuenta['data']['forma'] == "30 DIAS 10%" ? 'selected' : '' ?>>30 DIAS 10%</option>
                                            <option <?= $cuenta['data']['forma'] == "45 DIAS 10%" ? 'selected' : '' ?>>45 DIAS 10%</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label><b class="fs-12">Categoria del cliente</b></label>
                                        <select class="form-control" name="f5-categoria" required data-validation="required">
                                            <option disabled selected> ELEGIR</option>
                                            <option <?= $cuenta['data']['categoria'] == "CASA DE GOMAS" ? 'selected' : '' ?>>CASA DE GOMAS</option>
                                            <option <?= $cuenta['data']['categoria'] == "CORRALÓN" ? 'selected' : '' ?>>CORRALÓN</option>
                                            <option <?= $cuenta['data']['categoria'] == "FERRETERÍA" ? 'selected' : '' ?>>FERRETERÍA</option>
                                            <option <?= $cuenta['data']['categoria'] == "HIDRAULICA" ? 'selected' : '' ?>>HIDRAULICA</option>
                                            <option <?= $cuenta['data']['categoria'] == "INDUSTRIA" ? 'selected' : '' ?>>INDUSTRIA</option>
                                            <option <?= $cuenta['data']['categoria'] == "LUBRICENTRO" ? 'selected' : '' ?>>LUBRICENTRO</option>
                                            <option <?= $cuenta['data']['categoria'] == "ESTACIÓN DE SERVICIO" ? 'selected' : '' ?>>ESTACIÓN DE SERVICIO</option>
                                            <option <?= $cuenta['data']['categoria'] == "PRODUCTOS AGROPECUARIO" ? 'selected' : '' ?>>PRODUCTOS AGROPECUARIO</option>
                                            <option <?= $cuenta['data']['categoria'] == "RESPUESTOS AGRICOLAS" ? 'selected' : '' ?>>RESPUESTOS AGRICOLAS</option>
                                            <option <?= $cuenta['data']['categoria'] == "RESPUESTOS PRODUCTOS" ? 'selected' : '' ?>>RESPUESTOS PRODUCTOS</option>
                                            <option <?= $cuenta['data']['categoria'] == "RESPUESTOS MOTO" ? 'selected' : '' ?>>RESPUESTOS MOTO</option>
                                            <option <?= $cuenta['data']['categoria'] == "TALLER MECANICO" ? 'selected' : '' ?>>TALLER MECANICO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label><b class="fs-12">Comentarios del solicitante</b></label>
                                <textarea class="form-control" rows="5" name="f5-comentario"><?= !empty($cuenta['data']['comentario_solicitante']) ? $cuenta['data']['comentario_solicitante'] : '' ?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-30">
                                <button id="account-form-4-btn" type="submit" class="btn btn-lg btn-success btn-block ">GUARDAR LOS DATOS</button>
                            </div>
                            <div class="col-md-12 mt-30">
                                <span class="fs-10">* Al hacer click en éste botón acepto que EVER WEAR pueda contactarse con los datos de contactos que he brindado.</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            $archivosData = $archivo->list(["id_cuenta_corriente=$id"], '', '');
            ?>
            <a class="btn btn-primary" data-toggle="collapse" data-target="#stage6" aria-expanded="false" aria-controls="stage6" style="width: 100%;background: #282828 !important;margin-bottom:5px">
                <div class="card-header pb-10 pt-10" id="headingSix" style="border-bottom: unset">
                    <h5 class="mb-0 " style="color: yellow;font-weight:700;margin:0px">
                        DOCUMENTACION Y OTROS DATOS
                    </h5>
                </div>
            </a>
            <div id="stage6" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                <div class="card-body">
                    <div class="row">
                        <?php foreach ($archivosData as $archivos_) { ?>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-15" id="img-<?= $archivos_['data']['id'] ?>">
                                <a target="_blank" href="<?= URL ?>/<?= $archivos_['data']['ruta'] ?>">
                                    <span><?= URL ?>/<?= $archivos_['data']['ruta'] ?></span>
                                </a>
                                <a id="img-btn-<?= $archivos_['data']['id'] ?>" class="btn btn-danger"  onclick="deleteFile('<?= $archivos_['data']['id'] ?>')">
                                    X
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                    <hr>
                    <form method="post" id="account-form-6" data-url="<?= URL ?>" onsubmit="event.preventDefault();fil('<?= $id ?>')">
                        <div class="row">
                            <div class="col-md-4">
                                <label><b class="fs-14">Formulario 1276 API - SANTA FE</b></label>
                                <input type="file" class="form-control" name="files[]" multiple="multiple">
                            </div>
                            <div class="col-md-4">
                                <label><b class="fs-14">Constancia de inscripción en IIBB</b></label>
                                <input type="file" class="form-control" name="files[]" multiple="multiple">
                            </div>
                            <div class="col-md-4">
                                <label><b class="fs-14">CM 05 (último año)</b></label>
                                <input type="file" class="form-control" name="files[]" multiple="multiple">
                            </div>
                            <div class="col-md-4">
                                <label><b class="fs-14">Constancia de exclusión de retención y percepción de impuestos</b></label>
                                <input type="file" class="form-control" name="files[]" multiple="multiple">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-30">
                                <button id="account-form-6-btn" type="submit" class="btn btn-lg btn-success btn-block ">GUARDAR ARCHIVOS</button>
                            </div>
                        </div>
                    </form>
                    <form method="post" id="account-form-7" data-url="<?= URL ?>" onsubmit="event.preventDefault();updateOthers()">
                        <input type="hidden" name="f7-cc" value="<?= $id ?>">
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <label><b class="fs-12">Comentarios de la apertura</b></label>
                                <textarea class="form-control" rows="5" name="f7-comentario"><?= !empty($cuenta['data']['comentario_apertura']) ? $cuenta['data']['comentario_apertura'] : '' ?></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-30">
                                <label><b class="fs-14">NOMBRE DE LA PERSONA DE EVER WEAR QUE LO ATIENDE/VISITA</b></label>
                                <input type="text" class="form-control" name="f5-viajante" value="<?= !empty($cuenta['data']['nombre_viajante']) ? $cuenta['data']['nombre_viajante'] : '' ?>">
                            </div>
                            <div class="col-md-12 mt-30">
                                <button id="account-form-7-btn" type="submit" class="btn btn-lg btn-success btn-block ">GUARDAR LOS DATOS</button>
                            </div>
                            <div class="col-md-12 mt-30">
                                <span class="fs-10">* Al hacer click en éste botón acepto que EVER WEAR pueda contactarse con los datos de contactos que he brindado.</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    function updateGeneral() {
        let btn = $('#account-form-1' + '-btn');
        btn.attr("disabled", true);
        btn.html("");
        btn.addClass("ld-ext-right running");
        btn.append("<div class='ld ld-ring ld-spin'></div>");
        let form = $('#account-form-1');
        let collapse = $('#stage1');
        let url = form.attr("data-url");
        $.ajax({
            url: url + "/api/clients/updateGeneral.php",
            type: "POST",
            data: form.serialize(),
            success: function (data) {
                data = JSON.parse(data);
                btn.html("GUARDAR LOS DATOS ");
                btn.removeClass("ld-ext-right running");
                btn.attr("disabled", false);
                if (data['status']) {
                    successSide(data['message']);
                    collapse.collapse();
                } else {
                    alertSide(data['message']);
                }
            }
        });
    }

    function updateCommercial() {
        let btn = $('#account-form-2' + '-btn');
        btn.attr("disabled", true);
        btn.html("");
        btn.addClass("ld-ext-right running");
        btn.append("<div class='ld ld-ring ld-spin'></div>");
        let form = $('#account-form-2');
        let collapse = $('#stage2');
        let url = form.attr("data-url");
        $.ajax({
            url: url + "/api/clients/updateCommercial.php",
            type: "POST",
            data: form.serialize(),
            success: function (data) {
                data = JSON.parse(data);
                btn.html("GUARDAR LOS DATOS ");
                btn.removeClass("ld-ext-right running");
                btn.attr("disabled", false);
                if (data['status']) {
                    successSide(data['message']);
                    collapse.collapse();
                } else {
                    alertSide(data['message']);
                }
            }
        });
    }

    function updateReference() {
        let btn = $('#account-form-3' + '-btn');
        btn.attr("disabled", true);
        btn.html("");
        btn.addClass("ld-ext-right running");
        btn.append("<div class='ld ld-ring ld-spin'></div>");
        let form = $('#account-form-3');
        let collapse = $('#stage3');
        let url = form.attr("data-url");
        $.ajax({
            url: url + "/api/clients/updateReference.php",
            type: "POST",
            data: form.serialize(),
            success: function (data) {
                data = JSON.parse(data);
                btn.html("GUARDAR LOS DATOS ");
                btn.removeClass("ld-ext-right running");
                btn.attr("disabled", false);
                if (data['status']) {
                    data['messages'].forEach(message => {
                        if (message['status']) {
                            successSide(data['message']);
                        } else {
                            alertSide(data['message']);

                        }
                    });
                } else {
                    alertSide(data['message']);
                }
            }
        });
    }

    function updateFinancial() {
        var btn = $('#account-form-4' + '-btn');
        btn.attr("disabled", true);
        btn.html("");
        btn.addClass("ld-ext-right running");
        btn.append("<div class='ld ld-ring ld-spin'></div>");
        var form = $('#account-form-4');
        var collapse = $('#stage4');
        let url = form.attr("data-url");
        $.ajax({
            url: url + "/api/clients/updateFinancial.php",
            type: "POST",
            data: form.serialize(),
            success: function (data) {
                data = JSON.parse(data);
                btn.html("GUARDAR LOS DATOS ");
                btn.removeClass("ld-ext-right running");
                btn.attr("disabled", false);
                if (data['status']) {
                    successSide(data['message']);
                    collapse.collapse();
                } else {
                    alertSide(data['message']);
                }
            }
        });
    }

    function updateOthers() {
        var btn = $('#account-form-7' + '-btn');
        btn.attr("disabled", true);
        btn.html("");
        btn.addClass("ld-ext-right running");
        btn.append("<div class='ld ld-ring ld-spin'></div>");
        var form = $('#account-form-7');
        var collapse = $('#stage6');
        let url = form.attr("data-url");
        $.ajax({
            url: url + "/api/clients/updateOthers.php",
            type: "POST",
            data: form.serialize(),
            success: function (data) {
                data = JSON.parse(data);
                btn.html("GUARDAR LOS DATOS ");
                btn.removeClass("ld-ext-right running");
                btn.attr("disabled", false);
                if (data['status']) {
                    successSide(data['message']);
                    collapse.collapse();
                } else {
                    alertSide(data['message']);
                }
            }
        });
    }

    function getStates(from, to) {
        let obj = $('#' + from);
        let state = obj.val();
        let url = $('#account-form-1').attr("data-url");
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

    function deleteFile(id) {
        var file = $('#img-' + id);
        var btn = $('#img-btn-' + id);
        btn.attr("disabled", true);
        $.ajax({
            url: "<?=URL?>/api/clients/deleteFile.php",
            type: "POST",
            data: {id: id},
            success: function (data) {
                data = JSON.parse(data);
                if (data['status']) {
                    file.remove();
                    successSide(data['message']);
                } else {
                    alertSide(data['message']);
                }
            }
        });
    }

    function fil(id) {
        var btn = $('#account-form-6' + '-btn');
        btn.attr("disabled", true);
        var fil = $('input[type=file]');
        let formData = new FormData();
        formData.append("id", id);
        for (let i = 0; i < fil.length; i++) {
            for (let j = 0; j < fil[i].files.length; j++) {
                formData.append(fil[i].files[j].name, fil[i].files[j]);
            }
        }
        const API_ENDPOINT = "<?=URL?>/api/clients/uploadFile.php";
        const request = new XMLHttpRequest();

        request.open("POST", API_ENDPOINT, true);
        request.onreadystatechange = () => {
            if (request.readyState === 4 && request.status === 200) {
                response = request.response;

                data = JSON.parse(response);
                if (data['status']) {
                    data['data'].forEach(file => {
                        if (!file['status']) {
                            alertSide(file['message']);
                        } else {
                            successSide(file['message']);
                        }
                        btn.attr("disabled",false);
                    });
                } else {
                    alertSide(data['message']);
                }
            }
        };
        request.send(formData);
    }
</script>