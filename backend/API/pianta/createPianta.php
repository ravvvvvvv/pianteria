<?php
require __DIR__ . '/../../MODEL/pianta.php';
header("Content-type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('HTTP/1.1 200 OK');
}

$data = json_decode(file_get_contents("php://input"));

if(empty($data->nome) || empty($data->nomeScientifico) || empty($data->fiore) || empty($data->colore1) || empty($data->colore2) || empty($data->prezzo) || empty($data->quantità) || empty($data->adottabile) || empty($data->attivo) || empty($data->stagione)){
    http_response_code(404);
    echo json_encode(["message" => "Insert valid input"]);
    exit();
}

$pianta = new Pianta();

if($data->adottabile == 2) {
	$result = $pianta->createPianta($data->nome, $data->nomeScientifico, $data->fiore, $data->colore1, $data->colore2, $data->prezzo, $data->quantità, $data->adottabile, $data->attivo, $data->stagione);
} else {
	$result = $pianta->createPiantaAdottabile($data->nome, $data->nomeScientifico, $data->fiore, $data->colore1, $data->colore2, $data->prezzo, $data->quantità, $data->adottabile, $data->prezzo_adozione, $data->inizio_raccolto, $data->fine_raccolto, $data->attivo, $data->stagione);
}

if ($result) {
    http_response_code(404);
} else {
    http_response_code(200);
    echo json_encode($result);
}
