<?php
require __DIR__ . '/../../MODEL/Fornitore.php';
header("Content-type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin');

$data = json_decode(file_get_contents("php://input"));

if (empty($data->nome) || empty($data->email) || empty($data->telefono))
{
    http_response_code(400);
    echo json_encode(["message" => "Dati insufficienti o non corretti per la creazione di un utente"]);
    die();
}
// Se i dati di base sono sufficienti
$fornitore = new Fornitore();

// Provo a registrare lo utente
$result = $fornitore->createFornitore($data->nome, $data->email, $data->telefono);

echo json_encode($result);

?>
