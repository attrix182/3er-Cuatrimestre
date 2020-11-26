<?php

class Auto
{
    //Alta utilizada en la Api Rest
    public function Alta($request, $response)
    {
        $array = $request->getParsedBody();
        $datos = $array['auto'];
        $datos = json_decode($datos);

        $std = new stdclass();


        if (Auto::AltaBD($datos)) {
            $std->exito = true;
            $std->mensaje = "Agregado!";
            $std->auto = $datos;
            $retorno = $response->withJson($std, 200);
        } else {
            $std->exito = false;
            $std->mensaje = "ERROR! No se ha agregado!";
        }
        return $retorno;
    }

    //Alta en Base De Datos
    public static function AltaBD($uno)
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO autos(color, marca, precio, modelo)VALUES(?,?,?,?)");

        return $consulta->execute([$uno->color, $uno->marca, $uno->precio, $uno->modelo]);
    }

        //Lista en formato Json
        public function Listar($request, $response)
        {
            $uno = new Auto();
            $tabla = Auto::TraerTodosBD(); //completar
            $std = new stdclass();
    
            if ($tabla) {
                $std->exito = true;
                $std = $tabla;
                $retorno = $response->withJson($std, 200);
            } else {
                $std->exito = false;
                $retorno = $response->withJson($std, 418);
            }
            return $retorno;
        }

    //Lista en formato Json
    public function ListarParte4($request, $response)
    {
        //$uno = new Auto();
        $lista = Auto::TraerTodosBD();
        $std = new stdclass();
        $id = $_GET["id"] ?? null;


        $encargado = $request->getAttribute('encargado');
        $propietario = $request->getAttribute('propietario');
        $empleado = $request->getAttribute('empleado');

        if ($lista) {

            $std->mensaje = "Correcto";

            if ($propietario == true) {

                if ($id != null) {
                    $uno = Auto::TraerUnoBD($id);
                    if ($uno) {
                        $std->lista = $uno;
                    } else {
                        $std->mensaje = "Esa ID no tiene un auto existente";
                    }
                } else {
                    $std->lista = $lista;
                }
            } else if ($encargado == true) {

                $std->lista = array_map(function ($item) {
                    $item = (array)$item;
                    unset($item["id"]);
                    return $item;
                }, $lista);
            } else if ($empleado == true) {

                $color = array_column($lista, "color");
                $std->lista = array_count_values($color);
            }
            $std->exito = true;
            $retorno = $response->withJson($std, 200);

            return $retorno;
        } else {
            $std->exito = false;
            $retorno = $response->withJson($std, 418);
        }
    }



    //Trae todos los elementos de una tabla en la DB
    public static function TraerTodosBD()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM autos");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Auto");
    }

    public static function TraerUnoBD($id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM autos  WHERE id=?");
        $consulta->execute([$id]);
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Auto");
    }

    //Bora un elemento de la DB por un ID recibido por parametro
    public static function BorradoBD($id)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM autos WHERE id=?");
        return $consulta->execute([$id]);
    }

    //Modifica un elemento de la DB por un ID recibido por parametro, completando con los datos tambien recibidos por parametro
    public static function ModificarBD($id, $uno)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE autos SET color= ?, marca= ?, precio= ?,modelo= ? WHERE id=?");
        $consulta->execute([$uno->color, $uno->marca, $uno->precio, $uno->modelo, $id]);
        return $consulta;
    }

    //Modificacion de un elemento de la DB implemetnado en la Api Rest
    public function Modificar($request, $response)
    {
        $array = $request->getParsedBody();

        $id = $array['id_auto'];
        $uno = $array['auto'];
        $uno = json_decode($uno);

        //$id = $uno->id;

        $std = new stdclass();

        if (Auto::ModificarBD($id, $uno)) {
            $std->exito = true;
            $std->mensaje = "Modificado";
            $retorno = $response->withJson($std, 200);
        } else {
            $std->exito = false;
            $std->mensaje = "ERROR - No se ha podido modificar!";
            $retorno = $response->withJson($std, 418);
        }
        return $retorno;
    }

    //Borrdado implementado en la Api
    public function Borrado($request, $response)
    {
        $array = $request->getParsedBody();
        $id = $array['id_auto'];

        $std = new stdClass();
        $std->exito = Auto::BorradoBD($id);
        $std->mensaje = "Eliminado";
        $rta = $response->withJson($std, 200);

        return $rta;
    }
}
