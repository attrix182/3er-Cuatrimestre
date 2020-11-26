<?php

require "clases/Ciudadano.php";

$email = $_POST["email"] ?? null;
$clave = $_POST["clave"] ?? null;


$array = Ciudadano::traerTodos();
$ciudadano = new  Ciudadano($_POST['email'], $_POST['clave']);
$validar = json_decode(Ciudadano::verificarExistencia($ciudadano));

$resp = new stdClass();

if ($validar->ok) {
    $cookieNombre = $ciudadano->getEmail() . "_" . $ciudadano->getCiudad();
    $cookieValor = date("H:i:s") . $validar->mensaje;
    setcookie($cookieNombre, $cookieValor, time() + (86400 * 30), "/");
    $resp->exito = $validar->ok;
    $resp->mensaje = $validar->mensaje;


} else {

    $resp->exito = false;
    $resp->mensaje = $validar->mensaje;
    
}

echo json_encode($resp);