<?php

include("IParte2.php");

include("IParte1.php");

include("IParte3.php");

require "./clases/AccesoDatos.php";

class Ciudad implements IParte1, IParte2, IParte3
{

    public $id;
    public $nombre;
    public $poblacion;
    public $pais;
    public $pathFoto;

    public function __construct($id = "", $nombre = "", $poblacion = "", $pais = "", $pathFoto = "")
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->poblacion = $poblacion;
        $this->pais = $pais;
        $this->pathFoto = $pathFoto;
    }


    public function ToJSON()
    {
        $resp = new stdClass();

        $resp->id = $this->id;
        $resp->nombre = $this->nombre;
        $resp->poblacion = $this->poblacion;
        $resp->pais = $this->pais;
        $resp->pathFoto = $this->pathFoto;
        return json_encode($resp);
    }

    public function setFoto($fotonew){ $this->pathFoto = $fotonew; }

    public function Agregar()
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();    

        $consulta =$objetoAccesoDato->RetornarConsulta ("INSERT INTO ciudades( id, nombre, poblacion, pais,path_foto )
        VALUES(?, ?, ?, ?, ?)");

        return $consulta->execute([$this->id,$this->nombre,$this->poblacion,$this->pais,$this->pathFoto]);

    }

    public static function Traer()
    {
        $lista = [];
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();        
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM ciudades");    
        $consulta->execute();   
  
          while ($obj = $consulta->fetch()) {
              $unItem = new Ciudad($obj[0], $obj[1], $obj[2], $obj[3], $obj[4]);
              array_push($lista, $unItem);
          }
  
          return $lista;
  
    }

    function Existe($lista)
    {
        $existe = false;

        foreach ($lista as  $unaCiudad) {
            if ($unaCiudad->nombre == $this->nombre && $unaCiudad->pais == $this->pais) {
                $existe = true;
                break;
            }
        }

        return $existe;
    }

    function Modificar()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE ciudades SET nombre= ?, poblacion= ?,pais= ?,path_foto= ? WHERE id=?");
        $consulta->execute([$this->nombre, $this->poblacion, $this->pais, $this->pathFoto, $this->id]);
        return $consulta;
    
    }


    function Eliminar()
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM ciudades WHERE nombre=? AND pais=?");
        return $consulta->execute([$this->nombre, $this->pais]); 

    }


    function GuardarEnArchivo()
    {
        $nombreArchivo = "./ciudades_borradas.txt";
        $archivo = fopen($nombreArchivo, "a+");
        if ($archivo) {
            $pathFoto = $this->pathFoto;
            $fechaActual = date("h:i:s");
            $fechaActual = str_replace(":", "", $fechaActual);
            $pathviejoM = "ciudadesModificadas/" . $pathFoto;
            $pathviejoI = "ciudades/imagenes/" . $pathFoto;
            $imagenTipo = strtolower(pathinfo($pathFoto, PATHINFO_EXTENSION));
            if (file_exists("./ciudadesModificadas/" . $pathFoto)) {
                rename(chop($pathviejoM), chop("./ciudadesBorradas/" . $this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $imagenTipo));
            }
            if (file_exists("./ciudades/imagenes/" . $pathFoto)) {
                rename(chop($pathviejoI), chop("./ciudadesBorradas/" . $this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $imagenTipo));
            }
            $this->pathFoto = $this->id . "." . $this->nombre . "." . "borrado" . "." . $fechaActual . "." . $imagenTipo;
            fwrite($archivo, $this->id . "-" . $this->nombre . "-" . $this->poblacion . "-" . $this->pais . "-" . chop($this->pathFoto) . "\r\n");
            fclose($archivo);
        }
    }


    static function MostrarBorrados()
    {
        $archivo = fopen("./ciudades_borradas.txt", "r");
        $datos = [];

        $listaBorrados = array();
        if ($archivo) {
            $archivito = filesize('./ciudades_borradas.txt');
            if ($archivito != 0) {
                while (!feof($archivo)) {
                    $cadena = fgets($archivo);
                    $datos = explode('-', $cadena);
                    if (count($datos) > 2) {
                        $CiudadBorrada = new Ciudad($datos[0], $datos[1], $datos[2], $datos[3], $datos[4]);
                        array_push($listaBorrados, $CiudadBorrada);
                    }
                }
            }
            fclose($archivo);
        }
        return $listaBorrados;
    }
}
