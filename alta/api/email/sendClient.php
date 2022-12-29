<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();
$enviar = new Clases\Email();
$config = new Clases\Config();

$emailData = $config->viewEmail();

$data = [];

$data["cod"] = isset($_POST["cod"]) ? $funciones->antihack_mysqli($_POST["cod"]) : '';
$data["userEmail"] = isset($_POST["userEmail"]) ? $funciones->antihack_mysqli($_POST["userEmail"]) : '';
?>

<head>
    <link rel="stylesheet" href="<?= URL ?>/assets/theme/css/bootstrap/css/bootstrap.min.css">
</head>

<?php
if (!empty($data['cod'])) {
    //DATOS GENERALES DE LA CUENTA
    $data["email-confirmacion"] = isset($_POST['email-confirmacion']) ? $funciones->antihack_mysqli($_POST['email-confirmacion']) : '';
    $data["responsable"] = isset($_POST['f1-responsable']) ? $funciones->antihack_mysqli($_POST['f1-responsable']) : '';
    $data["zona"] = isset($_POST['f1-zona']) ? $funciones->antihack_mysqli($_POST['f1-zona']) : '';
    $data["razon"] = isset($_POST['f1-razon']) ? $funciones->antihack_mysqli($_POST['f1-razon']) : '';
    $data["nombre"] = isset($_POST['f1-nombre']) ? $funciones->antihack_mysqli($_POST['f1-nombre']) : '';
    $data["calle"] = isset($_POST['f1-calle']) ? $funciones->antihack_mysqli($_POST['f1-calle']) : '';
    $data["numero"] = isset($_POST['f1-numero']) ? $funciones->antihack_mysqli($_POST['f1-numero']) : '';
    $data["postal"] = isset($_POST['f1-postal']) ? $funciones->antihack_mysqli($_POST['f1-postal']) : '';
    $data["provincia"] = isset($_POST['f1-provincia']) ? $funciones->antihack_mysqli($_POST['f1-provincia']) : '';
    $data["localidad"] = isset($_POST['f1-localidad']) ? $funciones->antihack_mysqli($_POST['f1-localidad']) : '';
    $data["telefonoFijoZona"] = isset($_POST['f1-tel'][0]['zona']) ? $funciones->antihack_mysqli($_POST['f1-tel'][0]['zona']) : '';
    $data["telefonoFijoNumero"] = isset($_POST['f1-tel'][0]['numero']) ? $funciones->antihack_mysqli($_POST['f1-tel'][0]['numero']) : '';
    $data["telefonoFijo"] = $data["telefonoFijoZona"] . "-" . $data["telefonoFijoNumero"];
    $data["celularAdmZona"] = isset($_POST['f1-tel'][1]['zona']) ? $funciones->antihack_mysqli($_POST['f1-tel'][1]['zona']) : '';
    $data["celularAdmNumero"] = isset($_POST['f1-tel'][1]['numero']) ? $funciones->antihack_mysqli($_POST['f1-tel'][1]['numero']) : '';
    $data["celularAdm"] = $data["celularAdmZona"] . "-" . $data["celularAdmNumero"];
    $data["celularCompraZona"] = isset($_POST['f1-tel'][2]['zona']) ? $funciones->antihack_mysqli($_POST['f1-tel'][2]['zona']) : '';
    $data["celularCompraNumero"] = isset($_POST['f1-tel'][2]['numero']) ? $funciones->antihack_mysqli($_POST['f1-tel'][2]['numero']) : '';
    $data["celularCompra"] = $data["celularCompraZona"] . "-" . $data["celularCompraNumero"];
    $data["email"] = isset($_POST['f1-email']) ? $funciones->antihack_mysqli($_POST['f1-email']) : '';
    $data["emailCompra"] = isset($_POST['f1-email-compra']) ? $funciones->antihack_mysqli($_POST['f1-email-compra']) : '';
    $data["tipoSocietario"] = isset($_POST['f1-tipo-societario']) ? $funciones->antihack_mysqli($_POST['f1-tipo-societario']) : '';
    $data["tipoSocietarioOtra"] = isset($_POST['f1-tipo-societario-otra']) ? $funciones->antihack_mysqli($_POST['f1-tipo-societario-otra']) : '';
    $data["tipoSocietario"] .= "-" . $data["tipoSocietarioOtra"];

    //DATOS IMPOSITIVOS
    $data["cuit"] = isset($_POST['f2-cuit']) ? $funciones->antihack_mysqli($_POST['f2-cuit']) : '';
    $data["impuestoAgregado"] = isset($_POST['f2-imp-agregado']) ? $funciones->antihack_mysqli($_POST['f2-imp-agregado']) : '';
    $data["impuestoGanancia"] = isset($_POST['f2-imp-ganancias']) ? $funciones->antihack_mysqli($_POST['f2-imp-ganancias']) : '';
    $data["impuestoBrutos"] = isset($_POST['f2-imp-brutos']) ? $funciones->antihack_mysqli($_POST['f2-imp-brutos']) : '';
    $data["numeroInscripcion"] = isset($_POST['f2-inscripcion']) ? $funciones->antihack_mysqli($_POST['f2-inscripcion']) : '';

    //DATOS COMERCIALES
    $data["transportes"][0]["tipo"] = 1;
    $data["transportes"][0]["calle"] = isset($_POST['f3-t-calle']) ? $funciones->antihack_mysqli($_POST['f3-t-calle']) : '';
    $data["transportes"][0]["numero"] = isset($_POST['f3-t-numero']) ? $funciones->antihack_mysqli($_POST['f3-t-numero']) : '';
    $data["transportes"][0]["provincia"] = isset($_POST['f3-t-provincia']) ? $funciones->antihack_mysqli($_POST['f3-t-provincia']) : '';
    $data["transportes"][0]["localidad"] = isset($_POST['f3-t-localidad']) ? $funciones->antihack_mysqli($_POST['f3-t-localidad']) : '';
    $data["transportes"][0]["transporte"] = isset($_POST['f3-t-transporte-1']) ? $funciones->antihack_mysqli($_POST['f3-t-transporte-1']) : '';
    $data["transportes"][0]["transporteTelefono"] = isset($_POST['f3-t-transporte-1-t']) ? $funciones->antihack_mysqli($_POST['f3-t-transporte-1-t']) : '';


    $data["transportes"][1]["tipo"] = 2;
    $data["transportes"][1]["calle"] = isset($_POST['f3-r-calle']) ? $funciones->antihack_mysqli($_POST['f3-r-calle']) : '';
    $data["transportes"][1]["numero"] = isset($_POST['f3-r-numero']) ? $funciones->antihack_mysqli($_POST['f3-r-numero']) : '';
    $data["transportes"][1]["provincia"] = isset($_POST['f3-r-provincia']) ? $funciones->antihack_mysqli($_POST['f3-r-provincia']) : '';
    $data["transportes"][1]["localidad"] = isset($_POST['f3-r-localidad']) ? $funciones->antihack_mysqli($_POST['f3-r-localidad']) : '';
    $data["transportes"][1]["transporte"] = isset($_POST['f3-r-transporte-1']) ? $funciones->antihack_mysqli($_POST['f3-r-transporte-1']) : '';
    $data["transportes"][1]["transporteTelefono"] = isset($_POST['f3-r-transporte-1-t']) ? $funciones->antihack_mysqli($_POST['f3-r-transporte-1-t']) : '';

    //REFERENCIAS COMERCIALES Y BANCARIAS PROPUESTAS
    $data["referencias"] = [];
    if (isset($_POST['f4'])) {
        foreach ($_POST['f4'] as $key => $ref) {
            $data["referencias"][$key]["razon"] = !empty($ref["razon"]) ? $funciones->antihack_mysqli($ref["razon"]) : '';
            $data["referencias"][$key]["contacto"] = !empty($ref["contacto"]) ? $funciones->antihack_mysqli($ref["contacto"]) : '';
            $data["referencias"][$key]["rubro"] = !empty($ref["rubro"]) ? $funciones->antihack_mysqli($ref["rubro"]) : '';
            $data["referencias"][$key]["telefono"] = !empty($ref["tel"]) ? $funciones->antihack_mysqli($ref["tel"]) : '';
        }
    }

    //NOMBRE DE LA PERSONA DE EVER WEAR QUE LO ATIENDE/VISITA
    $data["nombreViajante"] = isset($_POST['f5-viajante']) ? $funciones->antihack_mysqli($_POST['f5-viajante']) : '';

    //ARCHIVOS ADJUNTOS
    $statusFile = true;
    $data["documentsArray"] = [];

    foreach ($_FILES['files']['name'] as $f => $name) {
        $prefijo = substr(md5(uniqid(rand())), 0, 12);
        $imgInicio = $_FILES["files"]["tmp_name"][$f];
        $tucadena = $_FILES["files"]["name"][$f];
        $partes = explode(".", $tucadena);
        $dom = (count($partes) - 1);
        $dominio = $partes[$dom];
        if ($dominio != '') {

            $destinoFinal = "../../assets/archivos/documentacion/" . $prefijo . "." . $dominio;
            move_uploaded_file($imgInicio, $destinoFinal);
            chmod($destinoFinal, 0777);

            if (@!filesize($destinoFinal)) {
                $statusFile = false;
            } else {
                $data["documentsArray"][] = $prefijo . "." . $dominio;
            }
        }
    }

    $message = "<h1 style='text-align: center'>FORMULARIO DE APERTURA Y/O MODIFICACIÓN DE CUENTAS CORRIENTES</h1>";
    $message .= "<hr>";
    $message .= "<div style='text-align: center;background-color: black'>";
    $message .= "<h4 style='color:#e5b509'>DATOS GENERALES DE LA CUENTA</h4>";
    $message .= "</div>";

    $message .= "<b>RESPONSABLE DE LA CUENTA: </b>" . $data['responsable'];
    $message .= "<br><b>ZONA: </b>" . $data['zona'];
    $message .= "<br><b>APELLIDO NOMBRE / RAZON SOCIAL: </b>" . $data['razon'];
    $message .= "<br><b>NOMBRE COMERCIAL: </b>" . $data['nombre'];
    $message .= "<br><b>CALLE: </b>" . $data['calle'];
    $message .= "<br><b>NUMERO: </b>" . $data['numero'];
    $message .= "<br><b>CÓDIGO POSTAL: </b>" . $data['postal'];
    $message .= "<br><b>PROVINCIA: </b>" . $data['provincia'];
    $message .= "<br><b>LOCALIDAD: </b>" . $data['localidad'];
    $message .= "<br><b>TELÉFONO FIJO: </b>" . $data['telefonoFijo'];
    $message .= "<br><b>CELULAR ADMINISTRACIÓN: </b>" . $data['celularAdm'];
    $message .= "<br><b>CELULAR COMPRA: </b>" . $data['celularCompra'];
    $message .= "<br><b>CORREO ELECTRÓNICO: </b>" . $data['email'];
    $message .= "<br><b>CORREO ELECTRÓNICO COMPRA: </b>" . $data['emailCompra'];
    $message .= "<br><b>TIPO SOCIETARIO: </b>" . $data['tipoSocietario'];

    $message .= "<div style='text-align: center;background-color: black'>";
    $message .= "<h4 style='color:#e5b509'>DATOS IMPOSITIVOS</h4>";
    $message .= "</div>";
    $message .= "<b>CUIT: </b>" . $data['cuit'];
    $message .= "<br><b>IMPUESTO AL VALOR AGREGADO: </b>" . $data['impuestoAgregado'];
    $message .= "<br><b>IMPUESTO A LAS GANANCIAS: </b>" . $data['impuestoGanancia'];
    $message .= "<br><b>IMPUESTO A LOS INGRESOS BRUTOS: </b>" . $data['impuestoBrutos'];
    $message .= "<br><b>Nº INSCRIPCIÓN: </b>" . $data['numeroInscripcion'];

    $message .= "<div style='text-align: center;background-color: black'>";
    $message .= "<h4 style='color:#e5b509'>DATOS COMERCIALES</h4>";
    $message .= "</div>";
    $message .= "<div style='width: 100%'>";

    foreach ($data['transportes'] as $key => $transporte) {
        $ship = ($data['transportes'][$key]['tipo'] == 1) ? "TRANSPORTE" : "REDESPACHO";
        $message .= "<div style='width: 50%;display:inline-block'>";
        if (!empty($data['transportes'][$key]['calle'])) $message .= "<b>CALLE: </b>" . $data['transportes'][$key]['calle'];
        if (!empty($data['transportes'][$key]['numero'])) $message .= "<br><b>Nº: </b>" . $data['transportes'][$key]['numero'];
        if (!empty($data['transportes'][$key]['localidad'])) $message .= "<br><b>LOCALIDAD: </b>" . $data['transportes'][$key]['localidad'];
        if (!empty($data['transportes'][$key]['provincia'])) $message .= "<br><b>PROVINCIA: </b>" . $data['transportes'][$key]['provincia'];
        if (!empty($data['transportes'][$key]['transporte'])) $message .= "<br><b>$ship: </b>" . $data['transportes'][$key]['transporte'];
        if (!empty($data['transportes'][$key]['transporteTelefono'])) $message .= "<br><b>TELEFONO: </b>" . $data['transportes'][$key]['transporteTelefono'];
        $message .= "</div>";
    }

    $message .= "</div>";

    $message .= "<div style='text-align: center;background-color: black'>";
    $message .= "<h4 style='color:#e5b509'>REFERENCIAS COMERCIALES Y BANCARIAS PROPUESTAS</h4>";
    $message .= "</div>";

    if (!empty($data['referencias'])) {
        foreach ($data['referencias'] as $key => $refs) {
            $ref = $key + 1;
            $message .= "<b>REFERENCIA Nº$ref</b>";
            $message .= "<br><b>RAZÓN SOCIAL: </b>" . $data['referencias'][$key]['razon'];
            $message .= "<br><b>CONTACTO: </b>" . $data['referencias'][$key]['contacto'];
            $message .= "<br><b>RUBRO: </b>" . $data['referencias'][$key]['rubro'];
            $message .= "<br><b>TELÉFONO: </b>" . $data['referencias'][$key]['telefono'];
            $message .= "<br><br>";
        }
    } else {
        $message .= "<b>NO APLICA: SELECCIONÓ PAGO ANTICIPADO.</b>";
    }

    $message .= "<div style='text-align: center;background-color: black'>";
    $message .= "<h4 style='color:#e5b509'>NOMBRE DE LA PERSONA DE EVER WEAR QUE LO ATIENDE/VISITA</h4>";
    $message .= "</div>";
    if (!empty($data['nombreViajante'])) {
        $message .= "<b>" . $data['nombreViajante'] . "</b>";
    } else {
        $message .= "<b>SIN ESPECIFICAR.</b>";
    }

    include dirname(__DIR__, 2) . "/api/excel/generateExcel.php";
    file_put_contents(dirname(__DIR__, 2) . "/assets/archivos/excel/replicaExcel-" . $data["cod"] . ".xls", utf8_decode($table));

    $attachmentArray = [];
    $attachmentArray[] = dirname(__DIR__, 2) . '/assets/archivos/excel/replicaExcel-' . $data["cod"] . '.xls';

    foreach ($data['documentsArray'] as $document) {
        $url = dirname(__DIR__, 2) . '/assets/archivos/documentacion/' . $document;
        $attachmentArray[] = $url;
    }

    $enviar->set("attachment", $attachmentArray);
    $enviar->set("asunto", "NUEVO FORMULARIO DE APERTURA");
    $enviar->set("receptor", "lmarengo11@gmail.com");
    $enviar->set("emisor", $emailData['data']['remitente']);
    $enviar->set("mensaje", $message);
    $enviar->emailEnviar();

    $enviar->set("receptor", "lmarengo11@gmail.com");
    $enviar->emailEnviar();

    if (!empty($data["email-confirmacion"])) {
        $enviar->set("attachment", "");
        $enviar->set("asunto", "NUEVO FORMULARIO DE APERTURA - EVER WEAR");
        $enviar->set("receptor", $data["email-confirmacion"]);
        $enviar->set("mensaje", "Formulario cargado correctamente.");
        $enviar->emailEnviar();
    }

    if (!empty($data['userEmail'])) {
        $enviar->set("attachment", "");
        $enviar->set("receptor", $data['userEmail']);
        $enviar->set("mensaje", "Formulario cargado correctamente para " . $data['responsable']);
        $enviar->emailEnviar();
    } else {
        $enviar->set("attachment", "");
        $enviar->set("receptor", $data['email']);
        $enviar->set("mensaje", "Formulario cargado correctamente para " . $data['responsable']);
        $enviar->emailEnviar();
    }
}
?>


<div class="container">
    <div class="alert alert-success">
        <h1>¡PLANILLA CARGADA SATISFACTORIAMENTE!</h1>
        <a href="<?= URL ?>" class="btn btn-success">INICIO</a>
    </div>
</div>