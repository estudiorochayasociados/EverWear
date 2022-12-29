<?php
header("Pragma: public");
header("Expires: 0");
$filename = "excelProductosNEW.xls";
header("Content-type: application/x-msdownload");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

require_once dirname(__DIR__,3)."/Config/Autoload.php";
Config\Autoload::runAdmin();
$productos = new Clases\Productos();

$productosArray = $productos->list("","","");

$content = '<table><thead><th>Titulo(Categoría,Producto,Rubro)</th><th>Código Web</th><th>Descripción</th><th>Envío</th><th>Vacío</th><th>Precio c/iva</th><th>Categoría y Rubro</th><th>Rubro ML</th><th>Vacío</th><th>Vacío</th><th>Stock</th><th>Rubro(número)</th><th>Cod producto virtual</th></thead><tbody>';

foreach ($productosArray as $producto){
    $content .= "<tr>";
    $content .= "<td>".$producto['data']['titulo']."</td>";
    $content .= "<td>".$producto['data']['cod_producto']."</td>";
    $content .= "<td>".$producto['data']['desarrollo']."</td>";
    $content .= "<td>".$producto['data']['variable2']."</td>";
    $content .= "<td></td>";
    $content .= "<td>".$producto['data']['precio']."</td>";
    $content .= "<td>".$producto['data']['categoria']."</td>";
    $content .= "<td>".$producto['data']['variable6']."</td>";
    $content .= "<td></td>";
    $content .= "<td></td>";
    $content .= "<td>".$producto['data']['stock']."</td>";
    $content .= "<td>".$producto['data']['variable5']."</td>";
    $content .= "<td>".$producto['data']['variable7']."</td>";
    $content .= "</tr>";
}

$content .= '</tbody></table>';
?>

    <meta charset="UTF-8">

<?php
echo $content;
?>