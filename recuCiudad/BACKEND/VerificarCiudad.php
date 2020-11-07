<?php

require_once 'clases\Ciudad.php';

$ciudad = $_POST["ciudad"] ?? null;
$ciudad = json_decode($ciudad);

$listaCiudades = [];
$listaCiudades  = Ciudad::Traer();


foreach ($listaCiudades as $unaCiudad) {

    if ($ciudad->nombre == $unaCiudad->nombre && $unaCiudad->pais == $ciudad->pais) {

        echo $unaCiudad->ToJSON();
        break;
    } else if ($ciudad->nombre != $unaCiudad->nombre && $unaCiudad->pais != $ciudad->pais) {

        echo "No hay coincidencias con ese Nombre ni ese Pais!";
        break;
    } else if ($ciudad->nombre != $unaCiudad->nombre) {

        echo "No hay coincidencias con ese Nombre!";
        break;
    } else if ($unaCiudad->pais != $ciudad->pais) {

        echo "No hay coincidencias con ese Pais!";
        break;
    }
}
