<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();
$cuentaCorriente = new Clases\CuentasCorrientes();

$cc = $funciones->antihack_mysqli(!empty($_POST["f5-cc"]) ? $_POST["f5-cc"] : '');
$lista = $funciones->antihack_mysqli(!empty($_POST["f5-lista"]) ? $_POST["f5-lista"] : '');
$condicion = $funciones->antihack_mysqli(!empty($_POST["f5-condicion"]) ? $_POST["f5-condicion"] : '');
$forma = $funciones->antihack_mysqli(!empty($_POST["f5-forma"]) ? $_POST["f5-forma"] : '');
$categoria = $funciones->antihack_mysqli(!empty($_POST["f5-categoria"]) ? $_POST["f5-categoria"] : '');
$comentario = $funciones->antihack_mysqli(!empty($_POST["f5-comentario"]) ? $_POST["f5-comentario"] : '');

$cuentaCorriente->__set("id", $cc);
$cuentaCorriente->set("lista", $lista);
$cuentaCorriente->set("condicion", $condicion);
$cuentaCorriente->set("forma", $forma);
$cuentaCorriente->set("categoria", $categoria);
$cuentaCorriente->set("comentarioSolicitante", $comentario);
$cuentaCorriente->set("usuario", $_SESSION['usuarios']['cod']);

$response = $cuentaCorriente->updateFinancial();
if ($response) {
    echo json_encode(["status" => true, "message" => "Datos financieros y estrategicos guardados correctamente."]);
} else {
    echo json_encode(["status" => false, "message" => "Completar los campos correctamente."]);
}