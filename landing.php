<?php
require_once "Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$funciones = new Clases\PublicFunction();

//Clases
$imagenes = new Clases\Imagenes();
$landing = new Clases\Landing();
$categorias = new Clases\Categorias();
//Productos
$cod = $funciones->antihack_mysqli(isset($_GET["cod"]) ? $_GET["cod"] : '');
$landing->set("cod", $cod);
$landing_ = $landing->view();
$imagenes->set("cod", $landing_['cod']);
$imagenData = $imagenes->list(array("cod = '" . $landing_['cod'] . "'"));
$landingData = $landing->list('');
$landingData = $landing->list('');
$categorias->set("cod", $landing_["categoria"]);
$categoria = $categorias->view();
$i = 0;

setlocale(LC_ALL, "es_ES");
$fecha = ucfirst(strftime("%u de %B de %Y", strtotime($landing_['fecha'])));

$imagenes->set("cod", $cod);
$imagenes_landing = $imagenes->listForProduct();
$contar_imagenes = count($imagenes_landing);

$template->set("title", ucfirst($landing_['titulo']));
$template->set("description", $landing_['description']);
$template->set("keywords", $landing_['keywords']);
$template->set("imagen", LOGO);
$template->set("body", "single-product full-width");
$template->themeInit();

switch ($categoria["titulo"]) {
    case "Informacion":
        $titulo_form = "Solicitá más información";
        $boton_form = "¡Pedir más info!";
        break;
    case "Compra":
        $titulo_form = "Llená el formulario y comprá online";
        $boton_form = "¡Comprar!";
        break;
    case "Sorteo":
        $titulo_form = "Participá del sorteo";
        $boton_form = "¡Participar!";
        break;
    case "Evento":
        $titulo_form = "Inscribite al evento";
        $boton_form = "¡Inscribirme!";
        break;
    default:
        $titulo_form = "Completar el formulario";
        $boton_form = "¡Enviar mis datos!";
        break;
}
//
?>
    <div id="content" class="site-content mb-50" tabindex="-1">
        <div class="container">
            <nav class="woocommerce-breadcrumb"><a href="<?= URL ?>/index">Inicio</a><span class="delimiter"><i class="fa fa-angle-right"></i></span>Landing</nav>
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <article class="has-post-thumbnail hentry col-md-8">
                        <div class="product-images-wrapper">
                            <div class="images electro-gallery">
                                <div class="thumbnails-single owl-carousel hidden-sm-down" style="height: 410px !important;overflow: hidden;">
                                    <?php
                                    if ($contar_imagenes >= 1) {
                                        foreach ($imagenes_landing as $imagen) {
                                            ?>
                                            <a href="<?= URL ?>/<?= $imagen["ruta"] ?>" class="zoom" title="" data-rel="prettyPhoto[product-gallery]"><img src="assets/images/blank.gif" data-echo="<?= URL ?>/<?= $imagen["ruta"] ?>" class="wp-post-image"  alt=""></a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div><!-- .thumbnails-single -->
                                <div class="thumbnails-all columns-5 owl-carousel">
                                    <?php
                                    if ($contar_imagenes >= 1) {
                                        foreach ($imagenes_landing as $imagen) {
                                            ?>
                                            <a href="<?= URL ?>/<?= $imagen["ruta"] ?>" class="first" title=""><img src="assets/images/blank.gif" data-echo="<?= URL ?>/<?= $imagen["ruta"] ?>" class="wp-post-image" alt=""></a>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div><!-- .thumbnails-all -->
                            </div><!-- .electro-gallery -->
                        </div><!-- /.product-images-wrapper -->
                        <hr/>
                        <header class="entry-header">
                            <div class="entry-meta">
                                <span class="posted-on"><a href="#" rel="bookmark"><i class="fa fa-calendar" aria-hidden="true"></i> <?=$fecha?></a></span>
                            </div>
                            <h2 class="entry-title" itemprop="name headline"><?= ucfirst($landing_['titulo']); ?></h2>
                        </header><!-- .entry-header -->
                        <hr/>
                        <p class="fs-20">
                            <?= $landing_['desarrollo']; ?>
                        </p>
                    </article>
                    <div class="blogs-page col-md-4 ">
                        <div>
                            <h3><?= $titulo_form ?></h3>
                            <hr/>
                            <form method="post" class="row" id="Formulario de Contacto" action="<?= URL ?>/gracias">
                                <label class="col-xs-12 col-sm-12 col-md-6">
                                    Nombre <span style="color:red">(*)</span>:<br/>
                                    <input type="text" name="nombre" class="form-control" required/>
                                </label>
                                <label class="col-xs-12 col-sm-12 col-md-6">
                                    Apellido <span style="color:red">(*)</span>:<br/>
                                    <input type="text" name="apellido" class="form-control" required/>
                                </label>
                                <label class="col-xs-12 col-sm-12 col-md-12">
                                    Landing:<br/>
                                    <input type="text" readonly name="landing" class="form-control" value="<?= mb_strtoupper($landing_["titulo"]) ?>"/>
                                </label>
                                <label class="col-xs-12 col-sm-12 col-md-12">
                                    Teléfono:<br/>
                                    <input type="text" name="telefono" class="form-control"/>
                                </label>
                                <label class="col-xs-12 col-sm-12 col-md-12">
                                    Email <span style="color:red">(*)</span>:<br/>
                                    <input type="email" name="email" class="form-control" required/>
                                </label>
                                <label class="col-xs-12 col-sm-12 col-md-12">
                                    Mensaje:<br/>
                                    <textarea name="mensaje" class="text-input"></textarea>
                                </label>
                                <label class="col-xs-12 col-sm-12  col-md-12">
                                    <input type="submit" name="enviar" class="btn btn-block btn-success" value="<?= $boton_form ?>"/>
                                </label>
                            </form>
                            <hr/>
                        </div>
                        <div class="mt-40 text-center">
                            <h5><b>Comunicate también por:</b></h5>
                            <div>
                                <a target="_blank" href="https://wa.me/5555555" class="btn btn-block btn-success fs-18">
                                    <i class="ifoot fa fa-whatsapp" aria-hidden="true"></i> WhatsApp
                                </a>
                                <a target="_blank" href="tel:<?=TELEFONO?>" class="btn btn-block btn-info fs-19">
                                    <i class="ifoot fa fa-phone" aria-hidden="true"></i> <?=TELEFONO?>
                                </a>
                            </div>
                        </div>

                    </div>
                </main>
            </div>
        </div>
    </div>

<?php $template->themeEnd(); ?>
