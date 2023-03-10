<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous" />
<link rel="stylesheet" href="https://bootswatch.com/4/simplex/bootstrap.min.css" />
<link rel="stylesheet" href="<?= URL_ADMIN ?>/css/style.css" />
<link href="<?= URL_ADMIN ?>/css/jquery.magicsearch.css" rel="stylesheet">
<meta charset="UTF-8" />
<title><?= TITULO_ADMIN ?></title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?= URL_ADMIN ?>/js/bootstrap-input-spinner.js"></script>
<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
<link href="<?= URL_ADMIN ?>/css/tagify.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/css/loading.css" />
<link rel="stylesheet" type="text/css" href="<?= URL_ADMIN ?>/css/loading-btn.css" />
<?php
$config = new Clases\Config();
$meli = new Meli($config->meli["data"]["app_id"], $config->meli["data"]["app_secret"]);
?>