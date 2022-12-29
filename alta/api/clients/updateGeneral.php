<?php
require_once dirname(__DIR__, 2) . "/Config/Autoload.php";
Config\Autoload::run();
$funciones = new Clases\PublicFunction();
$cuentaCorriente = new Clases\CuentasCorrientes();

//DATOS GENERALES DE LA CUENTA
$id = $funciones->antihack_mysqli(isset($_POST['id']) ? $_POST['id'] : '');

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

$cuentaCorriente->__set("id", $id);
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
$cuentaCorriente->set("usuario", $_SESSION['usuarios']['cod']);

$response = $cuentaCorriente->update();
if ($response) {
    echo json_encode(["status" => true,"message"=>"Datos generales de la cuenta guardados correctamente."]);
} else {
    echo json_encode(["status" => false, "message" => "Completar los campos correctamente."]);
}