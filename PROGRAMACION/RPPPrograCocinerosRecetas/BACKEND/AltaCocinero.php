
<?php 

require "clases/Cocinero.php";

$email = $_POST["email"] ?? null;
$clave = $_POST["clave"] ?? null;
$especialidad = $_POST["especialidad"] ?? null;

$nuevo = new Cocinero($especialidad, $email, $clave);

$msj = $nuevo->GuardarEnArchivo();

echo $msj;