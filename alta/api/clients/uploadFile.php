<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();
$archivo = new Clases\Archivos();
$zebra = new Clases\Zebra_Image();

$id = $funciones->antihack_mysqli(isset($_POST['id']) ? $_POST['id'] : '');

if (empty($id)) {
    echo json_encode(["status" => false, "message" => "Ocurrió un error en la carga de la documentacion, puede volver a cargarla en el panel de modificación."]);
    die();
}

$response = [
    "status" => true,
    "data" => []
];
foreach ($_FILES as $f => $name) {
    $statusFile = false;
    $imgInicio = $name["tmp_name"];
    $tucadena = $name["name"];
    $partes = explode(".", $tucadena);
    $dom = (count($partes) - 1);
    $dominio = $partes[$dom];
    $prefijo = substr(md5(uniqid(rand())), 0, 12);
    if ($dominio != '') {
//        $imgFormat = ["jpg", "jpeg", "JPG", "JPEG", "png", "PNG"];
//        if (in_array($dominio, $imgFormat)) {
        $destinoFinal = "../../assets/archivos/" . $prefijo . "." . $dominio;
        move_uploaded_file($imgInicio, $destinoFinal);
        chmod($destinoFinal, 0777);
        $destinoRecortado = "../../assets/archivos/documentacion/" . $id . "_" . $prefijo . "." . $dominio;
        rename($destinoFinal, $destinoRecortado);


//            $zebra->source_path = $destinoFinal;
//            $zebra->target_path = $destinoRecortado;
//            $zebra->jpeg_quality = 80;
//            $zebra->preserve_aspect_ratio = true;
//            $zebra->enlarge_smaller_images = true;
//            $zebra->preserve_time = true;

//            if ($zebra->resize(800, 800, ZEBRA_IMAGE_NOT_BOXED)) {
//                unlink($destinoFinal);
//            }
//        } else {
//
//        }

        if (@filesize($destinoRecortado)) $statusFile = true;

        if ($statusFile) {
            $archivo->__set("idCuentaCorriente", $id);
            $archivo->set("ruta", str_replace("../", "", $destinoRecortado));
            if ($archivo->create() && $statusFile) {
                array_push($response['data'], ["status" => true, "message" => $tucadena . " pudo subirse correctamente."]);
            } else {
                array_push($response['data'], ["status" => false, "message" => $tucadena . " no pudo subirse correctamente."]);
            }
        } else {
            array_push($response['data'], ["status" => false, "message" => $tucadena . " no pudo subirse correctamente."]);
        }
    }
}

//json start
$json = file_get_contents('uploadFileStatus.json');
$json = json_decode($json,true);

$array = ["id" => $id];

array_push($json,$array);

$fp = fopen(dirname(__DIR__, 2) . '/api/clients/uploadFileStatus.json', 'w');
fwrite($fp, json_encode($json, JSON_UNESCAPED_UNICODE));
fclose($fp);
//json end

echo json_encode($response);