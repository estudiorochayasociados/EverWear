<?php

namespace Clases;

class Transportes
{
    private $DB = "transportes";

    private $id;
    private $idCuentaCorriente;
    private $calle;
    private $numero;
    private $provincia;
    private $localidad;
    private $transporte1;
    private $transporte1Telefono;
    private $transporte2;
    private $transporte2Telefono;
    private $tipo;
    private $fecha;
    private $fechaModificacion;

    private $con;

    public function __construct()
    {
        $this->con = new Conexion();
    }

    public function __set($key, $value)
    {
        $this->$key = $value;
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

    public function create()
    {
        $atributtes = [
            "id_cuenta_corriente" => $this->idCuentaCorriente,
            "calle" => $this->calle,
            "numero" => $this->numero,
            "provincia" => $this->provincia,
            "localidad" => $this->localidad,
            "transporte_1" => $this->transporte1,
            "transporte_1_telefono" => $this->transporte1Telefono,
//            "transporte_2" => $this->transporte2,
//            "transporte_2_telefono" => $this->transporte2Telefono,
            "tipo" => $this->tipo
        ];

        $count = count($atributtes) - 1;
        $head = "INSERT INTO `$this->DB` (";
        $values = "VALUES (";

        foreach ($atributtes as $key => $atributte) {
            $head .= $key;
            $values .= $atributte;
            $count != 0 ? $head .= "," : $head .= ")";
            $count != 0 ? $values .= "," : $values .= ")";
            $count--;
        }
        $sql = $head . $values;
        return $this->con->sqlReturnId($sql);
    }

    public function update()
    {
        $atributtes = [
            "calle" => $this->calle,
            "numero" => $this->numero,
            "provincia" => $this->provincia,
            "localidad" => $this->localidad,
            "transporte_1" => $this->transporte1,
            "transporte_1_telefono" => $this->transporte1Telefono,
//            "transporte_2" => $this->transporte2,
//            "transporte_2_telefono" => $this->transporte2Telefono
        ];

        $count = count($atributtes) - 1;
        $values = "";
        foreach ($atributtes as $key => $atributte) {
            $values .= $key . "=" . $atributte;
            if ($count != 0) $values .= ",";
            $count--;
        }
        $sql = "UPDATE `$this->DB` SET " . $values . " WHERE id={$this->id} AND tipo={$this->tipo}";
        return $this->con->sqlReturn($sql);
    }

    public function view()
    {
        $sql = "SELECT * FROM `$this->DB` WHERE id = {$this->id} ORDER BY id DESC LIMIT 1";
        $clientes = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($clientes);
        return ["data" => $row];
    }

    public function viewByType()
    {
        $sql = "SELECT * FROM `$this->DB` WHERE id_cuenta_corriente = {$this->idCuentaCorriente} AND tipo={$this->tipo} ORDER BY id DESC LIMIT 1";
        $clientes = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($clientes);
        return ["data" => $row];
    }

    public function list($filter, $order, $limit)
    {
        $array = [];
        if (is_array($filter)) {
            $filterSql = "WHERE ";
            $filterSql .= implode(" AND ", $filter);
        } else {
            $filterSql = '';
        }

        !empty($order) ? $orderSql = $order : $orderSql = "id DESC";

        !empty($limit) ? $limitSql = "LIMIT " . $limit : $limitSql = '';

        $sql = "SELECT * FROM `$this->DB` $filterSql ORDER BY $orderSql $limitSql";
        $clientes = $this->con->sqlReturn($sql);
        if ($clientes) {
            while ($row = mysqli_fetch_assoc($clientes)) {
                $array[] = ["data" => $row];
            }
        }
        return $array;
    }
}