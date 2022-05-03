<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("/xampp/htdocs/GestionalePHP/class/giacenze.php");
include_once '/xampp/htdocs/GestionalePHP/config/database.php';

$database = new Database();
$db = $database->getConnection();

$oggGiac = new Giacenze($db);

$data = json_decode(file_get_contents("php://input"));

$oggGiac->id = $data->id;

if ($giacenza = $oggGiac->getSingleGiacenza()) {
    echo json_encode(array(
        "posizione" => $giacenza['posizione'],
        "nomeCassetto" => $giacenza['nomeCassetto'],
        "quantita" => $giacenza['quantita'],
        "quantitaSpann" => $giacenza['quantitaSpann'],
        "idArmadietto" => $giacenza['ID_Armadietto'],
        "risposta" => true
    ));
} else
    echo json_encode(array("risposta" => false));
