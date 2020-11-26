<?php

require_once "clases/Cocinero.php";

$email = $_GET["email"] ?? NULL;
$especialidad = $_GET["especialidad"] ?? NULL;

$email = str_replace(".", "_", $email);
$cookienombre = $email . "_" . $especialidad;



$obj = new stdClass();
if (isset($_COOKIE[$cookienombre])) {
    $obj->ok = true;
    $obj->mensaje = $_COOKIE[$cookienombre];
} else {
    $obj->ok = false;
    $obj->mensaje = "Cookie no encontrada";
}

echo json_encode($obj);