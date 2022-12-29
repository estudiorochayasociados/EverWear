<?php namespace Clases;

class Conexion
{
    private $datos = array("host" => "localhost", "user" => "root", "pass" => "", "db" => "ever_alta");

    private $con;

    public function con()
    {
        $conexion = mysqli_connect($this->datos["host"], $this->datos["user"], $this->datos["pass"], $this->datos["db"]);
        mysqli_set_charset($conexion, 'utf8');
        return $conexion;
    }

    public function pdo()
    {
        $conexion = mysqli_connect($this->datos["host"], $this->datos["user"], $this->datos["pass"], $this->datos["db"]);
        mysqli_set_charset($conexion, 'utf8');
        return $conexion;
    }

    public function sql($query)
    {
        $conexion = mysqli_connect($this->datos["host"], $this->datos["user"], $this->datos["pass"], $this->datos["db"]);
        mysqli_set_charset($conexion, 'utf8');
        $conexion->query($query);
        $conexion->close();
    }

    public function sqlReturn($query)
    {
        $conexion = mysqli_connect($this->datos["host"], $this->datos["user"], $this->datos["pass"], $this->datos["db"]);
        mysqli_set_charset($conexion, 'utf8');
        $dato = $conexion->query($query);
        $conexion->close();
        return $dato;
    }

    public function sqlReturnId($query)
    {
        $conexion = mysqli_connect($this->datos["host"], $this->datos["user"], $this->datos["pass"], $this->datos["db"]);
        mysqli_set_charset($conexion, 'utf8');
        $result = $conexion->query($query);
        if ($result) {
            $response = $conexion->insert_id;
        } else {
            $response = false;
        }
        $conexion->close();
        return $response;
    }

    public function backup()
    {
        return $this->datos;
    }
}
