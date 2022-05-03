<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("/xampp/htdocs/GestionalePHP/class/armadietti.php");
include_once '/xampp/htdocs/GestionalePHP/config/database.php';

$database = new Database();
$db = $database->getConnection();

$oggArm = new Armadietti($db);

$data = json_decode(file_get_contents("php://input"));

$oggArm->id = $data->id;

if ($armadietto = $oggArm->getSingleArmadietto()) {
    echo json_encode(array(
        "nome" => $armadietto['nomeArmadietto'],
        "ripiani" => $armadietto['ripiani'],
        "numPorte" => $armadietto['numPorte'],
        "larghezza" => $armadietto['larghezza'],
        "lunghezza" => $armadietto['lunghezza'],
        "altezza" => $armadietto['altezza'],
        "locale" => $armadietto['ID_Locale'],
        "risposta" => true
    ));
} else
    echo json_encode(array("risposta" => false));
