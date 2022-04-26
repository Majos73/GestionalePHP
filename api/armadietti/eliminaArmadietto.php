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
$oggLoc = new Locali($db);

$data = json_decode(file_get_contents("php://input"));

$oggArm->id = $data->idArmadietto;

$oggLoc->id = $data->id;

if($oggLoc->controlLocale()){
    echo json_encode(false);
}
else{
    if ($oggArm->deleteArmadietto()) {
        echo json_encode("Siamo entrati");
    } else
        echo json_encode("Non siamo entrati");
}


