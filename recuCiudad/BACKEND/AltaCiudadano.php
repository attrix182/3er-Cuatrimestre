<?php 

require "clases/Ciudadano.php";

$email = $_POST["email"] ?? null;
$clave = $_POST["clave"] ?? null;
$ciudad = $_POST["ciudad"] ?? null;

$nuevo = new Ciudadano($email, $clave, $ciudad);

$msj = $nuevo->GuardarEnArchivo();

echo $msj;

?>

