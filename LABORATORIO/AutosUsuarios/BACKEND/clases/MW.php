<?php

class MW
{
    public function VerificarSetCorreoClave($request, $response, $next)
    {
        $array = $request->getParsedBody();
        $exito = false;
        $mensaje = "";
        $usuario = null;
  
        if(isset($array['user']) && $array['user'] != null)
        {
            $usuario = $array['user'];
        }
        else if(isset($array['usuario'] ) && $array['usuario'] != null)
        {
            $usuario = $array['usuario'];
        }

        if($usuario == null)
        {
            $std = new stdClass();
            $mensaje = "ERROR Usuario null";
            $std->mensaje = $mensaje; 
            $newResponse = $response->withJson($std, 409);
          
        }

        
        if($usuario != null)
        {
        $usuario = json_decode($usuario);
  

        if (isset($usuario->correo) && isset($usuario->clave)) {
           $exito = true; //Ambos seteados
          
        } else if (isset($usuario->correo) == true && isset($usuario->clave) == false) {

            $mensaje = "ERROR - No esta seteada la CLAVE!"; //Solo el 1 seteado

        } else if (isset($usuario->correo) == false && isset($usuario->clave) == true) {

            $mensaje = "ERROR - No esta seteado el CORREO!"; //Solo el 2 seteado

        } else {

            $mensaje = "ERROR - No esta seteado ni el CORREO ni la CLAVE!"; //Ninguno seteado

        }

        if ($exito == true) {

            $newResponse = $next($request, $response); //Todos seteados

        } else {
            $std = new stdClass();
            $std->mensaje = $mensaje;   //Ninguno seteado
            $newResponse = $response->withJson($std, 409);
        }
    }
        return $newResponse;
    }

    public static function VerificarVacios($request, $response, $next)
    {
        $array = $request->getParsedBody();
        $exito = false;
        $mensaje = "";

        $usuario = null;
  
        if(isset($array['user']) && $array['user'] != null)
        {
            $usuario = $array['user'];
        }
        else if(isset($array['usuario'] ) && $array['usuario'] != null)
        {
            $usuario = $array['usuario'];
        }

        if($usuario == null)
        {
            $std = new stdClass();
            $mensaje = "ERROR";
            $std->mensaje = $mensaje; 
            $newResponse = $response->withJson($std, 409);
          
        }

        $usuario = json_decode($usuario);
        $correo = $usuario->correo;
        $clave = $usuario->clave;



        if (($correo != "" && $clave != "")) {

            $exito = true; //Ambos seteados

        } else if ($correo != "" && $clave == "") {

            $mensaje = "ERROR - Esta vacia la CLAVE!"; //Solo el 1 seteado

        } else if ($correo == "" && $clave != "") {

            $mensaje = "ERROR - Esta vacio el CORREO!"; //Solo el 2 seteado

        } else {

            $mensaje =  "ERROR - Esta vacio el CORREO y la CLAVE!"; //Ninguno seteado

        }

        if ($exito == true) {

            $newResponse = $next($request, $response); // seteado Todos seteados

        } else {
            $std = new stdClass();
            $std->mensaje = $mensaje;   //ninguno seteado
            $newResponse = $response->withJson($std, 409);
        }
        return $newResponse;
    }

   

    public function VerificarExisteCorreoClave($request, $response, $next)
    {

        $array = $request->getParsedBody();
        $std = new stdClass();
        $std->exito = false;
        $std->mensaje = "Error.";
        $usuario = null;
  
        if(isset($array['user']) && $array['user'] != null)
        {
            $usuario = $array['user'];
        }
        else if(isset($array['usuario'] ) && $array['usuario'] != null)
        {
            $usuario = $array['usuario'];
        }

        if($usuario == null)
        {
            $std = new stdClass();
            $mensaje = "ERROR";
            $std->mensaje = $mensaje; 
            $newResponse = $response->withJson($std, 409);
          
        }
        $usuario = json_decode($usuario);
        $correo = $usuario->correo;
        $clave = $usuario->clave;

        if (Usuario::Validar($correo, $clave)) {
           
            $newResponse = $next($request, $response);
        } else {
            $std->exito = true;
            $std->mensaje = "No existe en la base de datos";
            $newResponse = $response->withJson($std, 403);
        }

        return $newResponse;
    }

    public static function VerificarExisteCorreo($request, $response, $next)
    {

        $array = $request->getParsedBody();
        $std = new stdClass();
        $std->exito = false;
        $std->mensaje = "Error.";
        $usuario = null;
  
        if(isset($array['user']) && $array['user'] != null)
        {
            $usuario = $array['user'];
        }
        else if(isset($array['usuario'] ) && $array['usuario'] != null)
        {
            $usuario = $array['usuario'];
        }

        if($usuario == null)
        {
            $std = new stdClass();
            $mensaje = "ERROR";
            $std->mensaje = $mensaje; 
            $newResponse = $response->withJson($std, 403);
          
        }

        $usuario = json_decode($usuario);
        $correo = $usuario->correo;


        if (Usuario::ValidarCorreo($correo)) {
            $std->exito = false;
            $std->mensaje = "Existe en la base de datos";
            $newResponse = $response->withJson($std, 403);
   
        } else {
            $newResponse = $next($request, $response);
        }

        return $newResponse;
    }

    public function VerificarPrecioYcolor($request, $response, $next) //ARREGLAR!
    {
        $recibo = $request->getParsedBody();
        $datos = json_decode($recibo["auto"]);
        $retorno = new stdClass();
        $retorno->mensaje = "";

        if ($datos->precio < 50000 || $datos->precio > 600000 || strtolower($datos->color) == "azul") {

            $retorno->mensaje = "Error, Los datos deben cumplir Color distitno de Azul y precio entre 50.000 y 600.000 ";
            $retorno = $response->withJson($retorno, 409);
        }
        else{
            $retorno = $next($request, $response);
           
        }

        

        return $retorno;
    }



    //Parte 3

    public function MWverificarJWT($request, $response, $next)
    {
        $array = $request->getHeaders(); 

        $token = $array['HTTP_TOKEN'][0]; 
     

        $std = new stdClass();
        $std = Autentificadora::VerificarJWT($token);

        if ($std->verificado) {
            $retorno = $next($request, $response);
        } else {

            $retorno = $response->withJson($std, 403);
        }

        return $retorno;
    }


    public static function MWverificarPropietario($request, $response, $next)
    {
        $array = $request->getHeaders();
        $token = $array['HTTP_TOKEN'][0];

        $usuario = Autentificadora::ObtenerData($token);
        $usuario = $usuario->data;

        //si el perfil es propietario pasa
        if ($usuario->perfil == "propietario") {
            $newResponse = $next($request, $response);
        } else {
            $std = new stdClass();
            $std->mensaje = $usuario->nombre . " " . $usuario->apellido . " NO es Propietario!";
            $newResponse = $response->withJson($std, 409);
        }
        return $newResponse;
    }


    public function MWverificarEncargado($request, $response, $next)
    {
        $array = $request->getHeaders();
        $token = $array['HTTP_TOKEN'][0];

        $usuario = Autentificadora::ObtenerData($token);
        $usuario = $usuario->data;
        if ($usuario->perfil == "encargado") {
            $newResponse = $next($request, $response);
        } else {
            $std = new stdClass();
            $std->mensaje = $usuario->nombre . " " . $usuario->apellido . " NO es Encargado!";
            $newResponse = $response->withJson($std, 409);
        }
        return $newResponse;
    }


    //Parte 4 A

    public static function listaPropietario($request, $response, $next)
    {
        $array = $request->getHeaders();
        $token = $array['HTTP_TOKEN'][0];

        $usuario = Autentificadora::ObtenerData($token);
        $usuario = $usuario->data;

        if ($usuario->perfil == "propietario") {
            $request = $request->withAttribute('propietario', true);
        } 

        return $next($request, $response);
    }

    public static function listaEncargado($request, $response, $next)
    {
        $array = $request->getHeaders();
        $token = $array['HTTP_TOKEN'][0];

        $usuario = Autentificadora::ObtenerData($token);
        $usuario = $usuario->data;

        if ($usuario->perfil == "encargado") {
            $request = $request->withAttribute('encargado', true);
        } 

        return $next($request, $response);
    }

    public static function listaEmpleado($request, $response, $next)
    {
        $array = $request->getHeaders();
        $token = $array['HTTP_TOKEN'][0];

        $usuario = Autentificadora::ObtenerData($token);
        $usuario = $usuario->data;

        if ($usuario->perfil == "empleado") {
            $request = $request->withAttribute('empleado', true);
        } 

        return $next($request, $response);
    }

    
    //Parte 4 B
    




}
