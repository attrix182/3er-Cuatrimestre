<?php
require "./clases/Receta.php";

$nombre = $_GET["nombre"] ?? NULL;
$receta = $_POST["receta_json"] ?? NULL;
$accion = $_POST["accion"] ?? NULL;

$nueva = new Receta("", "", "", "");

if ($receta == NULL) {
    if ($nombre != NULL) {
        $lista = array();
        $lista = $nueva->Traer();
        $retorno = "NO Esta en la Base de Datos";
        foreach ($lista as $key) {
            if ($key->nombre == $nombre) {
                $retorno = "Esta en la Base de Datos";
                break;
            }
        }
        echo $retorno;
    } else {
        $listaBorrados = Receta::MostrarBorrados();
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Eliminar receta</title>
        </head>

        <body>
            <table>
                <th>
                    <h4>Listado Eliminadas</h4>
                </th>
                <tr>
                    <td colspan="4">
                    </td>
                </tr>
                <tr>
                    <th>Nombre</th>
                    <th>Ingredientes</th>
                    <th>Tipo</th>
                    <th>Foto</th>
                </tr>
                <?php foreach ($listaBorrados as $key) { ?>
                    <tr class="tr">
                        <td><?php echo $key->nombre ?></td>
                        <td><?php echo $key->ingredientes ?></td>
                        <td><?php echo $key->tipo ?></td>
                        <?php
                        $flag = false;
                        if ($key->pathFoto == "") {
                            echo '<td>SinFoto</td';
                        } else {
                            if (file_exists("./recetasBorradas/" . chop($key->pathFoto))) {
                                echo "<td><img src=./recetasBorradas/" . chop($key->pathFoto) . " height='100px' width='100px'></td>";
                            } else
                                echo '<td>SinFoto</td';
                        }
                        ?>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="4">

                    </td>
                </tr>
            </table>
        </body>

        </html>

<?php }
}
