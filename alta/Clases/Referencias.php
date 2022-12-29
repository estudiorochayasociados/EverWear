<?php

namespace Clases;

class Referencias
{
    private $DB = "referencias";

    private $id;
    private $idCuentaCorriente;
    private $razonSocial;
    private $contacto;
    private $rubro;
    private $telefono;
    private $detalle;
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
            "razon_social" => $this->razonSocial,
            "contacto" => $this->contacto,
            "rubro" => $this->rubro,
            "telefono" => $this->telefono
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
            "razon_social" => $this->razonSocial,
            "contacto" => $this->contacto,
            "rubro" => $this->rubro,
            "telefono" => $this->telefono,
            "detalle" => $this->detalle
        ];

        $count = count($atributtes) - 1;
        $values = "";
        foreach ($atributtes as $key => $atributte) {
            $values .= $key . "=" . $atributte;
            if ($count != 0) $values .= ",";
            $count--;
        }
        $sql = "UPDATE `$this->DB` SET " . $values . " WHERE id={$this->id} AND id_cuenta_corriente={$this->idCuentaCorriente}";
        return $this->con->sqlReturn($sql);
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