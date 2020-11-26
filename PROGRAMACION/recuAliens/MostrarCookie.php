<?php

require_once "clases/Alien.php";

$email = $_GET["email"] ?? NULL;
$planeta = $_GET["planeta"] ?? NULL;

$email = str_replace(".", "_", $email);
$cookienombre = $email . "_" . $planeta;



$obj = new stdClass();
if (isset($_COOKIE[$cookienombre])) {
    $obj->ok = true;
    $obj->mensaje = $_COOKIE[$cookienombre];
} else {
    $obj->ok = false;
    $obj->mensaje = "Cookie no encontrada";
}

echo json_encode($obj);
