<?php

namespace Clases;

class Carrito
{
    //Atributos
    public $id;
    public $titulo;
    public $cantidad;
    public $peso;
    public $precio;
    public $opciones;
    public $link;
    public $stock;
    public $descuento;
    private $con;


    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
    }

    public function set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function get($atributo)
    {
        return $this->$atributo;
    }

    public function add()
    {
        if (!isset($_SESSION["carrito"])) {
            $_SESSION["carrito"] = array();
        }

        $condition = '';

        if ($this->id != "Envio-Seleccion" && $this->id != "Metodo-Pago") {
            if (isset($_SESSION['usuarios'])) {
                if (!empty($_SESSION['usuarios'])) {
                    if ($_SESSION['usuarios']['invitado'] != 1) {
                        if ($_SESSION['usuarios']['descuento'] != 0) {
                            $valor = ($this->precio * $_SESSION['usuarios']['descuento']) / 100;
                            $this->set("precio", $this->precio - $valor);
                        }
                    }
                }
            }
        }
        $add = array('id' => $this->id, 'titulo' => $this->titulo, 'cantidad' => $this->cantidad, 'precio' => $this->precio, 'stock' => $this->stock, 'peso' => $this->peso, 'opciones' => $this->opciones, 'link' => $this->link, 'descuento' => $this->descuento);

        if (count($_SESSION["carrito"]) == 0) {
            array_push($_SESSION["carrito"], $add);
            return true;
        } else {
            for ($i = 0; $i < count($_SESSION["carrito"]); $i++) {
                if (is_array($_SESSION["carrito"][$i]["opciones"])) {
                    if (is_array($this->opciones)) {
                        $opcion = $this->opciones;
                        if (isset($_SESSION['carrito'][$i]['opciones']['combinacion'])) {
                            if ($_SESSION["carrito"][$i]["id"] == $this->id && $_SESSION["carrito"][$i]["opciones"]['combinacion']['cod_combinacion'] === $opcion['combinacion']['cod_combinacion']) {
                                $condition = $i;
                            }
                        } else {
                            if (isset($_SESSION['carrito'][$i]['opciones']['subatributos'])) {
                                if ($_SESSION["carrito"][$i]["id"] == $this->id && $_SESSION["carrito"][$i]["opciones"]['subatributos'] === $opcion['subatributos']) {
                                    $condition = $i;
                                }
                            }
                        }
                    }
                } else {
                    if ($_SESSION["carrito"][$i]["id"] == $this->id) {
                        $condition = $i;
                    }
                }
            }

            if (is_numeric($condition)) {
                $stock_carrito = $_SESSION["carrito"][$condition]["cantidad"] + $add["cantidad"];
                if ($stock_carrito <= $add["stock"]) {
                    $_SESSION["carrito"][$condition]["cantidad"] = $_SESSION["carrito"][$condition]["cantidad"] + $this->cantidad;
                    return true;
                } else {
                    return false;
                }
            } else {
                array_push($_SESSION["carrito"], $add);
                return true;
            }
        }
    }

    public function return()
    {
        if (!isset($_SESSION["carrito"])) {
            $_SESSION["carrito"] = array();
            return $_SESSION["carrito"];
        } else {
            return $_SESSION["carrito"];
        }
    }

    public function finalWeight()
    {
        $peso = 0;
        foreach ($_SESSION["carrito"] as $carrito) {
            $peso += ($carrito["peso"] * $carrito["cantidad"]);
        }
        return $peso;
    }

    public function totalPrice()
    {
        $precio = 0;
        for ($i = 0; $i < count($_SESSION["carrito"]); $i++) {
            $precio += ($_SESSION["carrito"][$i]["precio"] * $_SESSION["carrito"][$i]["cantidad"]);
        }
        return $precio;
    }

    public function precioSinMetodoDePago()
    {
        $precio = 0;
        foreach ($_SESSION["carrito"] as $key => $val) {
            if ($val['id'] != "Metodo-Pago") {
                $precio += ($val["precio"] * $val["cantidad"]);
            }
        }
        return $precio;
    }

    public function delete($key)
    {
        unset($_SESSION["carrito"][$key]);
        $_SESSION["carrito"] = array_values($_SESSION["carrito"]);
    }

    public function edit($key)
    {
        if (array_key_exists($key, $_SESSION["carrito"])) {
            $_SESSION["carrito"][$key]["cantidad"] = $this->cantidad;
        }
    }

    public function destroy()
    {
        unset($_SESSION["carrito"]);
        $_SESSION["carrito"] = array();
    }

    public function checkEnvio()
    {
        foreach ($_SESSION["carrito"] as $key => $val) {
            if ($val['id'] === "Envio-Seleccion") {
                return $key;
            }
        }
        return null;
    }

    public function checkPago()
    {
        foreach ($_SESSION["carrito"] as $key => $val) {
            if ($val['id'] === "Metodo-Pago") {
                return $key;
            }
        }
        return null;
    }
}
