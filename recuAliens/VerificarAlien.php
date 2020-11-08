<?php

require "clases/Alien.php";

$email = $_POST["email"] ?? null;
$clave = $_POST["clave"] ?? null;


$array = Alien::traerTodos();
$alien = new  Alien("", $email, $clave);
$validar = json_decode(Alien::verificarExistencia($alien));

$resp = new stdClass();

if ($validar->ok) {
    $cookieNombre = $alien->getEmail() . "_" . $alien->getPlaneta();
    $cookieValor = date("H:i:s") . $validar->mensaje;
    setcookie($cookieNombre, $cookieValor, time() + (86400 * 30), "/");
    $resp->exito = $validar->ok;
    $resp->mensaje = $validar->mensaje;
} else {

    $resp->exito = false;
    $resp->mensaje = $validar->mensaje;
}

echo json_encode($resp);
