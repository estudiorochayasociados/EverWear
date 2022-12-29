<?php

namespace Clases;

class Clientes
{
    //Atributos
    public $id;
    public $cod;
    public $razon_social;
    public $categoria;
    public $iva;
    public $doc;
    public $estado;
    public $nombre;
    public $telefono;
    public $telefono2;
    public $celular;
    public $email;
    public $domicilio;
    public $localidad;
    public $provincia;
    public $vendedor;
    public $nombre_compras;
    public $email_compras;
    public $celular_compras;
    public $nombre_compras2;
    public $email_compras2;
    public $celular_compras2;
    public $nombre_facturacion;
    public $email_facturacion;
    public $celular_facturacion;
    public $nombre_facturacion2;
    public $email_facturacion2;
    public $celular_facturacion2;
    public $iibb;
    public $transporte;
    public $transporte_redespacho;
    private $con;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
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

    public function add()
    {
        $sql = "INSERT INTO `clientes`(cod,razon_social,categoria,iva,doc,estado,nombre,telefono,telefono2,celular,email,domicilio,localidad,provincia,vendedor,email_facturacion,celular_facturacion,iibb,transporte,transporte_redespacho) VALUES 
        ({$this->cod},{$this->razon_social},{$this->categoria},{$this->iva},{$this->doc},{$this->estado},{$this->nombre},{$this->telefono},{$this->telefono2},{$this->celular},{$this->email},{$this->domicilio},{$this->localidad},{$this->provincia},{$this->vendedor},{$this->email_facturacion},{$this->celular_facturacion},{$this->iibb},{$this->transporte},{$this->transporte_redespacho})";
        $query = $this->con->sqlReturn($sql);
        return $query;
    }

    public function edit()
    {
        $sql = "UPDATE `clientes` 
                SET 
                cod = {$this->cod},
                razon_social = {$this->razon_social},
                categoria = {$this->categoria},
                iva = {$this->iva},
                doc = {$this->doc},
                estado = {$this->estado},
                nombre = {$this->nombre},
                telefono = {$this->telefono},
                telefono2 = {$this->telefono2},
                celular = {$this->celular},
                email = {$this->email},
                domicilio = {$this->domicilio},
                localidad = {$this->localidad},
                provincia = {$this->provincia},
                vendedor = {$this->vendedor},
                iibb = {$this->iibb},
                nombre_compras= {$this->nombre_compras},
                email_compras= {$this->email_compras},
                celular_compras= {$this->celular_compras},
                nombre_compras2= {$this->nombre_compras2},
                email_compras2= {$this->email_compras2},
                celular_compras2= {$this->celular_compras2},
                nombre_facturacion= {$this->nombre_facturacion},
                email_facturacion= {$this->email_facturacion},
                celular_facturacion= {$this->celular_facturacion},
                nombre_facturacion2= {$this->nombre_facturacion2},
                email_facturacion2= {$this->email_facturacion2},
                celular_facturacion2= {$this->celular_facturacion2},
                transporte = {$this->transporte},
                transporte_redespacho = {$this->transporte_redespacho},
                `update` = NOW() 
                WHERE `id`={$this->id}";
        $query = $this->con->sqlReturn($sql);
        return $query;
    }

    public function delete()
    {
        $sql = "DELETE FROM `clientes` WHERE `id`  = {$this->id}";
        $query = $this->con->sqlReturn($sql);
        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function view()
    {
        $sql = "SELECT * FROM `clientes` WHERE id = {$this->id} ORDER BY id DESC LIMIT 1";
        $clientes = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($clientes);
        $array = array("data" => $row);
        return $array;
    }

    public function viewEncode($id)
    {
        $sql = "SELECT * FROM `clientes` WHERE id_enc = '$id' ORDER BY id DESC LIMIT 1";
        $clientes = $this->con->sqlReturn($sql);
        if ($clientes->num_rows != 0) {
            $row = mysqli_fetch_assoc($clientes);
            $array = array("data" => $row);
            return $array;
        }
    }

    function list($filter, $order, $limit)
    {
        $array = array();
        if (is_array($filter)) {
            $filterSql = "WHERE ";
            $filterSql .= implode(" AND ", $filter);
        } else {
            $filterSql = '';
        }

        if ($order != '') {
            $orderSql = $order;
        } else {
            $orderSql = "id DESC";
        }

        if ($limit != '') {
            $limitSql = "LIMIT " . $limit;
        } else {
            $limitSql = '';
        }

        $sql = "SELECT * FROM `clientes` $filterSql ORDER BY $orderSql $limitSql";
        $clientes = $this->con->sqlReturn($sql);
        if ($clientes) {
            while ($row = mysqli_fetch_assoc($clientes)) {
                $array[] = array("data" => $row);
            }
            return $array;
        }
    }
}