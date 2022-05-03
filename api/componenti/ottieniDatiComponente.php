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

$oggCom = new Componenti($db);

$data = json_decode(file_get_contents("php://input"));

$oggCom->id = $data->id;

if ($componente = $oggCom->getSingleComponente()) {
    echo json_encode(array(
        "componente" => $componente['nomeComp'],
        "sigla" => $componente['sigla'],
        "valore" => $componente['valore'],
        "umValore" => $componente['umValore'],
        "valore2" => $componente['valore2'],
        "umValore2" => $componente['umValore2'],
        "note" => $componente['note'],
        "immagine" => $componente['immagine'],
        "quantitaMin" => $componente['quantitaMin'],
        "id_categoria" => $componente['ID_Categoria'],
        "id_catalogo" => $componente['ID_Catalogo'],
        "risposta" => true
    ));
} else
    echo json_encode(array("risposta" => false));
