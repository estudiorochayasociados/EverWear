<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
////Clases
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$usuario = new Clases\Usuarios();
$config = new Clases\Config();

///Datos
$userData = $usuario->viewSession();
$captchaData = $config->viewCaptcha();
if (!empty($userData)) $funciones->headerMove(URL . '/sesion');
//
$template->set("title", "USUARIOS | " . TITULO);
$template->set("description", "Panel de para usuarios de " . TITULO);
$template->set("keywords", "");
$template->set("body", "contacts");
$template->themeInit();
$funciones->headerMove(URL . '/sesion/agregar');
if (isset($_POST["ingresar"])) {
    // Verify the reCAPTCHA response
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $captchaData['data']['captcha_secret'] . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if ($responseData->success) {
        $user = $funciones->antihack_mysqli(isset($_POST['l-user']) ? $_POST['l-user'] : '');
        $pass = $funciones->antihack_mysqli(isset($_POST['l-pass']) ? $_POST['l-pass'] : '');
        if (!empty($user) && !empty($pass)) {
            $usuario->set("email", mb_strtolower(trim($user)));
            $usuario->set("password", mb_strtolower(trim($pass)));
            $response = $usuario->login();
            if (isset($response['error'])) {
                if ($response['error'] == 1) {
                    echo '<div class="alert alert-danger">El usuario no esta activado, comunicarse con el soporte.</div>';
                }
                if ($response['error'] == 2) {
                    echo '<div class="alert alert-danger">Email o Contraseña incorrectos.</div>';
                }
                if ($response['error'] == 3) {
                    echo '<div class="alert alert-danger">El usuario no existe.</div>';
                }
            } else {
                $funciones->headerMove(URL . '/sesion/agregar');
            }
        } else {
            echo '<div class="alert alert-danger">Completar ambos campos.</div>';
        }
    } else {
        $funciones->headerMove(URL . '/sesion/agregar');
    }
}

?>
<hr>
<div class="container">
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="box">
                        <h2 class="bold">INGRESO DE USUARIO</h2>
                        <div id="l-error"></div>

                        <form method="post">
                            <input class="form-control" type="hidden" name="stg-l" value="1">
                            <div class="form-fild">
                                <span><label>Email <span class="required">*</span></label></span>
                                <input class="form-control" name="l-user" value="" type="text" required>
                            </div>
                            <div class="form-fild">
                                <span><label>Contraseña <span class="required">*</span></label></span>
                                <input class="form-control" name="l-pass" id="l-pass" value="" type="password" required>
                            </div>
                            <div class="form-fild mt-15">
                                <div id="RecaptchaField1"></div>
                            </div>
                            <div id="btn-l" class="login-submit mt-10 mb-10">
                                <input type="submit" name="ingresar" value="INGRESAR" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 text-center">
                    <h2 class="bold">INGRESO COMO INVITADO</h2>
                    <a href="<?= URL ?>/sesion/agregar" class="btn btn-success">INGRESAR</a>
                </div>

            </div>
        </div>
    </div>
</div>
<!--Login Register section end-->
<?php $template->themeEnd(); ?>
<script src="<?= URL ?>/assets/js/services/user.js"></script>
<script>
    function sendCaptcha() {
        try {
            CaptchaCallback('RecaptchaField1', '<?= $captchaData['data']['captcha_key'] ?>');
        } catch (err) {
            setTimeout(sendCaptcha, 1000);
        }
    }

    sendCaptcha();
</script>