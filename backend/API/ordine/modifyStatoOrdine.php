<?php
require __DIR__ . '/../../MODEL/ordine.php';
header("Content-type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin');
$parts = explode("/", $_SERVER["REQUEST_URI"]);
if(empty($parts[5]) || empty($parts[6])){
    http_response_code(404);
    echo json_encode(["message" => "Insert a valid ID"]);
    exit();
}

$ordine = new Ordine();

$result = $ordine->modifyStatoOrdine($parts[5],$parts[6]);

if (empty($result)) {
    http_response_code(404);
} else {
    http_response_code(200);
    echo json_encode($result);
}
