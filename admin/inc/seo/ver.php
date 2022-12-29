<?php
$seo = new Clases\Seo();
$urls = $seo->list('', '', '');
?>
    <div class="mt-20">
        <div class="col-lg-12 col-md-12">
            <h4>
                SEO
                <a class="btn btn-success pull-right" href="<?= URL_ADMIN ?>/index.php?op=seo&accion=agregar">
                    AGREGAR URL
                </a>
            </h4>
            <hr/>
            <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
            <hr/>
            <table class="table  table-bordered  ">
                <thead>
                <th>
                    URL
                </th>
                <th>
                    Ajustes
                </th>
                </thead>
                <tbody>
                <?php
                if (is_array($urls)) {
                    foreach ($urls as $url) {
                        echo "<tr>";
                        echo "<td>" . strtoupper($url['data']["url"]) . "</td>";
                        echo "<td>";
                        echo '<a class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Modificar" href="' . URL_ADMIN . '/index.php?op=seo&accion=modificar&cod=' . $url['data']["cod"] . '">
                        <i class="fa fa-cog"></i></a>';

                        if (in_array(1, $_SESSION["admin"]["rol"])) {
                            echo '<a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar" href="' . URL_ADMIN . '/index.php?op=seo&accion=ver&borrar=' . $url['data']["cod"] . '">
                        <i class="fa fa-trash"></i></a>';
                        }
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
    $cod = isset($_GET["borrar"]) ? $funciones->antihack_mysqli($_GET["borrar"]) : '';
    $seo->set("cod", $cod);
    $seo->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=seo");
}
?>