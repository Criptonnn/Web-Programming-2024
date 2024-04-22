<?php

require_once __DIR__ . "/rest/services/UserService.class.php";

$user_id = $_REQUEST["id"]; // passali smo ga u url (?id=id)

if ($user_id == NULL || $user_id == "") {
    header("HTTP/1.1 500 Bad Request");
    die(json_encode(["error" => "Invalid user id"]));
}

$user_service = new UserService();

$user_service->delete_user($user_id);

echo json_encode(["message" => "you have successfully deleted an user"]);