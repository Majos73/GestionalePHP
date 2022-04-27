<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("/xampp/htdocs/GestionalePHP/class/componenti.php");
include_once '/xampp/htdocs/GestionalePHP/config/database.php';

$database = new Database();
$db = $database->getConnection();

$oggComp = new Componenti($db);

$data = json_decode(file_get_contents("php://input"));

$oggComp->componente = $data->componente;
$oggComp->sigla = $data->sigla;
$oggComp->valore = $data->valore;
$oggComp->umValore = $data->umValore;
$oggComp->valore2 = $data->valore2;
$oggComp->umValore2 = $data->umValore2;
$oggComp->note = $data->note;
$oggComp->immagine = $data->immagine;
$oggComp->quantitaMin = $data->quantitaMin;
$oggComp->id_categoria = $data->id_categoria;
$oggComp->id_catalogo = $data->id_catalogo;

if ($oggComp->createComponente()) {
    echo ("Tutto bene");
} else
    echo "Male male";
