<?php

require __DIR__ . '/../../../vendor/autoload.php';

if($_SERVER["SERVER_NAME"] == "localhost" || $_SERVER["SERVER_NAME"] == "127.0.0.1") {
    define('BASE_URL', 'http://localhost/Web-Programming-2024/assets/php/');
} else {
    define('BASE_URL', $_SERVER["SERVER_NAME"] . "assets/php/"); // SERVER["SERVER_NAME"] = https://king-prawn-app-rtyg8.ondigitalocean.app/
}

error_reporting(0);

$openapi = \OpenApi\Generator::scan(['../../../rest/routes', './']);
// $openapi = \OpenApi\Util::finder(['../../../rest/routes', './'], NULL, '*.php');
// $openapi = \OpenApi\scan(['../../../rest', './'], ['pattern' => '*.php']);

header('Content-Type: application/x-yaml');
echo $openapi->toYaml();
?>