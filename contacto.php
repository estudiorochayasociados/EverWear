<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$template->set("title", "Contacto | " . TITULO);
$template->set("description", "Realizá tu consulta a través de los distintos medios que ofrece nuestra web.");
$template->set("keywords", "contacto, direccion rivarosa, telefono rivarosa, direccion neumaticos, direccion neumaticos morteros, direccion neumaticos san francisco");
$template->set("imagen", LOGO);
$template->set("body", "page-template-default contact-v1");

$funciones = new Clases\PublicFunction();
$enviar = new Clases\Email();
$contenido = new Clases\Contenidos();
$config = new Clases\Config();

$captchaData = $config->viewCaptcha();
$emailData = $config->viewEmail();

$topHeader = $contenido->viewByTitle("CONTACTO");
$copy = $contenido->viewByTitle("CONTACTO SUPERIOR");
$contactData = $contenido->viewByTitle("DATOS DE CONTACTO");

$template->themeInit();
?>
<main>
    <!-- slider -->
    <div class="img-slider-content" style="background: url(<?= (count($topHeader["images"]) != 0) ? URL . "/" . $topHeader["images"][0]["ruta"] : URL . "/assets/archivos/60fe6cceb4.png" ?>) center center /cover no-repeat;">
        <div class="container">
            <div class="row">
                <div class="col-md-6"></div>
                <div class="col-md-6 vertical-align justify-slider-content bf bg-tr  pt-60 pb-60">
                    <h3 class="vertical-text text-uppercase">
                        <?= $topHeader["data"]["titulo"] ?>
                    </h3>
                    <span>
                        <?= $topHeader["data"]["contenido"] ?>
                    </span>
                </div>
            </div>
        </div>
    </div>


    <!-- lineas section -->
    <section class="pt-50 pb-50 section-white box-shadow">
        <div class="container">
            <h2 class="bold fs-30 text-uppercase">Envianos tus consultas</h2>
            <p><?= $copy["data"]["contenido"] ?></p>
            <div class="row">
                <?php if (isset($_POST["enviar"])) {
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
                } ?>
                <div class="col-md-8">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nombre"> Nombre</label>
                                <br>
                                <input type="text" name="nombre" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="apellido"> Apellido</label>
                                <br>
                                <input type="text" name="apellido" class="form-control">
                            </div>
                        </div>
                        <div class="customer-name row">
                            <div class="col-md-6">
                                <label for="email"> Email</label>
                                <br>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="telefono"> Telefono</label>
                                <br>
                                <input type="number" name="telefono" class="form-control">
                            </div>
                        </div>
                        <label for="mensaje">Mensaje</label>
                        <br>
                        <textarea name="mensaje" class="required-entry form-control"></textarea>
                        <br>
                        <div class="row">
                            <div class="col-md-12 check-box mb-10">
                                <div class="g-recaptcha" data-sitekey="<?= $captchaData['data']['captcha_key'] ?>"></div>
                            </div>
                        </div>
                        <button type="submit" name="enviar" class="btn btn-secondary">Enviar</button>
                    </form>
                </div>
                <div class="col-md-4 pt-30">
                    <?= $contactData['data']['contenido'] ?>
                </div>
            </div>
    </section>
</main>

<?php $template->themeEnd() ?>