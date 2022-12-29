<?php
require_once "../Config/Autoload.php";
Config\Autoload::runSitio();
$terminales = new Clases\Terminales();
include "../vendor/phpoffice/phpexcel/Classes/PHPExcel.php";
require "../vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php";
?>
<div class="col-md-12">
    <form method="post" enctype="multipart/form-data">
        <hr />
        <div class="row">
            <div class="col-md-12">
                <input type="file" name="excel" class="form-control" required />
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
                <input type="submit" name="submit" value="Verifica e importar archivo" class='btn  btn-info' />
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

            $terminales->truncate();

            if ($numCols > 4) {
                for ($row = 3; $row <= $numRows; $row++) {

                    if ($row % 100 == 0) {
                        sleep(5);
                    }

                    $codigo = $objPHPExcel->getActiveSheet()->getCell("A" . $row)->getCalculatedValue();
                    $descripcion = $objPHPExcel->getActiveSheet()->getCell("B" . $row)->getCalculatedValue();
                    $aclaracion = $objPHPExcel->getActiveSheet()->getCell("C" . $row)->getCalculatedValue();
                    $cañiflex = $objPHPExcel->getActiveSheet()->getCell("E" . $row)->getCalculatedValue();
                    $iron = $objPHPExcel->getActiveSheet()->getCell("F" . $row)->getCalculatedValue();
                    $iron_r2_pp = $objPHPExcel->getActiveSheet()->getCell("G" . $row)->getCalculatedValue();
                    $iron_r2_sp = $objPHPExcel->getActiveSheet()->getCell("H" . $row)->getCalculatedValue();
                    $iron_r1 = $objPHPExcel->getActiveSheet()->getCell("I" . $row)->getCalculatedValue();
                    $iron_r9 = $objPHPExcel->getActiveSheet()->getCell("J" . $row)->getCalculatedValue();
                    $iron_r13 = $objPHPExcel->getActiveSheet()->getCell("K" . $row)->getCalculatedValue();
                    $metalurgicajs = $objPHPExcel->getActiveSheet()->getCell("L" . $row)->getCalculatedValue();
                    $metalurgicajs_r1_sp = $objPHPExcel->getActiveSheet()->getCell("M" . $row)->getCalculatedValue();
                    $metalurgicajs_r2_sp = $objPHPExcel->getActiveSheet()->getCell("N" . $row)->getCalculatedValue();
                    $metalurgicajs_r1_pp = $objPHPExcel->getActiveSheet()->getCell("O" . $row)->getCalculatedValue();
                    $metalurgicajs_r2_pp = $objPHPExcel->getActiveSheet()->getCell("P" . $row)->getCalculatedValue();
                    $metalurgicajs_r12 = $objPHPExcel->getActiveSheet()->getCell("Q" . $row)->getCalculatedValue();
                    $metalurgicajs_r13 = $objPHPExcel->getActiveSheet()->getCell("R" . $row)->getCalculatedValue();
                    $parker = $objPHPExcel->getActiveSheet()->getCell("S" . $row)->getCalculatedValue();
                    $tecnicord = $objPHPExcel->getActiveSheet()->getCell("T" . $row)->getCalculatedValue();
                    $hsf = $objPHPExcel->getActiveSheet()->getCell("U" . $row)->getCalculatedValue();
                    $keyword = str_replace(["/", ".", ",", " ", "-"], "", $codigo . "|" . $cañiflex . "|" . $iron . "|" . $iron_r2_pp . "|" . $iron_r2_sp . "|" . $iron_r1 . "|" . $iron_r9 . "|" . $iron_r13 . "|" . $metalurgicajs . "|" . $metalurgicajs_r1_sp . "|" . $metalurgicajs_r2_sp . "|" . $metalurgicajs_r1_pp . "|" . $metalurgicajs_r2_pp . "|" . $metalurgicajs_r12 . "|" . $metalurgicajs_r13 . "|" . $parker . "|" . $tecnicord . "|" . $hsf);
                    $terminales->set("codigo", $codigo);
                    $terminales->set("descripcion", $descripcion);
                    $terminales->set("aclaracion", $aclaracion);
                    $terminales->set("cañiflex", $cañiflex);
                    $terminales->set("iron", $iron);
                    $terminales->set("iron_r2_pp", $iron_r2_pp);
                    $terminales->set("iron_r2_sp", $iron_r2_sp);
                    $terminales->set("iron_r1", $iron_r1);
                    $terminales->set("iron_r9", $iron_r9);
                    $terminales->set("iron_r13", $iron_r13);
                    $terminales->set("metalurgicajs", $metalurgicajs);
                    $terminales->set("metalurgicajs_r1_sp", $metalurgicajs_r1_sp);
                    $terminales->set("metalurgicajs_r2_sp", $metalurgicajs_r2_sp);
                    $terminales->set("metalurgicajs_r1_pp", $metalurgicajs_r1_pp);
                    $terminales->set("metalurgicajs_r2_pp", $metalurgicajs_r2_pp);
                    $terminales->set("metalurgicajs_r12", $metalurgicajs_r12);
                    $terminales->set("metalurgicajs_r13", $metalurgicajs_r13);
                    $terminales->set("parker", $parker);
                    $terminales->set("tecnicord", $tecnicord);
                    $terminales->set("hsf", $hsf);
                    $terminales->set("keyword", $keyword);
                    $terminales->add();
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