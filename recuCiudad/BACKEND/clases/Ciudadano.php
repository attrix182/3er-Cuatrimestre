<?php

class Ciudadano 
{

    private $email;
    private $clave;
    private $ciudad;

    public function __construct($email, $clave, $ciudad = "")
    {
        $this->email = $email;
        $this->clave = $clave;
        $this->ciudad = $ciudad;
    }


    public function ToJSON()
    {
        $resp = new stdClass();
        $resp->email = $this->email;
        $resp->clave = $this->clave;
        $resp->ciudad = $this->ciudad;
        return json_encode($resp);
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function getClave()
    {
        return $this->clave;
    }

    public function getCiudad()
    {
        return $this->ciudad;
    }

    public function setCiudad($ciudadParam)
    {
        $this->ciudad = $ciudadParam;
    }


    function GuardarEnArchivo()
    {

        $archivo = fopen("./archivos/ciudadano.json", "a+");
        $guardar_json = $this->toJSON();
        $obj = new stdClass();

        if (!fwrite($archivo, $guardar_json . "\n")) {
            $obj->exito = false;
            $obj->mensaje = "No se pudo guardar";
        } else {
            $obj->exito = true;
            $obj->mensaje = "Guardado!";
        }

        return json_encode($obj);
    }

    static function TraerTodos()
    {
        $archivo = fopen("./archivos/ciudadano.json", "a+");
        rewind($archivo);
        $linea = '';
        $lista = null;
        while (!feof($archivo)) {
            $linea = fgets($archivo);
            $json = json_decode($linea, true);
            if ($json != false) {
                $obj = new Ciudadano($json['email'], $json['clave'], $json['ciudad']);
                $lista[] = $obj;
            }
        }
        fclose($archivo);
        return $lista;
    }


    static function VerificarExistencia($uno)
    {
        $lista = Ciudadano::traerTodos();
        $obj = new stdClass();
        $obj->cont = 0;
        $obj->ok = false;
        $obj->mensaje = "No se encontro ";

        foreach ($lista as $value) {
            if ($value->getEmail() == $uno->getEmail()  && $value->getClave() == $uno->getClave()) {

                $uno->setCiudad($value->getCiudad());
                foreach($lista as $valor)
                {
                    if($valor->getCiudad() == $uno->getCiudad())
                    {
                        $obj->cont++; 
                    }
                }
                $obj->ok = true;
                $obj->mensaje = "Ciudadano encontrado y " . $obj->cont . " en esa ciudad";

                break;
            }
        }
        if($obj->ok == false)
        {
            $obj->ciudades = array_keys(self::CiudadesPopulares($uno));
            $obj->mensaje = "No se encontro ";
        }

        return json_encode($obj);
    }

    static function CiudadesPopulares($lista)
    {
        $resultado = [];
        foreach ($lista as $uno) 
        {
            if(isset($resultado[$uno->getCiudad()]))
            {
                $resultado[$uno->getCiudad()]++;

            }
            else
            {
                $resultado[ $uno->getCiudad()] = 1;
            }
        
        }

        rsort($resultado);

        return $resultado;
    }





}
