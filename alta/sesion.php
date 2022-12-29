<?php
require_once "Config/Autoload.php";
Config\Autoload::run();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();
$checkout = new Clases\Checkout();
$carrito = new Clases\Carrito();
$usuario = new Clases\Usuarios();

$op = isset($_GET["op"]) ? $_GET["op"] : '';
$usuarioSesion = $usuario->viewSession();

$template->set("title", "PANEL DE USUARIO | " . TITULO);
$template->set("description", "");
$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->set("body", "");
$template->themeInit();
?>
<!--My Account section start-->
<div class="my-account-section section pt-10 pb-100 pb-lg-80 pb-md-70 pb-sm-60 pb-xs-50">
    <div class="container">
        <div class="row">
            <div class="col-md-12 pt-15 hidden-xs hidden-sm">
                <div class="row">
                    <?php if(isset($_SESSION["usuarios"]) && !empty($_SESSION["usuarios"])) { ?>

                    <?php } ?>
                </div>
            </div>
            <div class="col-lg-12 float-md-right">
                <div class="categories_product_area">
                    <div class="row">
                        <?php
                        $op = isset($_GET["op"]) ? $_GET["op"] : 'listado';
                        if ($op != '') {
                            include("assets/inc/sesion/" . $op . ".php");
                        }
                        if (isset($_GET["logout"])) {
                            session_destroy();
                            $funciones->headerMove(URL . "/index.php");
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--My Account section end-->
<!-- panel-user -->
<div class="container pb-150">

</div>
<?php $template->themeEnd(); ?>
<script>
    $(document).ready(function () {
        $('#f1-provincia').select2();
        $('#f1-localidad').select2();
        $('#f3-t-provincia').select2();
        $('#f3-t-localidad').select2();
        $('#f3-r-provincia').select2();
        $('#f3-r-localidad').select2();
    });
</script>
