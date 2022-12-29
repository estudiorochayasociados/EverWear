<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();
$cuentaCorriente = new Clases\CuentasCorrientes();

$cc = $funciones->antihack_mysqli(isset($_POST['f7-cc']) ? $_POST['f7-cc'] : '');
$comentarioApertura = $funciones->antihack_mysqli(isset($_POST['f7-comentario']) ? $_POST['f7-comentario'] : '');
$nombreViajante = $funciones->antihack_mysqli(isset($_POST['f5-viajante']) ? $_POST['f5-viajante'] : '');

$cuentaCorriente->__set("id", $id);
$cuentaCorriente->set("comentarioApertura", $comentarioApertura);
$cuentaCorriente->set("nombreViajante", $nombreViajante);
$cuentaCorriente->set("usuario", $_SESSION['usuarios']['cod']);
$result = $cuentaCorriente->updateOthers();
if ($response) {
    echo json_encode(["status" => true,"message"=>"Datos guardados correctamente."]);
} else {
    echo json_encode(["status" => false, "message" => "Ocurrió un error, recargue la pagina nuevamente."]);
}