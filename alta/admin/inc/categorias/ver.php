<?php
$categorias = new Clases\Categorias();
$subcategorias = new Clases\Subcategorias();
$data = $categorias->list('', '', '');
?>
    <div class="mt-20">
        <div class="col-lg-12 col-md-12">
            <h4>
                Categorias
                <a class="btn btn-success pull-right" href="<?= URLADMIN ?>/index.php?op=categorias&accion=agregar">
                    AGREGAR CATEGORIAS
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
                if (is_array($data)) {
                    foreach ($data as $val) {
                        echo "<tr>";
                        echo "<td>";
                        echo strtoupper($val['data']["titulo"]);
                        if (!empty($val['subcategories'])) {
                            echo "<hr/>";
                            foreach ($val['subcategories'] as $sub) {
                                echo "<div class='mb-20'>";
                                echo $sub['data']["titulo"];
                                echo "<a href='" . URL . "/index.php?op=categorias&accion=ver&borrarSubcategorias=" . $sub['data']["cod"] . "' class='btn btn-danger btn-sm  pull-right'><i class='fa fa-trash'></i></a>";
                                echo "<a href='" . URL . "/index.php?op=subcategorias&accion=modificar&cod=" . $sub['data']["cod"] . "' class='btn btn-info btn-sm pull-right'><i class='fa fa-edit'></i></a>";
                                echo "</div>";
                            }
                        }
                        echo "</td>";
                        echo "<td>" . strtoupper($val['data']["area"]) . "</td>";
                        echo "<td>";
                        /*echo '<a class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Agregar" href="' . URLADMIN . '/index.php?op=subcategorias&accion=agregar&cod=' . $val['data']["cod"] . '">
                        <i class="fa fa-plus"></i> SUBCATEGORÍA</a>';*/
                        echo '<a class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Modificar" href="' . URLADMIN . '/index.php?op=categorias&accion=modificar&cod=' . $val['data']["cod"] . '"><i class="fa fa-cog"></i></a>';

                        echo '<a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar" href="' . URLADMIN . '/index.php?op=categorias&accion=ver&borrar=' . $val['data']["cod"] . '">
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
    $categorias->set("cod", $cod);
    $categorias->delete();
    $funciones->headerMove(URLADMIN . "/index.php?op=categorias");
}

if (isset($_GET["borrarSubcategorias"])) {
    $cod = $funciones->antihack_mysqli(isset($_GET["borrarSubcategorias"]) ? $_GET["borrarSubcategorias"] : '');
    $subcategorias->set("cod", $cod);
    $subcategorias->delete();
    $funciones->headerMove(URLADMIN . "/index.php?op=categorias");
}
?>