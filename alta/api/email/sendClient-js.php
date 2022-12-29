<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();
$enviar = new Clases\Email();
$config = new Clases\Config();
$cuentaCorriente = new Clases\CuentasCorrientes();
$transporte = new Clases\Transportes();
$referencias = new Clases\Referencias();
$archivos = new Clases\Archivos();
$usuario = new Clases\Usuarios();
$emailData = $config->viewEmail();

$id = $funciones->antihack_mysqli(isset($_POST['id']) ? $_POST['id'] : '');
if (!empty($id)) {
    $cuentaCorriente->set("id", $id);
    $cuentaCorrienteData = $cuentaCorriente->viewById();
    if (!empty($cuentaCorrienteData['data'])) {
        $usuario->set("cod", $cuentaCorrienteData['data']['usuario']);
        $usuarioData = $usuario->view();
        $message = "<h1 style='text-align: center'>FORMULARIO DE APERTURA Y/O MODIFICACIÓN DE CUENTAS CORRIENTES</h1>";
        $message .= "<hr>";
        $message .= "<div style='text-align: center;background-color: black'>";
        $message .= "<h4 style='color:#e5b509'>DATOS GENERALES DE LA CUENTA</h4>";
        $message .= "</div>";

//        if ($usuarioData['data']['cod'] != 'e3f6251f0f') {
//            $message .= "<b>VIAJANTE: </b>" . $usuarioData['data']['nombre']." ".$usuarioData['data']['apellido'];
//        }

        $message .= "<b>RESPONSABLE DE LA CUENTA: </b>" . $cuentaCorrienteData['data']['responsable'];
        $message .= "<br><b>ZONA: </b>" . $cuentaCorrienteData['data']['zona'];
        $message .= "<br><b>APELLIDO NOMBRE / RAZON SOCIAL: </b>" . $cuentaCorrienteData['data']['razon_social'];
        $message .= "<br><b>NOMBRE COMERCIAL: </b>" . $cuentaCorrienteData['data']['nombre_comercial'];
        $message .= "<br><b>CALLE: </b>" . $cuentaCorrienteData['data']['calle'];
        $message .= "<br><b>NUMERO: </b>" . $cuentaCorrienteData['data']['numero'];
        $message .= "<br><b>C.P.: </b>" . $cuentaCorrienteData['data']['postal'];
        $message .= "<br><b>PROVINCIA: </b>" . $cuentaCorrienteData['data']['provincia'];
        $message .= "<br><b>LOCALIDAD: </b>" . $cuentaCorrienteData['data']['localidad'];
        $message .= "<br><b>TELÉFONO FIJO: </b>" . $cuentaCorrienteData['data']['telefono'];
        $message .= "<br><b>CELULAR ADMINISTRACIÓN: </b>" . $cuentaCorrienteData['data']['celular_adm'];
        $message .= "<br><b>CELULAR COMPRA: </b>" . $cuentaCorrienteData['data']['celular_compra'];
        $message .= "<br><b>CORREO ELECTRÓNICO: </b>" . $cuentaCorrienteData['data']['email'];
        $message .= "<br><b>CORREO ELECTRÓNICO COMPRA: </b>" . $cuentaCorrienteData['data']['email_compra'];
        $message .= "<br><b>TIPO SOCIETARIO: </b>" . $cuentaCorrienteData['data']['tipo_societario'];

        $message .= "<div style='text-align: center;background-color: black'>";
        $message .= "<h4 style='color:#e5b509'>DATOS IMPOSITIVOS</h4>";
        $message .= "</div>";
        $message .= "<b>CUIT: </b>" . $cuentaCorrienteData['data']['cuit'];
        $message .= "<br><b>IMPUESTO AL VALOR AGREGADO: </b>" . $cuentaCorrienteData['data']['impuesto_agregado'];
        $message .= "<br><b>IMPUESTO A LAS GANANCIAS: </b>" . $cuentaCorrienteData['data']['impuesto_ganancia'];
        $message .= "<br><b>IMPUESTO A LOS INGRESOS BRUTOS: </b>" . $cuentaCorrienteData['data']['impuesto_brutos'];
        $message .= "<br><b>Nº INSCRIPCIÓN: </b>" . $cuentaCorrienteData['data']['numero_inscripcion'];

        $message .= "<div style='text-align: center;background-color: black'>";
        $message .= "<h4 style='color:#e5b509'>DATOS COMERCIALES</h4>";
        $message .= "</div>";
        $message .= "<div style='width: 100%'>";
        $transporteData = $transporte->list(["id_cuenta_corriente=$id"], '', '');
        foreach ($transporteData as $trans) {
            $ship = ($trans['data']['tipo'] == 1 ? "TRANSPORTE" : "REDESPACHO");
            $message .= "<div style='width: 50%;display:inline-block'>";
            $message .= "<b>CALLE: </b>" . $trans['data']['calle'];
            $message .= "<br><b>Nº: </b>" . $trans['data']['numero'];
            $message .= "<br><b>LOCALIDAD: </b>" . $trans['data']['localidad'];
            $message .= "<br><b>PROVINCIA: </b>" . $trans['data']['provincia'];
            $message .= "<br><b>$ship: </b>" . $trans['data']['transporte_1'];
            $message .= "<br><b>TELEFONO: </b>" . $trans['data']['transporte_1_telefono'];
            $message .= "</div>";
        }
        $message .= "</div>";

        $message .= "<div style='text-align: center;background-color: black'>";
        $message .= "<h4 style='color:#e5b509'>REFERENCIAS COMERCIALES Y BANCARIAS PROPUESTAS</h4>";
        $message .= "</div>";

        $referenciasData = $referencias->list(["id_cuenta_corriente=$id"], 'id ASC', '');
        if (!empty($referenciasData)) {
            foreach ($referenciasData as $key => $refs) {
                $ref = $key + 1;
                $message .= "<b>REFERENCIA Nº$ref</b>";
                $message .= "<br><b>RAZÓN SOCIAL: </b>" . $refs['data']['razon_social'];
                $message .= "<br><b>CONTACTO: </b>" . $refs['data']['contacto'];
                $message .= "<br><b>RUBRO: </b>" . $refs['data']['rubro'];
                $message .= "<br><b>TELÉFONO: </b>" . $refs['data']['telefono'];
                $message .= "<br><br>";
            }
        } else {
            $message .= "<b>NO APLICA: SELECCIONÓ PAGO ANTICIPADO.</b>";
        }

        $message .= "<div style='text-align: center;background-color: black'>";
        $message .= "<h4 style='color:#e5b509'>NOMBRE DE LA PERSONA DE EVER WEAR QUE LO ATIENDE/VISITA</h4>";
        $message .= "</div>";
        if (!empty($cuentaCorrienteData['data']['nombre_viajante'])) {
            $message .= "<b>" . $cuentaCorrienteData['data']['nombre_viajante'] . "</b>";
        } else {
            $message .= "<b>SIN ESPECIFICAR.</b>";
        }

        $replicaExcel = file_get_contents(URL . "/api/excel/generateExcel.php?id=" . $id, false, stream_context_create(["ssl" => ["verify_peer" => false, "verify_peer_name" => false]]));
        file_put_contents(dirname(__DIR__, 2) . "/assets/archivos/excel/replicaExcel-" . $id . ".xls", $replicaExcel);

        $archivosData = $archivos->list(["id_cuenta_corriente=$id"], '', '');
        $attachmentArray[] = dirname(__DIR__, 2) . '/assets/archivos/excel/replicaExcel-' . $id . '.xls';
        foreach ($archivosData as $arch) {
            $url = dirname(__DIR__, 2) . '/' . $arch['data']['ruta'];
            $attachmentArray[] = $url;
        }

        $enviar->set("attachment", $attachmentArray);
        $enviar->set("asunto", "NUEVO FORMULARIO DE APERTURA");
        $enviar->set("receptor", "webestudiorocha@gmail.com");
        $enviar->set("emisor", $emailData['data']['remitente']);
        $enviar->set("mensaje", $message);
        $enviar->emailEnviar();

        if (isset($usuarioData['data']['email']) && !empty($usuarioData['data']['email'])) {
            $enviar->set("attachment", "");
            $enviar->set("receptor", $usuarioData['data']['email']);
            $enviar->set("mensaje", "Formulario cargado correctamente para " . $cuentaCorrienteData['data']['responsable']);
            $enviar->emailEnviar();
        }elseif(isset($cuentaCorrienteData['data']['email']) && !empty($cuentaCorrienteData['data']['email'])){
            $enviar->set("attachment", "");
            $enviar->set("receptor", $cuentaCorrienteData['data']['email']);
            $enviar->set("mensaje", "Formulario cargado correctamente para " . $cuentaCorrienteData['data']['responsable']);
            $enviar->emailEnviar();
        }

        //json start
        $json = file_get_contents('sendClientStatus.json');
        $json = json_decode($json, true);

        $array = ["id" => $id];

        array_push($json, $array);

        $fp = fopen(dirname(__DIR__, 2) . '/api/email/sendClientStatus.json', 'w');
        fwrite($fp, json_encode($json, JSON_UNESCAPED_UNICODE));
        fclose($fp);
        //json end

//      $enviar->set("receptor", "cuentascorrientes@everwear.com.ar");
//      $enviar->emailEnviar();

//      $enviar->set("receptor", "cuentascorrientes2@everwear.com.ar");
//      $enviar->emailEnviar();
    }
}