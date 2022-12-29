<?php
require_once dirname(__DIR__) . "/Config/Autoload.php";
Config\Autoload::runSitio();
$funciones = new Clases\PublicFunction();
$enviar = new Clases\Email();
$config = new Clases\Config();
$emailData = $config->viewEmail();


if (isset($_POST["nombre"])) {

    if (!empty($_FILES['files']['tmp_name'])) {
        foreach ($_FILES['files']['tmp_name'] as $key => $file) {
            $filename = $_FILES['files']['name'][$key];
            $uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $filename));
            if (move_uploaded_file($_FILES['files']['tmp_name'][$key], $uploadfile)) {
                $arrayFile[] = [$filename => $uploadfile];
            }
        }
    }
    $nombre = isset($_POST["nombre"]) ? $funciones->antihack_mysqli($_POST["nombre"]) : '';
    $email = isset($_POST["email"]) ? $funciones->antihack_mysqli($_POST["email"]) : '';
    $telefono = isset($_POST["telefono"]) ? $funciones->antihack_mysqli($_POST["telefono"]) : '';
    $mensaje = isset($_POST["descripcion"]) ? $funciones->antihack_mysqli($_POST["descripcion"]) : '';
    $factura = isset($_POST["factura"]) ? $funciones->antihack_mysqli($_POST["factura"]) : '';
    $diferencia = isset($_POST["diferencia"]) ? $funciones->antihack_mysqli($_POST["diferencia"]) : '';
    $faltante = isset($_POST["faltante"]) ? $funciones->antihack_mysqli($_POST["faltante"]) : '';
    $fallado = isset($_POST["fallado"]) ? $funciones->antihack_mysqli($_POST["fallado"]) : '';
    $otra = isset($_POST["otra"]) ? $funciones->antihack_mysqli($_POST["otra"]) : '';
    //USUARIO
    $mensajeFinal = "<b>Gracias por realizar tu reclamo, te contactaremos a la brevedad.</b><br/>";
    $mensajeFinal .= "<b>Reclamo</b>: " . $mensaje . "<br/>";

    $enviar->set("asunto", "Realizaste un reclamo");
    $enviar->set("receptor", $email);
    $enviar->set("emisor", $emailData['data']['remitente']);
    $enviar->set("mensaje", $mensajeFinal);
    $enviar->set("files", $arrayFile);
    if ($enviar->emailEnviar() == 1) {
        echo '<div class="col-md-12 alert alert-success" role="alert">¡Reclamo enviado correctamente!</div>';
    }

    //ADMIN
    $mensajeFinalAdmin = "<b>Nuevo reclamo desde la web.</b><br/>";
    $mensajeFinalAdmin .= "<b>Nombre</b>: " . $nombre . " <br/>";

    $mensajeFinalAdmin .= "<b>Email</b>: " . $email . "<br/>";
    $mensajeFinalAdmin .= "<b>Telefono</b>: " . $telefono . "<br/>";
    $mensajeFinalAdmin .= "<b>Factura</b>: ";
    $mensajeFinalAdmin .= !empty($factura) ? $factura . "<br/>" : "No detallado" . "<br/>";
    $mensajeFinalAdmin .= "<b>Tipo de Reclamo</b>:<br/>";
    $mensajeFinalAdmin .= !empty($diferencia) ? "-" . $diferencia . "<br/>" : '';
    $mensajeFinalAdmin .= !empty($faltante) ? "-" . $faltante . "<br/>" : '';
    $mensajeFinalAdmin .= !empty($fallado) ? "-" . $fallado . "<br/>" : '';
    $mensajeFinalAdmin .= !empty($otra) ? "-" . $otra . "<br/>" : '';
    $mensajeFinalAdmin .= (empty($diferencia) &&  empty($faltante) &&  empty($fallado) &&  empty($otra)) ? "No detallado" : '';
    $mensajeFinalAdmin .= "<b>Detalle del reclamo</b>: " . $mensaje . "<br/>";

    $enviar->set("asunto", "Reclamo Web");
    $enviar->set("receptor", "lucasestudiorocha@gmail.com");
    // $enviar->set("receptor", "atencionalcliente@everwear.com.ar");
    $enviar->set("mensaje", $mensajeFinalAdmin);
    $enviar->set("files", $arrayFile);

    if ($enviar->emailEnviar() == 0) {
        echo '<div class="col-md-12 alert alert-danger" role="alert">¡No se ha podido enviar la consulta!</div>';
        $funciones->headerMove(URL . "/formulario/reclamo.html");
    }
    $funciones->headerMove(URL . "/reclamo-realizado");
}