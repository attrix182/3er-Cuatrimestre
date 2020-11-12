<?php 

require "clases/Ciudadano.php";

$email = $_POST["email"] ?? null;
$clave = $_POST["clave"] ?? null;
$ciudad = $_POST["ciudad"] ?? null;

$usuario = new Ciudadano($email, $clave, $ciudad);
$g = $usuario->GuardarEnArchivo();
echo $g;

?>

