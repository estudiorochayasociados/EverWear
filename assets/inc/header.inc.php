<?php
$config = new Clases\Config();
$marketing = $config->viewMarketing();
$configHeader = $config->viewConfigHeader();
echo $configHeader["data"]["content_header"];
?>
<link rel="manifest" href="/manifest.json" />
<link rel="stylesheet" href="<?= URL ?>/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?= URL ?>/assets/css/styles.css">
<link rel="stylesheet" href="<?= URL ?>/assets/css/responsive.css">
<link rel="stylesheet" href="<?= URL ?>/assets/css/animate.css">
<link rel="stylesheet" href="<?= URL ?>/assets/css/main-rocha.css">
<link rel="stylesheet" href="<?= URL ?>/assets/css/owl/owl.carousel.min.css">
<link rel="stylesheet" href="<?= URL ?>/assets/css/owl/owl.theme.default.min.css">
<link rel="stylesheet" type="text/css" href="<?= URL ?>/assets/css/toastr.css">
<link rel="stylesheet" type="text/css" href="<?= URL ?>/assets/css/owl/toastr.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

<link href="https://fonts.googleapis.com/css?family=Muli:400,700&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" />
<!--captcha-->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!-- 
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(function() {
        OneSignal.init({
            appId: "<?= $marketing["data"]["onesignal"] ?>",
        });
    });
</script> -->