<?php
require "clases/Alien.php";

$array = Alien::traerTodos();

$rta = [];

foreach ($array as $value) {
 $rta[] =   json_decode($value->toJSON());
}

echo json_encode($rta);

?>