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

$oggArm->armadietto = $data->armadietto;
$oggArm->ripiani = $data->ripiani;
$oggArm->numPorte = $data->numeroPorte;
$oggArm->larghezza = $data->larghezza;
$oggArm->lunghezza = $data->lunghezza;
$oggArm->altezza = $data->altezza;
$oggArm->id_locale = $data->id_locale;

if ($oggArm->createArmadietto()) {
    echo ("Tutto bene");
} else
    echo "Male male";
