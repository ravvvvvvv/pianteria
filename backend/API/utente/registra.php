<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

require __DIR__ . '/../../MODEL/Utente.php';
header("Content-type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));


// Se i dati sono insufficienti per un utente di base
if (empty($data->username) || empty($data->email) || empty($data->password) || empty($data->livello_permessi))
{
    http_response_code(400);
    echo json_encode(["message" => "Dati insufficienti o non corretti per la creazione di un utente"]);
    die();
}
// Se i dati di base sono sufficienti
$utente = new Utente();

// Provo a registrare lo utente
$result = $utente->registraUtente($data->username, $data->email, $data->password, $data->livello_permessi);

echo json_encode($result);

?>
