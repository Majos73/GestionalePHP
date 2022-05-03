<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$_SESSION['user'] = trim($_POST['user']);
var_dump($_POST);
$_SESSION['TS'] = time();
$strRandom = md5(microtime()); #creo stringa random da 32 caratteri dal timestamp
$_SESSION['strCodice'] = substr($strRandom, 0, 30); #estraggo 6 caratteri dalla stringa, volendo posso arrivare fino a 32 o estrarne meno
#mail($_SESSION['user'], "OTP accesso account", $_SESSION['strCodice']);
header('location: caso3_3.php');
