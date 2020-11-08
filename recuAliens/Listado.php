<?php

require_once 'clases\Ovni.php';

$CiudadRandom = new  Ovni("", "", "", "");
$arrayCiudades = $CiudadRandom->Traer();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    table {

      padding: 15px;
      margin: 0 auto;
      width: 900px;
      text-align: center;
    }

    .tr {
      height: 100px;
    }
  </style>
  <title>Listado Ovnis</title>
</head>

<body>
  <th>
    <h4>Listado Ovnis</h4>
  </th>
  <table>
    <tr>
      <td colspan="6">
        <hr />
      </td>
    </tr>
    <tr>
      <th>ID</th>
      <th>Tipo</th>
      <th>Velociad</th>
      <th>Planeta</th>
      <th>Foto</th>
    </tr>
    <?php foreach ($arrayCiudades as $key) { ?>
      <tr class="tr">
      <td><?php echo $key->id ?></td>
        <td><?php echo $key->tipo ?></td>
        <td><?php echo $key->velocidad ?></td>
        <td><?php echo $key->planetaOrigen ?></td>

        <?php
        $flag = false;
        if ($key->pathFoto == "") {
          echo '<td>SinFoto</td';
        } else {
          if (file_exists("./ovnis/imagenes/" . $key->pathFoto)) {
            echo "<td><img src=./ovnis/imagenes/" . $key->pathFoto . " height='100px' width='100px'></td>";
            $flag = true;
          }
          if (file_exists("./ovnisModificadas/" . $key->pathFoto)) {
            echo "<td><img src=./ovnisModificadas/" . $key->pathFoto . " height='100px' width='100px'></td>";
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
        <hr />
      </td>
    </tr>
  </table>
</body>

</html>