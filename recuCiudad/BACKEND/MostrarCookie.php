<?php

require_once "clases/Ciudadano.php";

$email = $_GET["email"]??NULL;
$ciudad=$_GET["ciudad"]??NULL;
$email=str_replace(".","_",$email);
$cookienombre = $email . "_" . $_GET['ciudad'];



$obj = new stdClass();
if(isset($_COOKIE[$cookienombre]))
{
    $obj->ok = true;
    $obj->mensaje = $_COOKIE[$cookienombre];
}
else
{
    $obj->ok = false;
    $obj->mensaje = "Cookie no encontrada";
}

echo json_encode($obj);