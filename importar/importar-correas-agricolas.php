<?php
require_once "../Config/Autoload.php";
Config\Autoload::runSitio();
$correasAgricolas = new Clases\CorreasAgricolas();
include "../vendor/phpoffice/phpexcel/Classes/PHPExcel.php";
require "../vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php";
?>
<div class="col-md-12">
    <form method="post" enctype="multipart/form-data">
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

            $correasAgricolas->truncate();

            if ($numCols > 4) {
                for ($row = 2; $row <= $numRows; $row++) {


                    $sector = $objPHPExcel->getActiveSheet()->getCell("A" . $row)->getCalculatedValue();
                    $oem = $objPHPExcel->getActiveSheet()->getCell("B" . $row)->getCalculatedValue();
                    $marca = $objPHPExcel->getActiveSheet()->getCell("C" . $row)->getCalculatedValue();
                    $modelo = $objPHPExcel->getActiveSheet()->getCell("D" . $row)->getCalculatedValue();
                    $descripcion = $objPHPExcel->getActiveSheet()->getCell("E" . $row)->getCalculatedValue();
                    $lado = $objPHPExcel->getActiveSheet()->getCell("F" . $row)->getCalculatedValue();
                    $cantidad = $objPHPExcel->getActiveSheet()->getCell("G" . $row)->getCalculatedValue();
                    $carlisle = $objPHPExcel->getActiveSheet()->getCell("H" . $row)->getCalculatedValue();
                    $everWear = $objPHPExcel->getActiveSheet()->getCell("I" . $row)->getCalculatedValue();

                    $correasAgricolas->set("sector", $sector);
                    $correasAgricolas->set("oem", $oem);
                    $correasAgricolas->set("marca", $marca);
                    $correasAgricolas->set("modelo", str_replace("  ", " ", $modelo));
                    $correasAgricolas->set("descripcion", $descripcion);
                    $correasAgricolas->set("lado", $lado);
                    $correasAgricolas->set("cantidad", $cantidad);
                    $correasAgricolas->set("carlisle", $carlisle);
                    $correasAgricolas->set("everWear", $everWear);
                    $correasAgricolas->add();
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