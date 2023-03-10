<?php


namespace Clases;


class Subatributos
{
    //Atributos
    public $id;
    public $cod;
    public $codAtributo;
    public $value;

    private $combinaciones;
    private $con;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
        //$this->variaciones = new Variaciones();
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

    public function add()
    {
        $sql = "INSERT INTO `subatributos`(`cod`,`cod_atributo`, `value`) 
                  VALUES ({$this->cod},{$this->codAtributo},{$this->value})";
        $query = $this->con->sql($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function delete()
    {
        $sql = "DELETE FROM `subatributos` WHERE `cod`  = {$this->cod}";
        $query = $this->con->sqlReturn($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit()
    {
        $sql = "UPDATE `subatributos` 
                  SET  value =  {$this->value}  
                  WHERE `cod`= {$this->cod} ";
        $query = $this->con->sql($sql);
        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }


    public function list()
    {
        $array=array();
        $sql = "SELECT * FROM `subatributos` WHERE cod_atributo={$this->codAtributo}";
        $data = $this->con->sqlReturn($sql);
        if ($data) {
            while ($row = mysqli_fetch_assoc($data)) {
                $array[] = $row;
            }
            return $array;
        }
    }

    public function view()
    {
        $sql = "SELECT * FROM `subatributos` WHERE cod = {$this->cod} ORDER BY id DESC LIMIT 1";
        $subatributo = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($subatributo);
        $array = array("data" => $row);
        return $array;
    }


}