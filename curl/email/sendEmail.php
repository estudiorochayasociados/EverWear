<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::runSitio();
$funciones = new Clases\PublicFunction();
$enviar = new Clases\Email();
$config = new Clases\Config();
$captchaData = $config->viewCaptcha();
$emailData = $config->viewEmail();
 
if (isset($_POST["email"])) {
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $captchaData['data']['captcha_secret'] . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if ($responseData->success) {
        $mensajesCliente = "Gracias por enviarnos tu consulta, a la brevedad vamos a estar comunicándonos con ustedes.";
        $mensaje = 'Nuevo mensaje desde el sitio web:';
        $email = isset($_POST["email"]) ? $funciones->antihack_mysqli($_POST["email"]) : '';

        foreach ($_POST as $key => $value) {
            $mensaje .= !isset($value) ? mb_strtoupper($key) . ": " . $funciones->antihack_mysqli($value) . '<br/>' : '';
        }

        //USUARIO
        $enviar->set("asunto", "Gracias por tu consulta");
        $enviar->set("receptor", $email);
        $enviar->set("emisor", $emailData['data']['remitente']);
        $enviar->set("mensaje", $mensajesCliente);
        
        if ($enviar->emailEnviarCurl() == 1) {
            echo '<div class="col-md-12 alert alert-success" role="alert">¡Consulta enviada correctamente!</div>';
        }

        //ADMIN
        $enviar->set("asunto", "Consulta desde el sitio web");
        $enviar->set("receptor", $emailData['data']['remitente']);
        $enviar->set("mensaje", $mensaje);

        
        if ($enviar->emailEnviarCurl() == 0) {
            echo '<div class="col-md-12 alert alert-danger" role="alert">¡No se ha podido enviar la consulta!</div>';
        }
    } else {
        echo '<div class="col-md-12 alert alert-danger" role="alert">¡Debe completar el CAPTCHA!</div>';
    }
}
