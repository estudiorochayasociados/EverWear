<?php

namespace Clases;

class TercerCategorias
{

    //Atributos
    public $id;
    public $cod;
    public $titulo;
    public $subcategoria;
    public $descripcion;
    public $orden = 0;
    private $con;
    private $imagenes;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
        $this->imagenes = new Imagenes();
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
        $sql   = "INSERT INTO `tercercategorias`(`cod`, `titulo`, `subcategoria`,`descripcion` , `orden`) VALUES ('{$this->cod}', '{$this->titulo}', '{$this->subcategoria}','{$this->descripcion}', '{$this->orden}')";
        $query = $this->con->sql($sql);

        return $query;
    }

    public function edit()
    {
        $sql   = "UPDATE `tercercategorias` SET cod = '{$this->cod}', titulo = '{$this->titulo}', subcategoria = '{$this->subcategoria}', `descripcion` = '{$this->descripcion}', orden = '{$this->orden}' WHERE `cod`='{$this->cod}'";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function delete()
    {
        $sql   = "DELETE FROM `tercercategorias` WHERE `cod`  = '{$this->cod}'";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function view()
    {
        $sql   = "SELECT * FROM `tercercategorias` WHERE cod = '{$this->cod}' ORDER BY orden ASC";
        $tercercategorias_ = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($tercercategorias_);
        $img = $this->imagenes->list(['cod = "' . $row['cod'] . '"'], "orden ASC", "");
        $row_ = array("data" => $row, "images" => $img);
        return $row_;
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

        $sql = "SELECT * FROM `tercercategorias` $filterSql  ORDER BY $orderSql $limitSql";
        $tercercategorias_ = $this->con->sqlReturn($sql);
        if ($tercercategorias_) {
            while ($row = mysqli_fetch_assoc($tercercategorias_)) {
                $img = $this->imagenes->list(['cod = "' . $row['cod'] . '"'], "orden ASC", "");
                $array[] = array("data" => $row, "images" => $img);
            }
            return $array;
        }
    }
}
