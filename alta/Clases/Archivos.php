<?php

namespace Clases;

class Archivos
{
    private $DB = "archivos";

    private $id;
    private $idCuentaCorriente;
    private $ruta;
    private $fecha;

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
            "ruta" => $this->ruta
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

    public function view($id)
    {
        $sql = "SELECT * FROM `$this->DB` WHERE id = '$id' ORDER BY id ASC";
        $result = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    public function delete()
    {
        $sql = "SELECT * FROM `$this->DB` WHERE id = {$this->id}";
        $imagen = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($imagen);
        $sqlDelete = "DELETE FROM `$this->DB` WHERE `id` = '" . $row['id'] . "'";
        unlink("../../" . $row["ruta"]);
        return $this->con->sqlReturn($sqlDelete);
    }
}