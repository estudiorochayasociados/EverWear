<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$enviar = new Clases\Email();

$template->set("title", "Gracias por enviarnos un mensaje | " . TITULO);
$template->set("description", "Gracias por enviarnos tu mensaje, pronto te responderemos");
$template->set("keywords", "enviar contacto, especialistas en neumaticos, contactar rivarosa");
$template->set("imagen", LOGO);
$template->set("body", "single-product full-width");
$template->themeInit();
//
?>

    <div id="content" class="site-content mb-50" tabindex="-1">
        <div class="container">
            <nav class="woocommerce-breadcrumb"><a href="<?= URL ?>/index">Inicio</a><span class="delimiter"><i class="fa fa-angle-right"></i></span>Landing</nav>
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <article class="has-post-thumbnail hentry">
                        <div id="sns_content" class="wrap">
                            <div class="container text-center">
                                <h1>¡GRACIAS POR CONTACTARTE CON NOSOTROS!</h1>
                                <h4>En pocos minutos un operador se estará comunicando con vos.</h4>
                                <i class="fa fa-check-circle fs-50" style="font-size:80px !important;color:green"></i>
                            </div>
                        </div>
                    </article>
                </main>
            </div>
        </div>
    </div>

<?php if (isset($_POST["enviar"])) {
    $nombre = $funciones->antihack_mysqli(isset($_POST["nombre"]) ? $_POST["nombre"] : '');
    $apellido = $funciones->antihack_mysqli(isset($_POST["apellido"]) ? $_POST["apellido"] : '');
    $landing = $funciones->antihack_mysqli(isset($_POST["landing"]) ? $_POST["landing"] : '');
    $telefono = $funciones->antihack_mysqli(isset($_POST["telefono"]) ? $_POST["telefono"] : '');
    $email = $funciones->antihack_mysqli(isset($_POST["email"]) ? $_POST["email"] : '');
    $mensaje = $funciones->antihack_mysqli(isset($_POST["mensaje"]) ? $_POST["mensaje"] : '');

    //USUARIO
    $mensajeFinal = "<b>Gracias por contactarte con nosotros, te responderemos a la brevedad.</b><br/>";
    $mensajeFinal .= "<b>Motivo</b>: " . $landing . "<br/>";
    $mensajeFinal .= "<b>Mensaje</b>: " . $mensaje . "<br/>";

    $enviar->set("asunto", $landing);
    $enviar->set("receptor", $email);
    $enviar->set("emisor", EMAIL);
    $enviar->set("mensaje", $mensajeFinal);
    if ($enviar->emailEnviar() == 1) {
        echo '<div class="alert alert-success" role="alert">¡Formulario enviado correctamente!</div>';
    }

    //ADMIN
    $mensajeFinalAdmin = "<b>Nueva consulta desde la web.</b><br/>";
    $mensajeFinalAdmin .= "<b>Motivo</b>: " . $landing . "<br/>";
    $mensajeFinalAdmin .= "<b>Nombre</b>: " . $nombre . " <br/>";
    $mensajeFinalAdmin .= "<b>Apellido</b>: " . $apellido . "<br/>";
    $mensajeFinalAdmin .= "<b>Email</b>: " . $email . "<br/>";
    $mensajeFinalAdmin .= "<b>Teléfono</b>: " . $telefono . "<br/>";
    $mensajeFinalAdmin .= "<b>Mensaje</b>: " . $mensaje . "<br/>";

    $enviar->set("asunto", $landing);
    $enviar->set("receptor", EMAIL);
    $enviar->set("mensaje", $mensajeFinalAdmin);
    if ($enviar->emailEnviar() == 0) {
        echo '<div class="alert alert-danger" role="alert">¡No se ha podido enviar el formulario!</div>';
    }
} ?>

<?php
$template->themeEnd();
?>