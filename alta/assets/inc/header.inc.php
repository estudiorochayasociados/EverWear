<?php
$config = new Clases\Config();
$marketing = $config->viewMarketing();
$configHeader = $config->viewConfigHeader();
echo $configHeader["data"]["content_header"];

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
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window,document,'script',
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

<!-- Libs CSS
============================================ -->
<link rel="stylesheet" href="<?= URL ?>/assets/theme/css/bootstrap/css/bootstrap.min.css">
<link href="<?= URL ?>/assets/theme/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?= URL ?>/assets/theme/js/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="<?= URL ?>/assets/theme/js/owl-carousel/owl.carousel.css" rel="stylesheet">
<link href="<?= URL ?>/assets/theme/css/themecss/lib.css" rel="stylesheet">
<link href="<?= URL ?>/assets/theme/js/jquery-ui/jquery-ui.min.css" rel="stylesheet">
<link href="<?= URL ?>/assets/theme/js/minicolors/miniColors.css" rel="stylesheet">


<!-- Theme CSS
============================================ -->
<link href="<?= URL ?>/assets/theme/css/themecss/so_searchpro.css" rel="stylesheet">
<link href="<?= URL ?>/assets/theme/css/themecss/so_megamenu.css" rel="stylesheet">
<link href="<?= URL ?>/assets/theme/css/themecss/so_advanced_search.css" rel="stylesheet">
<link href="<?= URL ?>/assets/theme/css/themecss/so-listing-tabs.css" rel="stylesheet">
<link href="<?= URL ?>/assets/theme/css/themecss/so-categories.css" rel="stylesheet">
<link href="<?= URL ?>/assets/theme/css/themecss/so-newletter-popup.css" rel="stylesheet">
<link href="<?= URL ?>/assets/theme/css/themecss/so-latest-blog.css" rel="stylesheet">

<link href="<?= URL ?>/assets/theme/css/footer/footer4.css" rel="stylesheet">
<link href="<?= URL ?>/assets/theme/css/header/header4.css" rel="stylesheet">
<link id="color_scheme" href="<?= URL ?>/assets/theme/css/home4.css" rel="stylesheet">
<link href="<?= URL ?>/assets/theme/css/responsive.css" rel="stylesheet">

<link rel="stylesheet" href="<?= URL ?>/assets/css/main-rocha.css">
<link rel="stylesheet" href="<?= URL ?>/assets/css/select2.min.css">
<link rel="stylesheet" href="<?= URL ?>/assets/css/loading.css">
<link rel="stylesheet" href="<?= URL ?>/assets/css/checkout-estudiorocha.css">
<link rel="stylesheet" href="<?= URL ?>/assets/css/estilos-rocha.css">
