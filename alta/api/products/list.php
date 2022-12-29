<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();
$producto = new Clases\Productos();
$categoria = new Clases\Categorias();
$subcategoria = new Clases\Subcategorias();
$csrf = new Clases\Token();


/*if (!$csrf::verifyToken('products',true)) {
    echo json_encode(["status" => false, "message" => "Ocurrió un error, recargar la página."]);
    die();
} else {*/
    if (empty($_POST["title"])) {
        unset($_POST["title"]);
    }

    $title = $funciones->antihack_mysqli(isset($_POST['title']) ? $_POST['title'] : '');
    $order = $funciones->antihack_mysqli(isset($_GET['order']) ? $_GET['order'] : '');
    $start = $funciones->antihack_mysqli(isset($_GET['start']) ? $_GET['start'] : '0');
    $limit = $funciones->antihack_mysqli(isset($_GET['limit']) ? $_GET['limit'] : '24');


    if (count($_POST) < 2) {
        $filter = '';
    } else {
        $filter = [];
    }

    if (!empty($title)) {
        $filter[] = "titulo LIKE '%$title%'";
    }

//VARIABLE DE VEHICULOS
    if (!empty($_POST['variable1'])) {
        $variable1Filter = '';
        foreach ($_POST['variable1'] as $key => $variable1) {
            $variable1 = $funciones->antihack_mysqli($variable1);
            $key == count($_POST['variable1']) - 1 ? $or = '' : $or = ' || ';
            $variable1Filter .= !empty($variable1) ? "variable1='" . $variable1 . "'" . $or : '';
        }
        $filter[] = $variable1Filter;
    }
//FIN VARIABLE DE VEHICULOS

//VARIABLE DE MARCAS
    if (!empty($_POST['variable2'])) {
        $variable2Filter = '';
        foreach ($_POST['variable2'] as $key => $variable2) {
            $variable2 = $funciones->antihack_mysqli($variable2);
            $key == count($_POST['variable2']) - 1 ? $or = '' : $or = ' || ';
            $variable2Filter .= !empty($variable2) ? "variable2='" . $variable2 . "'" . $or : '';
        }
        $filter[] = $variable2Filter;
    }
//FIN VARIABLE DE MARCAS


//VARIABLE DE MODELO
    if (!empty($_POST['variable3'])) {
        $variable3Filter = '';
        foreach ($_POST['variable3'] as $key => $variable3) {
            $variable3 = $funciones->antihack_mysqli($variable3);
            $key == count($_POST['variable3']) - 1 ? $or = '' : $or = ' || ';
            $variable3Filter .= !empty($variable3) ? "variable3='" . $variable3 . "'" . $or : '';
        }
        $filter[] = $variable3Filter;
    }
// FIN VARIABLE DE MODELO

    if (!empty($_POST['categories'])) {
        $categoryFilter = '';
        foreach ($_POST['categories'] as $key => $cat) {
            $cat_ = $funciones->antihack_mysqli($cat);
            $cat_ = $categoria->viewById($cat_)['data']['cod'];
            $key == count($_POST['categories']) - 1 ? $or = '' : $or = ' || ';
            $categoryFilter .= !empty($cat_) ? "categoria='" . $cat_ . "'" . $or : '';
            //$categoryFilter .= !empty($cat_) ? "variable1='" . $cat_ . "'" . $or : '';
        }
        $filter[] = $categoryFilter;
    }

    if (!empty($_POST['subcategories'])) {
        $subcategoryFilter = '';
        foreach ($_POST['subcategories'] as $key => $cat) {
            $subcat_ = $funciones->antihack_mysqli($cat);
            $subcat_ = $subcategoria->viewById($subcat_)['data']['cod'];

            $key == count($_POST['subcategories']) - 1 ? $or = '' : $or = ' || ';
            //echo $key;
            $subcategoryFilter .= !empty($subcat_) ? "subcategoria='" . $subcat_ . "'" . $or : '';
            //$subcategoryFilter .= !empty($cat_) ? "variable1='" . $cat_ . "'" . $or : '';
        }
        $filter[] = $subcategoryFilter;
    }


    switch ($order) {
        default:
            $order = "id DESC";
            break;
        case "2":
            $order = "precio ASC";
            break;
        case "3":
            $order = "precio DESC";
            break;
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
/*}*/