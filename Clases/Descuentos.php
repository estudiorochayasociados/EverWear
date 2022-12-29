<?php

namespace Clases;

class Descuentos
{
    //Atributos
    public $id;
    public $titulo;
    public $tipo;
    public $monto;
    public $categorias_cod;
    public $subcategorias_cod;
    public $productos_cod;
    public $sector;
    public $fecha_inicio;
    public $fecha_fin;
    public $cod;

    private $con;
    private $imagenes;
    private $productos;

    //Metodos
    public function __construct()
    {
        $this->con = new Conexion();
        $this->imagenes = new Imagenes();
        $this->productos = new Productos();
    }

    public function set($atributo, $valor)
    {
        if (($atributo == "tipo" && empty($valor)) || ($atributo == "sector" && empty($valor))) {
            $valor = 0;
        } else {
            if (!empty($valor)) {
                $valor = "'" . $valor . "'";
            } else {
                $valor = "NULL";
            }
        }

        $this->$atributo = $valor;
    }

    public function get($atributo)
    {
        return $this->$atributo;

    }

    public function add()
    {
        $sql = "INSERT INTO `descuentos`(`cod`,`titulo`,`tipo`,`monto`,`categorias_cod`,`subcategorias_cod`, `productos_cod`, `sector`, `fecha_inicio`, `fecha_fin`) 
                  VALUES ({$this->cod},
                          {$this->titulo},
                          {$this->tipo},
                          {$this->monto},
                          {$this->categorias_cod},
                          {$this->subcategorias_cod},
                          {$this->productos_cod},
                          {$this->sector},
                          {$this->fecha_inicio},
                          {$this->fecha_fin})";
        $query = $this->con->sql($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit()
    {
        $sql = "UPDATE `descuentos` 
                  SET `titulo`={$this->titulo},
                      `cod`={$this->cod},
                      `tipo`={$this->tipo},
                      `monto`={$this->monto},
                      `categorias_cod`={$this->categorias_cod},
                      `subcategorias_cod`={$this->subcategorias_cod},
                      `productos_cod`={$this->productos_cod},
                      `sector`={$this->sector},
                      `fecha_inicio`={$this->fecha_inicio},
                      `fecha_fin`={$this->fecha_fin}
                  WHERE `id`={$this->id}";
        $query = $this->con->sql($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function refreshCart($carro, $usuario = NULL)
    {
        $alert = 0; //Alert 0: si se mantiene en 0, el carrito no posee productos que entren en el descuento.
        $error = 0; //Error 0: si se mantiene en 0, todo esta ok.

        if ($this->cod != NULL) {

            $descuentoDataTemp = $this->view();

            if ($descuentoDataTemp != NULL) {

                $efectivo = ($descuentoDataTemp['data']['tipo'] == 0) ? true : false;
                $porcentaje = ($descuentoDataTemp['data']['tipo'] == 1) ? true : false;
                $sectorTodos = ($descuentoDataTemp['data']['sector'] == 0) ? true : false;
                $sectorSinDescuento = ($descuentoDataTemp['data']['sector'] == 1 && ($usuario == NULL || empty($usuario['data']['descuento']))) ? true : false;
                $sectorConDescuento = ($descuentoDataTemp['data']['sector'] == 2 && !empty($usuario['data']['descuento'])) ? true : false;
                $fechaInicial = (strtotime($descuentoDataTemp['data']['fecha_inicio']) <= strtotime(strftime("%Y-%m-%d"))) ? true : false;
                $fechaFinal = (strtotime($descuentoDataTemp['data']['fecha_fin']) >= strtotime(strftime("%Y-%m-%d"))) ? true : false;

                $arrayProductosDescuento = (explode(",", $descuentoDataTemp['data']['productos_cod']));
                $arrayCategoriasDescuento = (explode(",", $descuentoDataTemp['data']['categorias_cod']));
                $arraySubcategoriasDescuento = (explode(",", $descuentoDataTemp['data']['subcategorias_cod']));

                if ($sectorTodos || $sectorConDescuento || $sectorSinDescuento) {
                    if ($fechaInicial) {
                        if ($fechaFinal) {

                            foreach ($carro as $key => $item) {
                                if ($item['id'] != "Envio-Seleccion" && $item['id'] != "Metodo-Pago") {

                                    $comprobarCod = (isset($carro[$key]['descuento']['cod'])) ? $carro[$key]['descuento']['cod'] : NULL;

                                    if ($comprobarCod != $descuentoDataTemp['data']['cod']) {

                                        $this->productos->set("cod", $item['id']);
                                        $productoTemp = $this->productos->view();
                                        $senalProducto = (in_array($productoTemp['data']['cod'], $arrayProductosDescuento)) ? true : false;
                                        $senalCategoria = (in_array($productoTemp['category']['data']['cod'], $arrayCategoriasDescuento)) ? true : false;
                                        $senalSubcategoria = (in_array($productoTemp['subcategory']['data']['cod'], $arraySubcategoriasDescuento)) ? true : false;

                                        if ($senalProducto || $senalCategoria || $senalSubcategoria) {
                                            $alert = 1; //Alert 1: se aplico al menos un descuento.

                                            if ($efectivo) {
                                                $carro[$key]['descuento']['cod'] = $descuentoDataTemp['data']['cod'];
                                                $carro[$key]['descuento']['monto'] = "- $" . $descuentoDataTemp['data']['monto'];
                                                $carro[$key]['descuento']['precio-antiguo'] = $carro[$key]['precio'];

                                                $carro[$key]['precio'] = $item['precio'] - $descuentoDataTemp['data']['monto'];
                                            } elseif ($porcentaje) {
                                                $carro[$key]['descuento']['cod'] = $descuentoDataTemp['data']['cod'];
                                                $carro[$key]['descuento']['monto'] = "- %" . $descuentoDataTemp['data']['monto'];
                                                $carro[$key]['descuento']['precio-antiguo'] = $carro[$key]['precio'];

                                                $carro[$key]['precio'] = $item['precio'] - ($item['precio'] * $descuentoDataTemp['data']['monto'] / 100);
                                            }
                                        }
                                    }

                                }
                            }

                        } else {
                            $error = 4; //Error 4: el descuento ya finalizo.
                        }
                    } else {
                        $error = 3; //Error 3: el descuento todavia no comenzo.
                    }

                } else {
                    $error = 2; //Error 2: su cuenta no aplica para este descuento.
                }
            }

        }

        unset($_SESSION["carrito"]);
        $_SESSION["carrito"] = $carro;

        return array("error" => $error, "alert" => $alert);
    }

    public function descuentoCheck($carro, $usuario = NULL)
    {
        $senalCheck = 0;
        $codCheck = '';
        foreach ($carro as $item) {
            if (isset($item['descuento']['cod'])) {
                $senalCheck = 1;
                $codCheck = $item['descuento']['cod'];
            }
        }

        $this->set("cod", $codCheck);
        $refresh = $this->refreshCart($carro, $usuario);

        return array("check" => $senalCheck, "cod" => $codCheck, "refresh" => $refresh['alert']);
    }

    public function delete()
    {
        $sql = "DELETE FROM `descuentos` WHERE `cod`  = {$this->cod}";
        $query = $this->con->sql($sql);

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
        $sql = "SELECT * FROM descuentos WHERE   cod = {$this->cod}  ";
        $notas = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($notas);
        $img = $this->imagenes->list(array("cod='" . $row['cod'] . "'"), 'orden ASC', '');
        $row_ = array("data" => $row, "images" => $img);
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
        $sql = "SELECT * FROM `descuentos` $filterSql  ORDER BY $orderSql $limitSql";
        $banners = $this->con->sqlReturn($sql);
        if ($banners) {
            while ($row = mysqli_fetch_assoc($banners)) {
                $img = $this->imagenes->list(array("cod='" . $row['cod'] . "'"), 'orden ASC', '');
                $array[] = array("data" => $row, "images" => $img);
            }
            return $array;
        }
    }
}
