<?php
$config = new Clases\Config();
$funcion = new Clases\PublicFunction();
$tab = $funciones->antihack_mysqli(isset($_GET["tab"]) ? $_GET["tab"] : '');
$emailData = $config->viewEmail();
$marketingData = $config->viewMarketing();
$contactoData = $config->viewContact();
$socialData = $config->viewSocial();
$mercadoLibreData = $config->viewMercadoLibre();
$andreaniData = $config->viewAndreani();
$captchaData = $config->viewCaptcha();
$configHeader = $config->viewConfigHeader();
//$exportadorMeliData = $config->viewExportadorMeli();
//Metodos de pagos
$config->set("id", 1);
$pagosData1 = $config->viewPayment();
$config->set("id", 2);
$pagosData2 = $config->viewPayment();
$config->set("id", 3);
$pagosData3 = $config->viewPayment();
$config->set("id", 4);
$pagosData4 = $config->viewPayment();

?>
<section id="tabs" class="project-tab">
    <div class="row">
        <div class="col-md-12">
            <nav>
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                   <a class="nav-item nav-link" id="email-tab" data-toggle="tab" href="#email-home" role="tab" aria-controls="nav-home" aria-selected="true">CONFIGURACIÓN EMAIL</a>
                    <a class="nav-item nav-link" id="marketing-tab" data-toggle="tab" href="#marketing-home" role="tab" aria-controls="nav-profile" aria-selected="false">MARKETING</a>
                    <!--                    <a class="nav-item nav-link" id="contact-tab" data-toggle="tab" href="#contact-home" role="tab" aria-controls="nav-contact" aria-selected="false">DATOS EMPRESA</a>-->
                    <!--                    <a class="nav-item nav-link" id="social-tab" data-toggle="tab" href="#social-home" role="tab" aria-controls="nav-home" aria-selected="true">REDES SOCIALES</a>-->
                    <!-- <a class="nav-item nav-link" id="api-tab" data-toggle="tab" href="#api-home" role="tab" aria-controls="nav-profile" aria-selected="false">API</a> -->
                    <!-- <a class="nav-item nav-link active" id="exportadorMeli-tab" data-toggle="tab" href="#exportadorMeli-home" role="tab" aria-controls="nav-profile" aria-selected="false">Exportador Mercadolibre</a> -->
                    <!--                    <a class="nav-item nav-link" id="pagos-tab" data-toggle="tab" href="#pagos-home" role="tab" aria-controls="nav-contact" aria-selected="false">PAGOS</a>-->
                    <!--                    <a class="nav-item nav-link" id="captcha-tab" data-toggle="tab" href="#captcha-home" role="tab" aria-controls="nav-contact" aria-selected="false">CAPTCHA</a>-->
                    <a class="nav-item nav-link" id="cnf-tab" data-toggle="tab" href="#config-header" role="tab" aria-controls="nav-contact" aria-selected="false">HEADER</a>
                </div>
            </nav>
            <div class="tab-content mt-15" id="nav-tabContent">
                <?php
                if (isset($_POST["agregar-email"])) {
                    $config->set("remitente", $funciones->antihack_mysqli(isset($_POST["e-remitente"]) ? $_POST["e-remitente"] : ''));
                    $config->set("smtp", $funciones->antihack_mysqli(isset($_POST["e-smtp"]) ? $_POST["e-smtp"] : ''));
                    $config->set("smtp_secure", $funciones->antihack_mysqli(isset($_POST["e-smtp-secure"]) ? $_POST["e-smtp-secure"] : ''));
                    $config->set("puerto", $funciones->antihack_mysqli(isset($_POST["e-puerto"]) ? $_POST["e-puerto"] : ''));
                    $config->set("email_", $funciones->antihack_mysqli(isset($_POST["e-email"]) ? $_POST["e-email"] : ''));
                    $config->set("password", $funciones->antihack_mysqli(isset($_POST["e-password"]) ? $_POST["e-password"] : ''));
                    $error = $config->addEmail();
                    if ($error) {
                        $funciones->headerMove(URL_ADMIN . '/index.php?op=configuracion&accion=modificar&tab=email-tab');
                    } else {
                        echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
                    }
                }
                ?>
                <div class="tab-pane fade " id="email-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <form method="post" action="<?= URL_ADMIN ?>/index.php?op=configuracion&accion=modificar&tab=email-tab">
                        <div class="row mt-5">
                            <label class="col-md-6">
                                Remitente:<br />
                                <input type="email" class="form-control" name="e-remitente" value="<?= $emailData['data']["remitente"] ? $emailData['data']["remitente"] : '' ?>" required />
                            </label>
                            <label class="col-md-6">
                                Email:<br />
                                <input type="email" class="form-control" name="e-email" value="<?= $emailData['data']["email"] ? $emailData['data']["email"] : '' ?>" required />
                            </label>
                            <label class="col-md-4">
                                SMTP Server:<br />
                                <input type="text" class="form-control" name="e-smtp" value="<?= $emailData['data']["smtp"] ? $emailData['data']["smtp"] : '' ?>" required />
                            </label>
                            <label class="col-md-2">
                                SMTP Secure:<br />
                                <select name="e-smtp-secure" required>
                                    <?php
                                    if (!empty($emailData['data']['smtp_secure'])) {
                                        $secure = $emailData['data']['smtp_secure'];
                                    ?>
                                        <option value="tls" <?php if ($secure == "tls") {
                                                                echo "selected";
                                                            } ?>>
                                            TLS
                                        </option>
                                        <option value="ssl" <?php if ($secure == "ssl") {
                                                                echo "selected";
                                                            } ?>>
                                            SSL
                                        </option>
                                    <?php
                                    } else {
                                    ?>
                                        <option value="tls">TLS</option>
                                        <option value="ssl">SSL</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </label>
                            <label class="col-md-2">
                                Puerto:<br />
                                <input type="number" class="form-control" name="e-puerto" value="<?= $emailData['data']["puerto"] ? $emailData['data']["puerto"] : '' ?>" required />
                            </label>
                            <label class="col-md-4">
                                Password:<br />
                                <input type="password" class="form-control" name="e-password" value="<?= $emailData['data']["password"] ? $emailData['data']["password"] : '' ?>" required />
                            </label>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit" name="agregar-email">Guardar cambios</button>
                            </div>
                        </div>
                    </form>
                </div>

                <?php
                if (isset($_POST["agregar-marketing"])) {
                    $config->set("googleDataStudioId", $funciones->antihack_mysqli(isset($_POST["m-google-id"]) ? $_POST["m-google-id"] : ''));
                    $config->set("googleAnalytics", $funciones->antihack_mysqli(isset($_POST["m-google-analytics"]) ? $_POST["m-google-analytics"] : ''));
                    $config->set("hubspot", $funciones->antihack_mysqli(isset($_POST["m-hubspot"]) ? $_POST["m-hubspot"] : ''));
                    $config->set("mailrelay", $funciones->antihack_mysqli(isset($_POST["m-mailrelay"]) ? $_POST["m-mailrelay"] : ''));
                    $config->set("onesignal", $funciones->antihack_mysqli(isset($_POST["m-onesignal"]) ? $_POST["m-onesignal"] : ''));
                    $config->set("facebookPixel", $funciones->antihack_mysqli(isset($_POST["m-facebook-pixel"]) ? $_POST["m-facebook-pixel"] : ''));
                    $error = $config->addMarketing();
                    if ($error) {
                        $funciones->headerMove(URL_ADMIN . '/index.php?op=configuracion&accion=modificar&tab=marketing-tab');
                    } else {
                        echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
                    }
                }
                ?>
                <div class="tab-pane fade" id="marketing-home" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <form method="post" action="<?= URL_ADMIN ?>/index.php?op=configuracion&accion=modificar&tab=marketing-tab">
                        <div class="row mt-5">
                            <label class="col-md-12">
                                Google Data Studio ID:<br />
                                <input type="text" class="form-control" name="m-google-id" value="<?= $marketingData['data']["google_data_studio_id"] ? $marketingData['data']["google_data_studio_id"] : '' ?>" />
                            </label>
                            <label class="col-md-12">
                                Google Analytics:<br />
                                <input type="text" class="form-control" name="m-google-analytics" value="<?= $marketingData['data']["google_analytics"] ? $marketingData['data']["google_analytics"] : '' ?>" />
                            </label>
                            <label class="col-md-12">
                                Hubspot:<br />
                                <input type="text" class="form-control" name="m-hubspot" value="<?= $marketingData['data']["hubspot"] ? $marketingData['data']["hubspot"] : '' ?>" />
                            </label>
                            <label class="col-md-12">
                                Mailrelay:<br />
                                <input type="text" class="form-control" name="m-mailrelay" value="<?= $marketingData['data']["mailrelay"] ? $marketingData['data']["mailrelay"] : '' ?>" />
                            </label>
                            <label class="col-md-12">
                                OneSignal:<br />
                                <input type="text" class="form-control" name="m-onesignal" value="<?= $marketingData['data']["onesignal"] ? $marketingData['data']["onesignal"] : '' ?>" />
                            </label>
                            <label class="col-md-12">
                                Facebook Pixel:<br />
                                <input type="text" class="form-control" name="m-facebook-pixel" value="<?= $marketingData['data']["facebook_pixel"] ? $marketingData['data']["facebook_pixel"] : '' ?>" />
                            </label>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit" name="agregar-marketing">Guardar cambios</button>
                            </div>
                        </div>
                    </form>
                </div>

                <?php
                if (isset($_POST["agregar-contacto"])) {
                    $config->set("email", $funciones->antihack_mysqli(isset($_POST["email"]) ? $_POST["email"] : ''));
                    $config->set("telefono", $funciones->antihack_mysqli(isset($_POST["telefono"]) ? $_POST["telefono"] : ''));
                    $config->set("whatsapp", $funciones->antihack_mysqli(isset($_POST["whatsapp"]) ? $_POST["whatsapp"] : ''));
                    $config->set("domicilio", $funciones->antihack_mysqli(isset($_POST["domicilio"]) ? $_POST["domicilio"] : ''));
                    $config->set("localidad", $funciones->antihack_mysqli(isset($_POST["localidad"]) ? $_POST["localidad"] : ''));
                    $config->set("provincia", $funciones->antihack_mysqli(isset($_POST["provincia"]) ? $_POST["provincia"] : ''));
                    $config->set("pais", $funciones->antihack_mysqli(isset($_POST["pais"]) ? $_POST["pais"] : ''));
                    $error = $config->addContact();
                    if ($error) {
                        $funciones->headerMove(URL_ADMIN . '/index.php?op=configuracion&accion=modificar&tab=contact-tab');
                    } else {
                        echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
                    }
                }
                ?>
                <div class="tab-pane fade" id="contact-home" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <form method="post" action="<?= URL_ADMIN ?>/index.php?op=configuracion&accion=modificar&tab=contact-tab">
                        <div class="row mt-5">
                            <label class="col-md-12">
                                Email:<br />
                                <input type="email" class="form-control" name="email" value="<?= $contactoData['data']["email"] ? $contactoData['data']["email"] : '' ?>" required />
                            </label>
                            <label class="col-md-6">
                                Teléfono:<br />
                                <input type="text" class="form-control" name="telefono" value="<?= $contactoData['data']["telefono"] ? $contactoData['data']["telefono"] : '' ?>" required />
                            </label>
                            <label class="col-md-6">
                                Whatsapp:<br />
                                <input type="text" class="form-control" name="whatsapp" value="<?= $contactoData['data']["whatsapp"] ? $contactoData['data']["whatsapp"] : '' ?>" />
                            </label>
                            <label class="col-md-3">
                                Domicilio:<br />
                                <input type="text" class="form-control" name="domicilio" value="<?= $contactoData['data']["domicilio"] ? $contactoData['data']["domicilio"] : '' ?>" required />
                            </label>
                            <label class="col-md-3">
                                Localidad:<br />
                                <input type="text" class="form-control" name="localidad" value="<?= $contactoData['data']["localidad"] ? $contactoData['data']["localidad"] : '' ?>" required />
                            </label>
                            <label class="col-md-3">
                                Provincia:<br />
                                <input type="text" class="form-control" name="provincia" value="<?= $contactoData['data']["provincia"] ? $contactoData['data']["provincia"] : '' ?>" required />
                            </label>
                            <label class="col-md-3">
                                País:<br />
                                <input type="text" class="form-control" name="pais" value="<?= $contactoData['data']["pais"] ? $contactoData['data']["pais"] : '' ?>" required />
                            </label>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit" name="agregar-contacto">Guardar cambios</button>
                            </div>
                        </div>
                    </form>
                </div>

                <?php
                if (isset($_POST["agregar-redes"])) {
                    $config->set("facebook", $funciones->antihack_mysqli(isset($_POST["s-facebook"]) ? $_POST["s-facebook"] : ''));
                    $config->set("twitter", $funciones->antihack_mysqli(isset($_POST["s-twitter"]) ? $_POST["s-twitter"] : ''));
                    $config->set("instagram", $funciones->antihack_mysqli(isset($_POST["s-instagram"]) ? $_POST["s-instagram"] : ''));
                    $config->set("linkedin", $funciones->antihack_mysqli(isset($_POST["s-linkedin"]) ? $_POST["s-linkedin"] : ''));
                    $config->set("youtube", $funciones->antihack_mysqli(isset($_POST["s-youtube"]) ? $_POST["s-youtube"] : ''));
                    $config->set("googleplus", $funciones->antihack_mysqli(isset($_POST["s-google"]) ? $_POST["s-google"] : ''));
                    $error = $config->addSocial();
                    if ($error) {
                        $funciones->headerMove(URL_ADMIN . '/index.php?op=configuracion&accion=modificar&tab=social-tab');
                    } else {
                        echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
                    }
                }
                ?>
                <div class="tab-pane fade" id="social-home" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <form method="post" action="<?= URL_ADMIN ?>/index.php?op=configuracion&accion=modificar&tab=social-tab">
                        <div class="row mt-5">
                            <label class="col-md-12">
                                Facebook:<br />
                                <input type="text" class="form-control" name="s-facebook" value="<?= $socialData['data']["facebook"] ? $socialData['data']["facebook"] : '' ?>" />
                            </label>
                            <label class="col-md-12">
                                Twitter:<br />
                                <input type="text" class="form-control" name="s-twitter" value="<?= $socialData['data']["twitter"] ? $socialData['data']["twitter"] : '' ?>" />
                            </label>
                            <label class="col-md-12">
                                Instragram:<br />
                                <input type="text" class="form-control" name="s-instagram" value="<?= $socialData['data']["instagram"] ? $socialData['data']["instagram"] : '' ?>" />
                            </label>
                            <label class="col-md-12">
                                Linkedin:<br />
                                <input type="text" class="form-control" name="s-linkedin" value="<?= $socialData['data']["linkedin"] ? $socialData['data']["linkedin"] : '' ?>" />
                            </label>
                            <label class="col-md-12">
                                YouTube:<br />
                                <input type="text" class="form-control" name="s-youtube" value="<?= $socialData['data']["youtube"] ? $socialData['data']["youtube"] : '' ?>" />
                            </label>
                            <label class="col-md-12">
                                Google Plus:<br />
                                <input type="text" class="form-control" name="s-google" value="<?= $socialData['data']["googleplus"] ? $socialData['data']["googleplus"] : '' ?>" />
                            </label>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit" name="agregar-redes">Guardar cambios</button>
                            </div>
                        </div>
                    </form>
                </div>



                <?php
                if (isset($_POST["agregar-captcha"])) {
                    $config->set("captcha_key", $funciones->antihack_mysqli(isset($_POST["c-key"]) ? $_POST["c-key"] : ''));
                    $config->set("captcha_secret", $funciones->antihack_mysqli(isset($_POST["c-secret"]) ? $_POST["c-secret"] : ''));
                    $error = $config->addCaptcha();
                    if ($error) {
                        $funciones->headerMove(URL_ADMIN . '/index.php?op=configuracion&accion=modificar&tab=captcha-tab');
                    } else {
                        echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
                    }
                }
                ?>
                <div class="tab-pane fade" id="captcha-home" role="tabpanel" aria-labelledby="nav-contact-tab">
                    <form method="post" action="<?= URL_ADMIN ?>/index.php?op=configuracion&accion=modificar&tab=captcha-tab">
                        <div class="row mt-5">
                            <label class="col-md-12">
                                CAPTCHA KEY:<br />
                                <input type="text" class="form-control" name="c-key" value="<?= $captchaData['data']["captcha_key"] ? $captchaData['data']["captcha_key"] : '' ?>" required />
                            </label>
                            <label class="col-md-12">
                                CAPTCHA SECRET:<br />
                                <input type="text" class="form-control" name="c-secret" value="<?= $captchaData['data']["captcha_secret"] ? $captchaData['data']["captcha_secret"] : '' ?>" required />
                            </label>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit" name="agregar-captcha">Guardar cambios</button>
                            </div>
                        </div>
                    </form>
                </div>

                <?php
                if (isset($_POST["agregar-config"])) {
                    $config->set("content_header", $funciones->antihack_mysqli(isset($_POST["cnf-header"]) ? $_POST["cnf-header"] : ''));
                    $error = $config->addConfigHeader();
                    if ($error) {
                        $funciones->headerMove(URL_ADMIN . '/index.php?op=configuracion&accion=modificar&tab=config-header');
                    } else {
                        echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
                    }
                }
                ?>
                <div class="tab-pane fade" id="config-header" role="tabpanel" aria-labelledby="nav-header-tab">

                    <form method="post" action="<?= URL_ADMIN ?>/index.php?op=configuracion&accion=modificar&tab=config-header">
                        <div class="row mt-5">
                            <label class="col-md-12">
                                CONFIG HEADER:<br />
                                <textarea class="form-control" name="cnf-header" rows="20"><?= $configHeader["data"]["content_header"] ?></textarea>
                            </label>
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit" name="agregar-config">Guardar cambios</button>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
</section>


<script>
    $(document).ready(function() {
        $('#<?= $tab ?>').click();
    })
</script>