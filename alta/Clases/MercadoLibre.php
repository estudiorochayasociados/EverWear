<?php

namespace Clases;

use DateTime;

class MercadoLibre extends Productos
{
    private $options;

    public function setOptions(array $opt)
    {
        $this->options = [
            "types" => [
                [
                    "name" => "gold_special",
                    "value" => $opt['classic']
                ],
                [
                    "name" => "gold_pro",
                    "value" => $opt['premium']
                ]
            ],
            "check1" => $opt['check1']
        ];
    }

    public function checkExpiration()
    {
        if (!empty($_SESSION['access_token'])) {
            $interval = date_diff(
                new DateTime(date('Y-m-d H:i:s')),
                new DateTime(date("Y-m-d H:i:s", $_SESSION['expires_in']))
            );

            if (empty($interval->h)) {
                if ($interval->i <= 10) {
                    $this->refreshToken();
                }
            }
        }
    }

    /*
     * PRIVATE
     */

    private function refreshToken()
    {
        $cfg = new Config();
        $keys = $cfg->viewMercadoLibre();

        $data = json_encode([
            "grant_type" => "refresh_token",
            "client_id" => $keys['data']['app_id'],
            "client_secret" => $keys['data']['app_secret'],
            "refresh_token" => $_SESSION['refresh_token']
        ]);

        $result = json_decode(
            $this->f->curl(
                "POST",
                "https://api.mercadolibre.com/oauth/token",
                $data
            ),
            true
        );

        if (isset($result['access_token'])) {
            $expires = strtotime(date("Y-m-d H:i:s")) + $result['expires_in'];
            $_SESSION['access_token'] = $result['access_token'];
            $_SESSION['user_id'] = $result['user_id'];
            $_SESSION['expires_in'] = $expires;
            $_SESSION['refresh_token'] = $result['refresh_token'];
        } else {
            $this->destroy();
        }
    }

    private function destroy()
    {
        unset($_SESSION['access_token']);
        unset($_SESSION['user_id']);
        unset($_SESSION['expires_in']);
        unset($_SESSION['refresh_token']);
    }

    private function checkCategoryShipping($id)
    {
        $categoryData = json_decode(
            $this->f->curl(
                "GET",
                "https://api.mercadolibre.com/categories/" . $id . "/shipping_preferences",
                ""
            ),
            true
        );

        if (empty($categoryData['dimensions'])) return ["status" => false];

        $from = 2400;
        $to = 1675;
        $dimensions = $categoryData['dimensions']['height'] . "x" . $categoryData['dimensions']['width'] . "x" . $categoryData['dimensions']['length'] . "," . $categoryData['dimensions']['weight'];
        $shipCost = json_decode(
            $this->f->curl(
                "GET",
                "https://api.mercadolibre.com/sites/MLA/shipping_options?zip_code_from=" . $from . "&zip_code_to=" . $to . "&dimensions=" . $dimensions,
                ""
            ),
            true
        );

        if (isset($shipCost['error'])) return ["status" => false];

        $cost = 0;
        foreach ($shipCost['options'] as $shipOptions) {
            if ($shipOptions['cost'] > $cost) $cost = $shipOptions['cost'];
        }

        return ["status" => true, "cost" => $cost];
    }

    private function changePriceByType()
    {
        if (empty($this->variable7) || is_int($this->variable7)) $this->variable7 = '1';
        $this->precio += ($this->precio * $this->options["types"][$this->variable7 - 1]["value"]) / 100;
        $this->precio = ceil($this->precio);
        return ["type" => $this->options["types"][$this->variable7 - 1]["name"]];
    }

    private function normalize($string)
    {
        $utf8 = [
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u' => 'A',
            '/[ÍÌÎÏ]/u' => 'I',
            '/[íìîï]/u' => 'i',
            '/[éèêë]/u' => 'e',
            '/[ÉÈÊË]/u' => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u' => 'O',
            '/[úùûü]/u' => 'u',
            '/[ÚÙÛÜ]/u' => 'U',
            '/ç/' => 'c',
            '/Ç/' => 'C',
            //'/ñ/' => 'n',
            //'/Ñ/' => 'N',
            '/–/' => '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u' => ' ', // Literally a single quote
            '/[“”«»„]/u' => ' ', // Double quote
            '/ /' => ' ', // nonbreaking space (equiv. to 0x160)
        ];
        $string = preg_replace(array_keys($utf8), array_values($utf8), trim($string));

        $first = '/[^A-Za-z0-9\ ';
        $end = '-]/';

        $string = preg_replace($first . $end, ' ', $string);
        $string = str_replace(" ", "%20", $string);

        return strtolower($string);
    }

    /*
     * END PRIVATE
     */

    public function read($id)
    {
        return json_decode(
            $this->f->curl(
                "GET",
                "https://api.mercadolibre.com/items/$id?access_token=" . $_SESSION["access_token"],
                ""
            ),
            true
        );
    }

    public function create()
    {
        $result = json_decode(
            $this->f->curl(
                "GET",
                "https://api.mercadolibre.com/sites/MLA/category_predictor/predict?title=" . $this->normalize(substr($this->variable9, 0, 200)) . "",
                ""
            ),
            true
        );

        !empty($result) ? $prediction = $result['id'] : $prediction = "MLA4594";

        $type = $this->changePriceByType();

        $price = $this->precio;
        $cost = 0;
        $shipping = false;
        $mode = "me2";
        $shippingData = $this->checkCategoryShipping($prediction);
        if ($this->options['check1']) {
            if ($shippingData['status']) {
                if ($this->precio >= 1950) {
                    $shipping = true;
                    $this->precio = $this->precio + ceil($shippingData['cost']);
                    $cost = ceil($shippingData['cost']);
                }
            } else {
                $mode = "not_specified";
            }
        } else {
            if ($shippingData['status']) {
                if ($this->precio >= 1950) $shipping = true;
            } else {
                $mode = "not_specified";
            }
        }

        $data = [
            "title" => $this->titulo,
            "category_id" => $prediction,
            "price" => $this->precio,
            "currency_id" => "ARS",
            "available_quantity" => $this->stock,
            "buying_mode" => "buy_it_now",
            "listing_type_id" => $type['type'],
            "condition" => "new",
            "description" => [
                "plain_text" => strip_tags($this->desarrollo)
            ],
            "tags" => [
                "immediate_payment"
            ],
            "video_id" => '',
            "attributes" => [
                [
                    "id" => "EAN",
                    "value_name" => "123212451323"
                ],
                [
                    "id" => "ITEM_CONDITION",
                    "name" => "Condición del ítem",
                    "value_id" => "2230284",
                    "value_name" => "Nuevo",
                    "value_struct" => null,
                    "attribute_group_id" => "OTHERS",
                    "attribute_group_name" => "Otros"
                ]
            ],
            "pictures" => [
                [
                    "source" => LOGO
                ]
            ],
            "shipping" => [
                "mode" => $mode,
                "local_pick_up" => true,
                "free_shipping" => $shipping,
                "free_methods" => []
            ]
        ];

        if (!empty($this->cod_producto)) {
            array_push($data['atributes'], ["id" => "SELLER_SKU", "value_name" => $this->cod_producto]);
        }

        if (!empty($this->img) && $this->img != 'NULL') {
            foreach ($this->img as $img_) {
                array_push($data['pictures'], $img_);
            }
        }

        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $data = str_replace("\\\\", "\\", $data);

        $meli = json_decode(
            $this->f->curl(
                "POST",
                "https://api.mercadolibre.com/items?access_token=" . $_SESSION["access_token"],
                $data
            ),
            true
        );

        $response = [
            "status" => false,
            "data" => '',
            "error" => '',
            "price" => $price,
            "shipment" => $cost
        ];

        if (isset($meli['error'])) {
            !empty($meli['cause']) ? $response['error'] = $meli['cause'] : $response['error'] = $meli['error'];
        } else {
            $response['status'] = true;
            $response['data'] = $meli;
        }

        return $response;
    }

    public function update(string $category = '')
    {
        $variations = $this->getVariations($this->meli);
        if (is_array($variations)) {
            foreach ($variations as $value) {
                $this->deleteVariations($this->meli, $value->id);
            }
        }

        $this->changePriceByType();

        $price = $this->precio;
        $cost = 0;
        $shippingData = $this->checkCategoryShipping($category);
        if ($this->options['check1']) {
            if ($shippingData['status']) {
                if ($this->precio >= 1950) {
                    $this->precio = $this->precio + ceil($shippingData['cost']);
                    $cost = ceil($shippingData['cost']);
                }
            }
        }

        $data = [
            "title" => $this->titulo,
            "price" => $this->precio,
            "available_quantity" => $this->stock,
            "pictures" => [
                [
                    "source" => LOGO
                ]
            ]
        ];

        if (!empty($this->img) && $this->img != 'NULL') {
            foreach ($this->img as $img_) {
                array_push($data['pictures'], $img_);
            }
        }

        $meli = json_decode(
            $this->f->curl(
                "PUT",
                "https://api.mercadolibre.com/items/$this->meli?access_token=" . $_SESSION["access_token"],
                json_encode($data, JSON_UNESCAPED_UNICODE)
            ),
            true
        );

        $response = [
            "status" => false,
            "data" => '',
            "error" => '',
            "price" => $price,
            "shipment" => $cost
        ];

        if (isset($meli['error'])) {
            !empty($meli['cause']) ? $response['error'] = $meli['cause'] : $response['error'] = $meli['error'];
        } else {
            if ($meli['available_quantity'] > 0) {
                if ($meli['status'] == 'paused') $this->activate();
            }
            $response['status'] = true;
            $response['data'] = $meli;
        }

        return $response;
    }

    public function validateItem()
    {
        $data = json_decode(
            $this->f->curl(
                "",
                'https://api.mercadolibre.com/items/' . $this->meli,
                ''
            ),
            true
        );

        if (isset($data["status"])) {
            if (is_numeric($data["status"])) {
                return ["status" => false, "text" => "El código de producto en MercadoLibre ingresado es incorrecto."];
            } else {
                if ($_SESSION["user_id"] == $data["seller_id"]) {
                    if ($data['status'] != 'closed') {
                        return ["status" => true, "substatus" => true, "data" => $data];
                    } else {
                        return ["status" => true, "substatus" => false, "text" => "El producto con este código se encuentra eliminado."];
                    }
                } else {
                    return ["status" => false, "text" => "El código ingresado es de otro usuario, usted no puedo modificarlo."];
                }
            }
        } else {
            return ["status" => false, "text" => "El código de producto en MercadoLibre ingresado es incorrecto."];
        }
    }

    public function getVariations($id)
    {
        return json_decode($this->f->curl(
            "GET",
            "https://api.mercadolibre.com/items/$id/variations?access_token=" . $_SESSION["access_token"],
            ""
        ));
    }

    public function deleteVariations($id, $variation)
    {
        $this->f->curl(
            "DELETE",
            "https://api.mercadolibre.com/items/$id/variations/$variation?access_token=" . $_SESSION["access_token"],
            ""
        );
    }

    public function activate()
    {
        $this->f->curl(
            "PUT",
            "https://api.mercadolibre.com/items/$this->meli?access_token=" . $_SESSION["access_token"],
            '{ "status":"active" }'
        );
    }

    public function pause()
    {
        $this->f->curl(
            "PUT",
            "https://api.mercadolibre.com/items/$this->meli?access_token=" . $_SESSION["access_token"],
            '{ "status":"paused" }'
        );
    }

    public function delete()
    {
        $this->f->curl(
            "PUT",
            "https://api.mercadolibre.com/items/$this->meli?access_token=" . $_SESSION["access_token"],
            '{ "status":"closed" }'
        );
    }

    public function viewDescription()
    {
        $meli = json_decode(
            $this->f->curl(
                "GET",
                "https://api.mercadolibre.com/items/" . $this->meli . "/description",
                ""
            ),
            true
        );

        if (isset($meli['error'])) {
            return '';
        } else {
            return $meli;
        }
    }

    public function shipCost($zip)
    {
        $meli = json_decode(
            $this->f->curl(
                "GET",
                "https://api.mercadolibre.com/sites/MLA/shipping_options?zip_code_from=1059&zip_code_to=" . $zip . "&dimensions=10x10x10,2000",
                ""
            ),
            true
        );

        if (isset($meli['error'])) {
            return ['status' => false, "message" => "Código postal incorrecto"];
        } else {
            return ['status' => true, "data" => $meli];
        }
    }

    public function getAllOrders(string $type = '')
    {
        //Type: archived,''
        $meli = json_decode(
            $this->f->curl(
                "GET",
                "https://api.mercadolibre.com/orders/search/" . $type . "/facets?seller=145263251&access_token=" . $_SESSION["access_token"],
                ""
            ),
            true
        );

        if (isset($meli['error'])) {
            return ["status" => false];
        } else {
            return ["status" => true, "data" => $meli];
        }
    }

    public function getOrdersPaginated(string $type = '', string $page = '0')
    {
        //Type: archived,''
        $meli = json_decode(
            $this->f->curl(
                "GET",
                "https://api.mercadolibre.com/orders/search/" . $type . "?seller=145263251&access_token=" . $_SESSION["access_token"] . "&offset=" . $page,
                ""
            ),
            true
        );

        if (isset($meli['error'])) {
            return ["status" => false];
        } else {
            return ["status" => true, "data" => $meli];
        }
    }
}