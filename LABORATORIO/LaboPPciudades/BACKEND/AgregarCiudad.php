<?php

require_once 'clases\Ciudad.php';

$nombre = $_POST["nombre"] ?? null;
$poblacion = $_POST["poblacion"] ?? null;
$pais = $_POST["pais"] ?? null;
$foto = $_FILES["foto"] ?? null;
$pathFoto = "./imagenes/" . $_FILES["foto"]["name"];

$imagenTipo = pathinfo($pathFoto,PATHINFO_EXTENSION);
$fechaActual= date("h:i:s");
$fechaActual=str_replace(":","",$fechaActual);
$nuevoNombre = $_FILES["foto"]["name"]=$nombre.".".$pais.".".$fechaActual.".".$imagenTipo;

$resp = new stdClass();

$ciudadNueva;
$listaCiudades = [];
$listaCiudades  = Ciudad::Traer();

$ciudadNueva = new Ciudad("" ,$nombre, $poblacion, $pais, $_FILES["foto"]["name"]);

if( !$ciudadNueva->Existe($listaCiudades))
{
    
    move_uploaded_file($_FILES["foto"]["tmp_name"], "./imagenes/".$nuevoNombre);

    $ciudadNueva->Agregar();

    $resp->exito = true;
    $resp->mensaje = "Se se pudo la ciudad";

}
else{
   
    $resp->exito = false;
    $resp->mensaje = "No se pudo agregar la ciudad";
}

echo json_encode($resp);