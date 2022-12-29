<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();

$title = $funciones->antihack_mysqli(isset($_POST['title']) ? $_POST['title'] : '');
$user = $funciones->antihack_mysqli(isset($_GET['user']) ? $_GET['user'] : '');
$order = $funciones->antihack_mysqli(isset($_GET['order']) ? $_GET['order'] : '');
$start = $funciones->antihack_mysqli(isset($_GET['start']) ? $_GET['start'] : '0');
$limit = $funciones->antihack_mysqli(isset($_GET['limit']) ? $_GET['limit'] : '24');

$filter = [];

if (!empty($title)) {
    $filter[] = "titulo LIKE '%$title%'";
}

$productosData = $producto->list($filter, $order, $start . "," . $limit);

if (!empty($productosData)) {
    foreach ($productosData as $producto) {
        ?>
        <div class='col-md-4 mb-20 text-center'>
            <h4 class='bold'>
                <a href='<?= $producto['link'] ?>'><?= $producto['data']['titulo'] ?></a>
                <hr/>
            </h4>
            <a href='<?= $producto['link'] ?>'>
                <img src="<?= URL . "/" . $producto['images'][0]['ruta'] ?>" style="width:100%;height:250px;object-fit: contain; "/>
            </a>
            <span class="fs-12">
                <?= !empty($producto['data']['variable1']) ? "<b>VEHICULO: </b>" . $producto['data']['variable1'] . " / " : ''; ?>
                <?= !empty($producto['data']['variable2']) ? "<b>MARCA: </b>" . $producto['data']['variable2'] . " / " : ''; ?>
                <?= !empty($producto['data']['variable3']) ? "<b>MODELO: </b>" . $producto['data']['variable3'] . " / " : ''; ?>
                <?= !empty($producto['data']["categoria"]['titulo']) ? "<b>CATEGORIA: </b>" . $producto['data']["categoria"]['titulo'] . " / " : ''; ?>
                </span>
            <div class='price-addtocart'>
                <div class='product-price'>
                    <div class='fs-17 pt-10'>
                        $<?= !empty($producto["data"]["precio_descuento"]) ? $producto["data"]["precio_descuento"] . " <span class='tachado'>$" . $producto["data"]["precio"] . "</span>" : $producto["data"]["precio"]; ?>
                    </div>
                </div>
            </div>
            <span class='fs-10 mt-10 text-uppercase'> <a class='fs-14 btn btn-primary mt-10' href='<?= $producto['link'] ?>'>ver +</a></span>
        </div>
        <?php
    }
}