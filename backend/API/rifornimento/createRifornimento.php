<?php
require __DIR__ . '/../../MODEL/rifornimento.php';
header("Content-type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin');

$data = json_decode(file_get_contents("php://input"));

if(empty($data->id_pianta) || empty($data->id_fornitore) || empty($data->quantità) || empty($data->data_ordine) || empty($data->data_arrivo) || empty($data->id_user)){
    http_response_code(404);
    echo json_encode(["message" => "Insert valid input"]);
    exit();
}

$rifornimento = new Rifornimento();

$result = $rifornimento->createRifornimento($data->id_pianta,$data->id_fornitore,$data->quantità,$data->data_ordine,$data->data_arrivo,$data->id_user);

if ($result) {
    http_response_code(404);
} else {
    http_response_code(200);
    echo json_encode(true);
}