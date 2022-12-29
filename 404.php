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
$contenido->set("cod", "direccion");
$direccion = $contenido->view()["contenido"];
$contenido->set("cod", "telefonos");
$telefonos = $contenido->view()["contenido"];
$contenido->set("cod", "horarios");
$horarios = $contenido->view()["contenido"];
$contenido->set("cod", "email");
$email = $contenido->view()["contenido"];
$template->themeInit();
?>

    <!-- breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <ul>
                    <li class="home"><a title="Go to Home Page" href="<?= URL ?>/index">Inicio</a><span>&mdash;›</span></li>
                    <li class="category13"><strong>Contacto</strong></li>
                </ul>
            </div>
        </div>
    </div>

    <!--End main-container -->
    <section class="content-wrapper">
        <div class="container">
            <div class="std">
                <div class="page-not-found wow bounceInRight animated">
                    <h2>404</h2>
                    <h3>Oops! La página no fue no encontrada o no existe!</h3>
                    <div><a href="<?=URL?>/index" class="btn-home"><span>Regresar al inicio</span></a></div>
                </div>
            </div>
        </div>
    </section>

<?php $template->themeEnd() ?>