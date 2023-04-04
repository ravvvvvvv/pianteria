<?php
require __DIR__ . '/../../MODEL/Fornitore.php';
header("Content-type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin');

$data = json_decode(file_get_contents("php://input"));

if(empty($data->id_fornitore) || empty($data->nome) || empty($data->email) || empty($data->telefono) || empty($data->stato)){
    http_response_code(404);
    echo json_encode(["message" => "Insert valid input"]);
    exit();
}


$fornitore = new Fornitore();

$result = $fornitore->modifyFornitore($data->id_fornitore, $data->nome, $data->email, $data->telefono, $data->stato);

if ($result) {
    http_response_code(404);
} else {
    http_response_code(200);
    echo json_encode($result);
}
