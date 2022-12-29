<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();
$config = new Clases\Config();
$cuentaCorriente = new Clases\CuentasCorrientes();
$transporte = new Clases\Transportes();
$referencias = new Clases\Referencias();
$archivos = new Clases\Archivos();
$usuario = new Clases\Usuarios();

$id = $funciones->antihack_mysqli(isset($_GET['id']) ? $_GET['id'] : '');

?>
    <meta charset="UTF-8">
<?php

if (!empty($id)) {
    $cuentaCorriente->set("id", $id);
    $cuentaCorrienteData = $cuentaCorriente->viewById();
    if (!empty($cuentaCorrienteData['data'])) {
        $usuario->set("cod", $cuentaCorrienteData['data']['usuario']);
        $usuarioData = $usuario->view();
        $table = "<table>";
        $table .= "<tr><td><b>FORMULARIO DE APERTURA Y/O MODIFICACIÓN DE CUENTAS CORRIENTES</b></td></tr>";
        $table .= "<tr><td></td></tr>";
        $table .= "<tr><td><div style='text-align: center;background-color: black'>";
        $table .= "<h4 style='color:#e5b509'>DATOS GENERALES DE LA CUENTA</h4>";
        $table .= "</div></td></tr>";

//        if ($usuarioData['data']['cod'] != 'e3f6251f0f') {
//            $table .= "<b>VIAJANTE: </b>" . $usuarioData['data']['nombre']." ".$usuarioData['data']['apellido'];
//        }

        $table .= "<tr><td><b>RESPONSABLE DE LA CUENTA: </b>" . $cuentaCorrienteData['data']['responsable'] . "</td></tr>";
        $table .= "<tr><td><br><b>ZONA: </b>" . $cuentaCorrienteData['data']['zona'] . "</td></tr>";
        $table .= "<tr><td><br><b>APELLIDO NOMBRE / RAZON SOCIAL: </b>" . $cuentaCorrienteData['data']['razon_social'] . "</td></tr>";
        $table .= "<tr><td><br><b>NOMBRE COMERCIAL: </b>" . $cuentaCorrienteData['data']['nombre_comercial'] . "</td></tr>";
        $table .= "<tr><td><br><b>CALLE: </b>" . $cuentaCorrienteData['data']['calle'] . "</td></tr>";
        $table .= "<tr><td><br><b>NUMERO: </b>" . $cuentaCorrienteData['data']['numero'] . "</td></tr>";
        $table .= "<tr><td><br><b>C.P.: </b>" . $cuentaCorrienteData['data']['postal'] . "</td></tr>";
        $table .= "<tr><td><br><b>PROVINCIA: </b>" . $cuentaCorrienteData['data']['provincia'] . "</td></tr>";
        $table .= "<tr><td><br><b>LOCALIDAD: </b>" . $cuentaCorrienteData['data']['localidad'] . "</td></tr>";
        $table .= "<tr><td><br><b>TELÉFONO FIJO: </b>" . $cuentaCorrienteData['data']['telefono'] . "</td></tr>";
        $table .= "<tr><td><br><b>CELULAR ADMINISTRACIÓN: </b>" . $cuentaCorrienteData['data']['celular_adm'] . "</td></tr>";
        $table .= "<tr><td><br><b>CELULAR COMPRA: </b>" . $cuentaCorrienteData['data']['celular_compra'] . "</td></tr>";
        $table .= "<tr><td><br><b>CORREO ELECTRÓNICO: </b>" . $cuentaCorrienteData['data']['email'] . "</td></tr>";
        $table .= "<tr><td><br><b>CORREO ELECTRÓNICO COMPRA: </b>" . $cuentaCorrienteData['data']['email_compra'] . "</td></tr>";
        $table .= "<tr><td><br><b>TIPO SOCIETARIO: </b>" . $cuentaCorrienteData['data']['tipo_societario'] . "</td></tr>";

        $table .= "<tr><td><div style='text-align: center;background-color: black'>";
        $table .= "<h4 style='color:#e5b509'>DATOS IMPOSITIVOS</h4>";
        $table .= "</div></td></tr>";
        $table .= "<tr><td><b>CUIT: </b>" . $cuentaCorrienteData['data']['cuit'] . "</td></tr>";
        $table .= "<tr><td><br><b>IMPUESTO AL VALOR AGREGADO: </b>" . $cuentaCorrienteData['data']['impuesto_agregado'] . "</td></tr>";
        $table .= "<tr><td><br><b>IMPUESTO A LAS GANANCIAS: </b>" . $cuentaCorrienteData['data']['impuesto_ganancia'] . "</td></tr>";
        $table .= "<tr><td><br><b>IMPUESTO A LOS INGRESOS BRUTOS: </b>" . $cuentaCorrienteData['data']['impuesto_brutos'] . "</td></tr>";
        $table .= "<tr><td><br><b>Nº INSCRIPCIÓN: </b>" . $cuentaCorrienteData['data']['numero_inscripcion'] . "</td></tr>";

        $table .= "<tr><td><div style='text-align: center;background-color: black'>";
        $table .= "<h4 style='color:#e5b509'>DATOS COMERCIALES</h4>";
        $table .= "</div></td></tr>";
        $table .= "<tr><td><div style='width: 100%'>";
        $transporteData = $transporte->list(["id_cuenta_corriente=$id"], '', '');
        foreach ($transporteData as $trans) {
            $ship = ($trans['data']['tipo'] == 1 ? "TRANSPORTE" : "REDESPACHO");
            $table .= "<div style='width: 50%;display:inline-block'>";
            $table .= "<b>CALLE: </b>" . $trans['data']['calle'];
            $table .= "<br><b>Nº: </b>" . $trans['data']['numero'];
            $table .= "<br><b>LOCALIDAD: </b>" . $trans['data']['localidad'];
            $table .= "<br><b>PROVINCIA: </b>" . $trans['data']['provincia'];
            $table .= "<br><b>$ship: </b>" . $trans['data']['transporte_1'];
            $table .= "<br><b>TELEFONO: </b>" . $trans['data']['transporte_1_telefono'];
            $table .= "</div>";
        }
        $table .= "</div></td></tr>";

        $table .= "<tr><td></td></tr>";
        $table .= "<tr><td><div style='text-align: center;background-color: black'>";
        $table .= "<h4 style='color:#e5b509'>REFERENCIAS COMERCIALES Y BANCARIAS PROPUESTAS</h4>";
        $table .= "</div></td></tr><tr><td>";

        $referenciasData = $referencias->list(["id_cuenta_corriente=$id"], 'id ASC', '');
        if (!empty($referenciasData)) {
            foreach ($referenciasData as $key => $refs) {
                $ref = $key + 1;
                $table .= "<b>REFERENCIA Nº$ref</b>";
                $table .= "<br><b>RAZÓN SOCIAL: </b>" . $refs['data']['razon_social'];
                $table .= "<br><b>CONTACTO: </b>" . $refs['data']['contacto'];
                $table .= "<br><b>RUBRO: </b>" . $refs['data']['rubro'];
                $table .= "<br><b>TELÉFONO: </b>" . $refs['data']['telefono'];
                $table .= "<br><b>OBSERVACIÓN:</b> ";
                $table .= "<br><br>";
            }
        } else {
            $table .= "<b>NO APLICA: SELECCIONÓ PAGO ANTICIPADO.</b><tr><td></td></tr>";
        }

        $table .= "</td></tr><tr><td><div style='text-align: center;background-color: black'>";
        $table .= "<h4 style='color:#e5b509'>NOMBRE DE LA PERSONA DE EVER WEAR QUE LO ATIENDE/VISITA</h4>";
        $table .= "</div></td></tr>";
        if (!empty($cuentaCorrienteData['data']['nombre_viajante'])) {
            $table .= "<tr><td><b>" . $cuentaCorrienteData['data']['nombre_viajante'] . "</b></td></tr>";
        } else {
            $table .= "<tr><td><b>SIN ESPECIFICAR.</b></td></tr>";
        }

        $table .= "</table>";
        echo $table;
    }
}
