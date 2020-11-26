<?php
require "clases/Cocinero.php";

$array = Cocinero::traerTodos();

$rta = [];

foreach ($array as $value) {
 $rta[] =   json_decode($value->toJSON());
}

echo json_encode($rta);

?>