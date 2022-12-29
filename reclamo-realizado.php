<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();


$template->set("title", "Gracias por enviarnos un mensaje | " . TITULO);
$template->set("description", "Gracias por enviarnos tu mensaje, pronto te responderemos");
$template->set("keywords", "");
$template->set("imagen", LOGO);
$template->set("body", "single-product full-width");
$template->themeInit();
//
?>
<main>
    <!-- slider -->

    <div class="img-slider-content-single-product" style="background: #222">
        <div class="col-md-12 vertical-align justify-content-center">
        </div>
    </div>

    <section class="pt-50 " style="margin-bottom: 380px;">
        <div class="container">
            <div id="content" class="site-content mb-50" tabindex="-1">
                <div class="container">

                    <div id="primary" class="content-area">
                        <main id="main" class="site-main">
                            <article class="has-post-thumbnail hentry">
                                <div id="sns_content" class="wrap">
                                    <div class="container text-center">
                                        <h1>¡GRACIAS POR CONTACTARTE CON NOSOTROS!</h1>
                                        <h4>te contactaremos a la brevedad.</h4>
                                        <i class="fa fa-check-circle fs-50"
                                            style="font-size:80px !important;color:green"></i>
                                    </div>
                                </div>
                            </article>
                        </main>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
<?php
$template->themeEnd();
?>