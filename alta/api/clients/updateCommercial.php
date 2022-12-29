<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();
$transporte = new Clases\Transportes();

//DATOS COMERCIALES
$transportes = [];
$transportes[0]["id"] = $funciones->antihack_mysqli(isset($_POST['f3-t-id']) ? $_POST['f3-t-id'] : '');
$transportes[0]["calle"] = $funciones->antihack_mysqli(isset($_POST['f3-t-calle']) ? $_POST['f3-t-calle'] : '');
$transportes[0]["tipo"] = 1;
$transportes[0]["calle"] = $funciones->antihack_mysqli(isset($_POST['f3-t-calle']) ? $_POST['f3-t-calle'] : '');
$transportes[0]["numero"] = $funciones->antihack_mysqli(isset($_POST['f3-t-numero']) ? $_POST['f3-t-numero'] : '');
$transportes[0]["provincia"] = $funciones->antihack_mysqli(isset($_POST['f3-t-provincia']) ? $_POST['f3-t-provincia'] : '');
$transportes[0]["localidad"] = $funciones->antihack_mysqli(isset($_POST['f3-t-localidad']) ? $_POST['f3-t-localidad'] : '');
$transportes[0]["transporte1"] = $funciones->antihack_mysqli(isset($_POST['f3-t-transporte-1']) ? $_POST['f3-t-transporte-1'] : '');
$transportes[0]["transporte1Telefono"] = $funciones->antihack_mysqli(isset($_POST['f3-t-transporte-1-t']) ? $_POST['f3-t-transporte-1-t'] : '');
$transportes[0]["transporte2"] = $funciones->antihack_mysqli(isset($_POST['f3-t-transporte-2']) ? $_POST['f3-t-transporte-2'] : '');
$transportes[0]["transporte2Telefono"] = $funciones->antihack_mysqli(isset($_POST['f3-t-transporte-2-t']) ? $_POST['f3-t-transporte-2-t'] : '');

$transportes[1]["id"] = $funciones->antihack_mysqli(isset($_POST['f3-r-id']) ? $_POST['f3-r-id'] : '');
$transportes[1]["calle"] = $funciones->antihack_mysqli(isset($_POST['f3-r-calle']) ? $_POST['f3-r-calle'] : '');
$transportes[1]["tipo"] = 2;
$transportes[1]["calle"] = $funciones->antihack_mysqli(isset($_POST['f3-r-calle']) ? $_POST['f3-r-calle'] : '');
$transportes[1]["numero"] = $funciones->antihack_mysqli(isset($_POST['f3-r-numero']) ? $_POST['f3-r-numero'] : '');
$transportes[1]["provincia"] = $funciones->antihack_mysqli(isset($_POST['f3-r-provincia']) ? $_POST['f3-r-provincia'] : '');
$transportes[1]["localidad"] = $funciones->antihack_mysqli(isset($_POST['f3-r-localidad']) ? $_POST['f3-r-localidad'] : '');
$transportes[1]["transporte1"] = $funciones->antihack_mysqli(isset($_POST['f3-r-transporte-1']) ? $_POST['f3-r-transporte-1'] : '');
$transportes[1]["transporte1Telefono"] = $funciones->antihack_mysqli(isset($_POST['f3-r-transporte-1-t']) ? $_POST['f3-r-transporte-1-t'] : '');
$transportes[1]["transporte2"] = $funciones->antihack_mysqli(isset($_POST['f3-r-transporte-2']) ? $_POST['f3-r-transporte-2'] : '');
$transportes[1]["transporte2Telefono"] = $funciones->antihack_mysqli(isset($_POST['f3-r-transporte-2-t']) ? $_POST['f3-r-transporte-2-t'] : '');

$transporte->__set("id", $transportes[0]["id"]);
$transporte->set("calle", $transportes[0]["calle"]);
$transporte->set("numero", $transportes[0]["numero"]);
$transporte->set("provincia", $transportes[0]["provincia"]);
$transporte->set("localidad", $transportes[0]["localidad"]);
$transporte->set("transporte1", $transportes[0]["transporte1"]);
$transporte->set("transporte2", $transportes[0]["transporte2"]);
$transporte->set("tipo", $transportes[0]["tipo"]);
$response = $transporte->update();

if (!empty($transportes[1]["id"])) {
    $transporte->__set("id", $transportes[1]["id"]);
    $transporte->set("calle", $transportes[1]["calle"]);
    $transporte->set("numero", $transportes[1]["numero"]);
    $transporte->set("provincia", $transportes[1]["provincia"]);
    $transporte->set("localidad", $transportes[1]["localidad"]);
    $transporte->set("transporte1", $transportes[1]["transporte1"]);
    $transporte->set("transporte2", $transportes[1]["transporte2"]);
    $transporte->set("tipo", $transportes[1]["tipo"]);
    $response2 = $transporte->update();
}

if ($response && $response2) {
    echo json_encode(["status" => true, "message" => "Datos comerciales guardados correctamente."]);
} else {
    echo json_encode(["status" => false, "message" => "Ocurrió un error, recargar la página."]);
}