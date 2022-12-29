<?php
require_once dirname(__DIR__, 3) . "/Config/Autoload.php";
Config\Autoload::runSitio();

$function = new Clases\PublicFunction();

$db = isset($_POST["db"]) ? $_POST["db"] : '';
$attr = isset($_POST["attr"]) ? $_POST["attr"] : '';
$value = isset($_POST["value"]) ? $_POST["value"] : '';
$cod = isset($_POST["cod"]) ? $_POST["cod"] : '';

if (!empty($db) && !empty($attr) && !empty($value) && !empty($cod)) {
    if ($function->edit_mysql($db, $cod, $attr, $value)) {
        echo json_encode(["status" => true]);
    } else {
        echo json_encode(["status" => false]);
    }
}
