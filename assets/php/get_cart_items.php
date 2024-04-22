<?php

require_once __DIR__ . "/rest/services/CartService.class.php";

$payload = $_REQUEST;


$cartId = 1;

$cart_service = new CartService();

$data = $cart_service->get_cart_products_paginated($cartId);

header('Content-Type: application/json');

echo json_encode($data["data"]);
// echo json_encode(["message" => "Products succesfully retreived from database", "data" => $data["data"]]); moze i ovako, ali onda imamo problem sa data.forEach jer ovaj message smeta