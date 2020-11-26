<?php
require_once 'clases\Ciudad.php';

$resp = new stdClass();
$resp->exito = true;
$resp->mensaje = "Se se pudo la ciudad";


$nuevaCiudad = new Ciudad(null, $_POST['nombre'], $_POST['poblacion'], $_POST['pais']);
$nuevaCiudad->Agregar();

echo json_encode($resp);




?>