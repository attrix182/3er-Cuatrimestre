<?php
require_once 'clases\Ovni.php';


$tipo = $_POST["tipo"] ?? null;
$velocidad = $_POST["velocidad"] ?? null;
$planetaOrigen = $_POST["planetaOrigen"] ?? null;

$resp = new stdClass();
$resp->exito = true;
$resp->mensaje = "Se pudo agregar";


$nueva = new Ovni(null, $tipo, $velocidad, $planetaOrigen);
$nueva->Agregar();

echo json_encode($resp);


?>