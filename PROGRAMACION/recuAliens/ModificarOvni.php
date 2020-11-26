<?php

require_once 'clases\Ovni.php';

$tipo = $_POST["tipo"] ?? null;
$velocidad = $_POST["velocidad"] ?? null;
$planetaOrigen = $_POST["planetaOrigen"] ?? null;
$foto = $_FILES["foto"]["name"] ?? null;
$id =  $_POST["id"] ?? null;
$pathFotoVieja = $_POST["pathFoto"] ?? null;


$modificada;
$lista = [];
$lista = Ovni::Traer();
$nuevoNombre;

$imagenTipo = pathinfo($foto, PATHINFO_EXTENSION);
$fechaActual = date("h:i:s");
$fechaActual = str_replace(":", "", $fechaActual);
$resp = new stdClass();


$modificada =  new Ovni($id ,$tipo, $velocidad, $planetaOrigen, $foto);



    $nuevoNombre = $_FILES["foto"]["name"] = $modificada->tipo . "." . $modificada->planetaOrigen . ".modificado." . $fechaActual . "." . $imagenTipo;
    move_uploaded_file($_FILES["foto"]["tmp_name"], "./ovnisModificadas/" . $nuevoNombre);
    $modificada->setFoto($nuevoNombre);

    if ($modificada->Modificar()) {
        $resp->exito = true;
        $resp->mensaje = "Se ha modificado";
        header("Location: ./Listado.php ");
    }
else {

    $resp->exito = false;
    $resp->mensaje = "No se ha modificado la ciudad, porque no existe";
}

echo json_encode($resp);