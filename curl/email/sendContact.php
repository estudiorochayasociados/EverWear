<?php
if (isset($_POST["enviar"])) {
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $captchaData['data']['captcha_secret'] . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);

    if ($responseData->success) {

        $nombre = $funciones->antihack_mysqli(isset($_POST["nombre"]) ? $_POST["nombre"] : '');
        $apellido = $funciones->antihack_mysqli(isset($_POST["apellido"]) ? $_POST["apellido"] : '');
        $email = $funciones->antihack_mysqli(isset($_POST["email"]) ? $_POST["email"] : '');
        $telefono = $funciones->antihack_mysqli(isset($_POST["telefono"]) ? $_POST["telefono"] : '');
        $mensaje = $funciones->antihack_mysqli(isset($_POST["mensaje"]) ? $_POST["mensaje"] : '');

        //USUARIO
        $mensajeFinal = "<b>Gracias por realizar tu consulta, te contactaremos a la brevedad.</b><br/>";
        $mensajeFinal .= "<b>Consulta</b>: " . $mensaje . "<br/>";

        $enviar->set("asunto", "Realizaste tu consulta");
        $enviar->set("receptor", $email);
        $enviar->set("emisor", $emailData['data']['remitente']);
        $enviar->set("mensaje", $mensajeFinal);
        if ($enviar->emailEnviar() == 1) {
            echo '<div class="col-md-12 alert alert-success" role="alert">¡Consulta enviada correctamente!</div>';
        }

        //ADMIN
        $mensajeFinalAdmin = "<b>Nueva consulta desde la web.</b><br/>";
        $mensajeFinalAdmin .= "<b>Nombre</b>: " . $nombre . " <br/>";
        $mensajeFinalAdmin .= "<b>Apellido</b>: " . $apellido . "<br/>";
        $mensajeFinalAdmin .= "<b>Email</b>: " . $email . "<br/>";
        $mensajeFinalAdmin .= "<b>Telefono</b>: " . $telefono . "<br/>";
        $mensajeFinalAdmin .= "<b>Consulta</b>: " . $mensaje . "<br/>";

        $enviar->set("asunto", "Consulta Web");
        $enviar->set("receptor", $emailData['data']['remitente']);
        $enviar->set("mensaje", $mensajeFinalAdmin);

        if ($enviar->emailEnviar() == 0) {
            echo '<div class="col-md-12 alert alert-danger" role="alert">¡No se ha podido enviar la consulta!</div>';
        }
    } else {
        echo '<div class="col-md-12 alert alert-danger" role="alert">¡Debe completar el CAPTCHA!</div>';
    }
}
