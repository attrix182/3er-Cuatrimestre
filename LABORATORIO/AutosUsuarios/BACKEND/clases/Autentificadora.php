<?php

use Firebase\JWT\JWT;

class Autentificadora
{
    private static $secret_key = 'claveSecreta';
    private static $encrypt = ['HS256'];

    //Crea un JWT guardando los datos recibidos como parametro
    public static function CrearJWT($data)
    {
        $time = time();

        $token = array(
            'iat' => $time,
            'exp' => $time + (30), //60 segundos * 10 son 10 min
            'aud' => self::Aud(),
            'data' => $data //Datos a guardar
        );

        return JWT::encode($token, self::$secret_key);
    }

    //Verifica de un JWT esta seteado y es valido
    public static function VerificarJWT($token)
    {
        $rta = new stdClass();
        $rta->verificado = FALSE;
        $rta->mensaje = "";
   
        try {
            if (!isset($token)) {
                $rta->mensaje = "Token vacio!!!";
                $rta->exito = false;
            } else {
                $decode = JWT::decode(
                    $token,
                    self::$secret_key,
                    self::$encrypt
                );

                if ($decode->aud !== self::Aud()) {
                    throw new Exception("Invalido!!!");
                } else {
                    $rta->verificado = TRUE;
                    $rta->mensaje = "Token OK!!!";
                    $rta->datos=$decode;
                }
            }
        } catch (Exception $e) {
            $rta->mensaje = "Token Expirado! - " . $e->getMessage();
            $rta->exito = false;
        }

        return $rta;
    }

    //Retorna el JWT decodeado (no solo data, sino todos sus componentes)
    public static function ObtenerData($token)
    {
        return JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        );
    }

    private static function Aud()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }
}
