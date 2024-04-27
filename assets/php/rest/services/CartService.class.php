<?php

require_once __DIR__ . '/../dao/CartDao.class.php';

class CartService {

    private $cart_dao;

    public function __construct() {
        $this->cart_dao = new CartDao();
    }


    public function get_cart_products_paginated($cartId) {
        $rows =  $this->cart_dao-> get_cart_products_paginated($cartId);

        return [
            'data' => $rows
        ];
    }
    public function delete_cart_product($cart_product_id) {
        $this->cart_dao->delete_cart_product($cart_product_id);
    }

}