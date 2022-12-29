<?php


namespace Clases;


class DetalleCombinaciones
{
    //Atributos
    public $id;
    public $codCombinacion;
    public $precio;
    public $stock;
    public $mayorista;

    private $con;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
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
        $sql = "INSERT INTO `detalle_combinaciones`(`cod_combinacion`,`precio`,`stock`,`mayorista`) 
                  VALUES ({$this->codCombinacion},{$this->precio},{$this->stock},{$this->mayorista})";
        $query = $this->con->sql($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit()
    {
        $sql = "UPDATE `detalle_combinaciones` 
                  SET  `precio` =  {$this->precio},
                       `stock` = {$this->stock},    
                       `mayorista` = {$this->mayorista}    
                  WHERE `cod_combinacion`= {$this->codCombinacion} ";
        $query = $this->con->sql($sql);
        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function editSingle($atributo, $valor)
    {
        $sql = "UPDATE `detalle_combinaciones` SET `$atributo` = {$valor} WHERE `cod_combinacion`={$this->codCombinacion}";
        $this->con->sql($sql);
    }

    public function delete()
    {
        $sql = "DELETE FROM `detalle_combinaciones` WHERE `cod_combinacion`  = {$this->codCombinacion}";
        $query = $this->con->sqlReturn($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function view()
    {
        $sql = "SELECT * FROM `detalle_combinaciones` WHERE  cod_combinacion={$this->codCombinacion} LIMIT 1";
        $data = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($data);
        $array = $row;
        return $array;
    }

    public function list()
    {
        $array = array();
        $sql = "SELECT * FROM `detalle_combinaciones` WHERE cod_combinacion={$this->codCombinacion}";
        $data = $this->con->sqlReturn($sql);
        if ($data) {
            while ($row = mysqli_fetch_assoc($data)) {
                $array[] = $row;
            }
            return $array;
        }
    }
}