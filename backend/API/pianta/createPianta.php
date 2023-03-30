<?php
require __DIR__ . '/../../MODEL/pianta.php';
header("Content-type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin');

$data = json_decode(file_get_contents("php://input"));

if(empty($data->nome) || empty($data->nome_scientifico) || empty($data->fiore) || empty($data->colore1) || empty($data->colore2) || empty($data->prezzo) || empty($data->quantità) || empty($data->adottabile) || empty($data->prezzo_adozione)){
    http_response_code(404);
    echo json_encode(["message" => "Insert valid input"]);
    exit();
}

$inizio_raccolto;
if(empty($data->inizio_raccolto)){
    $inizio_raccolto = null;
}else{
    $inizio_raccolto = $data->inizio_raccolto;
}

$fine_raccolto;
if(empty($data->fine_raccolto)){
    $fine_raccolto = null;
}else{
    $fine_raccolto = $data->fine_raccolto;
}

$pianta = new Pianta();

$result = $pianta->createPianta($data->nome, $data->nome_scientifico, $data->fiore, $data->colore1, $data->colore2, $data->prezzo, $data->quantità, $data->adottabile, $data->prezzo_adozione, $inizio_raccolto, $fine_raccolto);

/*if ($result) {
    http_response_code(404);
} else {
    http_response_code(200);
    echo json_encode($result);
}*/