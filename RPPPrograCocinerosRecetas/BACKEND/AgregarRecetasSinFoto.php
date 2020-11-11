<?php
require_once 'clases\Receta.php';


$tipo = $_POST["tipo"] ?? null;
$ingredientes = $_POST["ingredientes"] ?? null;
$nombre = $_POST["nombre"] ?? null;

$resp = new stdClass();
$resp->exito = true;
$resp->mensaje = "Se pudo agregar";


$nueva = new Receta(null, $nombre, $ingredientes, $tipo);
$nueva->Agregar();

echo json_encode($resp);


?>