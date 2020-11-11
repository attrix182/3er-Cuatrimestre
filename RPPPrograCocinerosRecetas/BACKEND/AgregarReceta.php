<?php

require_once 'clases\Receta.php';

$tipo = $_POST["tipo"] ?? null;
$ingredientes = $_POST["ingredientes"] ?? null;
$nombre = $_POST["nombre"] ?? null;
$foto = $_FILES["foto"] ?? null;
$pathFoto = "./recetas/imagenes/" . $_FILES["foto"]["name"];

$imagenTipo = pathinfo($pathFoto, PATHINFO_EXTENSION);
$fechaActual = date("h:i:s");
$fechaActual = str_replace(":", "", $fechaActual);
$nuevoNombre = $_FILES["foto"]["name"] = $nombre . "." . $tipo . "." . $fechaActual . "." . $imagenTipo;

$resp = new stdClass();

$nuevaAgregar;
$lista = [];
$lista  = Receta::Traer();

$nuevaAgregar = new Receta("", $nombre, $ingredientes, $tipo, $_FILES["foto"]["name"]);

if (!$nuevaAgregar->Existe($lista)) {

    move_uploaded_file($_FILES["foto"]["tmp_name"], "./recetas/imagenes/" . $nuevoNombre);

    if ($nuevaAgregar->Agregar()) {
        $resp->exito = true;
        $resp->mensaje = "Se puedo agregar";
    }
} else {

    $resp->exito = false;
    $resp->mensaje = "No se pudo agregar";
}

echo json_encode($resp);