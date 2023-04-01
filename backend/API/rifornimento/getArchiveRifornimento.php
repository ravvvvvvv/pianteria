<?php
require __DIR__ . '/../../MODEL/rifornimento.php';
header("Content-type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin');

$ordine_fornitore = new Rifornimento();

$result = $ordine_fornitore->getArchiveRifornimento();

if (empty($result)) {
    http_response_code(404);
} else {
    http_response_code(200);
    echo json_encode($result);
}
