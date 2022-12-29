<?php
$categorias = new Clases\Categorias();
$subcategorias = new Clases\Subcategorias();
$tercercategorias = new Clases\TercerCategorias();
$data = $categorias->list('', 'area DESC', '');
?>
<div class="mt-20">
    <div class="col-lg-12 col-md-12">
        <h4>
            Categorias
            <div class="pull-right">
                <a class="btn btn-success ml-10 " href="<?= URL_ADMIN ?>/index.php?op=categorias&accion=agregar">
                    + CATEGORIAS
                </a>
                <a class="btn btn-success ml-10" href="<?= URL_ADMIN ?>/index.php?op=subcategorias&accion=agregar">
                    + SUBCATEGORIAS
                </a>
                <a class="btn btn-success ml-10" href="<?= URL_ADMIN ?>/index.php?op=tercercategorias&accion=agregar">
                    + TERCER CATEGORIAS
                </a>
            </div>
        </h4>
        <hr />
        <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
        <hr />
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
                ?>
                        <tr>
                            <td>
                                <input class="mr-7 text-center" min="0" type="number" onchange="edit('<?= URL_ADMIN ?>','categorias','orden','<?= $val['data']['cod'] ?>')" id="<?= $val['data']["cod"] ?>" value="<?= $val['data']["orden"] ?>" style="width:30px;padding:0;height:auto;float:left" />
                                <?= strtoupper($val['data']["titulo"]) ?>
                                <?php
                                if (!empty($val['subcategories'])) {
                                ?>

                                    <button onclick="$('#subcat-<?= $val['data']['cod'] ?>').toggle()" class="pull-right btn btn-success btn-sm"><i class="fa fa-chevron-down"></i></button>
                                    <hr />
                                    <div class="ml-20 hidden" id="subcat-<?= $val['data']['cod'] ?>">
                                        <?php
                                        foreach ($subcategorias->list(["categoria = '" . $val['data']['cod'] . "'"], "orden ASC", "") as $sub) {
                                            $tercerCategoria = $tercercategorias->list(["subcategoria = '" . $sub['data']['cod'] . "'"], "orden ASC", "");
                                        ?>
                                            <div class='mb-20'>
                                                <input min="0" class="mr-7 text-center" type="number" onchange="edit('<?= URL_ADMIN ?>','subcategorias','orden','<?= $sub['data']['cod'] ?>')" id="<?= $sub['data']["cod"] ?>" value="<?= $sub['data']["orden"] ?>" style="width:30px;padding:0;height:auto;float:left" />
                                                <?= $sub['data']["titulo"] ?>
                                                <a href='<?= URL_ADMIN ?>/index.php?op=categorias&accion=ver&borrarSubcategorias=<?= $sub['data']["cod"] ?>' class='btn btn-danger btn-sm  pull-right'><i class='fa fa-trash'></i></a>
                                                <a href='<?= URL_ADMIN ?>/index.php?op=subcategorias&accion=modificar&cod=<?= $sub['data']["cod"] ?>' class='btn btn-info btn-sm pull-right'><i class='fa fa-edit'></i></a>
                                                <button onclick="$('#tercercat-<?= $sub['data']['cod'] ?>').toggle()" class="pull-right btn btn-success btn-sm <?= ($tercerCategoria) ? '' : 'hidden' ?>"><i class="fa fa-chevron-down"></i></button>
                                                <div class="ml-20 hidden" id="tercercat-<?= $sub['data']['cod'] ?>">
                                                    <?php
                                                    foreach ($tercerCategoria as $ter) {
                                                    ?>
                                                        <hr />
                                                        <div class='mb-20'>
                                                            <input min="0" class="mr-7 text-center" type="number" onchange="edit('<?= URL_ADMIN ?>','tercercategorias','orden','<?= $ter['data']['cod'] ?>')" id="<?= $ter['data']["cod"] ?>" value="<?= $ter['data']["orden"] ?>" style="width:30px;padding:0;height:auto;float:left" />
                                                            <?= $ter['data']["titulo"] ?>
                                                            <a href='<?= URL_ADMIN ?>/index.php?op=categorias&accion=ver&borrarTercercategorias=<?= $ter['data']["cod"] ?>' class='btn btn-danger btn-sm  pull-right'><i class='fa fa-trash'></i></a>
                                                            <a href='<?= URL_ADMIN ?>/index.php?op=tercercategorias&accion=modificar&cod=<?= $ter['data']["cod"] ?>' class='btn btn-info btn-sm pull-right'><i class='fa fa-edit'></i></a>
                                                        </div>
                                                    <?php
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
                                ?>
                            </td>
                            <td><?= strtoupper($val['data']["area"]) ?></td>
                            <td>
                                <a class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Modificar" href="<?= URL_ADMIN ?>/index.php?op=categorias&accion=modificar&cod=<?= $val['data']["cod"] ?>"><i class="fa fa-cog"></i></a>
                                <a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Eliminar" href="<?= URL_ADMIN ?>/index.php?op=categorias&accion=ver&borrar=<?= $val['data']["cod"] ?>"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                <?php
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
    $funciones->headerMove(URL_ADMIN . "/index.php?op=categorias");
}

if (isset($_GET["borrarSubcategorias"])) {
    $cod = $funciones->antihack_mysqli(isset($_GET["borrarSubcategorias"]) ? $_GET["borrarSubcategorias"] : '');
    $subcategorias->set("cod", $cod);
    $subcategorias->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=categorias");
}
if (isset($_GET["borrarTercercategorias"])) {
    $cod = $funciones->antihack_mysqli(isset($_GET["borrarTercercategorias"]) ? $_GET["borrarTercercategorias"] : '');
    $tercercategorias->set("cod", $cod);
    $tercercategorias->delete();
    $funciones->headerMove(URL_ADMIN . "/index.php?op=categorias");
}
?>