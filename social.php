<?php
require_once "Config/Autoload.php";
require_once "vendor/stefangabos/zebra_pagination/Zebra_Pagination.php";
Config\Autoload::runSitio();
//
$template = new Clases\TemplateSite();
$contenidos = new Clases\Contenidos();
$funciones = new Clases\PublicFunction();


$topHeader = $contenidos->viewByTitle('Comunidad Digital');

$template->set("title", "Comunidad Digital | " . TITULO);
$template->set("description", "Comunidad Digital de " . TITULO);
$template->set("keywords", "Comunidad Digital de " . TITULO);
$template->set("body", "shop-page");
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

    <!-- Blog section -->
    <section class="pt-50 pb-50 section-white box-shadow">
        <div class="container">
            <div class="row">
                <div class="col-md-12 main-blog">
                    <!-- Place <div> tag where you want the feed to appear -->
                    <div id="curator-feed-default-layout"><a href="https://curator.io" target="_blank" class="crt-logo crt-tag">Powered by Curator.io</a></div>
                    <!-- The Javascript can be moved to the end of the html page before the </body> tag -->
                    <script type="text/javascript">
                        /* curator-feed-default-layout */
                        (function() {
                            var i, e, d = document,
                                s = "script";
                            i = d.createElement("script");
                            i.async = 1;
                            i.src = "https://cdn.curator.io/published/ec2ba86e-315d-4f5c-a361-fe783ac7de3d.js";
                            e = d.getElementsByTagName(s)[0];
                            e.parentNode.insertBefore(i, e);
                        })();
                    </script>
                </div>
            </div>
        </div>
    </section>
</main>
<?php $template->themeEnd() ?>
<script>
    function traducir() {
        try {
            document.getElementsByClassName('crt-load-more')[0].children[0].innerText = 'Cargar más';
        } catch (err) {
            setTimeout(traducir, 1000);
        }
    }
    traducir();
</script>