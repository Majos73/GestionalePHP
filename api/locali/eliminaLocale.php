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
$oggArm = new Armadietti($db);

$data = json_decode(file_get_contents("php://input"));

$oggArm->id_locale = $data->id;
$oggLoc->id = $data->id;

if ($oggArm->controlLocale()) {
    echo json_encode(array("Risposta" => "Impossibile eliminare il seguente locale, dato che è legato a un o più armadietti."));
} else {
    if ($oggLoc->deleteLocale()) {
        echo json_encode(array("Risposta" => "Locale " . $data->id . " eliminato con successo"));
    } else
        echo json_encode(array("Risposta" => "Problemi con l'eliminazione del locale " . $data->id));
}
