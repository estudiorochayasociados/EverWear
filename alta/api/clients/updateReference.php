<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();
$referencia = new Clases\Referencias();

$cc = $funciones->antihack_mysqli(!empty($_POST["f4-cc"]) ? $_POST["f4-cc"] : '');

if (empty($_SESSION['usuarios'])) {
    echo json_encode(["status" => false, "message" => "Ocurrió un error, recargar la página."]);
    die();
}

$referencias = [];
if (isset($_POST['f4'])) {
    foreach ($_POST['f4'] as $key => $ref) {
        $referencias[$key]["id"] = $funciones->antihack_mysqli(!empty($ref["id"]) ? $ref["id"] : '');
        $referencias[$key]["razon"] = $funciones->antihack_mysqli(!empty($ref["razon"]) ? $ref["razon"] : '');
        $referencias[$key]["contacto"] = $funciones->antihack_mysqli(!empty($ref["contacto"]) ? $ref["contacto"] : '');
        $referencias[$key]["rubro"] = $funciones->antihack_mysqli(!empty($ref["rubro"]) ? $ref["rubro"] : '');
        $referencias[$key]["telefono"] = $funciones->antihack_mysqli(!empty($ref["tel"]) ? $ref["tel"] : '');
        $referencias[$key]["detalle"] = $funciones->antihack_mysqli(!empty($ref["detalle"]) ? $ref["detalle"] : '');
    }
}

$responses = [];
foreach ($referencias as $key => $referencias_) {
    if (empty($referencias_['razon'])) continue;
    $referencia->__set("idCuentaCorriente", $cc);
    $referencia->set("razonSocial", $referencias_['razon']);
    $referencia->set("contacto", $referencias_['contacto']);
    $referencia->set("rubro", $referencias_['rubro']);
    $referencia->set("telefono", $referencias_['telefono']);
    $referencia->set("detalle", $referencias_['detalle']);
    $responses[$key]['id'] = $key + 1;
    if (empty($referencias_["id"])) {
        $responses[$key]['status']=$referencia->create();
    } else {
        $referencia->__set("id", $referencias_['id']);
        $responses[$key]['status'] = $referencia->update();
    }
}

$messages = [];
foreach ($responses as $responses_) {
    $message = "Referencia Nº" . $responses_['id'] . ": ";

    $message .= ($responses_['status'] ? "fue guardada con éxito." : "no pudo guardarse correctamente.");
    $messages[] = ["status" => $responses_['status'], "message" => $message];
}
echo json_encode(["status" => true, "messages" => $messages]);