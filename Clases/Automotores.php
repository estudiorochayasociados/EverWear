<?php

namespace Clases;

class Automotores
{
    //Atributos
    public $id;
    public $cod;
    public $marca;
    public $modelo;
    public $motor;
    public $anio;
    public $aplicacion;
    public $cod_producto;

    //Clases
    private $con;
    private $funciones;
    private $categoriasClass;
    private $subcategoriasClass;
    private $imagenesClass;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
        $this->funciones = new PublicFunction();
        $this->categoriasClass = new Categorias();
        $this->subcategoriasClass = new Subcategorias();
        $this->imagenesClass = new Imagenes();
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
        $sql = "INSERT INTO `automotores`(`cod`, `marca`,`cod_producto`,  `modelo`, `motor`, `anio`, `aplicacion`) 
                VALUES ({$this->cod},
                        {$this->marca},
                        {$this->cod_producto},
                        {$this->modelo},
                        {$this->motor},
                        {$this->anio},
                        {$this->aplicacion})";
        $query = $this->con->sql($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit()
    {
        $sql = "UPDATE `automotores` 
                SET `cod` = {$this->cod},
                    `marca` = {$this->marca},
                    `cod_producto` = {$this->cod_producto},
                    `modelo` = {$this->modelo},
                    `motor` = {$this->motor},
                    `anio` = {$this->anio},
                    `aplicacion` = {$this->aplicacion}
                WHERE `id`={$this->id}";
        $query = $this->con->sql($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function editSingle($atributo, $valor)
    {
        $sql = "UPDATE `automotores` SET `$atributo` = {$valor} WHERE `cod`={$this->cod}";
        $this->con->sql($sql);
    }

    public function delete()
    {
        $sql = "DELETE FROM `automotores` WHERE `cod`  = {$this->cod}";
        $query = $this->con->sql($sql);

        if (!empty($this->imagenesClass->list(array("cod={$this->cod}"), '', ''))) {
            $this->imagenesClass->cod = $this->cod;
            $this->imagenesClass->deleteAll();
        }

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function import()
    {
        $sql = "({$this->cod},
                 {$this->marca},
                 {$this->cod_producto},
                 {$this->modelo},
                 {$this->motor},
                 {$this->anio},
                 {$this->aplicacion}),";
        return $sql;
    }

    public function query($sql)
    {
        $querySql = "INSERT INTO `automotores`(`cod`, `marca`,`cod_producto`, `modelo`,`motor`,`anio`, `aplicacion`) 
                VALUES " . $sql;
        $query = $this->con->sql($querySql);
        return $query;
    }

    public function truncate()
    {
        $sql = "TRUNCATE `automotores`";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function view()
    {
        $sql = "SELECT * FROM `automotores` WHERE  cod = {$this->cod} LIMIT 1";
        $automotores = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($automotores);
        $img = $this->imagenesClass->list(array("cod = '" . $row['cod'] . "'"), "orden ASC", "");
        $this->categoriasClass->set("cod", $row['categoria']);
        $cat = $this->categoriasClass->view();
        $this->subcategoriasClass->set("cod", $row['subcategoria']);
        $subcat = $this->subcategoriasClass->view();
        $array = array("data" => $row, "category" => $cat, "subcategory" => $subcat, "images" => $img);
        return $array;
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

        $sql = "SELECT DISTINCT $valueDistinct FROM `automotores` $filterSql ORDER BY $valueDistinct ASC";

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

        $sql = "SELECT * FROM `automotores` $filterSql ORDER BY $orderSql $limitSql";
        $automotor = $this->con->sqlReturn($sql);
        if ($automotor) {
            while ($row = mysqli_fetch_assoc($automotor)) {
                $array[] = array("data" => $row);
            }
            return $array;
        }
    }
    function list2($filter, $order, $limit)
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

        $sql = "SELECT DISTINCT `modelo` FROM `automotores` $filterSql ORDER BY $orderSql $limitSql";
        $automotor = $this->con->sqlReturn($sql);
        if ($automotor) {
            while ($row = mysqli_fetch_assoc($automotor)) {
                $array[] = array("data" => $row);
            }
            return $array;
        }
    }
    function list3($filter, $order, $limit)
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

        $sql = "SELECT DISTINCT `anio` FROM `automotores` $filterSql ORDER BY $orderSql $limitSql";
        $automotor = $this->con->sqlReturn($sql);
        if ($automotor) {
            while ($row = mysqli_fetch_assoc($automotor)) {
                $array[] = array("data" => $row);
            }
            return $array;
        }
    }


    function checkApplication($string)
    {
        switch ($string) {
            case "CIG":
                return ["texto" => "Cigüeñal", "img" => "CIG.png"];
                break;
            case "DH":
                return ["texto" => "Dirección Hidraulica", "img" => "DH.png"];
                break;
            case "AA":
                return ["texto" => "Aire acondicionado", "img" => "AA.png"];
                break;
            case "A":
                return ["texto" => "Alternador", "img" => "A.png"];
                break;
            case "BA":
                return ["texto" => "Bomba  de agua", "img" => "BA.png"];
                break;
        }
    }

    function paginador($filter, $cantidad)
    {
        $array = array();
        if (is_array($filter)) {
            $filterSql = "WHERE ";
            $filterSql .= implode(" AND ", $filter);
        } else {
            $filterSql = '';
        }
        $sql = "SELECT * FROM `automotores` $filterSql";
        $contar = $this->con->sqlReturn($sql);
        $total = mysqli_num_rows($contar);
        $totalPaginas = $total / $cantidad;
        return ceil($totalPaginas);
    }

    //Especiales
    public function getVariables($var, $category)
    {
        if ($category != '') {
            $sql = "SELECT `$var` FROM `automotores` WHERE `$var`!='' and `categoria`='$category' GROUP BY `$var` ORDER BY `$var`  DESC";
        } else {
            $sql = "SELECT `$var` FROM `automotores` WHERE `$var`!='' GROUP BY `$var` ORDER BY `$var`  DESC";
        }
        $dimensions = $this->con->sqlReturn($sql);
        if ($dimensions) {
            while ($row = mysqli_fetch_assoc($dimensions)) {
                $array[] = array("data" => $row);
            }
            return $array;
        }
    }
}
