<?php

require_once 'clases\Ovni.php';

$tipo = $_POST["tipo"] ?? null;
$velocidad = $_POST["velocidad"] ?? null;
$planetaOrigen = $_POST["planetaOrigen"] ?? null;
$foto = $_FILES["foto"] ?? null;
$pathFoto = "./ovnis/imagenes/" . $_FILES["foto"]["name"];

$imagenTipo = pathinfo($pathFoto, PATHINFO_EXTENSION);
$fechaActual = date("h:i:s");
$fechaActual = str_replace(":", "", $fechaActual);
$nuevoNombre = $_FILES["foto"]["name"] = $tipo . "." . $planetaOrigen . "." . $fechaActual . "." . $imagenTipo;

$resp = new stdClass();

$nuevaAgregar;
$lista = [];
$lista  = Ovni::Traer();

$nuevaAgregar = new Ovni("", $tipo, $velocidad, $planetaOrigen, $_FILES["foto"]["name"]);

if (!$nuevaAgregar->Existe($lista)) {

    move_uploaded_file($_FILES["foto"]["tmp_name"], "./ovnis/imagenes/" . $nuevoNombre);

    if ($nuevaAgregar->Agregar()) {
        $resp->exito = true;
        $resp->mensaje = "Se puedo agregar";
        header("Location: ./Listado.php ");
    }
} else {

    $resp->exito = false;
    $resp->mensaje = "No se pudo agregar";
}

echo json_encode($resp);
