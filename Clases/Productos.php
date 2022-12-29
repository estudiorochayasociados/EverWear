<?php

namespace Clases;

class Productos
{
    //Atributos
    public $id;
    public $cod;
    public $titulo;
    public $precio;
    public $precio_descuento;
    public $precio_mayorista;
    public $peso;
    public $stock;
    public $desarrollo;
    public $categoria;
    public $subcategoria;
    public $keywords;
    public $description;
    public $fecha;
    public $meli;
    public $variable1;
    public $variable2;
    public $variable3;
    public $variable4;
    public $variable5;
    public $variable6;
    public $variable7;
    public $variable8;
    public $variable9;
    public $variable10;
    public $cod_producto;
    public $img;
    public $url;

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
        $sql = "INSERT INTO `productos`(`cod`, `titulo`,`cod_producto`, `precio`,`precio_descuento`,`precio_mayorista`, `variable1`,`variable2`,`variable3`,`variable4`,`variable5`,`variable6`,`variable7`,`variable8`,`variable9`,`variable10`,  `stock`, `peso`, `desarrollo`, `categoria`, `subcategoria`, `keywords`, `description`, `fecha`, `meli`, `url`) 
                VALUES ({$this->cod},
                        {$this->titulo},
                        {$this->cod_producto},
                        {$this->precio},
                        {$this->precio_descuento},
                        {$this->precio_mayorista},
                        {$this->variable1},
                        {$this->variable2},
                        {$this->variable3},
                        {$this->variable4},
                        {$this->variable5},
                        {$this->variable6},
                        {$this->variable7},
                        {$this->variable8},
                        {$this->variable9},
                        {$this->variable10},
                        {$this->stock},
                        {$this->peso},
                        {$this->desarrollo},
                        {$this->categoria},
                        {$this->subcategoria},
                        {$this->keywords},
                        {$this->description},
                        {$this->fecha},
                        {$this->meli},
                        {$this->url})";
        $query = $this->con->sql($sql);

        if (!empty($query)) {
            return true;
        } else {
            return false;
        }
    }

    public function edit()
    {
        $sql = "UPDATE `productos` 
                SET `cod` = {$this->cod},
                    `titulo` = {$this->titulo},
                    `precio` = {$this->precio},
                    `precio_descuento` = {$this->precio_descuento},
                    `precio_mayorista` = {$this->precio_mayorista},
                    `cod_producto` = {$this->cod_producto},
                    `stock` = {$this->stock},
                    `peso` = {$this->peso},
                    `desarrollo` = {$this->desarrollo},
                    `categoria` = {$this->categoria},
                    `subcategoria` = {$this->subcategoria},
                    `keywords` = {$this->keywords},
                    `description` = {$this->description},
                    `variable1` = {$this->variable1},
                    `variable2` = {$this->variable2},
                    `variable3` = {$this->variable3},
                    `variable4` = {$this->variable4},
                    `variable5` = {$this->variable5},
                    `variable6` = {$this->variable6},
                    `variable7` = {$this->variable7},
                    `variable8` = {$this->variable8},
                    `variable9` = {$this->variable9},
                    `variable10` = {$this->variable10},
                    `fecha` = {$this->fecha},
                    `meli` = {$this->meli},
                    `url` = {$this->url}
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
        $sql = "UPDATE `productos` SET `$atributo` = {$valor} WHERE `cod`={$this->cod}";
        $this->con->sql($sql);
    }

    public function delete()
    {
        $sql = "DELETE FROM `productos` WHERE `cod`  = {$this->cod}";
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
                 {$this->titulo},
                 {$this->cod_producto},
                 {$this->precio},
                 {$this->precio_descuento},
                 {$this->precio_mayorista},
                 {$this->variable1},
                 {$this->variable2},
                 {$this->variable3},
                 {$this->variable4},
                 {$this->variable5},
                 {$this->variable6},
                 {$this->variable7},
                 {$this->variable8},
                 {$this->variable9},
                 {$this->variable10},
                 {$this->stock},
                 {$this->peso},
                 {$this->desarrollo},
                 {$this->categoria},
                 {$this->subcategoria},
                 {$this->keywords},
                 {$this->description},
                 {$this->fecha},
                 {$this->meli},
                 {$this->url}),";
        return $sql;
    }

    public function query($sql)
    {
        $querySql = "INSERT INTO `productos`(`cod`, `titulo`,`cod_producto`, `precio`,`precio_descuento`,`precio_mayorista`, `variable1`,`variable2`,`variable3`,`variable4`,`variable5`,`variable6`,`variable7`,`variable8`,`variable9`,`variable10`,  `stock`, `peso`, `desarrollo`, `categoria`, `subcategoria`, `keywords`, `description`, `fecha`, `meli`, `url`) 
                VALUES " . $sql;
        $query = $this->con->sql($querySql);
        return $query;
    }

    public function truncate()
    {
        $sql = "TRUNCATE `productos`";
        $query = $this->con->sql($sql);
        return $query;
    }

    public function view()
    {
        $sql = "SELECT * FROM `productos` WHERE  cod = {$this->cod} LIMIT 1";
        $productos = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($productos);
        $img = $this->imagenesClass->list(array("cod = '" . $row['cod'] . "'"), "orden ASC", "");
        $this->categoriasClass->set("cod", $row['categoria']);
        $cat = $this->categoriasClass->view();
        $this->subcategoriasClass->set("cod", $row['subcategoria']);
        $subcat = $this->subcategoriasClass->view();
        $array = array("data" => $row, "category" => $cat, "subcategory" => $subcat, "images" => $img);
        return $array;
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

        $sql = "SELECT * FROM `productos` $filterSql ORDER BY $orderSql $limitSql";
        $producto = $this->con->sqlReturn($sql);
        if ($producto) {
            while ($row = mysqli_fetch_assoc($producto)) {
                $img = $this->imagenesClass->list(array("cod = '" . $row['cod'] . "'"), "orden ASC", "");
                $this->categoriasClass->set("cod", $row['categoria']);
                $cat = $this->categoriasClass->view();
                $this->subcategoriasClass->set("cod", $row['subcategoria']);
                $subcat = $this->subcategoriasClass->view();
                $array[] = array("data" => $row, "category" => $cat, "subcategory" => $subcat, "images" => $img);
            }
            return $array;
        }
    }

    function listMeli($filter, $order, $limit)
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

        $sql = "SELECT cod FROM `productos` $filterSql ORDER BY $orderSql $limitSql";
        $producto = $this->con->sqlReturn($sql);
        if ($producto) {
            while ($row = mysqli_fetch_assoc($producto)) {
                $array[] = array("data" => $row);
            }
            return $array;
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
        $sql = "SELECT * FROM `productos` $filterSql";
        $contar = $this->con->sqlReturn($sql);
        $total = mysqli_num_rows($contar);
        $totalPaginas = $total / $cantidad;
        return ceil($totalPaginas);
    }

    //Especiales
    public function getVariables($var, $category)
    {
        if ($category != '') {
            $sql = "SELECT `$var` FROM `productos` WHERE `$var`!='' and `categoria`='$category' GROUP BY `$var` ORDER BY `$var`  DESC";
        } else {
            $sql = "SELECT `$var` FROM `productos` WHERE `$var`!='' GROUP BY `$var` ORDER BY `$var`  DESC";
        }
        $dimensions = $this->con->sqlReturn($sql);
        if ($dimensions) {
            while ($row = mysqli_fetch_assoc($dimensions)) {
                $array[] = array("data" => $row);
            }
            return $array;
        }
    }

    /**
     ** Use API Model MERCADOLIBRE
     **/

    public function validateItem()
    {
        $url = 'https://api.mercadolibre.com/items/' . $this->meli;
        $response = $this->funciones->curl("", $url, '');
        $data = json_decode($response, true);
        if (is_array($data)) {
            if (isset($data["status"])) {
                if (is_numeric($data["status"])) {
                    $result = array("status" => false, "text" => "El código de producto en MercadoLibre ingresado es incorrecto.");
                    return $result;
                } else {
                    if ($_SESSION["user_id"] == $data["seller_id"]) {
                        if ($data['status'] != 'closed') {
                            $result = array("status" => true, "substatus" => true, "data" => $data);
                            return $result;
                        } else {
                            $result = array("status" => true, "substatus" => false, "text" => "El producto con este código se encuentra eliminado.");
                            return $result;
                        }
                    } else {
                        $result = array("status" => false, "text" => "El código ingresado es de otro usuario, usted no puedo modificarlo.");
                        return $result;
                    }
                }
            } else {
                $result = array("status" => false, "text" => "El código de producto en MercadoLibre ingresado es incorrecto.");
                return $result;
            }
        };
    }

    public function addMeli()
    {
        $meli = $this->funciones->curl("GET", "https://api.mercadolibre.com/sites/MLA/category_predictor/predict?title=" . $this->funciones->normalizar_meli($this->titulo) . "", "");
        $meli = json_decode($meli, true);
        if (empty($meli)) {
            $meli = $this->funciones->curl("GET", "https://api.mercadolibre.com/sites/MLA/category_predictor/predict?title=otros", "");
            $meli = json_decode($meli, true);
        }
        $meli_categoria = $meli["id"];

        $data = '{
            "title": ' . $this->titulo . ',
            "category_id": ' . $meli_categoria . ',
            "price": ' . $this->precio . ',
            "currency_id": "ARS",
            "available_quantity": ' . $this->stock . ',
            "buying_mode": "buy_it_now",
            "listing_type_id": "gold_pro",
            "condition": "new",
            "description": {"plain_text": ' . strip_tags($this->desarrollo) . '},
            "tags": [
            "immediate_payment"
            ],
            "video_id": "",
            "attributes": [
            {
            "id": "EAN",
            "value_name": "123212451323",
            },
            {
            "id": "ITEM_CONDITION",
            "name": "Condición del ítem",
            "value_id": "2230284",
            "value_name": "Nuevo",
            "value_struct": null,
            "attribute_group_id": "OTHERS",
            "attribute_group_name": "Otros"
            }
            ],
            "pictures": [' . $this->img . '{"source":"' . LOGO . '"}],
            "shipping": {
            "mode": "me2",
            "local_pick_up": true,
            "free_shipping": false,
            "free_methods": []
            }
            }';

        $meli = $this->funciones->curl("POST", "https://api.mercadolibre.com/items?access_token=" . $_SESSION["access_token"], $data);
        $meli = json_decode($meli, true);

        if (isset($meli)) {
            if (isset($meli['error'])) {
                if (!empty($meli['error'])) {
                    if (!empty($meli['cause'])) {
                        $error = array("status" => "false", "error" => $meli["cause"]);
                        return $error;
                    } else {
                        $error = array("status" => "false", "error" => $meli["error"]);
                        return $error;
                    }
                }
            } else {
                $meli_ = array("status" => "true", "data" => $meli);
                return $meli_;
            }
        }
    }

    public function editMeli()
    {
        $variations_array = json_decode($this->getVariationsMeli($this->meli));
        if (is_array($variations_array)) {
            foreach ($variations_array as $value) {
                $this->deleteVariationsMeli($this->meli, $value->id);
            }
        }

        if (empty($this->img)) {
            $this->img = '';
        }

        $data = '{
                "title": ' . $this->titulo . ',  
                "price": ' . $this->precio . ', 
                "available_quantity": ' . $this->stock . ',      
                "pictures": [' . $this->img . '{"source":"' . LOGO . '"}]
        }';
        $meli = $this->funciones->curl("PUT", "https://api.mercadolibre.com/items/$this->meli?access_token=" . $_SESSION["access_token"], $data);
        $meli = json_decode($meli, true);

        if (isset($meli)) {
            if (isset($meli['error'])) {
                if (!empty($meli['error'])) {
                    if (!empty($meli['cause'])) {
                        $error = array("status" => "false", "error" => $meli["cause"]);
                        return $error;
                    } else {
                        $error = array("status" => "false", "error" => $meli["error"]);
                        return $error;
                    }
                }
            } else {
                $meli_ = array("status" => "true", "data" => $meli);
                if ($meli['available_quantity'] > 0) {
                    if ($meli['status'] == 'paused') {
                        $this->activateMeli();
                    }
                }
                return $meli_;
            }
        }
    }

    public function viewMeli($id)
    {
        $meli = $this->funciones->curl("GET", "https://api.mercadolibre.com/items/$id?access_token=" . $_SESSION["access_token"], "");
        return json_decode($meli);
    }


    public function getVariationsMeli($id)
    {
        $meli = $this->funciones->curl("GET", "https://api.mercadolibre.com/items/$id/variations?access_token=" . $_SESSION["access_token"], "");
        return $meli;
    }

    public function deleteVariationsMeli($id, $variation)
    {
        $meli = $this->funciones->curl("DELETE", "https://api.mercadolibre.com/items/$id/variations/$variation?access_token=" . $_SESSION["access_token"], "");
        return $meli;
    }

    public function activateMeli()
    {
        $data_status = '{ "status":"active" }';
        $meli = $this->funciones->curl("PUT", "https://api.mercadolibre.com/items/$this->meli?access_token=" . $_SESSION["access_token"], $data_status);
        return $meli;
    }
    public function pauseMeli()
    {
        $data_status = '{ "status":"paused" }';
        $meli = $this->funciones->curl("PUT", "https://api.mercadolibre.com/items/$this->meli?access_token=" . $_SESSION["access_token"], $data_status);
        return $meli;
    }

    public function deleteMeli()
    {
        $data_status = '{ "status":"closed" }';
        //$data_delete = '{ "deleted":"true" }';
        $meli = $this->funciones->curl("PUT", "https://api.mercadolibre.com/items/$this->meli?access_token=" . $_SESSION["access_token"], $data_status);
        //$meli = $this->funciones->curl("PUT", "https://api.mercadolibre.com/items/$this->meli?access_token=" . $_SESSION["access_token"], $data_delete);
        return $meli;
    }

    public function viewProductMeli()
    {
        $sql = "SELECT * FROM `productos` WHERE  cod = {$this->cod} LIMIT 1";
        $productos = $this->con->sqlReturn($sql);
        $row = mysqli_fetch_assoc($productos);
        $array = array("data" => $row);
        return $array;
    }

}
