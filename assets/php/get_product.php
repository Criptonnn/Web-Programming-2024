<?php

require_once __DIR__ . "/rest/services/ProductService.class.php";

$product_id = $_REQUEST["id"];

$product_service = new ProductService();

$product = $product_service->get_product_by_id($product_id);

// ovo treba da bi edit dugme radilo, inace returna text, a mi hocemo da nam returna json kako bi
// mogli accessat sa data.id, data.name,...
header('Content-Type: application/json');

echo json_encode($product);