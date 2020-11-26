<?php

require_once 'clases\Ovni.php';

$ovni = $_POST["ovni"] ?? null;
$ovni = json_decode($ovni);

$listaOvnis = [];
$listaOvnis  = Ovni::Traer();


foreach ($listaOvnis as $unOvni) {

    if ($ovni->tipo == $unOvni->tipo && $unOvni->planetaOrigen == $ovni->planetaOrigen) {

        echo $unOvni->ToJSON();
        break;
    } else if ($ovni->tipo != $unOvni->tipo && $ovni->planetaOrigen != $unOvni->planetaOrigen) {

        echo "No hay coincidencias con ese tipo ni ese planetaOrigen!";
        break;
    } else if ($ovni->tipo != $unOvni->tipo) {

        echo "No hay coincidencias con ese tipo!";
        break;
    } else if ($unOvni->planetaOrigen != $ovni->planetaOrigen) {

        echo "No hay coincidencias con ese planetaOrigen!";
        break;
    }
}
