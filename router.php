<?php
require_once "libs/Router.php";
require_once "./controllers/FixtureController.php";

$router = new Router();

$router->addRoute("fixture", "POST", "FixtureController", "insertarNueva");
$router->addRoute("fixture/resumen", "GET", "FixtureController", "resumenEquipos");

$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);


/*

<?php
require_once 'controllers/peliculaController.php';
require_once 'controllers/votoController.php';

// Definir rutas base
define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');


// Definir acción por defecto
if (empty($_GET['action'])) {
    $_GET['action'] = 'home';
}

// Obtener la acción solicitada por el usuario y analizar los parámetros
$accion = $_GET['action']; 
$param = explode('/', $accion);

$peliculaController = new

// TABLA DE RUTEO
switch ($param[0]) {

    case 'listar':  
        $peliculaController->listarPeliculas();
        break;
  
        case 'home':
          $peliculaController->mostrarHome();
        break;

   case 'pelicula':
            $peliculaController->showPelicula($param[1]);
        break;
   
   case 'eliminarPelicula':
      if (isset($param[1])) {
      $peliculaController->eliminarPelicula($param[1]);
      } else{
        echo "Error: ID de película no válido";
      }
    break;
      
  case 'agregarPelicula':
    $peliculaController->agregarPelicula();
    break;

  case 'formulario':
    $peliculaController->mostrarFormulario();
    break;

  case 'editarPelicula':
    
    $peliculaController->editarPeli($param[1]);
    break;
    default: echo "Error: Acción no válida";
}

*/
