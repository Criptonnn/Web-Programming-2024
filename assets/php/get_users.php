<?php

require_once __DIR__ . "/rest/services/UserService.class.php";

$payload = $_REQUEST;

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

$user_service = new UserService();

// Count query

$data = $user_service->get_users_paginated($params["start"], $params["limit"], $params["search"], $params["order_column"], $params["order_direction"]);

// Get data query

// kako ovo radi??????????? 
//$data variable [data, zato sto imamo i draw, end, recordsFiletered...] [id, da znamo koji row u data array] [action, targetamno action field] 
//$data["data"] je associative array, i mi loopamo kroz njega u vidu key:id, value: productObject(koji ima id,name,brand...), data["data"] mozemo vidjeti u payload
foreach($data["data"] as $id => $user) {
    $data["data"][$id]["action"] = '<div class="btn-group" role="group" aria-label="Actions">
                                        <button type="button" class="btn btn-outline-danger" onclick="UserService.delete_user(' . $user["id"] . ')">Delete</button>
                                    </div>';
}

// this is the response we want to return
echo json_encode([
    'draw' => $params['draw'],
    'data' => $data["data"], // OVAJ DATA NAM SADRZI SVE ROWS IZ TABELE I COLUMNS IZ BAZE, I U services/product.js "data" se referenca na ovu data
    'recordsFiltered' => $data['count'],
    'recordsTotal' => $data['count'],
    'end' => $data['count']
]);
