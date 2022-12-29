<?php

namespace Clases;

class Categorias
{

    //Atributos
    public $id;
    public $cod;
    public $titulo;
    public $area;
    public $descripcion;
    public $orden = 0;

    private $con;
    private $subcategoria;
    private $imagenes;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
        $this->subcategoria = new Subcategorias();
        $this->imagenes = new Imagenes();
    }

    public function set($atributo, $valor)
    {
        if (strlen($valor)) {
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
        $sql = "INSERT INTO `categorias`(`cod`, `titulo`, `area`, `descripcion`, `orden`) 
                  VALUES ({$this->cod},{$this->titulo},{$this->area},{$this->descripcion},{$this->orden})";
        $query = $this->con->sql($sql);
        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit()
    {
        $sql = "UPDATE `categorias` 
                  SET cod = {$this->cod} ,
                      titulo = {$this->titulo} ,
                      area = {$this->area}, 
                      orden = {$this->orden},  
                      descripcion = {$this->descripcion}  
                  WHERE `id`= {$this->id} ";
        $query = $this->con->sql($sql);
        return true;
    }


    public function delete()
    {
        $sql = "DELETE FROM `categorias` WHERE `cod`  = {$this->cod}";
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
        $sql = "SELECT * FROM `categorias` WHERE cod = {$this->cod} LIMIT 1";
        $categorias = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($categorias);
        $img = $this->imagenes->list(['cod = "' . $row['cod'] . '"'], "orden ASC", "");
        $sub = $this->subcategoria->list(array("categoria='" . $row['cod'] . "'"), '', '');
        $row_ = array("data" => $row, "subcategories" => $sub, "tercercategories" => $sub, "images" => $img);
        return $row_;
    }

    public function list($filter, $order, $limit)
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

        $sql = "SELECT * FROM `categorias` $filterSql  ORDER BY $orderSql $limitSql";
        $categorias = $this->con->sqlReturn($sql);
        if ($categorias) {
            while ($row = mysqli_fetch_assoc($categorias)) {
                $img = $this->imagenes->list(['cod = "' . $row['cod'] . '"'], "orden ASC", "");
                $sub = $this->subcategoria->list(array("categoria='" . $row['cod'] . "'"), '', '');
                $array[] = array("data" => $row, "subcategories" => $sub, "images" => $img);
            }
            return $array;
        }
    }

    public function listIfHave($db)
    {
        $array = array();
        $sql = " SELECT `categorias`.`titulo`,`categorias`.`cod`, count(`" . $db . "`.`categoria`) as cantidad FROM `" . $db . "`,`categorias` WHERE `categoria` = `categorias`.`cod` GROUP BY categoria ORDER BY cantidad DESC ";
        $listIfHave = $this->con->sqlReturn($sql);
        if ($listIfHave) {
            while ($row = mysqli_fetch_assoc($listIfHave)) {
                $img = $this->imagenes->list(['cod = "' . $row['cod'] . '"'], "orden ASC", "");
                $sub = $this->subcategoria->list(array("categoria='" . $row['cod'] . "'"), '', '');
                $array[] = array("data" => $row, "subcategories" => $sub, "images" => $img);
            }
            return $array;
        }
    }
}
