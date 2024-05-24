<?php
// GLUP ERROR; OVAJ KOMENTAR JE BIO IZVAN <?php I TO MI JE VRACALO U RESPONSE I PREVIEW, I NIJE BIO VALID JSON
// <!-- this makes it so that we have a single point access to our php filed, we don't want users to enter in the URL any php script they want -->

require "vendor/autoload.php";

require "rest/routes/middleware_routes.php";

require "rest/routes/product_routes.php";
require "rest/routes/user_routes.php";
require "rest/routes/cart_routes.php";
require "rest/routes/auth_routes.php";
// require "public/v1/docs/swagger.php"; NE TREBA OVO, INACE NIJE RADILO KAD ACCESSAM URL public/v1/docs, FIX JE BIO DA U .htaccess DODAMO ONA DVA RewriteCond

Flight::route("GET /web", function() {
    echo "GET REQ RADI";
    // $data = Flight::get("product_service")->get_all_products();
    // Flight::json($data);
});

Flight::start();
