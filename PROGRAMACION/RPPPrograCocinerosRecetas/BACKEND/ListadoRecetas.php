<?php

require_once 'clases\Receta.php';

$Random = new  Receta("", "", "", "");
$array = $Random->Traer();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    table {

      padding: 10px;
      margin: 0 auto;
      width: 900px;
      text-align: center;
    }

    .tr {
      height: 100px;
    }
  </style>
  
  <title>Listado Recetas</title>
</head>

<body>
  <th>
    <h2>Listado Recetas</h2>
  </th>
  <table>
    <tr>
      <td colspan="6">
      </td>
    </tr>
    <tr>

      <th>ID</th>
      <th>Nombre</th>
      <th>Ingredientes</th>
      <th>Tipo</th>
      <th>Foto</th>
      
    </tr>
    <?php foreach ($array as $key) { ?>
      <tr class="tr">

      <td><?php echo $key->id ?></td>
        <td><?php echo $key->nombre ?></td>
        <td><?php echo $key->ingredientes ?></td>
        <td><?php echo $key->tipo ?></td>

        <?php
        $flag = false;
        if ($key->pathFoto == "") {
          echo '<td>SinFoto</td';
        } else {
          if (file_exists("./recetas/imagenes/" . $key->pathFoto)) {
            echo "<td><img src=./recetas/imagenes/" . $key->pathFoto . " height='100px' width='100px'></td>";
            $flag = true;
          }
          if (file_exists("./recetasModificadas/" . $key->pathFoto)) {
            echo "<td><img src=./recetasModificadas/" . $key->pathFoto . " height='100px' width='100px'></td>";
            $flag = true;
          }
          if ($flag == false)
            echo '<td>SinFoto</td';
        }
        ?>

      </tr>
    <?php } ?>
    <tr>
      <td colspan="6">
      </td>
    </tr>
  </table>
</body>

</html>