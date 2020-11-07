<?php

require_once 'clases\Ciudad.php';

$ciudad = json_decode($_POST["ciudad_json"]) ?? null;
$modificada;
$lista = [];
$lista = Ciudad::Traer();
$foto = $_FILES["foto"]["name"] ?? null;
$nuevoNombre;

$imagenTipo = pathinfo($foto, PATHINFO_EXTENSION);
$fechaActual = date("h:i:s");
$fechaActual = str_replace(":", "", $fechaActual);
$resp = new stdClass();


$modificada = new Ciudad($ciudad->id, $ciudad->nombre, $ciudad->poblacion, $ciudad->pais, $ciudad->pathFoto);



if ((file_exists("./imagenes/ciudades/" . $ciudad->pathFoto))) {
    $nuevoNombre = $_FILES["foto"]["name"] = $modificada->nombre . "." . $modificada->pais . ".modificado." . $fechaActual . "." . $imagenTipo;
    move_uploaded_file($_FILES["foto"]["tmp_name"], "./ciudadesModificadas/" . $nuevoNombre);
    $modificada->setFoto($nuevoNombre);

    if ($modificada->Modificar()) {
        $resp->exito = true;
        $resp->mensaje = "Se ha modificado la ciudad";
    }
} else {

    $resp->exito = false;
    $resp->mensaje = "No se ha modificado la ciudad, porque no existe";
}

echo json_encode($resp);
