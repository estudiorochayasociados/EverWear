<?php
$cuentaCorriente = new Clases\CuentasCorrientes();


if (empty($_SESSION["usuarios"]) || $_SESSION['usuarios']['invitado'] == 1) {
    $usuario->logout();
    $funciones->headerMove(URL);
}

$cuentas = $cuentaCorriente->list(["usuario='" . $_SESSION['usuarios']['cod'] . "'"], '', '');
?>
<div class="col-md-12 mt-20">
    <h2>LISTADO DE CLIENTES</h2>
    <hr/>
</div>
<div class="col-md-12">
    <label><b class="fs-11">Buscar:</b></label>
    <input class="form-control" type="text">
</div>
<div class="col-md-12 mt-15">
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th class="text-left hidden-xs hidden-sm" scope="col">RAZON</th>
            <th class="text-left hidden-md hidden-lg hidden-xl" scope="col">DATOS</th>
            <th class="text-left hidden-xs hidden-sm" scope="col">RESPONSABLE</th>
            <th class="text-left hidden-xs hidden-sm" scope="col">EMAIL</th>
            <th class="text-left hidden-xs hidden-sm" scope="col">TELÉFONO</th>
            <th class="text-left" scope="col"></th>
        </tr>
        </thead>
        <tbody id="table-clients">
        <?php foreach ($cuentas as $cuentas_) { ?>
            <tr>
                <th class="text-left" scope="row">
                    <?=$cuentas_['data']['razon_social']?>
                    <div class="hidden-md hidden-lg hidden-xl">
                        <?=$cuentas_['data']['email']?><br>
                        <?=$cuentas_['data']['telefono']?>
                    </div>
                </th>
                <td class="text-left hidden-xs hidden-sm">
                    <?=$cuentas_['data']['responsable']?>
                </td>
                <td class="text-left hidden-xs hidden-sm">
                    <?=$cuentas_['data']['email']?>
                </td>
                <td class="text-left hidden-xs hidden-sm">
                    <?=$cuentas_['data']['telefono']?>
                </td>
                <td class="text-left">
                    <a class="btn btn-info"
                       data-toggle="tooltip"
                       data-placement="top"
                       title="Modificar"
                       href="<?= URL ?>/sesion/modificar/<?= $cuentas_['data']["id"] ?>">
                        <i class="fa fa-cog"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<script>
    var start = 0;
    var limit = 24;
    var order = '';
    const url = '<?=URL?>';

    $(document).ready(() => {
        getClientsData();
    });

    function orderClientsBy(value) {
        order = value;
        getClientsData();
    }

    function loadMoreClients() {
        disableLoadMoreClients();
        start += limit;
        getClientsData('add');
    }

    function disableLoadMoreClients() {
        $('#grid-products-btn').hide();
    }

    function enableLoadMoreClients() {
        $('#grid-products-btn').show();
    }

    function getClientsData(type) {
        let list = type != 'add' ? true : false;

        if (url) {
            if (list) {
                loaderClients();
                start = 0;
                enableLoadMoreClients();
            }
            $.ajax({
                url: url + "/api/products/list.php?start=" + start + "&limit=" + limit + "&order=" + order+"&user=<?=$_SESSION['usuarios']['cod']?>",
                type: "POST",
                data: $('#filter-form').serialize(),
                success: (data) => {
                    console.log(data);
                    list ? reset() : enableLoadMoreClients();
                    if (!data.length) disableLoadMoreClients();
                    $('#grid-products').append(data);
                }
            });
        }
    }

    function appendClients(data) {
        if (Array.isArray(data)) {
            if (data.length < limit) {
                disableLoadMoreClients();
            }

        } else {
            /*notFound();*/
        }
    }

    function loaderClients() {
        reset();
        $('#grid-products').append("" +
            "<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>" +
            "    <div class='product-wrap mb-10 mt-100 mb-400'>" +
            "        <div class='product-content text-center'>" +
            "            <i class='fa fa-circle-o-notch fa-spin fa-3x fs-70'></i>" +
            "        </div>" +
            "    </div>" +
            "</div>"
        );
    }

    function notFound() {
        reset();
        $('#grid-products').append("" +
            "<div class='col-xl-12 col-lg-12 col-md-12 col-sm-12'>" +
            "    <div class='product-wrap mb-35'>" +
            "        <div class='product-content text-center'>" +
            "            <i class='fa fa-times-circle fs-100' style='color: red'></i>" +
            "            <h4>No se encontró ningun producto con esas características.</h4>" +
            "        </div>" +
            "    </div>" +
            "</div>"
        );
        disableLoadMoreClients();
    }

    function reset() {
        $('#grid-products').html('');
    }
</script>