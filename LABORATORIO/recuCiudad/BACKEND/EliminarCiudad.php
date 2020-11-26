<?php
require "./clases/Ciudad.php";

$nombre = $_GET["nombre"] ?? NULL;
$ciudad = $_POST["ciudad_json"] ?? NULL;
$accion = $_POST["accion"] ?? NULL;

$nueva = new Ciudad("", "", "", "");

if ($ciudad == NULL) {
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
        $listaBorrados = Ciudad::MostrarBorrados();
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

                .trpapa {
                    height: 100px;
                }
            </style>
        </head>

        <body>
            <table>
                <th>
                    <h4>Listado Eliminadas</h4>
                </th>
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
                <?php foreach ($listaBorrados as $key) { ?>
                    <tr class="trpapa">
                        <td><?php echo $key->nombre ?></td>
                        <td><?php echo $key->poblacion ?></td>
                        <td><?php echo $key->pais ?></td>
                        <?php
                        $flag = false;
                        if ($key->pathFoto == "") {
                            echo '<td>SinFoto</td';
                        } else {
                            if (file_exists("./ciudadesBorradas/" . chop($key->pathFoto))) {
                                echo "<td><img src=./ciudadesBorradas/" . chop($key->pathFoto) . " height='100px' width='100px'></td>";
                            } else
                                echo '<td>SinFoto</td';
                        }
                        ?>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="4">
                        <hr />
                    </td>
                </tr>
            </table>
        </body>

        </html>

<?php }
} else {
    $ciudad = json_decode($ciudad);
    $js = new stdClass();
    if ($accion == "borrar") {
        $js->exito = false;
        $js->mensaje = "No se pudo borrar de la base de datos";
        $ciudadFake = new Ciudad($ciudad->id, "", "", "");
        $listaCiudades = $ciudadFake->Traer();
        $ciudadBorrar = null;
        foreach ($listaCiudades as $key) {
            if ($key->id == $ciudadFake->id) {
                $ciudadBorrar = new Ciudad($key->id, $key->nombre, $key->poblacion, $key->pais, $key->pathFoto);
                break;
            }
        }
        if ($ciudadBorrar->Eliminar()) {
            $js->exito = true;
            $js->mensaje = "Se ha Borrado de la clase y se ha Guardado en Borrados";
            $ciudadBorrar->GuardarEnArchivo();
        }
        echo json_encode($js);
    }
}