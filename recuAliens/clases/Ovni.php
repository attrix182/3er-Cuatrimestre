<?php

include("IParte2.php");
require_once 'clases\AccesoDatos.php';

class Ovni implements IParte2 //, IParte2, IParte3
{
    public $id;
    public $tipo;
    public $velocidad;
    public $planetaOrigen;
    public $pathFoto;

    public function __construct($id = "", $tipo = "", $velocidad = "", $planetaOrigen = "", $pathFoto = "")
    {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->velocidad = $velocidad;
        $this->planetaOrigen = $planetaOrigen;
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
        $resp->tipo = $this->tipo;
        $resp->velocidad = $this->velocidad;
        $resp->planetaOrigen = $this->planetaOrigen;
        $resp->pathFoto = $this->pathFoto;

        return json_encode($resp);
    }

    public function Agregar()
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO ovnis(tipo, velocidad, planeta, foto)
        VALUES(?, ?, ?, ?)");

        return $consulta->execute([$this->tipo, $this->velocidad, $this->planetaOrigen, $this->pathFoto]);
    }

    public static function Traer()
    {
        $lista = [];
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM ovnis");
        $consulta->execute();

        while ($obj = $consulta->fetch()) {
            $unItem = new Ovni($obj[0], $obj[1], $obj[2], $obj[3], $obj[4]);
            array_push($lista, $unItem);
        }

        return $lista;
    }

    public function ActivarVelocidadWarp()
    {
        $velociad = $this->velocidad * 10.45;
        return $velociad;
    }


    function Existe($lista)
    {
        $existe = false;

        foreach ($lista as  $uno) {
            if ($uno->tipo == $this->tipo && $uno->planetaOrigen == $this->planetaOrigen) {
                $existe = true;
                break;
            }
        }

        return $existe;
    }

    function Modificar()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE ovnis SET tipo= ?, velocidad= ?, planeta=? , foto= ? WHERE id=?");
        $consulta->execute([$this->tipo, $this->velocidad, $this->planetaOrigen, $this->pathFoto, $this->id]);
        return $consulta;

    }
}
