<?php
require_once 'Router.php';
require_once("api/apiController.php");

define("BASE_URL", 'http://' . $_SERVER["SERVER_NAME"] . ':' . $_SERVER["SERVER_PORT"] . dirname($_SERVER["PHP_SELF"]) . '/');

// recurso solicitado
$resource = $_GET["resource"];

// método utilizado
$method = $_SERVER["REQUEST_METHOD"];

// instancia el router
$router = new Router();

// arma la tabla de ruteo
$router->addRoute('/api/profesor', 'GET', 'ProfesoresApiController', 'obtenerProfesores');
$router->addRoute('/api/profesor/:ID', 'GET', 'ProfesoresApiController', 'getProfById');
$router->addRoute('/api/profesor/:ID', 'DELETE', 'ProfesoresApiController', 'eliminarProfesorId');

$router->addRoute('/api/pelicula?:filter=:GENERO&DIRECTOR:', 'GET', 'ProfesoresApiController', 'obtenerPeliculaByGeneroYDirector');

$router->addRoute('/api/pelicula?GENERO=:opcionA&DIRECTOR=:opcionB', 'GET', 'ProfesoresApiController', 'obtenerPeliculaByGeneroYDirector');


// ordena el porcentajePositivo por orden 
$router->addRoute('/api/profesores?:sort=:IMAGENPOSITIVA&:order', 'GET', 'ProfesorApiController', 'profOrdenImagenPositiva');


// rutea
$router->route($resource, $method);
