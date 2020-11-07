<?php
require_once 'clases\Ciudad.php';

$nombre = $_POST["nombre"] ?? null;
$poblacion = $_POST["poblacion"] ?? null;
$pais = $_POST["pais"] ?? null;

$resp = new stdClass();
$resp->exito = true;
$resp->mensaje = "Se pudo agregar";


$nueva = new Ciudad(null, $nombre, $poblacion, $pais);
$nueva->Agregar();

echo json_encode($resp);


?>