<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();
$archivo = new Clases\Archivos();

$id = $funciones->antihack_mysqli(!empty($_POST["id"]) ? $_POST["id"] : '');

if (empty($id)) die();

$archivo->__set("id",$id);
$result = $archivo->delete();

if ($result){
    echo json_encode(["status" => true, "message" => "Eliminado correctamente"]);
}else{
    echo json_encode(["status" => false, "message" => "No se pudo eliminar el archivo."]);
}