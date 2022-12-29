<?php

namespace Clases;

class TemplateAdmin
{

    public $title;
    public $keywords;
    public $description;
    public $favicon;
    public $canonical;

    public function themeInit($pagesCustom)
    {
        echo '<!DOCTYPE html><html lang="es">';
        echo '<head>';
        echo "<link rel='shortcut icon' href='$this->favicon'>";
        include("inc/header.inc.php");
        echo '</head><body>';
        include "inc/nav.inc.php";
        echo '<div class="container-fluid pb-100">';
    }

    public function themeEnd()
    {
        echo '</div></body>';
        include("inc/footer.inc.php");
        echo '</html >';
    }

    public function set($atributo, $valor)
    {
        if (!empty($valor)) {
            $valor = "'" . $valor . "'";
        } else {
            $valor = "NULL";
        }
        $this->$atributo = $valor;
    }

    public function get($atributo)
    {
        return $this->$atributo;
    }
}
