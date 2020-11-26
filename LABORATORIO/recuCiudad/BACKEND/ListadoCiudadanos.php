<?php
require "clases/Ciudadano.php";

$array = Ciudadano::traerTodos();

$rta = [];

foreach ($array as $value) {
 $rta[] =  $value->toJSON();
}

echo json_encode($rta);

?>