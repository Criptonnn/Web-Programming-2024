<?php

require_once __DIR__ . '/rest/services/ProductService.class.php';

$payload = $_REQUEST;

// TODO implement error handling

if ($payload["name"] == NULL || $payload["name"] == "") {
    header("HTTP/1.1 500 Bad Request");
    die(json_encode(["error" => "name field missing"]));
}

$product_service = new ProductService();
// ovaj if imamo kako bi add_product koristili za edit i add
if($payload["id"] != NULL && $payload["id"] != "") {
    // if hidden id is set, patient is already added, and we got the modal by clicking the edit button; edit the product
    $product = $product_service->edit_product($payload);

    echo json_encode(["message" => "You have successfully edited a product", "data" => $product, "payload" => $payload]);

} else {
    // add product
    unset($payload["id"]);
    $product = $product_service->add_product($payload);

    echo json_encode(["message" => "You have successfully added a product", "data" => $product, "payload" => $payload]);
}