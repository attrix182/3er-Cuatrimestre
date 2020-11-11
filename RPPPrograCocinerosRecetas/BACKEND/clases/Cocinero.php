<?php

class Cocinero 
{

    private $especialidad;
    private $email;
    private $clave;

    public function __construct($especialidad, $email, $clave)
    {
        $this->especialidad = $especialidad;
        $this->email = $email;
        $this->clave = $clave;

    }


    public function ToJSON()
    {
        $resp = new stdClass();
        $resp->especialidad = $this->especialidad;
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

    public function getEspecialidad()
    {
        return $this->especialidad;
    }

    public function setEspecialidad($especialidadParam)
    {
        $this->especialidad = $especialidadParam;
    }


    function GuardarEnArchivo()
    {

        $archivo = fopen("./archivos/cocinero.json", "a+");
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
        $archivo = fopen("./archivos/cocinero.json", "a+");
        rewind($archivo);
        $linea = '';
        $lista = null;
        while (!feof($archivo)) {
            $linea = fgets($archivo);
            $json = json_decode($linea, true);
            if ($json != false) {
                $obj = new Cocinero($json['especialidad'], $json['email'], $json['clave']);
                $lista[] = $obj;
            }
        }
        fclose($archivo);
        return $lista;
    }


    static function VerificarExistencia($uno)
    {
        $lista = Cocinero::traerTodos();
        $obj = new stdClass();
        $obj->cont = 0;
        $obj->ok = false;
        $obj->mensaje = "No se encontro ";

        foreach ($lista as $value) {
            if ($value->getEmail() == $uno->getEmail()  && $value->getClave() == $uno->getClave()) {

                $uno->setEspecialidad($value->getEspecialidad());
                foreach($lista as $valor)
                {
                    if($valor->getEspecialidad() == $uno->getEspecialidad())
                    {
                        $obj->cont++; 
                    }
                }
                $obj->ok = true;
                $obj->mensaje = "Cocinero encontrado y " . $obj->cont . " en con esa especialidad";

                break;
            }
        }
        if($obj->ok == false)
        {
            $obj->ciudades = array_keys(self::EspecialidadesPopulares($uno));
            $obj->mensaje = "No se encontro ";
        }

        return json_encode($obj);
    }

    static function EspecialidadesPopulares($lista)
    {
        $resultado = [];
        foreach ($lista as $uno) 
        {
            if(isset($resultado[$uno->getespecialidad()]))
            {
                $resultado[$uno->getEspecialidad()]++;

            }
            else
            {
                $resultado[ $uno->getEspecialidad()] = 1;
            }
        
        }

        rsort($resultado);

        return $resultado;
    }





}
