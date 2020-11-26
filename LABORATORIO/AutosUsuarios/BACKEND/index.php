<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require_once './vendor/autoload.php';

require_once './clases/AccesoDatos.php';
require_once './clases/Auto.php';
require_once './clases/Login.php';
require_once './clases/Usuario.php';
require_once './clases/Autentificadora.php';
require_once './clases/MW.php';


$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

///////// PARTE 1

$app->post('/usuarios', \Usuario::class . ':Alta')->add(\MW::class . '::VerificarExisteCorreo')->add(\MW::class . '::VerificarVacios')->add(\MW::class . ':VerificarSetCorreoClave');


//$app->get('[/]', \Usuario::class . ':ListarParte4')->add(\MW::class . '::listaEncargado')->add(\MW::class . '::listaEmpleado')->add(\MW::class . '::listaPropietario');;
$app->get('[/]', \Usuario::class . ':Listar');

$app->post('[/]', \Auto::class . ':Alta')->add(\MW::class . ':VerificarPrecioYcolor');

$app->get('/autos', \Auto::class . ':Listar');
/* $app->group('/autos', function () {
    $this->get('', \Auto::class . ':ListarParte4');
})->add(\MW::class . '::listaEncargado')->add(\MW::class . '::listaEncargado')->add(\MW::class . '::listaEmpleado')->add(\MW::class . '::listaPropietario');
 */


$app->post('/login', \Login::class . ':LoginCC')->add(\MW::class . ':VerificarExisteCorreoClave')->add(\MW::class . '::VerificarVacios')->add(\MW::class . ':VerificarSetCorreoClave');


$app->get('/login', \Login::class . ':LoginVerificarJWT');


$app->delete('[/]', \Auto::class . ':Borrado')->add(\MW::class . '::MWverificarPropietario')->add(\MW::class . ':MWverificarJWT');


$app->put('[/]', \Auto::class . ':Modificar')->add(\MW::class . '::MWverificarEncargado')->add(\MW::class . ':MWverificarJWT');



$app->run();
