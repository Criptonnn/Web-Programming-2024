<?php

require_once __DIR__ . '/BaseDao.class.php';

class CartDao extends BaseDao {
    public function __construct() {
        parent::__construct('cart');
    }

    public function get_cart_products_paginated($cartId) {
        $query = "SELECT 
            cp.id, #bitan detalj je da passamo id od cartProducta, ovako je najlakse jer ovo koristimo da deletamo id
            p.name, 
            p.brand, 
            p.description, 
            p.gender, 
            p.category, 
            p.rating, 
            p.price, 
            p.image, 
            cp.quantity,
            cp.size
            FROM 
                product p
            JOIN 
                cart_products cp ON p.id = cp.productId
            JOIN 
                cart c ON c.id = cp.cartId
            WHERE c.id = :cartId;
        ";
        
       return $this->query($query, ["cartId" => $cartId]);
    }

    public function delete_cart_product($id) {
        $query = "DELETE
                  FROM cart_products 
                  WHERE id = :id";
        $this->execute($query, ["id" => $id]);
    }
}
