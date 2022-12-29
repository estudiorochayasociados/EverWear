<?php
$producto = new Clases\Productos();
$funciones = new Clases\PublicFunction();
$pagina = $funciones->antihack_mysqli(isset($_GET["pagina"]) ? $_GET["pagina"] : '0');
$filter = array();

if ($pagina > 0) {
    $pagina = $pagina - 1;
}

if (@count($filter) == 0) {
    $filter = '';
}

if (@count($_GET) == 0) {
    $anidador = "?";
} else {
    if ($pagina >= 0) {
        $anidador = "&";
    } else {
        $anidador = "?";
    }
}

$productos = $producto->list("", "", (100 * $pagina) . ',' . 100);
$productoPaginador = $producto->paginador("", 100);
?>
    <div class="mt-20">
        <div class="col-lg-12 col-md-12">
            <h4>Productos <a class="btn btn-success pull-right" href="<?= URLADMIN ?>/index.php?op=productos&accion=agregar">AGREGAR PRODUCTOS</a></h4>
            <hr/>
            <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
            <hr/>
            <table class="table  table-bordered  ">
                <thead>
                <th>Título</th>
                <th>Precio</th>
                <th>Precio Descuento</th>
                <th>Precio Mayorista</th>
                <th>Stock</th>
                <th>Peso (kg)</th>
                <th>Ajustes</th>
                </thead>
                <tbody>
                <?php
                if (is_array($productos)) {
                    foreach ($productos as $producto_) {
                        $cod = $producto_["data"]["cod"];
                        $txtCod = '';
                        $txtCod .= !empty($producto_["data"]["cod_producto"]) ? "<br/><b>COD:</b> " . $producto_["data"]["cod_producto"] : "";
                        $txtCod .= !empty($producto_["data"]["meli"]) ? "<br/><b>MERCADOLIBRE:</b> " . $producto_["data"]["meli"] : "";
                        ?>
                        <tr>
                            <td>
                                <input class="borderInputBottom" style='width:auto' onchange='editProduct("titulo-<?= $cod ?>","<?= URLADMIN ?>")' id='titulo-<?= $cod ?>' name='titulo' value='<?= $producto_["data"]["titulo"] ?>'/>
                                <?= "<span style='font-size:11px'>" . $txtCod . "</span>" ?>
                            </td>
                            <td width="200">$ <input class="borderInputBottom" style='width:auto' onchange='editProduct("precio-<?= $cod ?>","<?= URLADMIN ?>")' id='precio-<?= $cod ?>' name='precio' value='<?= $producto_["data"]["precio"] ?>'/></td>
                            <td width="200">$ <input class="borderInputBottom" style='width:auto' onchange='editProduct("precio_descuento-<?= $cod ?>","<?= URLADMIN ?>")' id='precio_descuento-<?= $cod ?>' name='precio_descuento' value='<?= $producto_["data"]["precio_descuento"] ?>'/></td>
                            <td width="200">$ <input class="borderInputBottom" style='width:auto' onchange='editProduct("precio_mayorista-<?= $cod ?>","<?= URLADMIN ?>")' id='precio_mayorista-<?= $cod ?>' name='precio_mayorista' value='<?= $producto_["data"]["precio_mayorista"] ?>'/></td>
                            <td width="200"><input class="borderInputBottom" style='width:auto' onchange='editProduct("stock-<?= $cod ?>","<?= URLADMIN ?>")' id='stock-<?= $cod ?>' name='stock' value='<?= $producto_["data"]["stock"] ?>'/></td>
                            <td width="200"><input class="borderInputBottom" style='width:auto' onchange='editProduct("peso-<?= $cod ?>","<?= URLADMIN ?>")' id='peso-<?= $cod ?>' name='peso' value='<?= $producto_["data"]["peso"] ?>'/>kg</td>
                            <td>
                                <a class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Modificar" href="<?= URLADMIN ?>/index.php?op=productos&accion=modificar&cod=<?= $producto_["data"]["cod"] ?>">
                                    <i class="fa fa-cog"></i>
                                </a>
                                <a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar" href="<?= URLADMIN ?>/index.php?op=productos&accion=ver&borrar=<?= $producto_["data"]["cod"] ?>">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
            <nav aria-label="Page navigation">
                <ul class="pagination ">
                    <?php
                    if ($productoPaginador != 1 && $productoPaginador != 0) {
                        $url_final = $funciones->eliminar_get(CANONICAL, "pagina");
                        $links = '';
                        $links .= "<li class='page-item' ><a class='page-link' href='" . $url_final . $anidador . "pagina=1'>1</a></li>";
                        $i = max(2, $pagina - 5);

                        if ($i > 2) {
                            $links .= "<li class='page-item' ><a class='page-link' href='#'>...</a></li>";
                        }
                        for (; $i <= min($pagina + 35, $productoPaginador); $i++) {
                            $links .= "<li class='page-item' ><a class='page-link' href='" . $url_final . $anidador . "pagina=" . $i . "'>" . $i . "</a></li>";
                        }
                        if ($i - 1 != $productoPaginador) {
                            $links .= "<li class='page-item' ><a class='page-link' href='#'>...</a></li>";
                            $links .= "<li class='page-item' ><a class='page-link' href='" . $url_final . $anidador . "pagina=" . $productoPaginador . "'>" . $productoPaginador . "</a></li>";
                        }
                        echo $links;
                        echo "";
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>
<?php
if (isset($_GET["borrar"])) {
    $cod = $funciones->antihack_mysqli(isset($_GET["borrar"]) ? $_GET["borrar"] : '');
    $producto->set("cod", $cod);
    $productos = $producto->view();
    if (!empty($productos['data']['meli'])) {
        $producto->meli = $productos['data']['meli'];
        $producto->deleteMeli();
    }
    $producto->delete();
    $funciones->headerMove(URLADMIN . "/index.php?op=productos");
}
?>