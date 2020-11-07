<?php

require_once 'clases\Ciudad.php';

$nombre = $_POST["nombre"] ?? null;
$poblacion = $_POST["poblacion"] ?? null;
$pais = $_POST["pais"] ?? null;
$foto = $_FILES["foto"] ?? null;
$pathFoto = "./imagenes/ciudades/" . $_FILES["foto"]["name"];

$imagenTipo = pathinfo($pathFoto,PATHINFO_EXTENSION);
$fechaActual= date("h:i:s");
$fechaActual=str_replace(":","",$fechaActual);
$nuevoNombre = $_FILES["foto"]["name"]=$nombre.".".$pais.".".$fechaActual.".".$imagenTipo;

$resp = new stdClass();

$nuevaAgregar;
$lista = [];
$lista  = Ciudad::Traer();

$nuevaAgregar = new Ciudad("" ,$nombre, $poblacion, $pais, $_FILES["foto"]["name"]);

if( !$nuevaAgregar->Existe($lista))
{
    
    move_uploaded_file($_FILES["foto"]["tmp_name"], "./imagenes/ciudades/".$nuevoNombre);

    $nuevaAgregar->Agregar();

    $resp->exito = true;
    $resp->mensaje = "Se puedo agregar";

}
else{
   
    $resp->exito = false;
    $resp->mensaje = "No se pudo agregar";
}

echo json_encode($resp);