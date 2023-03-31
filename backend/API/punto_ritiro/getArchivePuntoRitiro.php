<?php
require __DIR__ . '/../../MODEL/Punto_ritiro.php';
header("Content-type: application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);

$query = new Punto_ritiro;
$result = $query->getArchivePuntoRitiro();

$archivePuntiritiro = array();
for ($i = 0; $i < (count($result)); $i++) {
    $archivePuntoritiro= array(
        "id" =>  $result[$i]["id"],
        "nome" => $result[$i]["nome"]
    );
    array_push($archivePuntiritiro, $archivePuntoritiro);
}

if (!empty($archivePuntiritiro)) {
    echo json_encode($archivePuntoritiro);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Can't find any Pickup"]);
}
