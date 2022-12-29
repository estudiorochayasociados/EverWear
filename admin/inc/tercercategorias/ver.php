<?php
$categorias = new Clases\Categorias();
$subCategorias = new Clases\Subcategorias();
$filter    = array();
$data = $categorias->list("");
$data2 = $subCategorias->list("");
?>
    <div class="mt-20">
        <div class="col-lg-12 col-md-12">
            <h4>
                Sub Categorias
                <a class="btn btn-success pull-right" href="<?=URL?>/index.php?op=subcategorias&accion=agregar">
                    AGREGAR SUB CATEGORIAS
                </a>
            </h4>
            <hr/>
            <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
            <hr/>
            <table class="table  table-bordered  ">
                <thead>
                <th>
                    Título
                </th>
                <th>
                    Área
                </th>
                <th>
                    Ajustes
                </th>
                </thead>
                <tbody>
                <?php
                if (is_array($data2)) {
                    for ($i = 0; $i < count($data2); $i++) {
                        echo "<tr>";
                        echo "<td>" . strtoupper($data2[$i]["titulo"]) . "</td>";
                        echo "<td>" . strtoupper($data2[$i]["area"]) . "</td>";
                        echo "<td>";
                        echo '<a class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Agregar" href="' . URL . '/index.php?op=tercercategorias&accion=agregar&cod=' . $data2[$i]["cod"] . '">
                        <i class="fa fa-plus"></i> TERCER CATEGORÍA</a>';
                        echo '<a class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Modificar" href="' . URL . '/index.php?op=subcategorias&accion=modificar&cod=' . $data2[$i]["cod"] . '"><i class="fa fa-cog"></i></a>';

                        echo '<a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar" href="' . URL . '/index.php?op=subcategorias&accion=ver&borrar=' . $data2[$i]["cod"] . '">
                        <i class="fa fa-trash"></i></a>';
                        echo "</td>";
                        echo "</tr>";
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
if (isset($_GET["borrar"])) {
    $cod = $funciones->antihack_mysqli(isset($_GET["borrar"]) ? $_GET["borrar"] : '');
    $subCategorias->set("cod", $cod);
    $imagenes->set("cod", $cod);
    $subCategorias->delete();
    $imagenes->deleteAll();
    $funciones->headerMove(URL . "/index.php?op=subcategorias");
}
?>