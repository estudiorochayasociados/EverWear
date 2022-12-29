<?php
$producto = new Clases\Productos();
$funciones = new Clases\PublicFunction();
$pagina = isset($_GET["pagina"]) ? $funciones->antihack_mysqli($_GET["pagina"]) : '0';
$filter = [];
isset($_GET["busqueda"]) ? $filter[] = 'titulo like "%' . $funciones->antihack_mysqli($_GET["busqueda"]) . '%"' : '';

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
$productos = $producto->list($filter, "", (100 * $pagina) . ',' . 100, true);
$productoPaginador = $producto->paginador("", 100);
?>
<div class="mt-20">
    <div class="col-lg-12 col-md-12">
        <h4>Productos <a class="btn btn-success pull-right" href="<?= URL_ADMIN ?>/index.php?op=productos&accion=agregar">AGREGAR PRODUCTOS</a></h4>
        <hr />
        <form method="get">
            <input name="op" value="productos" type="hidden" />
            <input name="accion" value="ver" type="hidden" />
            <input name="pagina" value="<?= $pagina ?>" type="hidden" />
            <input class="form-control" name="busqueda" type="text" placeholder="Buscar.." />
        </form>
        <hr />
        <table class="table  table-bordered  ">
            <thead>
                <th>Cod</th>
                <th>Título</th>
                <th>Mercadolibre</th>
                <th>Ajustes</th>
            </thead>
            <tbody>
                <?php
                if (is_array($productos)) {
                    foreach ($productos as $producto_) {
                        echo "<tr>";
                        echo "<td>" . strtoupper($producto_["data"]["cod_producto"]) . "</td>";
                        echo "<td>" . strtoupper($producto_["data"]["titulo"]) . "</td>";
                        echo "<td>" . strtoupper($producto_["data"]["meli"]) . "</td>";
                        echo "<td>";
                        echo '<a class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Modificar" href="' . URL_ADMIN . '/index.php?op=productos&accion=modificar&cod=' . $producto_["data"]["cod"] . '">
                    <i class="fa fa-cog"></i></a>';

                        echo '<a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar" href="' . URL_ADMIN . '/index.php?op=productos&accion=ver&borrar=' . $producto_["data"]["cod"] . '">
                    <i class="fa fa-trash"></i></a>';
                        echo "</td>";
                        echo "</tr>";
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
    $funciones->headerMove(URL_ADMIN . "/index.php?op=productos");
}
?>