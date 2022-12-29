<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();
$cuentaCorriente = new Clases\CuentasCorrientes();
$transporte = new Clases\Transportes();
$referencia = new Clases\Referencias();

//DATOS GENERALES DE LA CUENTA
$usuario = $funciones->antihack_mysqli(isset($_SESSION['usuarios']['cod']) ? $_SESSION['usuarios']['cod'] : 'invitado');
$responsable = $funciones->antihack_mysqli(isset($_POST['f1-responsable']) ? $_POST['f1-responsable'] : '');
$zona = $funciones->antihack_mysqli(isset($_POST['f1-zona']) ? $_POST['f1-zona'] : '');
$razon = $funciones->antihack_mysqli(isset($_POST['f1-razon']) ? $_POST['f1-razon'] : '');
$nombre = $funciones->antihack_mysqli(isset($_POST['f1-nombre']) ? $_POST['f1-nombre'] : '');
$calle = $funciones->antihack_mysqli(isset($_POST['f1-calle']) ? $_POST['f1-calle'] : '');
$numero = $funciones->antihack_mysqli(isset($_POST['f1-numero']) ? $_POST['f1-numero'] : '');
$postal = $funciones->antihack_mysqli(isset($_POST['f1-postal']) ? $_POST['f1-postal'] : '');
$provincia = $funciones->antihack_mysqli(isset($_POST['f1-provincia']) ? $_POST['f1-provincia'] : '');
$localidad = $funciones->antihack_mysqli(isset($_POST['f1-localidad']) ? $_POST['f1-localidad'] : '');

$telefonoFijo = $celularAdm = $celularCompra = '';
$telefonoFijoZona = $funciones->antihack_mysqli(isset($_POST['f1-tel'][0]['zona']) ? $_POST['f1-tel'][0]['zona'] : '');
$telefonoFijoNumero = $funciones->antihack_mysqli(isset($_POST['f1-tel'][0]['numero']) ? $_POST['f1-tel'][0]['numero'] : '');
if (!empty($telefonoFijoZona) && !empty($telefonoFijoNumero)) {
    $telefonoFijo = $telefonoFijoZona . "-" . $telefonoFijoNumero;
}

$celularAdmZona = $funciones->antihack_mysqli(isset($_POST['f1-tel'][1]['zona']) ? $_POST['f1-tel'][1]['zona'] : '');
$celularAdmNumero = $funciones->antihack_mysqli(isset($_POST['f1-tel'][1]['numero']) ? $_POST['f1-tel'][1]['numero'] : '');
if (!empty($celularAdmZona) && !empty($celularAdmNumero)) {
    $celularAdm = $celularAdmZona . "-" . $celularAdmNumero;
}

$celularCompraZona = $funciones->antihack_mysqli(isset($_POST['f1-tel'][2]['zona']) ? $_POST['f1-tel'][2]['zona'] : '');
$celularCompraNumero = $funciones->antihack_mysqli(isset($_POST['f1-tel'][2]['numero']) ? $_POST['f1-tel'][2]['numero'] : '');
if (!empty($celularCompraZona) && !empty($celularCompraNumero)) {
    $celularCompra = $celularCompraZona . "-" . $celularCompraNumero;
}

$email = $funciones->antihack_mysqli(isset($_POST['f1-email']) ? $_POST['f1-email'] : '');
$emailCompra = $funciones->antihack_mysqli(isset($_POST['f1-email-compra']) ? $_POST['f1-email-compra'] : '');
$tipoSocietario = $funciones->antihack_mysqli(isset($_POST['f1-tipo-societario']) ? $_POST['f1-tipo-societario'] : '');
$tipoSocietarioOtra = $funciones->antihack_mysqli(isset($_POST['f1-tipo-societario-otra']) ? $_POST['f1-tipo-societario-otra'] : '');
$tipoSocietario .= "-" . $tipoSocietarioOtra;

//DATOS IMPOSITIVOS
$cuit = $funciones->antihack_mysqli(isset($_POST['f2-cuit']) ? $_POST['f2-cuit'] : '');
$impuestoAgregado = $funciones->antihack_mysqli(isset($_POST['f2-imp-agregado']) ? $_POST['f2-imp-agregado'] : '');
$impuestoGanancia = $funciones->antihack_mysqli(isset($_POST['f2-imp-ganancias']) ? $_POST['f2-imp-ganancias'] : '');
$impuestoBrutos = $funciones->antihack_mysqli(isset($_POST['f2-imp-brutos']) ? $_POST['f2-imp-brutos'] : '');
$numeroInscripcion = $funciones->antihack_mysqli(isset($_POST['f2-inscripcion']) ? $_POST['f2-inscripcion'] : '');

//DATOS COMERCIALES
$transportes = [];
$transportes[0]["calle"] = $funciones->antihack_mysqli(isset($_POST['f3-t-calle']) ? $_POST['f3-t-calle'] : '');
$transportes[0]["tipo"] = 1;
$transportes[0]["calle"] = $funciones->antihack_mysqli(isset($_POST['f3-t-calle']) ? $_POST['f3-t-calle'] : '');
$transportes[0]["numero"] = $funciones->antihack_mysqli(isset($_POST['f3-t-numero']) ? $_POST['f3-t-numero'] : '');
$transportes[0]["provincia"] = $funciones->antihack_mysqli(isset($_POST['f3-t-provincia']) ? $_POST['f3-t-provincia'] : '');
$transportes[0]["localidad"] = $funciones->antihack_mysqli(isset($_POST['f3-t-localidad']) ? $_POST['f3-t-localidad'] : '');
$transportes[0]["transporte1"] = $funciones->antihack_mysqli(isset($_POST['f3-t-transporte-1']) ? $_POST['f3-t-transporte-1'] : '');
$transportes[0]["transporte1Telefono"] = $funciones->antihack_mysqli(isset($_POST['f3-t-transporte-1-t']) ? $_POST['f3-t-transporte-1-t'] : '');
$transportes[0]["transporte2"] = $funciones->antihack_mysqli(isset($_POST['f3-t-transporte-2']) ? $_POST['f3-t-transporte-2'] : '');
$transportes[0]["transporte2Telefono"] = $funciones->antihack_mysqli(isset($_POST['f3-t-transporte-2-t']) ? $_POST['f3-t-transporte-2-t'] : '');

$transportes[1]["calle"] = $funciones->antihack_mysqli(isset($_POST['f3-r-calle']) ? $_POST['f3-r-calle'] : '');
$transportes[1]["tipo"] = 2;
$transportes[1]["calle"] = $funciones->antihack_mysqli(isset($_POST['f3-r-calle']) ? $_POST['f3-r-calle'] : '');
$transportes[1]["numero"] = $funciones->antihack_mysqli(isset($_POST['f3-r-numero']) ? $_POST['f3-r-numero'] : '');
$transportes[1]["provincia"] = $funciones->antihack_mysqli(isset($_POST['f3-r-provincia']) ? $_POST['f3-r-provincia'] : '');
$transportes[1]["localidad"] = $funciones->antihack_mysqli(isset($_POST['f3-r-localidad']) ? $_POST['f3-r-localidad'] : '');
$transportes[1]["transporte1"] = $funciones->antihack_mysqli(isset($_POST['f3-r-transporte-1']) ? $_POST['f3-r-transporte-1'] : '');
$transportes[1]["transporte1Telefono"] = $funciones->antihack_mysqli(isset($_POST['f3-r-transporte-1-t']) ? $_POST['f3-r-transporte-1-t'] : '');
$transportes[1]["transporte2"] = $funciones->antihack_mysqli(isset($_POST['f3-r-transporte-2']) ? $_POST['f3-r-transporte-2'] : '');
$transportes[1]["transporte2Telefono"] = $funciones->antihack_mysqli(isset($_POST['f3-r-transporte-2-t']) ? $_POST['f3-r-transporte-2-t'] : '');

//REFERENCIAS COMERCIALES Y BANCARIAS PROPUESTAS
$referencias = [];
if (isset($_POST['f4'])) {
    foreach ($_POST['f4'] as $key => $ref) {
        $referencias[$key]["razon"] = $funciones->antihack_mysqli(!empty($ref["razon"]) ? $ref["razon"] : '');
        $referencias[$key]["contacto"] = $funciones->antihack_mysqli(!empty($ref["contacto"]) ? $ref["contacto"] : '');
        $referencias[$key]["rubro"] = $funciones->antihack_mysqli(!empty($ref["rubro"]) ? $ref["rubro"] : '');
        $referencias[$key]["telefono"] = $funciones->antihack_mysqli(!empty($ref["tel"]) ? $ref["tel"] : '');
    }
}
//
$check = $cuentaCorriente->list(["cuit=$cuit"], '', 1);
if (!empty($check)) {
    echo json_encode(["status" => false, "message" => "Ya existe un cliente con ese CUIT"]);
    die();
}
$nombreViajante = $funciones->antihack_mysqli(isset($_POST['f5-viajante']) ? $_POST['f5-viajante'] : '');

$cuentaCorriente->set("responsable", $responsable);
$cuentaCorriente->set("zona", $zona);
$cuentaCorriente->set("razonSocial", $razon);
$cuentaCorriente->set("nombreComercial", $nombre);
$cuentaCorriente->set("calle", $calle);
$cuentaCorriente->set("numero", $numero);
$cuentaCorriente->set("postal", $postal);
$cuentaCorriente->set("provincia", $provincia);
$cuentaCorriente->set("localidad", $localidad);
$cuentaCorriente->set("telefono", $telefonoFijo);
$cuentaCorriente->set("celularAdm", $celularAdm);
$cuentaCorriente->set("celularCompra", $celularCompra);
$cuentaCorriente->set("email", $email);
$cuentaCorriente->set("emailCompra", $emailCompra);
$cuentaCorriente->set("tipoSocietario", $tipoSocietario);
$cuentaCorriente->set("cuit", $cuit);
$cuentaCorriente->set("impuestoAgregado", $impuestoAgregado);
$cuentaCorriente->set("impuestoGanancia", $impuestoGanancia);
$cuentaCorriente->set("impuestoBrutos", $impuestoBrutos);
$cuentaCorriente->set("numeroInscripcion", $numeroInscripcion);
$cuentaCorriente->set("nombreViajante", $nombreViajante);
$cuentaCorriente->set("usuario", $usuario);

$response = $cuentaCorriente->create();

if (!$response) {
    echo json_encode(["status" => false,"message"=>"Ocurrió un error, intente nuevamente."]);
    die();
}

$cc = $response;
$transporte->set("idCuentaCorriente", $cc);

$transporte->set("calle", $transportes[0]["calle"]);
$transporte->set("numero", $transportes[0]["numero"]);
$transporte->set("provincia", $transportes[0]["provincia"]);
$transporte->set("localidad", $transportes[0]["localidad"]);
$transporte->set("transporte1", $transportes[0]["transporte1"]);
$transporte->set("transporte1Telefono", $transportes[0]["transporte1Telefono"]);
//$transporte->set("transporte2", $transportes[0]["transporte2"]);
//$transporte->set("transporte2Telefono", $transportes[0]["transporte2Telefono"]);
$transporte->set("tipo", $transportes[0]["tipo"]);
$transporte->create();

if (!empty($transportes[1]["calle"]) && !empty($transportes[1]["numero"]) && !empty($transportes[1]["localidad"]) && !empty($transportes[1]["provincia"]) && !empty($transportes[1]["transporte1"])) {
    $transporte->set("calle", $transportes[1]["calle"]);
    $transporte->set("numero", $transportes[1]["numero"]);
    $transporte->set("provincia", $transportes[1]["provincia"]);
    $transporte->set("localidad", $transportes[1]["localidad"]);
    $transporte->set("transporte1", $transportes[1]["transporte1"]);
    $transporte->set("transporte1Telefono", $transportes[1]["transporte1Telefono"]);
//$transporte->set("transporte2", $transportes[1]["transporte2"]);
//$transporte->set("transporte2Telefono", $transportes[1]["transporte2Telefono"]);
    $transporte->set("tipo", $transportes[1]["tipo"]);
    $transporte->create();
}

foreach ($referencias as $referencias_) {
    if (empty($referencias_['razon'])) continue;
    $referencia->set("idCuentaCorriente", $cc);
    $referencia->set("razonSocial", $referencias_['razon']);
    $referencia->set("contacto", $referencias_['contacto']);
    $referencia->set("rubro", $referencias_['rubro']);
    $referencia->set("telefono", $referencias_['telefono']);
    $referencia->create();
}

echo json_encode(["status" => true, "message" => "Cargado correctamente", "id" => $cc]);