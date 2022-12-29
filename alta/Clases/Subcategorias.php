<?php

namespace Clases;

class Subcategorias
{

    //Atributos
    public $id;
    public $cod;
    public $titulo;
    public $categoria;

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
        $sql = "INSERT INTO `subcategorias`(`cod`, `titulo`, `categoria`) 
                VALUES ({$this->cod},
                        {$this->titulo},
                        {$this->categoria})";
        $query = $this->con->sql($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit()
    {
        $sql = "UPDATE `subcategorias` 
                SET cod = {$this->cod}, 
                    titulo = {$this->titulo}, 
                    categoria = {$this->categoria}
                WHERE `id`={$this->id}";
        $query = $this->con->sql($sql);
        return true;

    }

    public function delete()
    {
        $sql = "DELETE FROM `subcategorias` WHERE `cod`  = {$this->cod}";
        $query = $this->con->sqlReturn($sql);
        if (!empty($this->imagenes->list(array("cod={$this->cod}"), 'orden ASC', ''))) {
            $this->imagenes->cod = $this->cod;
            $this->imagenes->deleteAll();
        }

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function view()
    {
        $sql = "SELECT * FROM `subcategorias` WHERE cod = {$this->cod} ORDER BY id DESC";
        $subcategorias_ = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($subcategorias_);
        $img = $this->imagenes->view($row['cod']);
        $row_ = array("data" => $row, "image" => $img);
        return $row_;
    }

    public function viewByTitle($value = null)
    {
        if ($value != '') {
            $value = str_replace("-", " ", $value);
            $sql = "SELECT * FROM `subcategorias` WHERE titulo = '$value' ORDER BY id DESC";
            $subcategorias_ = $this->con->sqlReturn($sql);
            $row = mysqli_fetch_assoc($subcategorias_);
            if (!empty($row)) {
                $img = $this->imagenes->view($row['cod']);
                $row_ = array("data" => $row, "image" => $img);
                return $row_;
            }
        } else {
            return false;
        }
    }


    public function viewById($id = null)
    {
        if ($id != '') {
            $id = str_replace("-", " ", $id);
            $sql = "SELECT * FROM `subcategorias` WHERE id = '$id' ORDER BY id DESC";
            $subcategorias_ = $this->con->sqlReturn($sql);
            $row = mysqli_fetch_assoc($subcategorias_);
            if (!empty($row)) {
                $img = $this->imagenes->view($row['cod']);
                $row_ = array("data" => $row, "image" => $img);
                return $row_;
            }
        } else {
            return false;
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

        $sql = "SELECT * FROM `subcategorias` $filterSql  ORDER BY $orderSql $limitSql";
        //echo $sql;
        $subcategorias_ = $this->con->sqlReturn($sql);
        if ($subcategorias_) {
            while ($row = mysqli_fetch_assoc($subcategorias_)) {
                $img = $this->imagenes->view($row['cod']);
                $array[] = array("data" => $row, "image" => $img);
            }
            return $array;
        }
    }

}
