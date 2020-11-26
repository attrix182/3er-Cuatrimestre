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


    function GuardarEnArchivo()
    {

        $archivo = fopen("./archivos/ciudadano.json", "a+");
        $guardar_json = $this->toJSON();
        $obj = new stdClass();

        if (!fwrite($archivo, $guardar_json . "\n")) {
            $obj->exito = false;
            $obj->mensaje = "No se pudo guardar al usuario";
        } else {
            $obj->exito = true;
            $obj->mensaje = "Usuario guardado!";
        }

        return json_encode($obj);
    }

    static function TraerTodos()
    {
        $archivo = fopen("./archivos/ciudadano.json", "a+");
        rewind($archivo);
        $linea = '';
        $listaCiudadanos = null;
        while (!feof($archivo)) {
            $linea = fgets($archivo);
            $json = json_decode($linea, true);
            if ($json != false) {
                $obj = new Ciudadano($json['email'], $json['clave'], $json['ciudad']);
                $listaCiudadanos[] = $obj;
            }
        }
        fclose($archivo);
        return $listaCiudadanos;
    }


    static function VerificarExistencia($ciudadano)
    {
        $ciudadanos = Ciudadano::traerTodos();
        $obj = new stdClass();
        $obj->cont = 0;
        $obj->ok = false;
        $obj->mensaje = "No se encontro al ciudadano";

        foreach ($ciudadanos as $value) {
            if ($value->getEmail() == $ciudadano->getEmail()  && $value->getClave() == $ciudadano->getClave()) {
                $obj->ok = true;
                $obj->mensaje = "Ciudadano encontrado";

                foreach($ciudadanos as $valor)
                {
                    if($valor->getCiudad() == $ciudadano->getCiudad())
                    {
                        $obj->cont++; 
                    }
                }

                break;
            }
        }
        if($obj->ok == false)
        {
            $obj->ciudades = array_keys(self::CiudadesPopulares($ciudadanos));
        }

        return json_encode($obj);
    }

    static function CiudadesPopulares($ciudadanos)
    {
        $resultado = [];
        foreach ($ciudadanos as $ciudadano) 
        {
            if(isset($resultado[$ciudadano->getCiudad()]))
            {
                $resultado[$ciudadano->getCiudad()]++;

            }
            else
            {
                $resultado[ $ciudadano->getCiudad()] = 1;
            }
        
        }

        rsort($resultado);

        return $resultado;
    }





}



?>