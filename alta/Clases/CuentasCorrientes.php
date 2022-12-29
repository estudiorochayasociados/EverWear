<?php

namespace Clases;

class CuentasCorrientes
{
    private $DB = 'cuentas_corrientes';

    private $id;
    private $cod;
    private $responsable;
    private $zona;
    private $razonSocial;
    private $nombreComercial;
    private $calle;
    private $numero;
    private $postal;
    private $provincia;
    private $localidad;
    private $telefono;
    private $celularAdm;
    private $celularCompra;
    private $email;
    private $emailCompra;
    private $tipoSocietario;
    private $cuit;
    private $impuestoAgregado;
    private $impuestoGanancia;
    private $impuestoBrutos;
    private $numeroInscripcion;
    private $lista;
    private $condicion;
    private $forma;
    private $categoria;
    private $comentarioSolicitante;
    private $comentarioApertura;
    private $nombreViajante;
    private $usuario;
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
            "responsable" => $this->responsable,
            "zona" => $this->zona,
            "razon_social" => $this->razonSocial,
            "nombre_comercial" => $this->nombreComercial,
            "calle" => $this->calle,
            "numero" => $this->numero,
            "postal" => $this->postal,
            "provincia" => $this->provincia,
            "localidad" => $this->localidad,
            "telefono" => $this->telefono,
            "celular_adm" => $this->celularAdm,
            "celular_compra" => $this->celularCompra,
            "email" => $this->email,
            "email_compra" => $this->emailCompra,
            "tipo_societario" => $this->tipoSocietario,
            "cuit" => $this->cuit,
            "impuesto_agregado" => $this->impuestoAgregado,
            "impuesto_ganancia" => $this->impuestoGanancia,
            "impuesto_brutos" => $this->impuestoBrutos,
            "numero_inscripcion" => $this->numeroInscripcion,
            "nombre_viajante" => $this->nombreViajante,
            "usuario" => $this->usuario
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
            "responsable" => $this->responsable,
            "zona" => $this->zona,
            "razon_social" => $this->razonSocial,
            "nombre_comercial" => $this->nombreComercial,
            "calle" => $this->calle,
            "numero" => $this->numero,
            "postal" => $this->postal,
            "provincia" => $this->provincia,
            "localidad" => $this->localidad,
            "telefono" => $this->telefono,
            "celular_adm" => $this->celularAdm,
            "celular_compra" => $this->celularCompra,
            "email" => $this->email,
            "email_compra" => $this->emailCompra,
            "tipo_societario" => $this->tipoSocietario,
            "cuit" => $this->cuit,
            "impuesto_agregado" => $this->impuestoAgregado,
            "impuesto_ganancia" => $this->impuestoGanancia,
            "impuesto_brutos" => $this->impuestoBrutos,
            "numero_inscripcion" => $this->numeroInscripcion
        ];

        $count = count($atributtes) - 1;
        $values = "";
        foreach ($atributtes as $key => $atributte) {
            $values .= $key . "=" . $atributte;
            if ($count != 0) $values .= ",";
            $count--;
        }
        $sql = "UPDATE `$this->DB` SET " . $values . " WHERE id={$this->id} AND usuario={$this->usuario}";
        return $this->con->sqlReturn($sql);
    }

    public function updateFinancial()
    {
        $atributtes = [
            "lista" => $this->lista,
            "condicion" => $this->condicion,
            "forma" => $this->forma,
            "categoria" => $this->categoria,
            "comentario_solicitante" => $this->comentarioSolicitante
        ];

        $count = count($atributtes) - 1;
        $values = "";
        foreach ($atributtes as $key => $atributte) {
            $values .= $key . "=" . $atributte;
            if ($count != 0) $values .= ",";
            $count--;
        }
        $sql = "UPDATE `$this->DB` SET " . $values . " WHERE id={$this->id} AND usuario={$this->usuario}";
        return $this->con->sqlReturn($sql);
    }

    public function updateOthers()
    {
        $atributtes = [
            "comentario_apertura" => $this->comentarioApertura,
            "nombre_viajante" => $this->nombreViajante
        ];

        $count = count($atributtes) - 1;
        $values = "";
        foreach ($atributtes as $key => $atributte) {
            $values .= $key . "=" . $atributte;
            if ($count != 0) $values .= ",";
            $count--;
        }
        $sql = "UPDATE `$this->DB` SET " . $values . " WHERE id={$this->id} AND usuario={$this->usuario}";
        return $this->con->sqlReturn($sql);
    }

    public function view()
    {
        $sql = "SELECT * FROM `$this->DB` WHERE id = {$this->id} AND usuario={$this->usuario} ORDER BY id DESC LIMIT 1";
        $clientes = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($clientes);
        return ["data" => $row];
    }

    public function viewById()
    {
        $sql = "SELECT * FROM `$this->DB` WHERE id = {$this->id} ORDER BY id DESC LIMIT 1";
        $clientes = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($clientes);
        return ["data" => $row];
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