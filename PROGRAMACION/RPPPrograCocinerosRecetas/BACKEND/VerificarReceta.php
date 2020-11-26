<?php

require_once 'clases\Receta.php';

$receta = $_POST["receta"] ?? null;
$receta = json_decode($receta);

$listaRecetas = [];
$listaRecetas  = Receta::Traer();

$rta = "No hay coincidencias con ese tipo ni ese nombre!";

foreach ($listaRecetas as $unaReceta) {

    if ($receta->tipo == $unaReceta->tipo && $unaReceta->nombre == $receta->nombre) {

        $rta = $unaReceta->ToJSON();
        break;
    } else if ($receta->tipo != $unaReceta->tipo && $unaReceta->nombre ==  $receta->nombre) {

        $rta  ="No hay coincidencias con ese tipo!";


    } else if ($unaReceta->nombre != $receta->nombre && $receta->tipo == $unaReceta->tipo) {

        $rta  ="No hay coincidencias con ese nombre!";

    }
}

echo $rta; 
