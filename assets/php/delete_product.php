 <?php

require_once __DIR__ . "/rest/services/ProductService.class.php";

$product_id = $_REQUEST["id"]; // passali smo ga u url (?id=id)

if ($product_id == NULL || $product_id == "") {
    header("HTTP/1.1 500 Bad Request");
    die(json_encode(["error" => "Invalid product id"]));
}

$product_service = new ProductService();

$product_service->delete_product($product_id);

echo json_encode(["message" => "you have successfully deleted a product"]);