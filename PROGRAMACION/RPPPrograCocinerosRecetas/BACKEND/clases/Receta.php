<?php
include("IParte1.php");
include("IParte2.php");

require_once 'clases\AccesoDatos.php';

class Receta  implements IParte1, IParte2//, IParte3
{
    public $id;
    public $tipo;
    public $ingredientes;
    public $nombre;
    public $pathFoto;

    public function __construct($id = "", $nombre = "", $ingredientes = "", $tipo = "", $pathFoto = "")
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->ingredientes = $ingredientes;
        $this->tipo = $tipo;
        $this->pathFoto = $pathFoto;
    }


    public function setFoto($fotonew)
    {
        $this->pathFoto = $fotonew;
    }

    public function ToJSON()
    {
        $resp = new stdClass();
        $resp->id = $this->id;
        $resp->nombre = $this->nombre;
        $resp->ingredientes = $this->ingredientes;
        $resp->tipo = $this->tipo;
        $resp->pathFoto = $this->pathFoto;

        return json_encode($resp);
    }

    public function Agregar()
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO recetas(nombre, ingredientes, tipo, path_foto)
        VALUES(?, ?, ?, ?)");

        return $consulta->execute([$this->nombre, $this->ingredientes, $this->tipo, $this->pathFoto]);
    }

    public static function Traer()
    {
        $lista = [];
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM recetas");
        $consulta->execute();

        while ($obj = $consulta->fetch()) {
            $unItem = new Receta($obj[0], $obj[1], $obj[2], $obj[3], $obj[4]);
            array_push($lista, $unItem);
        }

        return $lista;
    }

    function Existe($lista)
    {
        $existe = false;

        foreach ($lista as  $uno) {
            if ($uno->tipo == $this->tipo && $uno->nombre == $this->nombre) {
                $existe = true;
                break;
            }
        }

        return $existe;
    }

    function Modificar()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE recetas SET nombre= ?, ingredientes= ?, tipo=? , path_foto= ? WHERE id=?");
        $consulta->execute([$this->nombre, $this->ingredientes, $this->tipo, $this->pathFoto, $this->id]);
        return $consulta;



    }

    function Eliminar()
    {

        $objBD = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objBD->RetornarConsulta("UPDATE recetas SET nombre= ?, ingredientes= ?,tipo= ?,path_foto= ? WHERE id=?");
        return $consulta->execute([$this->nombre, $this->ingredientes, $this->tipo, $this->pathFoto,$this->id]);
    }


    function GuardarEnArchivo()
    {
        $nombreArchivo = "./recetas_borradas.txt";
        $archivo = fopen($nombreArchivo, "a+");
        if ($archivo) {
            $pathFoto = $this->pathFoto;
            $fechaActual = date("h:i:s");
            $fechaActual = str_replace(":", "", $fechaActual);
            $pathviejoM = "recetasModificadas/" . $pathFoto;
            $pathviejoI = "recetas/imagenes/" . $pathFoto;
            $imagenTipo = strtolower(pathinfo($pathFoto, PATHINFO_EXTENSION));
            if (file_exists("./recetasModificadas/" . $pathFoto)) {
                rename(chop($pathviejoM), chop("./recetasBorradas/" . $this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $imagenTipo));
            }
            if (file_exists("./recetas/imagenes/" . $pathFoto)) {
                rename(chop($pathviejoI), chop("./recetasBorradas/" . $this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $imagenTipo));
            }
            $this->pathFoto = $this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $imagenTipo;
            fwrite($archivo, $this->id . "-" . $this->nombre . "-" . $this->poblacion . "-" . $this->pais . "-" . chop($this->pathFoto) . "\r\n");
            fclose($archivo);
        }
    }

    
    static function MostrarBorrados()
    {
        $archivo = fopen("./recetas_borradas.txt", "r");
        $datos = [];

        $listaBorrados = array();
        if ($archivo) {
            $file = filesize('./recetas_borradas.txt');
            if ($file != 0) {
                while (!feof($archivo)) {
                    $cadena = fgets($archivo);
                    $datos = explode('-', $cadena);
                    if (count($datos) > 2) {
                        $borrada = new Receta($datos[0], $datos[1], $datos[2], $datos[3], $datos[4]);
                        array_push($listaBorrados, $borrada);
                    }
                }
            }
            fclose($archivo);
        }
        return $listaBorrados;
    }
}




