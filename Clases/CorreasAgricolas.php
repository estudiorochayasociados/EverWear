<?php

namespace Clases;

class CorreasAgricolas
{
    //Atributos
    public $id;
    public $sector;
    public $oem;
    public $marca;
    public $modelo;
    public $descripcion;
    public $lado;
    public $cantidad;
    public $carlisle;
    public $everWear;

    //Clases
    private $con;
    private $funciones;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
        $this->funciones = new PublicFunction();
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
        $sql = "INSERT INTO `correas_agricolas`(`sector`,`oem`, `marca`, `modelo`, `descripcion`,`lado`, `cantidad`, `carlisle`, `ever_wear`) 
                VALUES (
                    {$this->sector},
                    {$this->oem},
                {$this->marca},
                {$this->modelo},
                {$this->descripcion},
                {$this->lado},
                {$this->cantidad},
                {$this->carlisle},
                {$this->everWear})";
        $query = $this->con->sql($sql);
        return $query;
    }

    function listDistinct($valueDistinct, $filter)
    {
        $array = array();
        if (is_array($filter)) {
            $filterSql = "WHERE ";
            $filterSql .= implode(" AND ", $filter);
        } else {
            $filterSql = '';
        }

        $sql = "SELECT DISTINCT $valueDistinct FROM `correas_agricolas` $filterSql ORDER BY $valueDistinct ASC";

        $automotor = $this->con->sqlReturn($sql);
        if ($automotor) {
            while ($row = mysqli_fetch_assoc($automotor)) {
                $array[] = array("data" => $row);
            }
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

        $sql = "SELECT * FROM `correas_agricolas` $filterSql ORDER BY $orderSql $limitSql";
        $correaAgricola = $this->con->sqlReturn($sql);
        if ($correaAgricola) {
            while ($row = mysqli_fetch_assoc($correaAgricola)) {
                $array[] = array("data" => $row);
            }
            return $array;
        }
    }

    public function truncate()
    {
        $sql = "TRUNCATE `correas_agricolas`";
        $query = $this->con->sql($sql);
        return $query;
    }
}
