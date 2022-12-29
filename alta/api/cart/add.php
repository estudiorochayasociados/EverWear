<?php
require_once "../../Config/Autoload.php";
Config\Autoload::runCurl();
$funciones = new Clases\PublicFunction();
$carrito = new Clases\Carrito();
$producto = new Clases\Productos();
$atributo = new Clases\Atributos();
$subatributo = new Clases\Subatributos();
$combinacion = new Clases\Combinaciones();
$detalleCombinacion = new Clases\DetalleCombinaciones();
$checkout = new Clases\Checkout();

$product = $funciones->antihack_mysqli(isset($_POST['product']) ? $_POST['product'] : '');
$amount = $funciones->antihack_mysqli(isset($_POST['amount']) ? $_POST['amount'] : '');
if (!empty($product)) {
    $ERROR = '';
    $carroEnvio = $carrito->checkEnvio();
    if ($carroEnvio != '') {
        $carrito->delete($carroEnvio);
    }

    $carroPago = $carrito->checkPago();
    if ($carroPago != '') {
        $carrito->delete($carroPago);
    }
    $producto->set("cod", $product);
    $productoData = $producto->view();

    if (!empty($productoData['data'])) {
        if ($productoData['data']['stock'] >= $amount) {

            $carrito->set("id", $productoData['data']['cod']);
            $carrito->set("cantidad", $amount);
            $carrito->set("titulo", $productoData['data']['titulo']);

            //CARGA DE PRECIO EN LA COMPRA
            $carrito->set("precio", $productoData['data']['precio']);

            if (!empty($_SESSION['usuarios'])) {
                if ($_SESSION['usuarios']['invitado'] != 1 || $_SESSION["usuarios"]["minorista"] == 1) {
                    $carrito->set("precio", $productoData['data']['precio']);
                } else {
                    if (!empty($productoData['data']['precio_mayorista'])) {
                        $carrito->set("precio", $productoData['data']['precio_mayorista']);
                    } else {
                        if (!empty($productoData['data']['precio_descuento'])) {
                            if ($productoData['data']['precio_descuento'] > 0 && $productoData['data']['precio_descuento'] < ['data']['precio']) {
                                $carrito->set("precio", $productoData['data']['precio_descuento']);
                            }
                        }
                    }
                }
            } else {
                if (!empty($productoData['data']['precio_descuento'])) {
                    if ($productoData['data']['precio_descuento'] > 0 && $productoData['data']['precio_descuento'] < $productoData['data']['precio']) {
                        $carrito->set("precio", $productoData['data']['precio_descuento']);
                    }
                }
            }
            //
            $opciones = '';
            //CARGA DE STOCK PESO Y OPCIONES
            $carrito->set("stock", $productoData['data']['stock']);
            $carrito->set("peso", number_format($productoData['data']['peso'], 2, ".", ""));
            $carrito->set("opciones", $opciones);
            //

            //SI VIENE ATRIBUTO
            if (!empty($_POST['atribute'])) {
                $opcion = '| ';
                $atri;
                foreach ($_POST['atribute'] as $key => $atrib) {
                    $atributo->set("cod", $key);
                    $titulo = $atributo->view()['atribute']['value'];
                    $subatributo->set("cod", $atrib);
                    $sub = $subatributo->view()['data']['value'];
                    $opcion .= "<strong>$titulo: </strong>$sub | ";
                    $atri[] = array($titulo => $sub);
                }
                $opciones = array("texto" => $opcion, "subatributos" => $atri);
                $carrito->set("opciones", $opciones);
            }

            //SI TIENE COMBINACION
            if (!empty($_POST['combination'])) {
                $resultValidate = $combinacion->check($_POST['atribute'], $product);
                if ($resultValidate['result'] === 1) {
                    $detalleCombinacion->set("codCombinacion", $resultValidate['combination']);
                    $detalleData = $detalleCombinacion->view();

                    if (!empty($detalleData)) {
                        $carrito->set("precio", $detalleData['precio']);
                        if (!empty($_SESSION['usuarios'])) {
                            if ($_SESSION['usuarios']['invitado'] != 1 || $_SESSION["usuarios"]["minorista"] == 1) {
                                $carrito->set("precio", $detalleData['precio']);
                            } else {
                                if (!empty($detalleData['mayorista'])) {
                                    $carrito->set("precio", $detalleData['mayorista']);
                                }
                            }
                        }

                        $opciones = array("texto" => $opcion, "combinacion" => $detalleData);

                        $carrito->set("stock", $detalleData['stock']);
                        $carrito->set("peso", number_format($productoData['data']['peso'], 2, ".", ""));
                        $carrito->set("opciones", $opciones);
                    } else {
                        $ERROR = 'Ocurrió un error, intente nuevamente.';
                    }
                } else {
                    $ERROR = 'LO SENTIMOS NO HAY PRODUCTOS CON ESOS ATRIBUTOS.';
                }
            }
            if (!empty($ERROR)) {
                $result = array("status" => false, "message" => $ERROR);
                echo json_encode($result);
            } else {
                if ($amount <= $productoData['data']['stock']) {
                    if ($carrito->add()) {
                        $checkout->destroy();
                        $_SESSION['latest'] = $productoData['data']['titulo'];
                        $result = array("status" => true);
                        echo json_encode($result);
                    } else {
                        $result = array("status" => false, "message" => "LO SENTIMOS NO CONTAMOS CON ESA CANTIDAD EN STOCK, COMPRUEBE SI YA POSEE ESTE PRODUCTO EN SU CARRITO.");
                        echo json_encode($result);
                    }
                } else {
                    $result = array("status" => false, "message" => "LO SENTIMOS NO CONTAMOS CON ESA CANTIDAD EN STOCK.");
                    echo json_encode($result);
                }
            }
        } else {
            $result = array("status" => false, "message" => "Ocurrió un error, recargar la página.");
            echo json_encode($result);
        }
    } else {
        $result = array("status" => false, "message" => "Ocurrió un error, recargar la página.");
        echo json_encode($result);
    }
} else {
    $result = array("status" => false, "message" => "Ocurrió un error, recargar la página.");
    echo json_encode($result);
}