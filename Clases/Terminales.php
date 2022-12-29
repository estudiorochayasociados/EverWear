<?php

namespace Clases;

class Terminales
{
    //Atributos
    public $id;
    public $codigo;
    public $descripcion;
    public $aclaracion;
    public $cañiflex;
    public $iron;
    public $iron_r2_pp;
    public $iron_r2_sp;
    public $iron_r1;
    public $iron_r9;
    public $iron_r13;
    public $metalurgicajs;
    public $metalurgicajs_r1_sp;
    public $metalurgicajs_r2_sp;
    public $metalurgicajs_r1_pp;
    public $metalurgicajs_r2_pp;
    public $metalurgicajs_r12;
    public $metalurgicajs_r13;
    public $parker;
    public $tecnicord;
    public $hsf;
    public $keyword;

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
        $sql = "INSERT INTO `terminales`(`codigo`, `descripcion`, `aclaracion`, `cañiflex`,`iron`, `iron_r2_pp`, `iron_r2_sp`, `iron_r1`, `iron_r9`, `iron_r13`, `metalurgicajs`, `metalurgicajs_r1_sp`, `metalurgicajs_r2_sp`, `metalurgicajs_r1_pp`, `metalurgicajs_r2_pp`, `metalurgicajs_r12`, `metalurgicajs_r13`, `parker`, `tecnicord`, `hsf` , `keyword`) 
                VALUES ({$this->codigo},
                {$this->descripcion},
                {$this->aclaracion},
                {$this->cañiflex},
                {$this->iron},
                {$this->iron_r2_pp},
                {$this->iron_r2_sp},
                {$this->iron_r1},
                {$this->iron_r9},
                {$this->iron_r13},
                {$this->metalurgicajs},
                {$this->metalurgicajs_r1_sp},
                {$this->metalurgicajs_r2_sp},
                {$this->metalurgicajs_r1_pp},
                {$this->metalurgicajs_r2_pp},
                {$this->metalurgicajs_r12},
                {$this->metalurgicajs_r13},
                {$this->parker},
                {$this->tecnicord},
                {$this->hsf},
                {$this->keyword})";
        $query = $this->con->sql($sql);
        return $query;
    }

    function list($filter, $order, $limit)
    {
        $array = array();

        if (!empty($filter)) {
            $filterSql = "WHERE ";
            $filterSql .= "`codigo` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`cañiflex` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`iron` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`iron_r2_pp` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`iron_r2_sp` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`iron_r1` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`iron_r9` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`iron_r13` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`metalurgicajs` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`metalurgicajs_r1_sp` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`metalurgicajs_r2_sp` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`metalurgicajs_r1_pp` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`metalurgicajs_r2_pp` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`metalurgicajs_r12` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`metalurgicajs_r13` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`parker` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`tecnicord` LIKE '%" . $filter . "%' OR";
            $filterSql .= "`hsf` LIKE '%" . $filter . "%' ";
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

        $sql = "SELECT `id`, `codigo`, `descripcion`, `aclaracion`, `cañiflex`, `iron`, `iron_r2_pp`, `iron_r2_sp`, `iron_r1`, `iron_r9`, `iron_r13`, `metalurgicajs`, `metalurgicajs_r1_sp`, `metalurgicajs_r2_sp`, `metalurgicajs_r1_pp`, `metalurgicajs_r2_pp`, `metalurgicajs_r12`, `metalurgicajs_r13`, `parker`, `tecnicord`, `hsf` FROM `terminales` $filterSql GROUP BY codigo $limitSql ";
        $terminales = $this->con->sqlReturn($sql);
        if ($terminales) {
            while ($row = mysqli_fetch_assoc($terminales)) {
                $array[] = array("data" => $row);
            }
            return $array;
        }
    }

    public function truncate()
    {
        $sql = "TRUNCATE `terminales`";
        $query = $this->con->sql($sql);
        return $query;
    }
}
