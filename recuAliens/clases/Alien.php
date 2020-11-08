<?php

class Alien 
{

    private $planeta;
    private $email;
    private $clave;

    public function __construct($planeta, $email, $clave)
    {
        $this->planeta = $planeta;
        $this->email = $email;
        $this->clave = $clave;

    }


    public function ToJSON()
    {
        $resp = new stdClass();
        $resp->planeta = $this->planeta;
        $resp->email = $this->email;
        $resp->clave = $this->clave;
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

    public function getPlaneta()
    {
        return $this->planeta;
    }

    public function setPlaneta($planetaParam)
    {
        $this->planeta = $planetaParam;
    }


    function GuardarEnArchivo()
    {

        $archivo = fopen("./archivos/alien.json", "a+");
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
        $archivo = fopen("./archivos/alien.json", "a+");
        rewind($archivo);
        $linea = '';
        $lista = null;
        while (!feof($archivo)) {
            $linea = fgets($archivo);
            $json = json_decode($linea, true);
            if ($json != false) {
                $obj = new Alien($json['planeta'], $json['email'], $json['clave']);
                $lista[] = $obj;
            }
        }
        fclose($archivo);
        return $lista;
    }


    static function VerificarExistencia($uno)
    {
        $lista = Alien::traerTodos();
        $obj = new stdClass();
        $obj->cont = 0;
        $obj->ok = false;
        $obj->mensaje = "No se encontro ";

        foreach ($lista as $value) {
            if ($value->getEmail() == $uno->getEmail()  && $value->getClave() == $uno->getClave()) {

                $uno->setPlaneta($value->getPlaneta());
                foreach($lista as $valor)
                {
                    if($valor->getPlaneta() == $uno->getPlaneta())
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
            $obj->ciudades = array_keys(self::AlienPopulares($uno));
            $obj->mensaje = "No se encontro ";
        }

        return json_encode($obj);
    }

    static function AlienPopulares($lista)
    {
        $resultado = [];
        foreach ($lista as $uno) 
        {
            if(isset($resultado[$uno->getPlaneta()]))
            {
                $resultado[$uno->getPlaneta()]++;

            }
            else
            {
                $resultado[ $uno->getPlaneta()] = 1;
            }
        
        }

        rsort($resultado);

        return $resultado;
    }





}
