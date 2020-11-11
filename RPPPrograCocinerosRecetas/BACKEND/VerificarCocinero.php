  
<?php

require "clases/Cocinero.php";

$email = $_POST["email"] ?? null;
$clave = $_POST["clave"] ?? null;


$array = Cocinero::traerTodos();
$cocinero = new  Cocinero("", $email, $clave);
$validar = json_decode(Cocinero::verificarExistencia($cocinero));

$resp = new stdClass();

if ($validar->ok) {
    $cookieNombre = $cocinero->getEmail() . "_" . $cocinero->getEspecialidad();
    $cookieValor = date("H:i:s") . $validar->mensaje;
    setcookie($cookieNombre, $cookieValor, time() + (86400 * 30), "/");
    $resp->exito = $validar->ok;
    $resp->mensaje = $validar->mensaje;
} else {

    $resp->exito = false;
    $resp->mensaje = $validar->mensaje;
}

echo json_encode($resp);