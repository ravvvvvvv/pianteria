<?php
require __DIR__ . '/../../MODEL/Adozione.php';
header("Content-type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin');

$parts = explode("/", $_SERVER["REQUEST_URI"]);
if(empty($parts[6])){
    http_response_code(404);
    echo json_encode(["message" => "Insert a valid ID"]);
    exit();
}

$adozione = new Adozione();

$result = $adozione->getAdozione($parts[6]);

if ($result != false) {
    echo json_encode($result);
} else {
    http_response_code(400);
    echo json_encode(["message" => "Fornitore not found"]);
}

//wefseffe
