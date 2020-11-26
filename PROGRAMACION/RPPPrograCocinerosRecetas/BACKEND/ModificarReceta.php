  
<?php
require_once 'clases\Receta.php';

$receta = json_decode($_POST["receta_json"]) ?? null;
$modificada;
$lista = [];
$lista = Receta::Traer();
$foto = $_FILES["foto"]["name"] ?? null;
$nuevoNombre;

$imagenTipo = pathinfo($foto, PATHINFO_EXTENSION);
$fechaActual = date("h:i:s");
$fechaActual = str_replace(":", "", $fechaActual);
$resp = new stdClass();


$modificada = new Receta($receta->id, $receta->nombre, $receta->ingredientes, $receta->tipo, $receta->pathFoto);


    $nuevoNombre = $_FILES["foto"]["name"] = $modificada->nombre . "." . $modificada->tipo . ".modificado." . $fechaActual . "." . $imagenTipo;
    move_uploaded_file($_FILES["foto"]["tmp_name"], "./recetasModificadas/" . $nuevoNombre);
    $modificada->setFoto($nuevoNombre);

    if ($modificada->Modificar()) {
        $resp->exito = true;
        $resp->mensaje = "Se ha modificado";
    }
else {

    $resp->exito = false;
    $resp->mensaje = "No se ha modificado la receta, Error";
}

echo json_encode($resp);