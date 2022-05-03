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
$oggGiac->posizione = $data->posizione;
$oggGiac->nomeCassetto = $data->cassetto;
$oggGiac->quantita = $data->quantita;
$oggGiac->quantitaSpann = $data->quantitaSpan;
$oggGiac->id_armadietto = $data->idArmadietto;
$oggGiac->id_componente = $data->componente;


if ($oggGiac->updateGiacenza()) {
    echo ("Tutto bene");
} else
    echo "Male male";
