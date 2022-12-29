<?php
$productos = new Clases\Productos();
$imagenes = new Clases\Imagenes();
$conexion = new Clases\Conexion();
$categoria = new Clases\Categorias();
$subcategoria = new Clases\Subcategorias();
$categoriaData = $categoria->list(["area='productos'"], '', '');
$con = $conexion->con();
include "../vendor/phpoffice/phpexcel/Classes/PHPExcel.php";
require "../vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php";
?>
<div class="col-md-12">
    <form action="index.php?op=productos&accion=importar" method="post" enctype="multipart/form-data">
        <h3>Importar productos de Excel a la Web <a href="<?= URLSITE ?>/assets/ejemplo.xlsx">(Descargar ejemplo)</a>
        </h3>
        <hr/>
        <div class="row">
            <div class="col-md-12">
                <input type="file" name="excel" class="form-control" required/>
            </div>
            <!--<div class="col-md-12 mt-10 mb-10">-->
            <!--    <label>-->
            <!--        <div class="custom-control custom-checkbox">-->
            <!--            <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="vaciar" value="0" checked>-->
            <!--            <label class="custom-control-label" for="defaultUnchecked">Vaciar base de datos e importar la base de datos</label>-->
            <!--        </div>-->
            <!--    </label>-->
            <!--</div>-->
            <div class="col-md-6 mt-10">
                <input type="submit" name="submit" value="Verifica e importar archivo" class='btn  btn-info'/>
            </div>
        </div>
    </form>
    <?php
    if (isset($_POST['submit'])) {
        if (isset($_FILES['excel']['name']) && $_FILES['excel']['name'] != "") {
            $allowedExtensions = array("xls", "xlsx");
            $objPHPExcel = PHPEXCEL_IOFactory::load($_FILES['excel']['tmp_name']);
            $objPHPExcel->setActiveSheetIndex(0);
            $numRows = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
            $numCols = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
            $numCols = (ord(strtolower($numCols)) - 96);

            //if (isset($_POST["vaciar"])) {
            //    $productos->truncate();
            //}
            if ($numCols > 4) {
                for ($row = 2; $row <= $numRows; $row++) {
                    $titulo = $objPHPExcel->getActiveSheet()->getCell("A" . $row)->getCalculatedValue();
                    $cod_producto = $objPHPExcel->getActiveSheet()->getCell("B" . $row)->getCalculatedValue();
                    $descripcion = $objPHPExcel->getActiveSheet()->getCell("C" . $row)->getCalculatedValue();
                    $envio = $objPHPExcel->getActiveSheet()->getCell("D" . $row)->getCalculatedValue();

                    $precio = $objPHPExcel->getActiveSheet()->getCell("F" . $row)->getCalculatedValue();

                    $linea = $objPHPExcel->getActiveSheet()->getCell("G" . $row)->getCalculatedValue();
                    $rubro = $objPHPExcel->getActiveSheet()->getCell("H" . $row)->getCalculatedValue();
                    $subrubro = $objPHPExcel->getActiveSheet()->getCell("I" . $row)->getCalculatedValue();
                    $marca = $objPHPExcel->getActiveSheet()->getCell("J" . $row)->getCalculatedValue();

                    $stock = $objPHPExcel->getActiveSheet()->getCell("K" . $row)->getCalculatedValue();
                    $rubro_numero = $objPHPExcel->getActiveSheet()->getCell("L" . $row)->getCalculatedValue();
                    $cod_producto_virtual = $objPHPExcel->getActiveSheet()->getCell("M" . $row)->getCalculatedValue();
                    if (!empty($titulo)) {
                        $precio = ceil(str_replace(",", ".", $precio));
                        $title = trim($funciones->antihack_mysqli(isset($titulo) ? $titulo : ''));
                        $linea = $funciones->antihack_mysqli(isset($linea) ? $linea : '');
                        $rubro = $funciones->antihack_mysqli(isset($rubro) ? $rubro : '');
                        $subrubro = $funciones->antihack_mysqli(isset($subrubro) ? $subrubro : '');
                        $marca = $funciones->antihack_mysqli(isset($marca) ? $marca : '');
                        $rubro_numero = $funciones->antihack_mysqli(isset($rubro_numero) ? $rubro_numero : 0);
                        $cod_producto_virtual = $funciones->antihack_mysqli(isset($cod_producto_virtual) ? $cod_producto_virtual : 0);

                        $productos->set("titulo", $title);
                        $productos->set("cod_producto", trim($cod_producto));
                        $productos->set("precio", $funciones->antihack_mysqli(isset($precio) ? $precio : 0));
                        $productos->set("precio_descuento", "");
                        $productos->set("precio_mayorista", "");
                        $productos->set("peso", "");
                        $productos->set("stock", isset($stock) ? $stock : 0);
                        $productos->set("desarrollo", '');

                        $su = '';

                        $cod = substr(md5(uniqid(rand())), 0, 12) . "_c";
                        $productos->set("cod", $cod);
                        $productos->set("categoria", $linea);
                        $productos->set("subcategoria", $su);
                        $productos->set("keywords", "");
                        $productos->set("description", "");
                        $productos->set("fecha", date('Y-m-d'));
                        $productos->set("url", "");
                        //CLASICA
                        $productos->set("variable1", '1');//TIPO DE PUBLICACION 1 Clasica
                        $productos->set("variable2", '');
                        $productos->set("variable3", trim($linea) . " " . trim($rubro) . " " . trim($subrubro) . " " . trim($marca));
                        $productos->set("variable4", trim($descripcion));
                        $productos->set("variable5", trim($rubro_numero));
                        $productos->set("variable6", trim($rubro));
                        $productos->set("variable7", $cod_producto_virtual);
                        $productos->set("variable8", "");
                        $productos->set("variable9", "");
                        $productos->set("variable10", "");
                        $productos->set("meli", "");
                        $productos->set("precio", $precio);

                        $productoData = $productos->list(["variable7='$cod_producto_virtual' AND variable1='1'"], '', '1');
                        if (!empty($productoData)) {
                            $productos->set("id", $productoData[0]['data']['id']);
                            $productos->set("cod", $productoData[0]['data']['cod']);
                            $productos->set("meli", $productoData[0]['data']['meli']);
                            $productos->edit();
                        } else {
                            $productos->add();
                        }

                        //PREMIUM
                        $cod = substr(md5(uniqid(rand())), 0, 12) . "_p";
                        $productos->set("cod", $cod);
                        $productos->set("titulo", $title . " P");
                        $productos->set("variable1", '2');//TIPO DE PUBLICACION 2 Premium

                        $productoData = $productos->list(["variable7='$cod_producto_virtual' AND variable1='2'"], '', '1');
                        if (!empty($productoData)) {
                            $productos->set("id", $productoData[0]['data']['id']);
                            $productos->set("cod", $productoData[0]['data']['cod']);
                            $productos->set("meli", $productoData[0]['data']['meli']);
                            $productos->edit();
                        } else {
                            $productos->add();
                        }
                    }
                }
                ?>
                <div class="row mt-15">
                    <div class="col-md-12">
                        <div class="alert alert-success">Subida completada.</div>
                    </div>
                </div>
                <?php
            } else {
                echo '<span class="alert alert-danger">Hay errores en el excel que intetas subir. Descargar aquí el ejemplo</span>';
            }
        } else {
            echo '<span class="alert alert-danger">Seleccionar primero el archivo a subir.</span>';
        }
    }
    ?>
</div>