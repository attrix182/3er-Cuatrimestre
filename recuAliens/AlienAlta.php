<?php 

require "clases/Alien.php";

$email = $_POST["email"] ?? null;
$clave = $_POST["clave"] ?? null;
$planeta = $_POST["planeta"] ?? null;

$nuevo = new Alien($planeta, $email, $clave);

$msj = $nuevo->GuardarEnArchivo();

echo $msj;

