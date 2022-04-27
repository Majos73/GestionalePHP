<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once("/xampp/htdocs/GestionalePHP/class/locali.php");
include_once("/xampp/htdocs/GestionalePHP/class/armadietti.php");
include_once '/xampp/htdocs/GestionalePHP/config/database.php';

$database = new Database();
$db = $database->getConnection();

$oggLoc = new Locali($db);

$data = json_decode(file_get_contents("php://input"));

$oggLoc->id = $data->id;

if ($locale = $oggLoc->getSingleLocale()) {
    echo json_encode(array("locale" => $locale, "risposta"=>true ));

} else
    echo json_encode(array("risposta" => false));

