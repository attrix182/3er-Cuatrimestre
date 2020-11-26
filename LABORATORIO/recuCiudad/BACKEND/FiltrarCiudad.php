<?php
require "./clases/Ciudad.php";

$nombre = $_POST["nombre"] ?? NULL;
$pais = $_POST["pais"] ?? NULL;

$listado = array();
$ciudadRandom = new Ciudad("", "", "", "");
$listado = $ciudadRandom->Traer();
$nombrePais = false;
$nombreSolo = false;
$paisSolo = false;
if ($nombre != NULL && $pais != NULL)
    $nombrePais = true;

if ($pais == NULL)
    $nombreSolo = true;

if ($nombre == NULL)
    $paisSolo = true;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {

            padding: 20px;
            margin: 0 auto;
            width: 900px;
            text-align: center;
        }

        .tr {
            height: 100px;
        }
    </style>
</head>

<body>
    <th>
        <h4>Filtrado por <?php if ($nombrePais) {
                                echo "Nombre y Pais";
                            } else if ($nombreSolo) {
                                echo "Nombre";
                            } else if ($paisSolo) {
                                echo "Pais";
                            } ?></h4>
    </th>
    <table>
        <tr>
            <td colspan="4">
                <hr />
            </td>
        </tr>
        <tr>
            <th>Nombre</th>
            <th>Poblacion</th>
            <th>Pais</th>
            <th>Foto</th>
        </tr>
        <?php
        if ($nombrePais) {
            foreach ($listado as $key) {
                if ($key->nombre == $nombre && $key->pais == $pais) { ?>
                    <tr class="tr">
                        <td><?php echo $key->nombre ?></td>
                        <td><?php echo $key->poblacion ?></td>
                        <td><?php echo $key->pais ?></td>
                        <?php
                        if ($key->pathFoto == "") {
                            echo '<td>SinFoto</td';
                        } else {
                            if (file_exists("./imagenes/ciudades/" . $key->pathFoto)) {
                                echo "<td><img src=./imagenes/ciudades/" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if (file_exists("./ciudadesModificadas/" . $key->pathFoto)) {
                                echo "<td><img src=./ciudadesModificadas/" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if ($flag == false)
                                echo '<td>SinFoto</td';
                        }
                    }
                }
                echo '</tr>';
            } else if ($nombreSolo) {
                foreach ($listado as $key) {
                    if ($key->nombre == $nombre) { ?>
                    <tr class="tr">
                        <td><?php echo $key->nombre ?></td>
                        <td><?php echo $key->poblacion ?></td>
                        <td><?php echo $key->pais ?></td>
                        <?php
                        $flag = false;
                        if ($key->pathFoto == "") {
                            echo '<td>SinFoto</td';
                        } else {
                            if (file_exists("./ciudades\imagenes/" . $key->pathFoto)) {
                                echo "<td><img src=./ciudades\imagenes/" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if (file_exists("./ciudadesModificadas/" . $key->pathFoto)) {
                                echo "<td><img src=./ciudadesModificadas/" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if ($flag == false)
                                echo '<td>SinFoto</td';
                        }

                        echo '</tr>';
                    }
                }
            } else if ($paisSolo) {
                foreach ($listado as $key) {
                    if ($key->pais == $pais) { ?>
                    <tr class="tr">
                        <td><?php echo $key->nombre ?></td>
                        <td><?php echo $key->poblacion ?></td>
                        <td><?php echo $key->pais ?></td>
            <?php
                        $flag = false;
                        if ($key->pathFoto == "") {
                            echo '<td>SinFoto</td';
                        } else {
                            if (file_exists("./ciudades\imagenes/" . $key->pathFoto)) {
                                echo "<td><img src=./ciudades\imagenes/" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if (file_exists("./ciudadesModificadas/" . $key->pathFoto)) {
                                echo "<td><img src=./ciudadesModificadas/" . $key->pathFoto . " height='100px' width='100px'></td>";
                                $flag = true;
                            }
                            if ($flag == false)
                                echo '<td>SinFoto</td';
                        }

                        echo '</tr>';
                    }
                }
            } ?>
                    <tr>
                        <td colspan="4">
                            <hr />
                        </td>
                    </tr>
    </table>
</body>
</body>

</html>