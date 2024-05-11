<?php

require_once __DIR__ . "/../services/UserService.class.php";
require_once __DIR__ . "/../authorization.php";

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::set("user_service", new UserService);

Flight::group("/users", function() {

    /**
     * @OA\Get(
     *      path="/users/all",
     *      tags={"users"},
     *      summary="Get all users",
     *      @OA\Response(
     *           response=200,
     *           description="Get all users"
     *      )
     * )
     */
    Flight::route("GET /all", function() {
        $data = Flight::get("user_service")->get_all_users();
        Flight::json($data);
    });

    // In order for the DELETE to work for users who have a Cart bound to them, we need to update the foreign key constaint in the cart table and set it to ON DELETE = CASCADE, to delete both the user and the cart
    /**
     * @OA\Delete(
     *      path="/users/delete/{user_id}",
     *      tags={"users"},
     *      summary="Delete user by id",
     *      @OA\Response(
     *           response=200,
     *           description="Delete the user with the specified id from the database, or get 'Invalid user id'"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="user_id", example="1", description="User ID")
     * )
     */
    Flight::route("DELETE /delete/@user_id", function($user_id) {

        // try {
        //     $token = Flight::request()->getHeader("Authentication");
        //     if(!$token) {
        //         Flight::halt(500, "Missing Auth Header");
        //     }
        //     $decoded_token = JWT::decode($token, new Key(JWT_SECRET, "HS256"));
        //     // Flight::json([
        //     //     "jwt_decoded" => $decoded_token,
        //     //     "user" => $decoded_token->user
        //     // ]);
        // } catch(\Exception $e) {
        //     Flight::halt(401, $e->getMessage()); // errori vezani za provjeru tokena, token expired, pogresan jwt_secret...
        // }

        // --- php/rest/authorization.php ---
        authorize();

        if ($user_id == NULL || $user_id == "") {
            Flight::halt(500, "Invalid user id");
        }
        
        Flight::get("user_service")->delete_user($user_id);
        
        Flight::json(["message" => "you have successfully deleted an user"]);
    });

    /**
     * @OA\Post(
     *      path="/users/add",
     *      tags={"users"},
     *      summary="Add an user",
     *      @OA\Response(
     *           response=200,
     *           description="Input the user info and add the user to the database"
     *      ),
     *      @OA\RequestBody(
     *          description="User data payload",
     *          @OA\JsonContent(
     *              required={"firstName", "lastName", "email", "password"},
     *              @OA\Property(property="firstName", type="string", example="Example Name", description="User Name"),
     *              @OA\Property(property="lastName", type="string", example="Example Name", description="User Lastname"),
     *              @OA\Property(property="email", type="string", example="example@gmail.com", description="User Email"),
     *              @OA\Property(property="pwd", type="string", example="Example Password", description="User Password"),
     *          )
     *      )
     * )
     */
    Flight::route("POST /add", function() {
        $payload = Flight::request()->data->getData();

        if ($payload["firstName"] == NULL || $payload["firstName"] == "") {
            Flight::halt(500, "Invalid input");
        }

        $user = Flight::get("user_service")->add_user($payload);
        
        Flight::json(["message" => "You have successfully added a user", "data" => $user, "payload" => $payload]);
        
    });

    Flight::route("GET /", function() {
        
        // --- php/rest/authorization.php ---
        authorize();

        $payload = Flight::request()->query;
    
        // ovi params se passaju kroz payload koji dodje uz DataTables, sve ove values su definisani od njegove strane
        // oni ce nam trebati kako bi u queriju znali kako da sortamo, po cemu da sortamo...
        $params = [
            'start' => (int) $payload['start'], // offset, vezano za table page numbers, ako je page 2, onda ide od 11-og itema...
            'search' => $payload['search']['value'],
            'draw' => $payload['draw'],
            'limit' => (int) $payload['length'], // number of entries per page
            'order_column' => $payload['order'][0]['name'],
            'order_direction' => $payload['order'][0]['dir']
        ];
    
        $data = Flight::get("user_service")->get_users_paginated($params["start"], $params["limit"], $params["search"], $params["order_column"], $params["order_direction"]);
    
        // Get data query
    
        // kako ovo radi??????????? 
        //$data variable [data, zato sto imamo i draw, end, recordsFiletered...] [id, da znamo koji row u data array] [action, targetamno action field] 
        //$data["data"] je associative array, i mi loopamo kroz njega u vidu key:id, value: productObject(koji ima id,name,brand...), data["data"] mozemo vidjeti u payload
        foreach($data["data"] as $id => $user) {
            $data["data"][$id]["action"] = '<div class="btn-group" role="group" aria-label="Actions">
                                                <button type="button" class="btn btn-outline-danger" onclick="UserService.delete_user(' . $user["id"] . ')">Delete</button>
                                            </div>';
        }
    
        Flight::json([
            'draw' => $params['draw'],
            'data' => $data["data"], // OVAJ DATA NAM SADRZI SVE ROWS IZ TABELE I COLUMNS IZ BAZE, I U services/product.js "data" se referenca na ovu data
            'recordsFiltered' => $data['count'],
            'recordsTotal' => $data['count'],
            'end' => $data['count']
        ]);
    });
});
