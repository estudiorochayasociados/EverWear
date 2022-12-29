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
    $fecha = isset($_POST["fecha"]) ? $funciones->antihack_mysqli($_POST["fecha"]) : '';
    $fecha = strftime("%d/%m/%Y", strtotime($fecha));
    $banco = isset($_POST["banco"]) ? $funciones->antihack_mysqli($_POST["banco"]) : '';
    $importe = isset($_POST["importe"]) ? $funciones->antihack_mysqli($_POST["importe"]) : '';
    $valores = isset($_POST["valores"]) ? $funciones->antihack_mysqli($_POST["valores"]) : '';
    $valor1 = isset($_POST["valor1"]) ? $funciones->antihack_mysqli($_POST["valor1"]) : '';
    $valor2 = isset($_POST["valor2"]) ? $funciones->antihack_mysqli($_POST["valor2"]) : '';
    $valor3 = isset($_POST["valor3"]) ? $funciones->antihack_mysqli($_POST["valor3"]) : '';
    $valor4 = isset($_POST["valor4"]) ? $funciones->antihack_mysqli($_POST["valor4"]) : '';
    $valor5 = isset($_POST["valor5"]) ? $funciones->antihack_mysqli($_POST["valor5"]) : '';
    $valor6 = isset($_POST["valor6"]) ? $funciones->antihack_mysqli($_POST["valor6"]) : '';
    $echeq = isset($_POST["echeq"]) ? $funciones->antihack_mysqli($_POST["echeq"]) : '';
    $efectivo = isset($_POST["efectivo"]) ? $funciones->antihack_mysqli($_POST["efectivo"]) : '';
    $mensaje = isset($_POST["observacion"]) ? $funciones->antihack_mysqli($_POST["observacion"]) : '';
    //USUARIO
    $mensajeFinal = "<b>Gracias por enviarnos el informe, te contactaremos a la brevedad.</b><br/>";
    $mensajeFinal .= "<b>Informe</b>: " . $mensaje . "<br/>";

    $enviar->set("asunto", "Confirmacion Envio de Informe");
    $enviar->set("receptor", $email);
    $enviar->set("emisor", $emailData['data']['remitente']);
    $enviar->set("mensaje", $mensajeFinal);
    $enviar->set("files", $arrayFile);
    if ($enviar->emailEnviar() == 1) {
        echo '<div class="col-md-12 alert alert-success" role="alert">¡Informe enviado correctamente!</div>';
    }

    //ADMIN
    $mensajeFinalAdmin = "<b>Nuevo informe de depósito desde la web.</b><br/>";
    $mensajeFinalAdmin .= "<b>Nombre</b>: " . $nombre . " <br/>";
    $mensajeFinalAdmin .= "<b>Email</b>: " . $email . "<br/>";
    $mensajeFinalAdmin .= "<b>Datos del depósito o trasferencia</b>:<br/>";
    $mensajeFinalAdmin .= "<b>Fecha</b>: " . $fecha . "<br/>";
    $mensajeFinalAdmin .= "<b>Banco</b>: " . $banco . "<br/>";
    $mensajeFinalAdmin .= "<b>Importe</b>: $" . $importe . "<br/>";
    $mensajeFinalAdmin .= "<b>Metodo de Pago</b>:<br/>";
    $mensajeFinalAdmin .= !empty($valores) ? "- " . $valores . ":<br/>" : '';
    $mensajeFinalAdmin .= !empty($valor1) ? "$" . $valor1 . "<br/>" : '';
    $mensajeFinalAdmin .= !empty($valor2) ? "$" . $valor2 . "<br/>" : '';
    $mensajeFinalAdmin .= !empty($valor3) ? "$" . $valor3 . "<br/>" : '';
    $mensajeFinalAdmin .= !empty($valor4) ? "$" . $valor4 . "<br/>" : '';
    $mensajeFinalAdmin .= !empty($valor5) ? "$" . $valor5 . "<br/>" : '';
    $mensajeFinalAdmin .= !empty($valor6) ? "$" . $valor6 . "<br/>" : '';
    $mensajeFinalAdmin .= !empty($echeq) ? "- " . $echeq . "<br/>" : '';
    $mensajeFinalAdmin .= !empty($efectivo) ? "- " . $efectivo . "<br/>" : '';
    $mensajeFinalAdmin .= (empty($valores) &&  empty($echeq) &&  empty($efectivo)) ? "No detallado" : '';
    $mensajeFinalAdmin .= "<b>Detalle del Deposito</b>: " . $mensaje . "<br/>";

    $enviar->set("asunto", "INFORME DE DEPÓSITO WEB");
    $enviar->set("receptor", "lucasestudiorocha@gmail.com");
    //$enviar->set("receptor", "pago@everwear.com.ar");
    $enviar->set("mensaje", $mensajeFinalAdmin);

    $enviar->set("files", $arrayFile);

    if ($enviar->emailEnviar() == 0) {
        echo '<div class="col-md-12 alert alert-danger" role="alert">¡No se ha podido enviar la consulta!</div>';
        $funciones->headerMove(URL . "/formulario/informe.html");
    }
}
