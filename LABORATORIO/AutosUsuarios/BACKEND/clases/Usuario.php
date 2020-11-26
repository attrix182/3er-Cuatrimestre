<?php
class Usuario
{
    //Alta utilizada en la Api Rest
    public function Alta($request, $response)
    {

        $array = $request->getParsedBody();
        $usrJson = $array['usuario'];
        $usrJson = json_decode($usrJson);
        $archivos = $request->getUploadedFiles();
        $destino = "fotos/";

        $extension = explode(".", $archivos['foto']->getClientFilename());
        $path =  $usrJson->apellido . "." . date("Gis") .  "." . $extension[1];
        $usrJson->foto = $path;

        $std = new stdclass();
        $archivos['foto']->moveTo($destino . $path);


        if (usuario::AltaBD($usrJson)) {

            $std->exito = true;
            $std->mensaje = "Usuario agregado!";
            $retorno = $response->withJson($std, 200);
        } else {

            $std->exito = false;
            $std->mensaje = "ERROR! No se ha podido agregar al Usuario !";
            $retorno = $response->withJson($std, 418);
        }
        return $retorno;
    }

    //Alta en Base De Datos
    public static function AltaBD($usuario)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios(correo, clave, nombre, apellido, perfil, foto)VALUES(?,?,?,?,?,?)"); //Modificar a nombre de tabla correspondiente

        return $consulta->execute([$usuario->correo, $usuario->clave, $usuario->nombre, $usuario->apellido, $usuario->perfil, $usuario->foto]);
    }

    //Trae todos los elementos de una tabla en la DB
    public static function TraerTodosBD()
    {

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios");
        $consulta->execute();
        $usuarios = $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
        //$consulta->rowCount();
        return $usuarios;
    }

    public static function TraerUnoBD($ape)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE apellido=?");
        $consulta->execute([$ape]);
        $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");
        return $consulta->rowCount();
    }

    //Lista en formato Json
    public function Listar($request, $response)
    {
        $uno = new Usuario();
        $tabla = $uno->TraerTodosBD(); //completar
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


    public function ListarParte4($request, $response)
    {
        $uno = new Usuario();
        $tabla = $uno->TraerTodosBD(); //completar
        $std = new stdclass();

        $encargado = $request->getAttribute('encargado');
        $propietario = $request->getAttribute('propietario');
        $empleado = $request->getAttribute('empleado');
        $apellido = $_GET["apellido"] ?? null;


        if ($tabla) {

            $std->mensaje = "Correcto";

            if ($propietario == true) {   //REVISAR, NO HACE LO QUE DEBE

                if ($apellido != null) {
                    $uno = Usuario::TraerUnoBD($apellido);
                    if ($uno) {


                        $std->tabla = $apellido . ": " . $uno;
                    } else {
                        $std->mensaje = "Esa apellido no tiene un usuario existente";
                    }
                } else {
                    $apellido = array_column($tabla, "apellido");

                    $std->tabla = array_count_values($apellido);
                }
            } else if ($encargado == true) {

                $std->tabla = array_map(function ($item) {
                    $item = (array)$item;
                    unset($item["id"]);
                    unset($item["clave"]);
                    return $item;
                }, $tabla);
            } else if ($empleado == true) {
                $std->tabla = array_map(function ($item) {
                    $item = (array)$item;
                    unset($item["id"]);
                    unset($item["clave"]);
                    unset($item["correo"]);
                    unset($item["perfil"]);
                    return $item;
                }, $tabla);
            }
            $std->exito = true;
            $retorno = $response->withJson($std, 200);

            return $retorno;
        } else {
            $std->exito = false;
            $retorno = $response->withJson($std, 418);
        }
    }

    //Valida que un Elemento exista con solo 2 parametros. de ser asi lo retorna con sus datos completos
    public static function Validar($correo, $clave)
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE correo=? AND clave=?");
        $consulta->execute([$correo, $clave]);
        $usuario = false;

        if ($consulta->rowCount() > 0) {
            $usuario = $consulta->fetchObject('Usuario');
        }

        return $usuario;
    }


    public static function ValidarCorreo($correo)
    {
        $objetoAccesoDato = AccesoDatos::DameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE correo=?");
        $consulta->execute([$correo]);


        return (bool) $consulta->rowCount();
    }
}
