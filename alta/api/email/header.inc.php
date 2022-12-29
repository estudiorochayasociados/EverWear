<?php
$config = new Clases\Config();
$marketing = $config->viewMarketing();
$configHeader = $config->viewConfigHeader();
echo $configHeader["data"]["content_header"];

//onesignal
if (!empty($marketing['data']['google_analytics'])) {
    ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-127300251-31"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '<?= $marketing["data"]["google_analytics"] ?>');
    </script>

    <?php
}


//onesignal
if (!empty($marketing['data']['onesignal'])) {
    ?>
    <link rel="manifest" href="/manifest.json"/>
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        var OneSignal = window.OneSignal || [];
        OneSignal.push(function () {
            OneSignal.init({
                appId: "<?= $marketing["data"]["onesignal"] ?>",
            });
        });
    </script>
    <?php
}

//pixel facebook
if (!empty($marketing['data']['facebook_pixel'])) {
    ?>
    <!-- Facebook Pixel Code -->
    <script>
        !function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?= $marketing['data']['facebook_pixel'] ?>');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1"
             src="https://www.facebook.com/tr?id=<?= $marketing['data']['facebook_pixel'] ?>&ev=PageView
&noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->
    <?php
}
?>

<!-- Modernizr JS -->

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link href="<?= URL ?>/assets/css/progress-wizard.min.css" rel="stylesheet">

<link rel='stylesheet' href='<?= URL ?>/assets/plugins/goodlayers-core/plugins/combine/style.css' type='text/css' media='all'/>
<link rel='stylesheet' href='<?= URL ?>/assets/plugins/goodlayers-core/include/css/page-builder.css' type='text/css' media='all'/>
<link rel='stylesheet' href='<?= URL ?>/assets/plugins/revslider/public/assets/css/settings.css' type='text/css' media='all'/>
<link rel='stylesheet' href='<?= URL ?>/assets/css/style-core.css' type='text/css' media='all'/>
<link rel='stylesheet' href='<?= URL ?>/assets/css/kingster-style-custom.css' type='text/css' media='all'/>
<link rel='stylesheet' href='<?= URL ?>/assets/css/owl.carousel.min.css' type='text/css' media='all'/>
<link rel='stylesheet' href='<?= URL ?>/assets/css/owl.theme.default.min.css' type='text/css' media='all'/>

<link href="https://fonts.googleapis.com/css?family=Playfair+Display:700%2C400" rel="stylesheet" property="stylesheet" type="text/css" media="all">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins%3A100%2C100italic%2C200%2C200italic%2C300%2C300italic%2Cregular%2Citalic%2C500%2C500italic%2C600%2C600italic%2C700%2C700italic%2C800%2C800italic%2C900%2C900italic%7CABeeZee%3Aregular%2Citalic&amp;subset=latin%2Clatin-ext%2Cdevanagari&amp;ver=5.0.3' type='text/css' media='all'/>

<link rel="stylesheet" href="<?= URL ?>/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= URL ?>/assets/css/main-rocha.css">
<link rel="stylesheet" href="<?= URL ?>/assets/css/estilos-rocha.css">
<link rel="stylesheet" href="<?= URL ?>/assets/css/select2.min.css">
<link rel="stylesheet" href="<?= URL ?>/assets/css/loading.css">
<link rel="stylesheet" href="<?= URL ?>/assets/css/checkout-estudiorocha.css">
