<?php
$table = "<table>";
$table .= "<tr><td><b>FORMULARIO DE APERTURA Y/O MODIFICACIÓN DE CUENTAS CORRIENTES</b></td></tr>";
$table .= "<tr><td></td></tr>";
$table .= "<tr><td><div style='text-align: center;background-color: black'>";
$table .= "<h4 style='color:#e5b509'>DATOS GENERALES DE LA CUENTA</h4>";
$table .= "</div></td></tr>";

$table .= "<tr><td><b>RESPONSABLE DE LA CUENTA: </b>" . $data['responsable'] . "</td></tr>";
$table .= "<tr><td><br><b>ZONA: </b>" . $data['zona'] . "</td></tr>";
$table .= "<tr><td><br><b>APELLIDO NOMBRE / RAZON SOCIAL: </b>" . $data['razon'] . "</td></tr>";
$table .= "<tr><td><br><b>NOMBRE COMERCIAL: </b>" . $data['nombre'] . "</td></tr>";
$table .= "<tr><td><br><b>CALLE: </b>" . $data['calle'] . "</td></tr>";
$table .= "<tr><td><br><b>NUMERO: </b>" . $data['numero'] . "</td></tr>";
$table .= "<tr><td><br><b>C.P.: </b>" . $data['postal'] . "</td></tr>";
$table .= "<tr><td><br><b>PROVINCIA: </b>" . $data['provincia'] . "</td></tr>";
$table .= "<tr><td><br><b>LOCALIDAD: </b>" . $data['localidad'] . "</td></tr>";
$table .= "<tr><td><br><b>TELÉFONO FIJO: </b>" . $data['telefonoFijo'] . "</td></tr>";
$table .= "<tr><td><br><b>CELULAR ADMINISTRACION: </b>" . $data['celularAdm'] . "</td></tr>";
$table .= "<tr><td><br><b>CELULAR COMPRA: </b>" . $data['celularCompra'] . "</td></tr>";
$table .= "<tr><td><br><b>CORREO ELECTRONICO: </b>" . $data['email'] . "</td></tr>";
$table .= "<tr><td><br><b>CORREO ELECTRONICO COMPRA: </b>" . $data['emailCompra'] . "</td></tr>";
$table .= "<tr><td><br><b>TIPO SOCIETARIO: </b>" . $data['tipoSocietario'] . "</td></tr>";

$table .= "<tr><td><div style='text-align: center;background-color: black'>";
$table .= "<h4 style='color:#e5b509'>DATOS IMPOSITIVOS</h4>";
$table .= "</div></td></tr>";
$table .= "<tr><td><b>CUIT: </b>" . $data['cuit'] . "</td></tr>";
$table .= "<tr><td><br><b>IMPUESTO AL VALOR AGREGADO: </b>" . $data['impuestoAgregado'] . "</td></tr>";
$table .= "<tr><td><br><b>IMPUESTO A LAS GANANCIAS: </b>" . $data['impuestoGanancia'] . "</td></tr>";
$table .= "<tr><td><br><b>IMPUESTO A LOS INGRESOS BRUTOS: </b>" . $data['impuestoBrutos'] . "</td></tr>";
$table .= "<tr><td><br><b>Nº INSCRIPCION: </b>" . $data['numeroInscripcion'] . "</td></tr>";

$table .= "<tr><td><div style='text-align: center;background-color: black'>";
$table .= "<h4 style='color:#e5b509'>DATOS COMERCIALES</h4>";
$table .= "</div></td></tr>";
$table .= "<tr><td><div style='width: 100%'>";

foreach ($data['transportes'] as $key => $transporte) {
    if (!empty($data['transportes'][$key]['calle'])
        && !empty($data['transportes'][$key]['numero'])
        && !empty($data['transportes'][$key]['localidad'])
        && !empty($data['transportes'][$key]['provincia'])
        && !empty($data['transportes'][$key]['transporte'])
        && !empty($data['transportes'][$key]['transporteTelefono'])) {
        $ship = ($data['transportes'][$key]['tipo'] == 1 ? "TRANSPORTE" : "REDESPACHO");
        $table .= "<div style='width: 50%;display:inline-block'>";
        $table .= "<b>CALLE: </b>" . $data['transportes'][$key]['calle'];
        $table .= "<br><b>Nº: </b>" . $data['transportes'][$key]['numero'];
        $table .= "<br><b>LOCALIDAD: </b>" . $data['transportes'][$key]['localidad'];
        $table .= "<br><b>PROVINCIA: </b>" . $data['transportes'][$key]['provincia'];
        $table .= "<br><b>$ship: </b>" . $data['transportes'][$key]['transporte'];
        $table .= "<br><b>TELEFONO: </b>" . $data['transportes'][$key]['transporteTelefono'];
        $table .= "</div>";
    }
}
$table .= "</div></td></tr>";

$table .= "<tr><td></td></tr>";
$table .= "<tr><td><div style='text-align: center;background-color: black'>";
$table .= "<h4 style='color:#e5b509'>REFERENCIAS COMERCIALES Y BANCARIAS PROPUESTAS</h4>";
$table .= "</div></td></tr><tr><td>";


if (!empty($data['referencias'])) {
    foreach ($data['referencias'] as $key => $refs) {
        $ref = $key + 1;
        $table .= "<b>REFERENCIA Nº$ref</b>";
        $table .= "<br><b>RAZON SOCIAL: </b>" . $data['referencias'][$key]['razon'];
        $table .= "<br><b>CONTACTO: </b>" . $data['referencias'][$key]['contacto'];
        $table .= "<br><b>RUBRO: </b>" . $data['referencias'][$key]['rubro'];
        $table .= "<br><b>TELEFONO: </b>" . $data['referencias'][$key]['telefono'];
        $table .= "<br><b>OBSERVACION:</b> ";
        $table .= "<br><br>";
    }
} else {
    $table .= "<b>NO APLICA: SELECCIONO PAGO ANTICIPADO.</b><tr><td></td></tr>";
}

$table .= "</td></tr><tr><td><div style='text-align: center;background-color: black'>";
$table .= "<h4 style='color:#e5b509'>NOMBRE DE LA PERSONA DE EVER WEAR QUE LO ATIENDE/VISITA</h4>";
$table .= "</div></td></tr>";
if (!empty($data['nombreViajante'])) {
    $table .= "<tr><td><b>" . $data['nombreViajante'] . "</b></td></tr>";
} else {
    $table .= "<tr><td><b>SIN ESPECIFICAR.</b></td></tr>";
}

$table .= "</table>";