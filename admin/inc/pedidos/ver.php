<?php
//Clases
$pedidos = new Clases\Pedidos();
$funciones = new Clases\PublicFunction();
$usuarios = new Clases\Usuarios();

//$estadoFiltro = $funciones->antihack_mysqli(isset($_GET["estadoFiltro"]) ? $_GET["estadoFiltro"] : '');
$estadoFiltro = $funciones->antihack_mysqli(isset($_GET["estadoFiltro"]) ? $_GET["estadoFiltro"] : '');
$estado = $funciones->antihack_mysqli(isset($_GET["estado"]) ? $_GET["estado"] : '');
$cod = $funciones->antihack_mysqli(isset($_GET["cod"]) ? $_GET["cod"] : '');
$tipo = $funciones->antihack_mysqli(isset($_GET["tipo"]) ? $_GET["tipo"] : '');
$usuario = $funciones->antihack_mysqli(isset($_GET["usuario"]) ? $_GET["usuario"] : '');

if ($estado != '' && $cod != '') {
    $pedidos->set("estado", $estado);
    $pedidos->set("cod", $cod);
    $pedidos->set("tipo", $tipo);
    $pedidos->set("usuario", $usuario);
    $pedidos->changeState();
    $funciones->headerMove(URL_ADMIN . '/?op=pedidos&accion=ver');
}

$filter = '';
if ($estado != '') {
    $filter = array("estado = $estado");
}
if (!empty($estadoFiltro) && $estadoFiltro != '6') {
    $filter = array("estado ='" . $estadoFiltro . "'");
}

if ($usuario != '') {
    $filter = array("usuario ='" . $usuario . "'");
}
$pedidosData = $pedidos->list($filter, '', '');

?>
<div class="mt-20">
    <div class="col-lg-12 col-md-12">
        <h4>
            Pedidos
            <div class='pull-right'>
                <a href="<?= URL_ADMIN ?>/index.php?op=pedidos&accion=agregar" class="btn btn-success">AGREGAR PEDIDOS</a>
            </div>
            <div class='col-md-2 pull-right'>
                <form method="get" action="<?= CANONICAL ?>">
                    <input type="hidden" name="op" value="pedidos" />
                    <input type="hidden" name="accion" value="ver" />
                    <select name="estadoFiltro" onchange="this.form.submit()">
                        <option value="6" <?php if ($estadoFiltro == 6) {
                                                echo "selected";
                                            } ?>>
                            Todos
                        </option>
                        <option value="4" <?php if ($estadoFiltro == 4) {
                                                echo "selected";
                                            } ?>>
                            Rechazado
                        </option>
                        <option value="3" <?php if ($estadoFiltro == 3) {
                                                echo "selected";
                                            } ?>>
                            Enviado
                        </option>
                        <option value="2" <?php if ($estadoFiltro == 2) {
                                                echo "selected";
                                            } ?>>
                            Aprobado
                        </option>
                        <option value="1" <?php if ($estadoFiltro == 1) {
                                                echo "selected";
                                            } ?>>
                            Pendiente
                        </option>
                        <option value="5" <?php if ($estadoFiltro == 5) {
                                                echo "selected";
                                            } ?>>
                            Carrito no cerrado
                        </option>
                    </select>
                </form>
            </div>
        </h4>
        <hr />
        <?php foreach ($pedidosData as $key => $value) {
            $precioTotal = 0;
            $fecha = explode(" ", $value['data']["fecha"]);
            $fecha1 = explode("-", $fecha[0]);
            $fecha1 = $fecha1[2] . '-' . $fecha1[1] . '-' . $fecha1[0] . '-';
            $fecha = $fecha1 . $fecha[1];
        ?>
            <div class="card">
                <a data-toggle="collapse" href="#collapse<?= $value['data']["cod"] ?>" aria-expanded="false" aria-controls="collapse<?= $value['data']["cod"] ?>" class="collapsed text-uppercase ">
                    <div class="card-header bg-info" role="tab" id="heading">
                        <span>Pedido <?= $value['data']["cod"] ?></span>
                        <span class="hidden-xs hidden-sm">- Fecha <?= $fecha ?></span>
                        <?php if ($value['data']["estado"] == 0) { ?>
                            <span class="badge badge-secondary fs-13 text-uppercase  pull-right">
                                Estado: Carrito no cerrado
                            </span>
                        <?php } elseif ($value['data']["estado"] == 1) { ?>
                            <span class="badge badge-warning fs-13 text-uppercase  pull-right">
                                Estado: Pago pendiente
                            </span>
                        <?php } elseif ($value['data']["estado"] == 2) { ?>
                            <span class="badge badge-success fs-13 text-uppercase  pull-right">
                                Estado: Pago aprobado
                            </span>
                        <?php } elseif ($value['data']["estado"] == 3) { ?>
                            <span class="badge badge-info fs-13 text-uppercase  pull-right">
                                Estado: Pedido enviado
                            </span>
                        <?php } elseif ($value['data']["estado"] == 4) { ?>
                            <span class="badge badge-primary fs-13 text-uppercase  pull-right">
                                Estado: Pago rechazado
                            </span>
                        <?php } ?>
                    </div>
                </a>
                <div id="collapse<?= $value['data']["cod"] ?>" class="collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <table class="table table-striped table-hover">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>
                                                Producto
                                            </th>
                                            <th>
                                                Cantidad
                                            </th>
                                            <th class="hidden-xs hidden-sm">
                                                Precio
                                            </th>
                                            <th>
                                                Precio Final
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($value['detail'] as $key2 => $value2) :
                                            $descuento = unserialize($value2["variable2"]);
                                            if (isset($value2['variable5']) && !empty($value2['variable5'])) {
                                                $url = $value2['variable5'];
                                            }
                                        ?>
                                            <?php if ($value2['cod'] == $value['data']["cod"]) : ?>
                                                <tr>
                                                    <td>
                                                        <?= $value2["producto"] ?>
                                                        <?php if (isset($descuento["cod"])) { ?>
                                                            <b class="descuento-monto"><?= $descuento["monto"]; ?></b>
                                                        <?php } ?>
                                                        <br>
                                                        <?php
                                                        if (!empty($value2['variable3'])) {
                                                            echo $value2['variable3'];
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($value2["precio"] > 0) {
                                                            echo $value2["cantidad"];
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($value2["precio"] > 0) {
                                                            echo '$' . $value2["precio"];
                                                            if (isset($descuento["cod"])) {
                                                                echo '<b class="descuento-precio">  ' . $descuento["precio-antiguo"] . '</b>';
                                                            }
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($value2["precio"] > 0 || $value2["precio"] < 0) {
                                                            echo '$' . $value2["precio"] * $value2["cantidad"];
                                                        } elseif ($value2["precio"] == 0) {
                                                            echo 'Sin recargo';
                                                        } ?>
                                                    </td>
                                                    <?php $precioTotal = $precioTotal + ($value2["precio"] * $value2["cantidad"]); ?>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td><b>TOTAL DE LA COMPRA</b></td>
                                            <td></td>
                                            <td></td>
                                            <td><b>$<?= $precioTotal ?></b></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-5">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Usuario</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td>Nombre</td>
                                            <td width="100%"><?= $value['user']['data']['nombre'] . ' ' . $value['user']['data']['apellido'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Direcci??n</td>
                                            <td width="100%"><?= $value['user']['data']['direccion'] . ' - ' . $value['user']['data']['localidad'] . ' - ' . $value['user']['data']['provincia'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tel??fono</td>
                                            <td width="100%"><?= $value['user']['data']['telefono'] ?></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td width="100%"><?= $value['user']['data']['email'] ?></td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <h6><b>FORMA DE PAGO</b></h6>
                        <hr />
                        <div class="alert alert-info" style="border-radius: 10px; padding: 10px;">
                            <?= $value['data']["tipo"] ?>
                        </div>
                        <div class="clearfix"></div>
                        <?php if ($value['data']["detalle"] != '') {
                        ?>
                            <h6><b>OBSERVACIONES</b></h6>
                            <hr />
                            <div class="alert alert-info" style="border-radius: 10px; padding: 10px;">
                                <?php
                                if (!empty($value['data']['detalle'])) {
                                    $detalle = json_decode($value['data']['detalle'], true);
                                    if (!empty($detalle['leyenda'])) {
                                        echo "<b>DESCRIPCI??N DEL PAGO: </b>" . $detalle['leyenda'] . "<br/>";
                                    }
                                    if (!empty($detalle['descuento'])) {
                                        echo "<b>SE UTILIZ?? EL C??DIGO DE DESCUENTO: </b>" . $detalle['descuento'];
                                    }
                                    if (!empty($detalle['link'])) {
                                        echo "<b>URL PARA PAGAR: </b><a href='" . $detalle['link'] . "' target='_blank'>CLICK AQU??</a>";
                                    }
                                ?>
                                    <div class="row mb-15">
                                        <div class="col-md-6">
                                            <hr>
                                            <b>INFORMACI??N DE ENVI??</b>
                                            <br>
                                            <p class='mb-0 fs-13'><b>Tipo: </b><?= $detalle['envio']['tipo'] ?></p>
                                            <p class='mb-0 fs-13'><b>Nombre: </b><?= $detalle['envio']['nombre'] ?></p>
                                            <p class='mb-0 fs-13'><b>Apellido: </b><?= $detalle['envio']['apellido'] ?></p>
                                            <p class='mb-0 fs-13'><b>Email: </b><?= $detalle['envio']['email'] ?></p>
                                            <p class='mb-0 fs-13'><b>Provincia: </b><?= $detalle['envio']['provincia'] ?></p>
                                            <p class='mb-0 fs-13'><b>Localidad: </b><?= $detalle['envio']['localidad'] ?></p>
                                            <p class='mb-0 fs-13'><b>Direcci??n: </b><?= $detalle['envio']['direccion'] ?></p>
                                            <p class='mb-0 fs-13'><b>Tel??fono: </b><?= $detalle['envio']['telefono'] ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <hr>
                                            <b>INFORMACI??N DE FACTURACI??N</b>
                                            <br>
                                            <p class='mb-0 fs-13'><b>Nombre: </b><?= $detalle['pago']['nombre'] ?></p>
                                            <p class='mb-0 fs-13'><b>Apellido: </b><?= $detalle['pago']['apellido'] ?></p>
                                            <p class='mb-0 fs-13'><b>Email: </b><?= $detalle['pago']['email'] ?></p>
                                            <p class='mb-0 fs-13'><b>DNI/CUIT: </b><?= $detalle['pago']['dni'] ?></p>
                                            <p class='mb-0 fs-13'><b>Provincia: </b><?= $detalle['pago']['provincia'] ?></p>
                                            <p class='mb-0 fs-13'><b>Localidad: </b><?= $detalle['pago']['localidad'] ?></p>
                                            <p class='mb-0 fs-13'><b>Direcci??n: </b><?= $detalle['pago']['direccion'] ?></p>
                                            <p class='mb-0 fs-13'><b>Tel??fono: </b><?= $detalle['pago']['telefono'] ?></p>
                                            <?php
                                            if ($detalle['pago']['factura']) {
                                                echo "<p class='mb-0 fs-13'><b>Factura A al CUIT: </b>" . $detalle['pago']['dni'] . "</p>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        <?php
                        }
                        if (isset($url)) {
                        ?>
                            <hr />
                            <?php
                            if (!empty($value['user']['data']['celular'])) {
                            ?>
                                <a href="https://wa.me/<?= $value['user']['data']['celular'] ?>?text=<?= $url ?>" target="_blank" class="btn" style="background-color: lawngreen;">
                                    <i class="fa fa-phone"></i> Compartir por whatsapp
                                </a>
                            <?php
                            } else {
                            ?>
                                <button class="btn" style="background-color: lawngreen;" title="El usuario no posee numero de celular" disabled>
                                    <i class="fa fa-phone"></i> Compartir por whatsapp
                                </button>
                        <?php
                            }
                        }
                        ?>
                        <a class="btn btn-primary modal-page-ajax" data-title="Enviar email">
                            <i class="fa fa-envelope"></i> Compartir por mail
                        </a>
                        <hr />
                        <b>CAMBIAR ESTADO: </b>
                        <a href="<?= CANONICAL ?>&estado=1&cod=<?= $value['data']['cod'] ?>" class="btn btn-warning">Pendiente</a>
                        <a href="<?= CANONICAL ?>&estado=2&cod=<?= $value['data']['cod'] ?>" class="btn btn-success">Aprobado</a>
                        <a href="<?= CANONICAL ?>&estado=3&cod=<?= $value['data']['cod'] ?>" class="btn btn-info">Enviado</a>
                        <a href="<?= CANONICAL ?>&estado=4&cod=<?= $value['data']['cod'] ?>" class="btn btn-primary">Rechazado</a>
                        <a href="<?= CANONICAL ?>&borrar=<?= $value['data']['cod'] ?>" class="btn btn-danger pull-right">ELIMINAR PEDIDO</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div id="modalS" class="modal fade mt-120" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div id="textS" class="text-center">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function sendBuy(cod) {
        $.ajax({
            url: "<?= URLSITE ?>/curl/email/sendBuy.php",
            type: "POST",
            data: {
                cod: cod
            },
            beforeSend: function() {
                $('#textS').html('');
                $('#textS').append("<span class='fa fa-spinner fa-spin fa-3x'></span><br>");
                $('#textS').append("<div class='text-uppercase text-center'>");
                $('#textS').append("<p class='fs-18 mt-10'>EXCELENTE, ESTAMOS ENVIANDO UN EMAIL CON TODA LA INFORMACI??N DElPEDIDO.</p>");
                $('#textS').append("</div>");
                $('#modalS').modal('toggle');
            },
            success: function(data) {
                alert(data);
                $('#textS').html('');
                $('#textS').append("<i class='fa fa-check-circle fs-80' style='color:green'></i><br>");
                $('#textS').append("<div class='text-uppercase text-center'>");
                $('#textS').append("<p class='fs-18 mt-10'>EMAIL ENVIADO EXITOSAMENTE.</p>");
                $('#textS').append("</div>");
                if ($('#modalS').hasClass('show')) {

                } else {
                    $('#modalS').modal('toggle');
                }
            },
            error: function() {
                alert('Error occured');
            }
        });
    }
</script>
<?php
if (!empty($_GET["borrar"])) {
    $pedidos->set("cod", $funciones->antihack_mysqli(isset($_GET["borrar"]) ? $_GET["borrar"] : ''));
    $pedidos->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=pedidos");
}
?>