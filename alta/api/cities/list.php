<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();

$state = isset($_POST['state']) ? $_POST['state'] : '';
if (empty($state)) {
    echo json_encode(['status' => false]);
    die();
}

$result = $funciones->cities($state);
if (empty($result)) {
    echo json_encode(['status' => false]);
    die();
}

echo json_encode(["status" => true, "data" => $result]);
