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

$oggComp->id = $data->id;

if ($oggComp->deleteComponente()) {
    echo json_encode("Siamo entrati");
} else
    echo json_encode("Non siamo entrati");
