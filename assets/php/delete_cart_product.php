<?php

require_once __DIR__ . "/rest/services/CartService.class.php";

$cart_product_id = $_REQUEST["id"]; // passali smo ga u url (?id=id)

if ($cart_product_id == NULL || $cart_product_id == "") {
    header("HTTP/1.1 500 Bad Request");
    die(json_encode(["error" => "Invalid cart product id"]));
}

$cart_service = new CartService();

$cart_service-> delete_cart_product($cart_product_id);

echo json_encode(["message" => "you have successfully deleted a cart product"]);