<?php

class Login
{

    //Loguea al Usuario creando un JWT
    public function LoginCC($request, $response, $next)
    {
        $array = $request->getParsedBody();

        $usu = $array['user'];

        $usu = json_decode($usu);

        $clave = $usu->clave;
        $correo = $usu->correo;

        $std = new stdClass();


        $usu = Usuario::Validar($correo, $clave);

        $token = Autentificadora::CrearJWT($usu);

        if ($usu != false) {
            $std->exito = true;
            $std->jwt = $token;
            $retorno = $response->withJson($std, 200);
        } else {
            $std->exito = false;
            $std->jwt = null;
            $retorno = $response->withJson($std, 403);
        }
        return $retorno;
    }

    //Loguea al Usuario verificando su JWT
    public function LoginVerificarJWT($request, $response, $next)
    {
        $array = $request->getHeaders(); 

        $token = $array['HTTP_TOKEN'][0]; 

  

        $std = new stdClass();

        $std = Autentificadora::VerificarJWT($token);

        if ($std->verificado) {
            $retorno = $response->withJson($std, 200);
        } else {
            $retorno = $response->withJson($std, 403);
        }
        return $retorno;
    }
}
