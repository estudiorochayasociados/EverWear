<?php
require_once "../../Config/Autoload.php";
Config\Autoload::runSitio();
$template = new Clases\TemplateSite();
$terminales = new Clases\Terminales();

$search = (isset($_GET["search"])) ? $_GET["search"] : null;

if (!empty($search)) {

    $terminalesArray = $terminales->list($search, "", "20");

    $terminalesJson = [];
    foreach ($terminalesArray as $terminal) {
        $terminalesJson[] = str_replace('"', '', $terminal["data"]);
    }

    if (!empty($terminalesJson)) {
        echo json_encode($terminalesJson);
    } else {
        echo "error";
    }
} else {
    echo "error";
}
